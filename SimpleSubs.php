<?php
	
	# Simple Subsitiution
	#
	# plain alphabet : abcdefghijklmnopqrstuvwxyz
	# cipher alphabet: phqgiumeaylnofdxjkrcvstzwb
	
class SimpleSubstitution {

    static $pair = array("a"=>"p", "b"=>"h", "c"=>"q", "d"=>"g", "e"=>"i","f"=>"u",
               "g"=>"m", "h"=>"e","i"=>"a", "j"=>"y", "k"=>"l", "l"=>"n", "m"=>"o",
              "n"=>"f", "o"=>"d", "p"=>"x", "q"=>"j", "r"=>"k", "s"=>"r", "t"=>"c",
             "u"=>"v", "v"=>"s", "w"=>"t", "x"=>"z", "y"=>"w", "z"=>"b"," "=> " ");

    public function Encrypt($s, $pair){

        $encrypt = strtolower($s);
        $encryptValue = " ";			# holds encrypted word

        for($i=0; $i<strlen($encrypt); $i++){

            $temp = $encrypt[$i];
            $corresponding = $pair[$temp];

            $encryptValue = $corresponding . $encryptValue;
        }
        return $encryptValue;			# returns encrypted word
    }

    public function Decrypt($s, $pair){

        $decrypt = strtolower($s);
        $decryptValue = " "; 			# holds decrypted word

        for($i=0; $i<strlen($decrypt); $i++){
            $temp = $decrypt[$i];

            for($j=0; $j<sizeof(array_keys($pair,$temp)); $j++){
                $decryptValue = array_keys($pair,$temp)[$j] . $decryptValue;
            }
        }
        return $decryptValue;			# returns decrypted word
    }
}
	
	
	

	

?>