<?php

namespace App\Services;

use App\Models\Contragent\ContragentManager;
use App\Http\Requests\ContragentRequest;
use App\Models\Contragent;

class ContragentService
{
    /**
     * Получить полную информацию по контрагенту
     * @param Contragent $contragent
     * @return Contragent
     */
    public static function getFullInfo(Contragent $contragent): Contragent
    {
        return $contragent->load([
            ContragentManager::PSEUDO,
            Contragent\BankRequisites::PSEUDO => function ($query) {
                return $query->with('bank');
            },
        ]);
    }

    /**
     * Обновить счета в реквизитах
     *
     * @param ContragentRequest $request
     * @return Contragent\BankRequisites[]|array|null
     */
    public static function updateScoresInRequisiteByRequest(ContragentRequest $request): ?array
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
