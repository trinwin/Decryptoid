<?php

/**
 * Decryptoid (v1)
 * Server_side Web Programming
 * Team Members: Mandeep Pabla, Trinh Nguyen, Victor Nguyen
 * IDE: PhpStorm
 * Date: 05/19/2019
 */

require_once 'login.php';
require_once 'Sanitize.php';

// Connect to MySQL database
$conn = new mysqli($hn, $un, $pw, $db);
if($conn->connect_error) die($conn->connect_error);

//Start session
session_start();

//Authenticate User
if (isset($_SESSION['username'])) {

    ini_set('session.gc_maxlifetime', 60 * 60 * 24);
    $username = $_SESSION['username'];

    echo "Welcome back $username!<br><br>";

    $query = "CREATE TABLE IF NOT EXISTS dataEntry(
        entryTimeStamp TIMESTAMP NOT NULL,
        username VARCHAR(32) NOT NULL,
        textInput TEXT,
        fileInput BLOB,
        convertedOutput BLOB
    )";

    $result = $conn->query($query);
    if(!$result) die ("Database access failed 1: " . $conn->error);
}

echo <<<_END

    <h1>Welcome to Decryptoid!</h1>
    
	<p><a href=UserSignUp.php>Sign up</a>   <a href=UserLogin.php>Login</a></p>
	
    <form action="MainPage.php" method="POST" enctype="multipart/form-data">
        
        Select Cipher: <select id ="ciphers" name ="ciphers">
            <option value = "Simple Substitution">Simple Substitution</option>
            <option value = "Double Transposition">Double Transposition</option>
            <option value = "RC4">RC4</option>
            <option value = "Affine Cipher">Affine Cipher</option>
            <option value = "Vigenere Cipher">Vigenere Cipher</option>
            <option value = "Play Fair">Play Fair</option>
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
       <input type='file' name='fileToUpload' id='fileToUpload'>
        <br><br>
        
        <input type = "Submit" name ="submit1" value="Encrypt/Decrypt Textbox!"/>
        <input type = "Submit" name ="submit2" value="Encrypt/Decrypt File!"/>

        <h3>Output:</h3>
        
        
    </form>
                
_END;


if (isset($_POST['submit1'])){
	if(strlen($_POST['myArea'])!=0){
		
		$text = sanitizeMySQL($conn, $_POST['myArea']);
		$text=preg_replace("/[^A-Za-z]/", '', $text);

		start($text, $conn, true);
	}
}
else if (isset($_POST['submit2'])) {
    if ($_FILES['fileToUpload']['type'] == 'text/plain') {

        $filename = $_FILES['fileToUpload']['name'];
        $text = sanitizeMySQL($conn, file_get_contents($filename));
        $text = preg_replace("/[^A-Za-z]/", '', $text);

        start($text, $conn, false);

    } else {
        echo "This file is not a text file. Please try again" . "<br>";
    }

}

function start($myData, $conn, $bool){

    $output    = "";

    if($bool){
        $textInput = $myData;
        $fileInput = "";
    }else{
        $textInput ="";
        $fileInput = $myData;
    }

    date_default_timezone_set('America/Los_Angeles');
    $timestamp = date('Y-m-d G:i:s');

    if (isset($_SESSION['username']))
    {
        $username = $_SESSION['username'];
    }

    if($_POST['ciphers']=='Simple Substitution'){

        require_once 'SimpleSubs.php';

        $ob = new SimpleSubstitution();

        $pair = array("a"=>"p", "b"=>"h", "c"=>"q", "d"=>"g", "e"=>"i","f"=>"u",
            "g"=>"m", "h"=>"e","i"=>"a", "j"=>"y", "k"=>"l", "l"=>"n", "m"=>"o",
            "n"=>"f", "o"=>"d", "p"=>"x", "q"=>"j", "r"=>"k", "s"=>"r", "t"=>"c",
            "u"=>"v", "v"=>"s", "w"=>"t", "x"=>"z", "y"=>"w", "z"=>"b"," "=> " ");

        if($_POST['type'] == 'Encrypt'){

            $output =  $ob->encrypt($myData, $pair);
            echo $output;

        }else if($_POST['type'] == 'Decrypt'){

            $output = $ob->Decrypt($myData, $pair);
            echo $output;
        }

        if (isset($_SESSION['username'])) {

            makeQuery($conn, $timestamp, $username, $textInput, $fileInput, $output);

        }

    }else if($_POST['ciphers']=='Double Transposition'){

        require_once 'DoubleTransposition.php';

        $ob = new DoubleTransposition();

        if($_POST['type'] == 'Encrypt'){

            $output = $ob->encrypt("spart","pie", $myData);
            echo $output;

        }else if($_POST['type'] == 'Decrypt'){

            $output = $ob->decrypt("pie", "spart", $myData);
            echo $output;
        }

        if (isset($_SESSION['username'])) {
            makeQuery($conn, $timestamp, $username, $textInput, $fileInput, $output);
        }

    }else if($_POST['ciphers'] =='RC4'){
        require_once 'RC4.php';

        $ob = new RC4();

        if($_POST['type'] == 'Encrypt'){
            $output = $ob->rc4Cipher("secret", $myData);
            echo $output;
        } else if($_POST['type'] == 'Decrypt'){
            $output = $ob->rc4Cipher("secret", $myData);
            echo $output;
        }

        if (isset($_SESSION['username'])) {
            makeQuery($conn, $timestamp, $username, $textInput, $fileInput, $output);
        }

    }else if($_POST['ciphers']=='Affine Cipher'){
        require_once 'affineCipher.php';

        $ob = new AffineCipher();
        $key_A = 17;
        $key_B = 20;
        $numLetter = 26;

   if($_POST['type'] == 'Encrypt'){
            $output = $ob->affineCipherEncrypt($myData, $key_A, $key_B, $numLetter);
            echo $output;
        } else if($_POST['type'] == 'Decrypt'){
            $output = $ob->affineCipherDecrypt($myData, $key_A, $key_B, $numLetter);
            echo $output;
        }
        if (isset($_SESSION['username'])) {
            makeQuery($conn, $timestamp, $username, $textInput, $fileInput, $output);
        }
    }
    else if($_POST['ciphers']=='Vigenere Cipher'){
        require_once 'VigenereCipher.php';
        $ob = new VigenereCipher();
        if($_POST['type'] == 'Encrypt'){
            $output = $ob->encrypt("key", $myData);
            echo $output;
        } else if($_POST['type'] == 'Decrypt'){
            $output = $ob->decrypt("key", $myData);
            echo $output;
        }
        if (isset($_SESSION['username'])) {
            makeQuery($conn, $timestamp, $username, $textInput, $fileInput, $output);
        }
    }
    else if($_POST['ciphers']=='Play Fair'){

        require_once 'PlayFair.php';
        $ob = new PlayFair();
        if($_POST['type'] == 'Encrypt'){
            $output = $ob->encrypt($myData);
            echo $output;
        } else if($_POST['type'] == 'Decrypt'){
            $output = $ob->decrypt($myData);
            echo $output;
        }
        if (isset($_SESSION['username'])) {
            makeQuery($conn, $timestamp, $username, $textInput, $fileInput, $output);
        }

    }
}

function makeQuery($conn, $timestamp, $username, $text, $file, $output){
        $query = "INSERT INTO dataentry VALUES('$timestamp', '$username', '$text', '$file', '$output')";
        $result = $conn->query($query);
        if(!$result) die("Database access failed 2: " . $conn->error);

}

$result->close();
$connect->close();

?>