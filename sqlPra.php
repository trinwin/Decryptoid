<?php
#select tags in HTML for drop down menu # put into container?

#input type = file (inorder to have user upload file)

#
#   Email: <input type = "email" placeholder="enter email" required>

#   Password: <input type = "password" placeholder="enter password" required>
#   <button>Sign-in</button>


# login file
require_once 'login.php';
# Connect to MySQL database
$conn = new mysqli($hn, $un, $pw, $db);
if($conn->connect_error) die($conn->connect_error);

session_start();
//Set time out to 1 day
ini_set('session.gc_maxlifetime', 60 * 60 * 24);

if (isset($_SESSION['username'])) {

    $username = $_SESSION['username'];

    echo "Welcome back $username!<br><br>";

    //CHECK SESSION AND THEN SAVE dataEntry
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


function makeQuery($conn, $timestamp, $username, $text, $file, $output){

    if (isset($_SESSION['username'])) {
        $query = "INSERT INTO dataentry VALUES('$timestamp', '$username', '$text', '$file', '$output')";
        $result = $conn->query($query);
        if(!$result) die("Database access failed 2: " . $conn->error);
    }
}

if(isset($_POST['myArea']) && isset($_POST['submit'])){


    #$value = sanitizeMySQL($conn, $_POST['myArea']);
    #echo $value;

}

echo <<<_END
    
    <h1>Welcome to Decryptoid!</h1>
    
    <form action="sqlPra.php" method="POST">
        
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
        <input type="file" name ="file">
        <br><br>
        
        <input type = "Submit" name ="submit" value="Start!"/>
                
        <h3>Output:</h3>
        
        
    </form>
                
_END;


if(isset($_POST['submit'])){

    $output    = "";
    $fileInput = "";
    $textInput = "";

    date_default_timezone_set('America/Los_Angeles');
    $timestamp = date('Y-m-d G:i:s');

    if (isset($_SESSION['username']))
        $username = $_SESSION['username'];

    if((isset($_POST['myArea']) || isset($_POST['file'])) && $_POST['ciphers']=='Simple Substitution'){

        #$myData= sanitizeMySQL($conn, $_POST['myArea']);

        if(isset($_POST['myArea'])){

            $myData = $_POST['myArea'];

            if(strlen($myData)!=0){

                $textInput = $_POST['myArea'];
            }else if(isset($_POST['file'])){
                $myData = file_get_contents($_POST['file']);
                $fileInput = file_get_contents($_POST['file']);
            }
        }



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


        echo "time " . $timestamp . " username". $username . " fileInput "
            . $fileInput . " textInput " . $textInput. " output " . $output;
        makeQuery($conn, $timestamp, $username, $textInput, $fileInput, $output);


    }else if(isset($_POST['myArea']) && $_POST['ciphers']=='Double Transposition'){

        if(isset($_POST['myArea'])){

            $myData = $_POST['myArea'];

            if(strlen($myData)!=0){

                $textInput = $_POST['myArea'];
            }else if(isset($_POST['file'])){
                $myData = file_get_contents($_POST['file']);
                $fileInput = file_get_contents($_POST['file']);
            }
        }

        require_once 'DoubleTransposition.php';

        $ob = new DoubleTransposition();

        if($_POST['type'] == 'Encrypt'){

            $output = $ob->encrypt("spart","pie", $myData);
            echo $output;

        }else if($_POST['type'] == 'Decrypt'){

            $output = $ob->decrypt("pie", "spart", $myData);
            echo $output;
        }




        echo "time " . $timestamp . " username". $username . " fileInput "
            . $fileInput . " textInput " . $textInput. " output " . $output;
        makeQuery($conn, $timestamp, $username, $textInput, $fileInput, $output);

    }else if(isset($_POST['myArea']) && $_POST['ciphers'] =='RC4'){

        if(isset($_POST['myArea'])){

            $myData = $_POST['myArea'];

            if(strlen($myData)!=0){

                $textInput = $_POST['myArea'];
            }else if(isset($_POST['file'])){
                $myData = file_get_contents($_POST['file']);
                $fileInput = file_get_contents($_POST['file']);
            }
        }

        require_once 'RC4.php';

        $ob = new RC4();

        if($_POST['type'] == 'Encrypt'){
            $output = $ob->rc4Cipher("secret", $myData);
        } else if($_POST['type'] == 'Decrypt'){
            $output = $ob->rc4Cipher("secret", $myData);
        }




        echo "time " . $timestamp . " username". $username . " fileInput "
            . $fileInput . " textInput " . $textInput. " output " . $output;
        makeQuery($conn, $timestamp, $username, $textInput, $fileInput, $output);



    }else if(isset($_POST['myArea']) && $_POST['ciphers']=='Affine Cipher'){
        if(isset($_POST['myArea'])){

            $myData = $_POST['myArea'];

            if(strlen($myData)!=0){

                $textInput = $_POST['myArea'];
            }else if(isset($_POST['file'])){
                $myData = file_get_contents($_POST['file']);
                $fileInput = file_get_contents($_POST['file']);
            }
        }

        require_once 'affineCipher.php';

        $ob = new AffineCipher();
        $key_A = 17;
        $key_B = 20;
        $numLetter = 26;

        if($_POST['type'] == 'Encrypt'){
            $output = $ob->affineCipherEncrypt($myData, $key_A, $key_B, $numLetter);
        } else if($_POST['type'] == 'Decrypt'){
            $output = $ob->affineCipherDecrypt($myData, $key_A, $key_B, $numLetter);
        }




        echo "time " . $timestamp . " username". $username . " fileInput "
            . $fileInput . " textInput " . $textInput. " output " . $output;
        makeQuery($conn, $timestamp, $username, $textInput, $fileInput, $output);
    }

    else if(isset($_POST['myArea']) && $_POST['ciphers']=='Vigenere Cipher'){
        if(isset($_POST['myArea'])){

            $myData = $_POST['myArea'];

            if(strlen($myData)!=0){

                $textInput = $_POST['myArea'];
            }else if(isset($_POST['file'])){
                $myData = file_get_contents($_POST['file']);
                $fileInput = file_get_contents($_POST['file']);
            }
        }

        require_once 'VigenereCipher.php';

        $ob = new VigenereCipher();
        if($_POST['type'] == 'Encrypt'){
            $output = $ob->encrypt("key", $myData);

        } else if($_POST['type'] == 'Decrypt'){
            $output = $ob->decrypt("key", $myData);
        }

        echo "time " . $timestamp . " username". $username . " fileInput "
            . $fileInput . " textInput " . $textInput. " output " . $output;
        makeQuery($conn, $timestamp, $username, $textInput, $fileInput, $output);
    }

    else if(isset($_POST['myArea']) && $_POST['ciphers']=='Play Fair'){
        /*	if(isset($_POST['myArea'])){

            $myData = $_POST['myArea'];

            if(strlen($myData)!=0){

            $textInput = $_POST['myArea'];
            }else if(isset($_POST['file'])){
                    $myData = file_get_contents($_POST['file']);
                    $fileInput = file_get_contents($_POST['file']);
            }
        }

        require_once 'PlayFair.php';

        $ob = new PlayFair();
        if($_POST['type'] == 'Encrypt'){
            $output = $ob->encrypt("key", $myData);

        } else if($_POST['type'] == 'Decrypt'){
            $output = $ob->decrypt("key", $myData);
        }


        echo "time " . $timestamp . " username". $username . " fileInput "
            . $fileInput . " textInput " . $textInput. " output " . $output;
        makeQuery($conn, $timestamp, $username, $textInput, $fileInput, $output);
        */
    }




}


?>