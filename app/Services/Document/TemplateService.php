<?php

namespace App\Services\Document;

class TemplateService
{
    public static function renderContragent($contragent)
    {
        return implode(', ', [
            $contragent->title,
            "ИНН {$contragent->inn}",
            $contragent->address_postal,
            $contragent->address
        ]);
    }

    /**
     * 250000.0 -> 250 000,00
     * 250000.00 -> 250 000,00
     * 250000 -> 250 000,00
     *
     * @param $price
     * @return string
     */
    public static function formatPriceOne($price)
    {
        $intPart = (string)(int)$price;
        $intPartLength = strlen($intPart);
        $fracPart = str_replace("0.", "", round($price - $intPart, 2));

        $format = '';

        for ($i = $intPartLength - 1; $i >= 0; $i--) {
            $mirrorNumber = $intPartLength - 1 - $i;

            $format .= $intPart{$mirrorNumber};

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
     * @param $price
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
            $result .= $noKop{$i};
            if ($i == 2 && $i != $noKopLength - 1) {
                $result .= ' ';
            }
        }

        return $result . ',' . $kop;
    }

    static public function formatNetto($weight)
    {
        $intPart = (int) $weight;
        if ($weight == $intPart) {
            return $intPart. ',00';
        }

        $format = str_replace(".", ",", $weight);

        return $format;
    }

    /**
     * Склонение числительных
     *
     * @param $n
     * @param $words
     * @return mixed
     */
    public static function num2word($n, $words)
    {
        return ($words[($n = ($n = $n % 100) > 19 ? ($n % 10) : $n) == 1 ? 0 : (($n > 1 && $n <= 4) ? 1 : 2)]);
    }

    /**
     * @param $n
     * @return string
     */
    public static function sum2words($n)
    {
        $words = array(
            900 => 'девятьсот',
            800 => 'восемьсот',
            700 => 'семьсот',
            600 => 'шестьсот',
            500 => 'пятьсот',
            400 => 'четыреста',
            300 => 'триста',
            200 => 'двести',
            100 => 'сто',
            90 => 'девяносто',
            80 => 'восемьдесят',
            70 => 'семьдесят',
            60 => 'шестьдесят',
            50 => 'пятьдесят',
            40 => 'сорок',
            30 => 'тридцать',
            20 => 'двадцать',
            19 => 'девятнадцать',
            18 => 'восемнадцать',
            17 => 'семнадцать',
            16 => 'шестнадцать',
            15 => 'пятнадцать',
            14 => 'четырнадцать',
            13 => 'тринадцать',
            12 => 'двенадцать',
            11 => 'одиннадцать',
            10 => 'десять',
            9 => 'девять',
            8 => 'восемь',
            7 => 'семь',
            6 => 'шесть',
            5 => 'пять',
            4 > 'четыре',
            3 => 'три',
            2 => 'два',
            1 => 'один',
        );

        $level = [
            4 => ['миллиард', 'миллиарда', 'миллиардов'],
            3 => ['миллион', 'миллиона', 'миллионов'],
            2 => ['тысяча', 'тысячи', 'тысяч'],
        ];

        list($rub, $kop) = explode('.', number_format($n, 2));
        $parts = explode(',', $rub);

        for ($str = '', $l = count($parts), $i = 0; $i < count($parts); $i++, $l--) {
            if (intval($num = $parts[$i])) {
                foreach ($words as $key => $value) {
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
                if (isset($level[$l])) {
                    $str .= ' ' . self::num2word($parts[$i], $level[$l]);
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
}
