<?php

use App\Guest;

if (! function_exists('generateUniqueIdForGuest')) {
    function generateUniqueIdForGuest($suffix) {
        // three character dealership code + 6 digit number + random letter

        $unique = mt_rand(100000, 999999);
        $letter = randLetter();
        $unique = $suffix.$unique.$letter;
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

    function randLetter()
    {
        $int = rand(0,51);
        $a_z = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $rand_letter = $a_z[$int];
        return $rand_letter;
    }
}
