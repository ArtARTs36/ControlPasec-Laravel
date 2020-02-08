<?php

namespace App\Services;

use App\ContragentManager;
use App\Http\Requests\ContragentRequest;
use App\Models\Contragent;
use App\Parsers\DaDataParser\DaDataParser;

class ContragentService
{
    public static function getContragent($title, $inn)
    {
        return Contragent::where('title', $title) ?? DaDataParser::findContragentByInnOrOGRN($inn);
    }

    public static function getFullInfo(Contragent $contragent)
    {
        $contragent->load([
            ContragentManager::PSEUDO,
            Contragent\BankRequisites::PSEUDO => function ($query) {
                return $query->with('bank');
            },
        ]);

        return $contragent;
    }

    /**
     * Обновить счета в реквизитах
     *
     * @param ContragentRequest $request
     * @return Contragent\BankRequisites|mixed
     */
    public static function updateScoresInRequisiteByRequest(ContragentRequest $request)
    {
        $data = $request->all();
        if (!isset($data['requisites']) && !is_array($data['requisites'])) {
            return null;
        }

        $requisites = [];
        $requisite = null;

        foreach ($data['requisites'] as $req) {
            if (!isset($req['id']) || !isset($req['score'])) {
                continue;
            }

            $requisite = Contragent\BankRequisites::find($req['id']);

            $requisite->update([
                'score' => $req['score']
            ]);

            $requisites[] = $requisite;
        }

        return $requisites;
    }
}
