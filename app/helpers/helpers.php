<?php

use App\Guest;

if (! function_exists('generateUniqueIdForGuest')) {
    function generateUniqueIdForGuest() {
        $unique = md5(microtime().rand());
        while(true){
            $exists = Guest::where('unique', $unique)
                ->first();
            if($exists){
                $unique = md5(uniqid(rand(), true));
            }else{
                break;
            }
        }

        return $unique;
    }
}
