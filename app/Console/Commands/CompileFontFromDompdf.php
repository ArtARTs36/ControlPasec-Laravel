<?php

namespace App\Console\Commands;

use Dompdf\Dompdf;
use Dompdf\Exception;
use FontLib\Font;
use Illuminate\Console\Command;

class CompileFontFromDompdf extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'compile-font-from-dompdf';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     * @throws \Exception
     */
    public function handle()
    {
        //$fontName = $this->input->getArguments();
        $fontName = 'calibri';
        if (empty($fontName)) {
            throw new \LogicException('Не получено название шрифта!');
        }

        $domPdf = new Dompdf();

        $this->installFontFamily($domPdf, $fontName, env('DOCUMENT_FONTS_DIR') . '/' . $fontName);
    }

    /**
     * Installs a new font family
     * This function maps a font-family name to a font.  It tries to locate the
     * bold, italic, and bold italic versions of the font as well.  Once the
     * files are located, ttf versions of the font are copied to the fonts
     * directory.  Changes to the font lookup table are saved to the cache.
     *
     * @param Dompdf $dompdf dompdf main object
     * @param string $fontname the font-family name
     * @param string $normal the filename of the normal face font subtype
     *
     * @throws \Exception
     */
    private function installFontFamily($dompdf, $fontname, $normal)
    {
        $fontMetrics = $dompdf->getFontMetrics();

        $bold = $normal . '_bold.ttf';
        $bold_italic = $normal . '_bold_italic.ttf';
        $italic = $normal . '_italic.ttf';
        $normal .= '.ttf';

        // Check if the base filename is readable
        if ( !is_readable($normal) )
            throw new Exception("Unable to read '$normal'.");

        $dir = dirname($normal);
        $basename = basename($normal);
        $last_dot = strrpos($basename, '.');
        if ($last_dot !== false) {
            $file = substr($basename, 0, $last_dot);
            $ext = strtolower(substr($basename, $last_dot));
        } else {
            $file = $basename;
            $ext = '';
        }

        if ( !in_array($ext, array(".ttf", ".otf")) ) {
            throw new Exception("Unable to process fonts of type '$ext'.");
        }

        // Try $file_Bold.$ext etc.
        $path = "$dir/$file";

        $patterns = array(
            "bold"        => array("_Bold", "b", "B", "bd", "BD"),
            "italic"      => array("_Italic", "i", "I"),
            "bold_italic" => array("_Bold_Italic", "bi", "BI", "ib", "IB"),
        );

        foreach ($patterns as $type => $_patterns) {
            if ( !isset($$type) || !is_readable($$type) ) {
                foreach($_patterns as $_pattern) {
                    if ( is_readable("$path$_pattern$ext") ) {
                        $$type = "$path$_pattern$ext";
                        break;
                    }
                }

                if ( is_null($$type) )
                    echo ("Unable to find $type face file.\n");
            }
        }

        $fonts = compact("normal", "bold", "italic", "bold_italic");
        $entry = array();

        // Copy the files to the font directory.
        foreach ($fonts as $var => $src) {
            if ( is_null($src) ) {
                $entry[$var] = $dompdf->getOptions()->get('fontDir') . '/' . mb_substr(basename($normal), 0, -4);
                continue;
            }

            // Verify that the fonts exist and are readable
            if ( !is_readable($src) )
                throw new Exception("Requested font '$src' is not readable");

            $dest = $dompdf->getOptions()->get('fontDir') . '/' . basename($src);

            if ( !is_writeable(dirname($dest)) )
                throw new Exception("Unable to write to destination '$dest'.");

            echo "Copying $src to $dest...\n";

            if ( !copy($src, $dest) ) {
                throw new Exception("Unable to copy '$src' to '$dest'");
            }

            $entry_name = mb_substr($dest, 0, -4);

            echo "Generating Adobe Font Metrics for $entry_name...\n";

            $font_obj = Font::load($dest);
            $font_obj->saveAdobeFontMetrics("$entry_name.ufm");
            $font_obj->close();

            $entry[$var] = $entry_name;
        }

        // Store the fonts in the lookup table
        $fontMetrics->setFontFamily($fontname, $entry);

        // Save the changes
        $fontMetrics->saveFontFamilies();
    }
}
