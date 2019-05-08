<?php
	
	# Simple Subsitiution
	#
	# plain alphabet : abcdefghijklmnopqrstuvwxyz
	# cipher alphabet: phqgiumeaylnofdxjkrcvstzwb
	
	class SimpleSubstitution{
						
		public function Encrypt($s,$pair){
			
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
			
			$decrpyt = strtolower($s);
			$decrpytValue = " "; 			# holds decrypted word
			
			for($i=0; $i<strlen($decrpyt); $i++){
				$temp = $decrpyt[$i];
				
				for($j=0; $j<sizeof(array_keys($pair,$temp)); $j++){
					$decrpytValue = array_keys($pair,$temp)[$j] . $decrpytValue;
				}
			}
			return $decrpytValue;			# returns decrypted word
		}
	}	
	
	
	
	$pair = array("a"=>"p", "b"=>"h", "c"=>"q", "d"=>"g", "e"=>"i","f"=>"u",
			"g"=>"m", "h"=>"e","i"=>"a", "j"=>"y", "k"=>"l", "l"=>"n", "m"=>"o",
			 "n"=>"f", "o"=>"d", "p"=>"x", "q"=>"j", "r"=>"k", "s"=>"r", "t"=>"c",
			 "u"=>"v", "v"=>"s", "w"=>"t", "x"=>"z", "y"=>"w", "z"=>"b"," "=> " ");
	
	$ob = new SimpleSubstitution();
	
	$word1 = "bob";
	$word2 = "a very long word";
	$word3 = "averylongword";
	
	$en1 = $ob->encrypt($word1,$pair);	
	$en2 = $ob->encrypt($word2,$pair);	
	$en3 = $ob->encrypt($word3, $pair);
	
	echo $en1; 
	echo "<br>";
	echo $en2;
	echo "<br>";
	echo $en3;
	echo "<br>";

	echo "<br>";

	echo $ob->Decrypt($en1, $pair);
	echo "<br>";
	echo $ob->Decrypt($en2, $pair);
	echo "<br>";
	echo $ob->Decrypt($en3, $pair);
?>