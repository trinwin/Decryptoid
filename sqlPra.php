<?php

	#select tags in HTML for drop down menu # put into container?
	
	#input type = file (inorder to have user upload file)
	
	#
	#	Email: <input type = "email" placeholder="enter email" required>
		
	#	Password: <input type = "password" placeholder="enter password" required>
	#	<button>Sign-in</button>
	
		
	# login file 
	require_once 'login.php';

	# Connect to MySQL database
	$conn = new mysqli($hn, $un, $pw, $dp);
	if($conn->connect_error) die($conn->connect_error);
	
#	require_once 'login_final_project.php';
	
	
#	$query="CREATE TABLE IF NOT EXISTS users(
#		username VARCHAR(32) NOT NULL UNIQUE,
#		password VARCHAR(32) NOT NULL,
#		email VARCHAR(50) NOT NULL
#	)";
	
#	$result = $conn->query($query);
#	if(!$result) die ("Database access failed: " . $conn->error);
	
	$query = "CREATE TABLE IF NOT EXISTS dataEntry(
		entryTimeStamp TIMESTAMP NOT NULL,
		username VARCHAR(32) NOT NULL,
		textInput TEXT,
		fileInput BLOB,
		convertedOutput BLOB
	)";
	
	$result = $conn->query($query);
	if(!$result) die ("Database access failed: " . $conn->error);
	
	if(isset($_POST['myArea']) && isset($_POST['submit'])){
		
		
		#$value = sanitizeMySQL($conn, $_POST['myArea']);
		#echo $value;
		
	}

	echo <<<_END
	
	<h1>Welcome to Decryptoid!</h1>
	
	<form action="sqlPra.php" method="post">
		
		Select Cipher: <select id ="ciphers" name ="ciphers">
			<option value = "Simple Substitution">Simple Substitution</option>
			<option value = "Double Transposition">Double Transposition</option>
			<option value = "RC4">RC4</option>
			<option value = "DES">DES</option>
		</select>
		Select Type: <select id ="type" name="type">
			<option name ="Encrypt">Encrypt</option>
			<option name = "Decrypt">Decrypt</option>
		</select>
		
		<br><br>
		
		<p>Enter text here:</p>
		<textarea rows="10 cols="100" name="myArea"></textarea>
		
		<br><br>
		<p>Submit text file here:</p>
		<input type="file">
		<br><br>
		
		<input type = "Submit" name ="submit" value="Start!"/>
				
		<h3>Output:</h3>
		
		
	</form>
				
_END;
	
	
	if(isset($_POST['submit'])){
		#echo $_POST['ciphers'] . " " . $_POST['type'];
		
		if(isset($_POST['myArea']) && $_POST['ciphers']=='Simple Substitution'){
					
			#$myData= sanitizeMySQL($conn, $_POST['myArea']); 
			$myData = $_POST['myArea'];
			
			require_once 'SimpleSubs.php';
			
			$ob = new SimpleSubstitution();
			
			$pair = array("a"=>"p", "b"=>"h", "c"=>"q", "d"=>"g", "e"=>"i","f"=>"u",
			"g"=>"m", "h"=>"e","i"=>"a", "j"=>"y", "k"=>"l", "l"=>"n", "m"=>"o",
			 "n"=>"f", "o"=>"d", "p"=>"x", "q"=>"j", "r"=>"k", "s"=>"r", "t"=>"c",
			 "u"=>"v", "v"=>"s", "w"=>"t", "x"=>"z", "y"=>"w", "z"=>"b"," "=> " ");
			
			if($_POST['type']=='Encrypt'){
				
				echo $ob->encrypt($myData, $pair);
				
			}else if($_POST['type']=='Decrypt'){
				
				echo $ob->Decrypt($myData, $pair);
			}
		}else if(isset($_POST['myArea']) && $_POST['ciphers']=='Double Transposition'){
			
			$myData = $_POST['myArea'];
			
			require_once 'DoubleTransposition.php';
			
			$ob = new DoubleTransposition();
			
			if($_POST['type']=='Encrypt'){
				
				echo $ob->encrypt("spart","pie",$myData);
				
			}else if($_POST['type']=='Decrypt'){
				
				echo $ob->decrypt("pie", "spart", $myData);
			}
			
		}else if(isset($_POST['myArea']) && $_POST['ciphers']=='RC4'){
			
			$myData = $_POST['myArea'];
			
			require_once 'RC4.php';
			
			$ob = new RC4_1();	
			
			$poop=  $ob->rc4("secret", $myData);
			echo $poop . "<br>";
			
			$en = $ob->decrypt("secret", $poop);
			echo $en;
		
			if($_POST['type']=='Encrypt'){
				
				
			}else if($_POST['type']=='Decrypt'){
				

			}
			
			
		}else if(isset($_POST['myArea']) && $_POST['ciphers']=='DES'){
			
		}
	}
	
?>