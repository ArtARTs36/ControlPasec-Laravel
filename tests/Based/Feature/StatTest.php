<?php

namespace Tests\Based\Feature;

use Tests\TestCase;

final class StatTest extends TestCase
{
    private const BASE_URL = '/api/stat/';

    /**
     * @covers StatController::general
     */
    public function testGeneral(): void
    {
        $request = function () {
            return $this->getJson(static::BASE_URL . 'general');
        };

        //

        $request()->assertOk();
    }
}
