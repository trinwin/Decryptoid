<?php

/**
 * Decryptoid (v1)
 * Server_side Web Programming
 * Team Members: Mandeep Pabla, Trinh Nguyen, Victor Nguyen
 * IDE: PhpStorm
 * Date: 05/19/2019
 */

require_once "login.php";
require_once 'Sanitize.php';
$connect = new mysqli($hn, $un, $pw, $db);
if ($connect->connect_error) die("Connection failed: " . $connect->connect_error);

echo <<<_END
    <html>
		<head>
			<title>Sign up</title>
			
			<script>
			
			function Validate() {
                email = document.forms["signup"]["email"];
                username = document.forms["signup"]["username"];
                password = document.forms["signup"]["password"];
                
                reg_email = /^\w+@[a-z]+\.(edu|com)$/;
                reg_user = /^[\w_-]+$/;
                 
                if(!reg_user.test(username.value) || !reg_email.test(email.value) || !reg_user.test(password.value)) {
                    
                    if(!reg_user.test(username.value)){
                        window.alert("username is in an incorrect format\n");
                    }
                
                    if(!reg_email.test(email.value)) {
                        window.alert("email is in an incorrect format\n");
                    }
                
                    if(!reg_user.test(password.value)){
                         window.alert("password is in an incorrect format\n");
                    }
                        
                    return false;
                }
                
                return true;
            }
            
			</script>

		</head>
	<body>
        <form id='signup' method='POST' action='UserSignUp.php' name='form' onsubmit ="return Validate();">
            <div class="container">
                <h1>Sign Up</h1>
                <p>Please fill in this form to create an account.</p>
                <hr>
                
                <label for="username"><b>Username</b></label>
                <input type="text" placeholder="Enter Username" name="username" required> 
                <br><br>
            
                <label for="email"><b>Email</b></label>
                <input type="text" placeholder="Enter Email" name="email" required> 
                <br><br>
                
                <label for="psw"><b>Password</b></label>
                <input type="password" placeholder="Enter Password" name="psw" required>
                <br><br>
                
                <label for="psw-repeat"><b>Repeat Password</b></label>
                <input type="password" placeholder="Repeat Password" name="psw-repeat" required>
                <br><br>
                
                <div class="clearfix">
                    <button type="submit" name = "submit" class="signupbtn">Sign Up</button>
                    <button type="button" class="cancelbtn">Cancel</button>
                </div>
            </div>
        </form>
            
_END;


$table = "CREATE TABLE IF NOT EXISTS users (
         username VARCHAR(32) NOT NULL UNIQUE,
         email VARCHAR(50) NOT NULL,
         password VARCHAR(32) NOT NULL
      )";


$result = $connect->query($table);


if (isset($_POST['submit'])) {

    $username   = sanitizeMySQL($connect, $_POST['username']);
    $email      = sanitizeMySQL($connect, $_POST['email']);
    $password   = sanitizeMySQL($connect, $_POST['psw']);

    if (Validate($email, $username, $password)){
        $salt1 = "qm&h*"; $salt2 = "pg!@";
        $token = hash('ripemd128', "$salt1$password$salt2");

        add_user($connect, $username, $email, $token);

        echo "Welcome!<br>
        Your username is '$username' <br>
        Your email is '$email' <br>";
        die ("<p><a href=UserLogin.php>Click here to log in</a></p>");

    }

    $result->close();
    $connect->close();
}


function add_user($connection, $username, $email, $token)
{
    $query = "INSERT INTO users VALUES ('$username','$email', '$token')";
    $result = $connection->query($query);
    if (!$result) die($connection->error);
}


function Validate($email, $username, $password) {
    $reg_email = "/^\w+@[a-z]+\.(edu|com)$/";
    $reg_user = "/^[\w_-]+$/";

    if(!preg_match($reg_email, $email) || !preg_match($reg_user, $username) || !preg_match($reg_user, $password)) {

        if(!preg_match($reg_email, $email)) {
            echo "email is in an incorrect format<br>";
        }

        if(!preg_match($reg_user, $username)) {
            echo "username is in an incorrect format<br>";
        }

        if(!preg_match($reg_user, $password)) {
            echo "password is in an incorrect format<br>";
        }
        return false;
    }

    return true;
}

