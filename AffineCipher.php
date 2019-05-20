<?php

/**
 * Decryptoid (v1)
 * Server_side Web Programming
 * Team Members: Mandeep Pabla, Trinh Nguyen, Victor Nguyen
 * IDE: PhpStorm
 * Date: 05/19/2019
 */

class AffineCipher{
    static $key_A = 17;
    static $key_B = 20;
    static $numLetter = 26;
    function affineCipherEncrypt($plainText, $key_A, $key_B, $numLetter){
        $array = str_split(strtoupper($plainText));
        $cipherText = "";

        //Encrypt each letter
        foreach ($array as $letter) {
            if (ctype_alpha($letter)){
                $encryptLetter = ($key_A * (ord($letter) - ord("A")) + $key_B) % $numLetter + ord("A");
                $cipherText .= chr($encryptLetter);
            } else if (!ctype_alpha($letter)){
                $cipherText .= $letter;
            }
        }
        return $cipherText;
    }


    function affineCipherDecrypt($cipherText, $key_A, $key_B, $numLetter){
        $array = str_split(strtoupper($cipherText));
        $plainText = "";
        $inverse_A = 0;
        //Find multiplicative inverse of a
        for ($i = 0; $i < 26; $i++){
            $flag = ($key_A * $i) % 26;
            if ($flag == 1) {
                $inverse_A = $i;
                break;
            }
        }

        //Decrypt each letter
        foreach ($array as $letter) {
            if (ctype_alpha($letter)){

                $x = ord($letter) + ord("A");
                $decryptLetter = ($inverse_A * ( $x - $key_B ) % $numLetter) + ord("A");
                $plainText .= chr($decryptLetter);
            } else if (!ctype_alpha($letter)){
                $plainText .= $letter;
            }
        }
        return $plainText;
    }

}

