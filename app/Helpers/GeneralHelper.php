<?php
/**
 * Created by PhpStorm.
 * User: yuliusardian
 * Date: 1/13/19
 * Time: 12:58 PM
 */

namespace App\Helpers;


class GeneralHelper
{
    public static function duration($duration)
    {
        $toIntegerAfterFloorVariable = intval(floor($duration));
        return $toIntegerAfterFloorVariable;
    }
}



