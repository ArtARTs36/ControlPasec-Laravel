<?php

use ArtARTs36\WeatherArchive\Drivers\GisMeteo\GisMeteoParserDriver;
use ArtARTs36\WeatherArchive\Drivers\WorldWeather\WorldWeatherParserDriver;

return [
    'default_place' => [
        GisMeteoParserDriver::class => 5026,
        WorldWeatherParserDriver::class => '/russia/taly/',
    ],
];
