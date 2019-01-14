<?php
/**
 * Created by PhpStorm.
 * User: yuliusardian
 * Date: 1/13/19
 * Time: 12:52 PM
 */

namespace App\Helpers;

use getID3;

class ID3Helper
{
    public static function analyze($filename, $filesize=null, $original_filename='')
    {
        $getID3     = new getID3();
        $analyze    = $getID3->analyze(env('PIMCORE_ASSET_BASE_PATH').$filename);
        return $analyze;
    }
}
