<?php

namespace Tests\Unit;

use Tests\TestCase;

/**
 * Class HelpersTest
 * @package Tests\Unit
 */
class HelpersTest extends TestCase
{
    public const TEST_CONST = 5555;

    /**
     * TEST function const_exists
     */
    public function testConstExists(): void
    {
        $response = const_exists(static::class, 'TEST_CONST');

        self::assertTrue($response);

        //

        $object = new class() {
            const TEST_CONST = 6666;
        };

        self::assertTrue(const_exists($object, 'TEST_CONST'));

        //

        $object = new class() {
            private const TEST_CONST = 7777;
        };

        self::assertFalse(const_exists($object, 'TEST_CONST'));
    }
}
