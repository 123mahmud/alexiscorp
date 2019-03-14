<?php
namespace App\Lib;


class format{
	public static function format($rupiah){	
        $data = str_replace(['Rp', '\\', '.', ' '], '',$rupiah);
        $data= str_replace(',', '.', $data);    
        if($data==''){
        	$data=0;
        }
        return $data;
	}
}