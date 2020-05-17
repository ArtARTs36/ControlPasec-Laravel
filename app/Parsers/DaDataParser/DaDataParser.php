<?php

namespace App\Parsers\DaDataParser;

use App\Models\Contragent\ContragentManager;
use App\Models\Contragent;
use App\Services\WordService;

class DaDataParser extends DaDataSender
{
    public static function findContragentByInnOrOGRN($inn, bool $create = true, bool $save = true)
    {
        $response = self::send(self::URL_METHOD_FIND_PARTY_BY_INN, [
            'query' => $inn
        ]);

        return ($create === true) ? self::createContragentByResponse($response, $save) : $response;
    }

    public static function createContragentByResponse($responses, bool $save = true)
    {
        if (null === $responses || !isset($responses['suggestions'])) {
            return false;
        }

        foreach ($responses['suggestions'] as $response) {
            if (empty($response['data'])) {
                return false;
            }

            $response = $response['data'];

            $contragent = new Contragent();

            $contragent->title = $response['name']['short'] ?? $response['name']['short_with_opf'] ?? null;
            $contragent->full_title = $response['name']['full'] ?? null;
            $contragent->full_title_with_opf = $response['name']['full_with_opf'] ?? null;

            $contragent->inn = $response['inn'] ?? null;
            $contragent->kpp = $response['kpp'] ?? null;

            $contragent->ogrn = $response['ogrn'] ?? null;
            $contragent->okato = $response['address']['data']['okato'] ?? null;
            $contragent->oktmo = $response['address']['data']['oktmo'] ?? null;
            $contragent->okved = $response['okved'] ?? null;
            $contragent->okved_type = $response['okved_type'] ?? null;

            $contragent->address = $response['address']['value'];
            $contragent->address_postal = $response['address']['data']['postal_code'];
            $contragent->status = 0;

            if ($save) {
                $contragent->save();
            }

            self::parseManager($response, $contragent);

            break; // todo подумать над дерганием нескольких контрагентов по одному ИНН
        }

        return $contragent ?? null;
    }

    public static function parseManager($response, Contragent $contragent, $save = true)
    {
        if (!isset($response['management'])) {
            return false;
        }

        $manageString = explode(" ", $response['management']['name']);
        if (!(isset($manageString[2]) && !empty($manageString[2]))) {
            return false;
        }

        $manager = new ContragentManager();

        $manager->name = $manageString[1];
        $manager->patronymic = $manageString[2];
        $manager->family = $manageString[0];

        $words = [$manager->name, $manager->patronymic, $manager->family];

        if (!empty($response['management']['post'])) {
            $manager->post = $response['management']['post'];

            $words[] = $manager->post;
        }

        $manager->contragent_id = $contragent->id;

        if ($save === true) {
            $manager->save();

            WordService::checkVocabs($words);
        }

        return $manager;
    }
}
