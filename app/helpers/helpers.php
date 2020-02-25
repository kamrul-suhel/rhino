<?php

use App\Guest;

if (! function_exists('generateUniqueIdForGuest')) {
    function generateUniqueIdForGuest($suffix) {

        $unique = md5(microtime().rand());
        $unique = $suffix.$unique;
        while(true){
            $exists = Guest::where('unique', $unique)
                ->first();
            if($exists){
                $unique = md5(microtime().rand());
            }else{
                break;
            }
        }

        return $unique;
    }
}
