<?php

/**
 * Decryptoid (v1)
 * Server_side Web Programming
 * Team Members: Mandeep Pabla, Trinh Nguyen, Victor Nguyen
 * IDE: PhpStorm
 * Date: 05/19/2019
 */

/*
 * RC4 symmetric cipher encryption
 * @param key - secret key for encryption
 * @param str - string to be encrypted
 * @return string
 */

class RC4 {

    //use this function to encrypt and decrypt
    function rc4Cipher($key, $plainText) {
        $s = array();
        //Initialize array of 256 bytes
        for ($i = 0; $i < 256; $i++) {
            $s[$i] = $i;
        }

        //Secret key array
        $t = array();
        for ($i = 0; $i < 256; $i++) {
            $t[$i] = ord($key[$i % strlen($key)]);
        }

        $j = 0;
        for ($i = 0; $i < 256; $i++) {
            $j = ($j + $s[$i] + $t[$i]) % 256;
            //Swap value of s[i] and s[j]
            $temp = $s[$i];
            $s[$i] = $s[$j];
            $s[$j] = $temp;
        }

        //Generate key stream
        $i = 0;
        $j = 0;
        $cipherText = '';
        for ($y = 0; $y < strlen($plainText); $y++) {
            $i = ($i + 1) % 256;
            $j = ($j + $s[$i]) % 256;
            $x = $s[$i];
            $s[$i] = $s[$j];
            $s[$j] = $x;
            $cipherText .= $plainText[$y] ^ chr($s[($s[$i] + $s[$j]) % 256]);
        }
        return $cipherText;
    }

}

?>







