<?php

	class PlayFair{
			
		private function matrix(){
			
			$KeyWord = "abc";
			$Key = "abcdefghiklmnopqrstuvwxyz";
			$matrix_arr; 
			
			$counter = 0; 
			
			for($i =0; $i < 5; $i++){
				for($j=0; $j<5; $j++){
					
				$matrix_arr[$i][$j] = $Key{$counter};
				#echo $matrix_arr[$i][$j] . " ";
				$counter++;

				}
			}		

			return $matrix_arr;
		}
		
		private function format($old_text){
			
			$i =0; 
			$len =0;
			
			$text=''; 
			
			$len = strlen($old_text);
			
			for($tmp=0; $tmp<$len; $tmp++){
				
				if($old_text{$tmp}=='j'){
					$text = $text . 'i';
				}else{
					$text = $text . $old_text{$tmp};
				}
			}
			
			$len = strlen($text);
			for($i=0; $i < $len; $i=$i+2){
				
				if($text{$i+1} == $text{$i}){
					$text = substr($text,0,$i+1) . 'x' .substr($text,$i+1);
				}
			}
			return $text;
		}
		
		private function Divid2Pairs($new_string){
			
				$ob = new PlayFair();
					
				$Original = $ob->format($new_string);
				$size = strlen($Original);
				
				if($size%2 != 0){
					$size++;
					$Original = $Original . 'x';
				}
				
				$x_arr; 
				$counter = 0;
				
				for($i=0; $i<$size/2; $i++){
						
						$x_arr[$i]= substr($Original,$counter, $counter+2);
						
						#we only want the first two characters 
						if(strlen($x_arr[$i])==4){
							$x_arr[$i]= substr($x_arr[$i],0,2);
						}
						$counter = $counter +2;
				}
				
				return $x_arr;
		}
		
		private function GetDiminsions($letter){
			
			$ob = new PlayFair();
			$matrix_arr = $ob->matrix();
				
			$key_arr;
			
			if($letter=='j'){
				$letter='i';
			}
			
			for($i =0; $i < 5; $i++){
				for($j=0; $j<5; $j++){
						
					if($matrix_arr[$i][$j]==$letter){
						
						$key_arr[0]=$i;
						$key_arr[1]=$j;
						break 2;
					}
				}
			}
			
			return $key_arr;
		}
		
		private function encryptMessage($Source){
		
			$ob = new PlayFair();
			$src_arr = $ob->Divid2Pairs($Source);
		
			$code='';
			
			$one ='';
			$two='';
			
			$part1_arr;
			$part2_arr;
			
			for($i=0; $i < sizeof($src_arr); $i++){
						
				$one = $src_arr[$i]{0};
				$two = $src_arr[$i]{1};
				
				$part1_arr = $ob->GetDiminsions($one);
				$part2_arr = $ob->GetDiminsions($two);
				
				if($part1_arr[0]==$part2_arr[0]){
						
						if($part1_arr[1] < 4){
							$part1_arr[1]++;
						}
						else{
							$part1_arr[1] = 0;
						}
						if($part2_arr[1] < 4){
							$part2_arr[1]++;
						}
						else{
							$part2_arr[1] = 0;
						}
				}else if($part1_arr[1]==$part2_arr[1]){
						
						if($part1_arr[0] < 4){
							$part1_arr[0]++;
						}else{
							$part1_arr[0]=0;
						}
						if($part2_arr[0] < 4){
							$part2_arr[0]++;
						}else{
							$part2_arr[0]=0;
						}
				}else{
					
					$temp = $part1_arr[1];
					$part1_arr[1] = $part2_arr[1];
					$part2_arr[1] = $temp;
				}				
				
				$matrix_arr = $ob->matrix();
				
				$code = $code . $matrix_arr[$part1_arr[0]][$part1_arr[1]]
							  . $matrix_arr[$part2_arr[0]][$part2_arr[1]];
			}
			
			return $code;
		}
		
		public function encrypt($msg){
			
			$ob = new PlayFair();
			
			$str = str_replace(' ','',$msg);	# remove white spaces 
			
			if(strlen($str)%2!=0){
				$str = $str . "q";
			}
			
			$encryptedMSG = $ob->encryptMessage($str);
			
			return $encryptedMSG;
		}
	}
	
	$ob = new PlayFair();
	echo $ob->encrypt("my name is mandeep");
	
?>