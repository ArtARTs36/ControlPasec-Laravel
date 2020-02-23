<?php

namespace App\Http\Controllers\Stat;

use App\Http\Controllers\Controller;
use App\Models\Contragent;
use App\Models\News\ExternalNewsSource;
use App\Models\Supply\Supply;
use App\User;

class StatController extends Controller
{
    public function general()
    {
        return [
            'contragentsCount' => Contragent::all()->count(),
            'suppliesCount' => Supply::all()->count(),
            'usersCount' => User::all()->count(),
            'externalNewsSourcesCount' => ExternalNewsSource::all()->count(),
        ];
    }
}
