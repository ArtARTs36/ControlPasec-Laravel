<?php

namespace Tests\Feature;

use App\Support\Archiver\ArchiverFactory;
use App\Support\Archiver\ArchiverInterface;
use App\Support\Archiver\Zipper;
use Tests\BaseTestCase;

/**
 * @group BaseTest
 */
class ArchiverTest extends BaseTestCase
{
    public function testZipper(): void
    {
        $zipper = new Zipper();

        $archive = $zipper->compressDirectory(
            app_path('Console'),
            'test.zip'
        );

        self::assertTrue($archive->isCompressSuccess());

        $archive->delete();

        //

        $archive = $zipper->compress(
            [app_path('Console/Kernel.php')],
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
