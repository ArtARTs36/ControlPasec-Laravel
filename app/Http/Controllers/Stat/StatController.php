<?php

namespace App\Http\Controllers\Stat;

use App\Http\Controllers\Controller;
use App\Models\Contragent;
use App\Models\News\ExternalNewsSource;
use App\Models\Supply\Supply;
use App\User;
use Illuminate\Support\Facades\DB;

class StatController extends Controller
{
    public function general()
    {
        return [
            'contragentsCount' => DB::table(Contragent::TABLE)->count(),
            'suppliesCount' => DB::table(Supply::TABLE)->count(),
            'usersCount' => DB::table(User::TABLE)->count(),
            'externalNewsSourcesCount' => DB::table(ExternalNewsSource::TABLE)->count(),
        ];
    }
}
