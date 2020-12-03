<?php

namespace Tests\Bundles\Document\Unit;

use App\Services\Document\TemplateService;
use Tests\BaseTestCase;

class TemplateServiceTest extends BaseTestCase
{
    /**
     * @covers \App\Services\Document\TemplateService::numberToWord
     */
    public function testNumberToWord(): void
    {
        self::assertTrue(TemplateService::numberToWord(3) == "Три");
        self::assertTrue(TemplateService::numberToWord(23) == "Двадцать три");
        self::assertTrue(TemplateService::numberToWord(2555) == "Две тысячи пятьсот пятьдесят пять");
    }
}
