<?php

/**
 * Decryptoid (v1)
 * Server_side Web Programming
 * Team Members: Mandeep Pabla, Trinh Nguyen, Victor Nguyen
 * IDE: PhpStorm
 * Date: 05/19/2019
 */

class VigenereCipher {
    function elongateKey($key, $text)
    {
        $upperCaseKey = strtoupper($key);
        $upperText = strtoupper($text);
        $newKey = "";

        $upperText = str_replace(" ", "", $upperText);
	
        if (strlen($upperCaseKey) == strlen($upperText))
        {
            $newKey = $upperCaseKey;
        }
        else if (strlen($upperCaseKey) > strlen($upperText)) //if key is greater than text to be encrypted..
        {
            $newKey = substr($upperCaseKey, 0, strlen($upperText));
        }
        else //if (key.length() < text.length())if key is smaller than text to be encrypted
        {
            $tempKey = $upperCaseKey;
            while  (strlen($newKey) != strlen($upperText))
            {
                $newKey .= substr($tempKey, 0, 1);
				$tempKey = substr($tempKey, 1, strlen($tempKey) - 1) . substr($tempKey, 0, 1);
            }

            $newKey = substr($newKey, 0, strlen($upperText));
        }
        return $newKey;
    }

    function encrypt($key, $text)
    {
        $upperKey = strtoupper($key);
        $upperText = strtoupper($text);
        $upperText = str_replace(" ", "", $upperText);
        $encryptedText = "";
        $character;
        $newKey = $this->elongateKey($upperKey, $upperText);
        $spaceLocations = $this->getSpaceLocations($text);
        $spaceLocationIndex = 0;

        $j = 0;
        for ($i= 0; $i < strlen($upperText); $i++)
        {

                if ($spaceLocationIndex < sizeof($spaceLocations) && $spaceLocations[$spaceLocationIndex] == $j)
                {
                    $encryptedText .= " ";
                    $spaceLocationIndex++;
                    $j++;
                }

                $character =  65 + ((ord((substr($newKey, $i, 1))) + ord(substr($upperText, $i, 1)))  % 26); //??????????????

				$encryptedText .= chr($character);
                $j++;
        }

        return $encryptedText;
    }
	
    function decrypt($key, $cipherText)
    {
        $decryptedText = "";
        $character;
        $newKey = $this->elongateKey($key, $cipherText);

        $spaceLocations = $this->getSpaceLocations($cipherText);

        $strippedCipherText = str_replace(" ", "", $cipherText); 
        $spaceLocationIndex = 0;

        $j = 0;
        for ($i= 0; $i < strlen($strippedCipherText); $i++)
        {
            if ($spaceLocationIndex < sizeof($spaceLocations) && $spaceLocations[$spaceLocationIndex] == $j)
            {
                $decryptedText .= " ";
                $spaceLocationIndex++;
                $j++;
            }
            $character = 65 + ((ord(substr($strippedCipherText, $i, 1)) - ord(substr($newKey, $i, 1)) + 26) % 26);
            $decryptedText .=  chr($character);
            $j++;
        }
        return $decryptedText;
    }
	
    function getSpaceLocations($text)
    {
        $numOfSpaces = 0;
        $spaceLocations = [];
        for($i = 0; $i <strlen($text); $i++)
        {
            if (substr($text, $i, 1) == ' ')
            {
                $spaceLocations[$numOfSpaces] = $i;
                $numOfSpaces++;
            }
        }
        return $spaceLocations;
    }
	
}
?>