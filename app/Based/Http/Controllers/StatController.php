<?php

namespace App\Based\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Bundles\Contragent\Models\Contragent;
use App\Bundles\ExternalNews\Models\ExternalNewsSource;
use App\Models\Supply\Supply;
use App\User;
use Illuminate\Support\Facades\DB;

final class StatController extends Controller
{
    /**
     * Отобразить общую статистику системы
     *
     * @OA\Get(
     *     path="/stat/general",
     *     description="System Statistic: general",
     *     @OA\Response(response="default", description="View general System Statistic")
     * )
     *
     * @return array
     */
    public function general(): array
    {
        $getCount = function (string $table) {
            return DB::table($table)->count('id');
        };

        return [
            'contragentsCount' => $getCount(Contragent::TABLE),
            'suppliesCount' => $getCount(Supply::TABLE),
            'usersCount' => $getCount(User::TABLE),
            'externalNewsSourcesCount' => $getCount(ExternalNewsSource::TABLE),
        ];
    }
}
