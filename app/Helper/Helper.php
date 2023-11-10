<?php

namespace App\Helper;

use Exception;

class Helper
{
    public static function dateCheck($date){
        if(!empty($date)){
            return date('d F, Y',strtotime($date));
        }else{
            return '';
        }
    }

}
