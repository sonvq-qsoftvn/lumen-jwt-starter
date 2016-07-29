<?php
/**
 * 
 * @author 	
 */
namespace App\Common;

use Illuminate\Support\Facades\Input;

class Helper
{
	public static function generate_uuid()
	{
		return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
			mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
			mt_rand( 0, 0xffff ),
			mt_rand( 0, 0x0fff ) | 0x4000,
			mt_rand( 0, 0x3fff ) | 0x8000,
			mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
		);
	}
    
    public static function timestampSecondsToMilliseconds($timestampSecond) {
        return $timestampSecond . '000';
    }

	
}

