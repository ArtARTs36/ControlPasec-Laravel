<?php

namespace App\Services;

use App\Models\Contragent\ContragentManager;
use App\Http\Requests\StoreContragent;
use App\Models\Contragent;

final class ContragentService
{
    /**
     * Получить полную информацию по контрагенту
     * @param Contragent $contragent
     * @return Contragent
     */
    public static function getFullInfo(Contragent $contragent): Contragent
    {
        return $contragent->load([
            Contragent::RELATION_MANAGERS,
            Contragent::RELATION_REQUISITES => function ($query) {
                return $query->with('bank');
            },
        ]);
    }

    /**
     * Обновить счета в реквизитах
     *
     * @param StoreContragent $request
     * @return Contragent\BankRequisites[]|array|null
     */
    public static function updateScoresInRequisiteByRequest(StoreContragent $request): ?array
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
