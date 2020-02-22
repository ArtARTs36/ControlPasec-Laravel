<?php

namespace Tests\Feature;

use App\Services\Document\TemplateService;
use Tests\BaseTestCase;

class TemplateServiceTest extends BaseTestCase
{
    public function testNumberToWord()
    {
        self::assertTrue(TemplateService::numberToWord(3) == "Три");
        self::assertTrue(TemplateService::numberToWord(23) == "Двадцать три");
        self::assertTrue(TemplateService::numberToWord(2555) == "Две тысячи пятьсот пятьдесят пять");
    }
}
