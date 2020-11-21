<?php

namespace Tests\Based\Support;

use App\Helper\FileHelper;
use Tests\TestCase;

/**
 * @group base
 */
final class FileHelperTest extends TestCase
{
    /**
     * @covers \App\Helper\FileHelper::getPrevDir
     */
    public function testGetPrevDir(): void
    {
        self::assertEquals(realpath(__DIR__ . '/../'), FileHelper::getPrevDir(__DIR__));
    }
}
