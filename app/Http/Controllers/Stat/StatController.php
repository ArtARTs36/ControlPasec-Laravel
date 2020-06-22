<?php

namespace App\Http\Controllers\Stat;

use App\Http\Controllers\Controller;
use App\Models\Contragent;
use App\Bundles\ExternalNews\Models\ExternalNewsSource;
use App\Models\Supply\Supply;
use App\User;
use Illuminate\Support\Facades\DB;

class StatController extends Controller
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
        return [
            'contragentsCount' => DB::table(Contragent::TABLE)->count('id'),
            'suppliesCount' => DB::table(Supply::TABLE)->count('id'),
            'usersCount' => DB::table(User::TABLE)->count('id'),
            'externalNewsSourcesCount' => DB::table(ExternalNewsSource::TABLE)->count('id'),
        ];
    }
}
