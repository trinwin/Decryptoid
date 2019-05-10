<?php

//validation
require_once 'login.php';
$connect = new mysqli($hn, $un, $pw, $db);
if ($connect->connect_error) die("Connection failed: " . $connect->connect_error);

if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {

    $un_temp = mysql_entities_fix_string($connect, $_SERVER['PHP_AUTH_USER']);
    $pw_temp = mysql_entities_fix_string($connect, $_SERVER['PHP_AUTH_PW']);

    $query = "SELECT * FROM users WHERE username = '$un_temp'";
    $result = $connect->query($query);

    if (!$result) die($connect->error);

    elseif ($result->num_rows) {
        $row = $result->fetch_array(MYSQLI_NUM);
        $result->close();
        $salt1 = "qm&h*"; $salt2 = "pg!@";
        $token = hash('ripemd128', "$salt1$pw_temp$salt2");

        //Compare passwords
        if ($token == $row[3]) {
            session_start();
            $_SESSION['username'] = $un_temp;
            $_SESSION['email'] = $row[2];
            $_SESSION['password'] = $pw_temp;

            echo "Hi $un_temp";
            die ("<p><a href=fileUpload.php>Click here to access your files</a></p>");
        }
        else {
            echo "Please close the browser and log in again or sign up <br>";
            echo "<p><a href=userSignUp.php>Sign up</a></p>";
            die("Invalid username/password combination");
        }
    }
    else die("Invalid username/password combination");
} else {
    header('WWW-Authenticate: Basic realm="Restricted Section"'); //Pop up
    header('HTTP/1.0 401 Unauthorized'); // when you click cancel
    die ("Please enter your username and password");
}

$connect->close();

function mysql_entities_fix_string($connect, $string)
{
    return htmlentities(mysql_fix_string($connect, $string));
}

function mysql_fix_string($connect, $string)
{
    if (get_magic_quotes_gpc()) $string = stripslashes($string);
    return $connect->real_escape_string($string);
}

function sanitizeMySQL($connection, $var) {
    $var = $connection->real_escape_string($var);
    $var = sanitizeString($var);
    return $var;
}