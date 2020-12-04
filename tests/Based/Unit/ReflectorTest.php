<?php

namespace Tests\Based\Unit;

use App\Based\Support\Reflector;
use Tests\TestCase;

final class ReflectorTest extends TestCase
{
    /**
     * @covers \App\Based\Support\Reflector::getMethodsByReturnType
     */
    public function testGetMethodsByReturnType(): void
    {
        self::assertEquals(['hello'], Reflector::getMethodsByReturnType(new class {
            public function hello(): void
            {
                //
            }

            public function init()
            {
                //
            }
        }, 'void'));
    }
}
