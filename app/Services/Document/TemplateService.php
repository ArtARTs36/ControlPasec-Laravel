<?php

namespace App\Services\Document;

use App\Bundles\Contragent\Models\Contragent;
use ArtARTs36\RuSpelling\Number;

class TemplateService
{
    const VARIABLES_FIELD = 'variables';
    const TABLES_FIELD = 'tables';

    public static function renderContragent(Contragent $contragent, $withKpp = false): string
    {
        $data = [
            $contragent->title,
            'ИНН '. $contragent->inn,
        ];

        if ($withKpp === true && !empty($contragent->kpp)) {
            $data[] = 'КПП '. $contragent->kpp;
        }

        $data = array_merge($data, [$contragent->address_postal, $contragent->address]);

        return implode(', ', $data);
    }

    /**
     * 250000.0 -> 250 000,00
     * 250000.00 -> 250 000,00
     * 250000 -> 250 000,00
     *
     * @param mixed $price
     * @return string
     */
    public static function formatPriceOne($price)
    {
        $intPart = (string)(int)$price;
        $intPartLength = strlen($intPart);
        $fracPart = str_replace("0.", "", (string) round($price - $intPart, 2));

        $format = '';

        for ($i = $intPartLength - 1; $i >= 0; $i--) {
            $mirrorNumber = $intPartLength - 1 - $i;

            $format .= $intPart[$mirrorNumber];

            if ($i != 0 && $i % 3 == 0) {
                $format .= ' ';
            }
        };

        return $format . ',' . $fracPart;
    }

    /**
     * 250000.0 -> 250 000,00
     * 250000.00 -> 250 000,00
     * 250000 -> 250 000,00
     *
     * @param mixed $price
     * @return string
     */
    public static function formatPriceTwo($price)
    {
        $parse = explode('.', $price);

        if (isset($parse[1])) {
            $kop = $parse[1];
            if (strlen($kop) == 1) {
                $kop .= 0;
            }
        } else {
            $kop = '00';
        }

        $noKop = $parse[0];
        $result = '';

        $noKopLength = strlen($noKop);

        for ($i = 0; $i < $noKopLength; $i++) {
            $result .= $noKop[$i];
            if ($i == 2 && $i != $noKopLength - 1) {
                $result .= ' ';
            }
        }

        return $result . ',' . $kop;
    }

    public static function formatNetto($weight): string
    {
        $intPart = (int) $weight;
        if ($weight == $intPart) {
            return $intPart. ',00';
        }

        return str_replace(".", ",", $weight);
    }

    /**
     * Склонение числительных
     *
     * @param scalar $n
     * @param array $words
     * @return mixed
     */
    public static function num2word($n, array $words)
    {
        return ($words[($n = ($n = $n % 100) > 19 ? ($n % 10) : $n) == 1 ? 0 : (($n > 1 && $n <= 4) ? 1 : 2)]);
    }

    /**
     * @param mixed $n
     * @return string
     */
    public static function sum2words($n)
    {
        [$rub, $kop] = explode('.', number_format($n, 2));
        $parts = explode(',', $rub);

        for ($str = '', $l = count($parts), $i = 0; $i < count($parts); $i++, $l--) {
            if (intval($num = $parts[$i])) {
                foreach (Number::NUMBERS_TO_WORDS as $key => $value) {
                    if ($num >= $key) {
                        // Fix для одной тысячи
                        if ($l == 2 && $key == 1) {
                            $value = 'одна';
                        }
                        // Fix для двух тысяч
                        if ($l == 2 && $key == 2) {
                            $value = 'две';
                        }
                        $str .= ($str != '' ? ' ' : '') . $value;
                        $num -= $key;
                    }
                }
                if (isset(Number::NUMBER_LEVELS[$l])) {
                    $str .= ' ' . self::num2word($parts[$i], Number::NUMBER_LEVELS[$l]);
                }
            }
        }

        if (intval($rub = str_replace(',', '', $rub))) {
            $str .= ' ' . self::num2word($rub, ['рубль', 'рубля', 'рублей']);
        }

        $str .= ($str != '' ? ' ' : '') . $kop;
        $str .= ' ' . self::num2word($kop, ['копейка', 'копейки', 'копеек']);

        return mb_strtoupper(mb_substr($str, 0, 1, 'utf-8'), 'utf-8') .
            mb_substr($str, 1, mb_strlen($str, 'utf-8'), 'utf-8');
    }

    public static function numberToWord($number)
    {
        [$rub, $kop] = explode('.', number_format($number, 2));
        $parts = explode(',', $rub);

        for ($str = '', $l = count($parts), $i = 0; $i < count($parts); $i++, $l--) {
            if (intval($num = $parts[$i])) {
                foreach (Number::NUMBERS_TO_WORDS as $key => $value) {
                    if ($num >= $key) {
                        // Fix для одной тысячи
                        if ($l == 2 && $key == 1) {
                            $value = 'одна';
                        }
                        // Fix для двух тысяч
                        if ($l == 2 && $key == 2) {
                            $value = 'две';
                        }
                        $str .= ($str != '' ? ' ' : '') . $value;
                        $num -= $key;
                    }
                }
                if (isset(Number::NUMBER_LEVELS[$l])) {
                    $str .= ' ' . self::num2word($parts[$i], Number::NUMBER_LEVELS[$l]);
                }
            }
        }

        return mb_strtoupper(mb_substr($str, 0, 1, 'utf-8'), 'utf-8') .
            mb_substr($str, 1, mb_strlen($str, 'utf-8'), 'utf-8');
    }
}
