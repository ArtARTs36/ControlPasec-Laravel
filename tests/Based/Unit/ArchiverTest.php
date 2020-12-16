<?php

namespace Tests\Based\Unit;

use App\Based\Support\Archiver\ArchiverFactory;
use App\Based\Support\Archiver\ArchiverInterface;
use App\Based\Support\Archiver\Zipper;
use Tests\BaseTestCase;

class ArchiverTest extends BaseTestCase
{
    public function testZipper(): void
    {
        $zipper = new Zipper();

        $archive = $zipper->compressDirectory(
            app_path('Based/Console'),
            'test.zip'
        );

        self::assertTrue($archive->isCompressSuccess());

        $archive->delete();

        //

        $archive = $zipper->compress(
            [app_path('Based/Console/Kernel.php')],
            'test2.zip'
        );

        self::assertTrue($archive->isCompressSuccess());

        $archive->delete();
    }

    public function testFactory(): void
    {
        $archiver = ArchiverFactory::get(ArchiverInterface::EXTENSION_ZIP);

        self::assertInstanceOf(Zipper::class, $archiver);
    }
}
