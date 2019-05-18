<?php
require_once "login.php";
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
             
            if(!reg_email.test(email.value)) {
                window.alert("email is in an incorrect format");
                return false;
            }
            if(!reg_user.test(username.value)){
               window.alert("username is in an incorrect format");
               return false;
            }
            if(!reg_user.test(password.value)){
                window.alert("password is in an incorrect format");
                return false;
            }
            
            return true;
            }
			</script>

		</head>
	<body>
    
    <form id ='signup' form method='POST' action='userSignUp.php' name='form' onsubmit ="return Validate();">
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
			
			
			<script>
			
			</script>
		
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


//Check connections
if ($connect->query($table) === TRUE) {
    echo "Table users created successfully"."<br>";
} else {
    echo "Error creating table: " . $connect->error;
}

if (isset($_POST['submit'])) {

    $username   = sanitizeMySQL($connect, $_POST['username']);
    $email      = sanitizeMySQL($connect, $_POST['email']);
    $password   = sanitizeMySQL($connect, $_POST['psw']);

    Validate($email, $username, $password);

    echo "here".$password. "<br>";

    $salt1 = "qm&h*"; $salt2 = "pg!@";
    $token = hash('ripemd128', "$salt1$password$salt2");

    add_user($connect, $username, $email, $token);

    echo "Welcome!<br>
    Your username is '$username' <br>
    Your email is '$email' <br>";
    die ("<p><a href=userLogin.php>Click here to log in</a></p>");
}


function add_user($connection, $username, $email, $token)
{
    $query = "INSERT INTO users VALUES ('$username','$email', '$token')";
    $result = $connection->query($query);
    if (!$result) die($connection->error);
}


function sanitizeString($var) {
    $var = stripslashes($var);
    $var = strip_tags($var);
    $var = htmlentities($var);
    return $var;
}

function sanitizeMySQL($connection, $var) {
    $var = $connection->real_escape_string($var);
    $var = sanitizeString($var);
    return $var;
}

function Validate($email, $username, $password) {
    echo "validate";
    $str = "";
    $reg_email = "/^\w+@[a-z]+\.(edu|com)$/";
    $reg_user = "/^[\w_-]+$/";

    if(!preg_match($reg_email, $email))
        echo "email is in an incorrect format";

    if(!preg_match($reg_user, $username))
        echo "username is in an incorrect format";

    if(!preg_match($reg_user, $password))
        echo "password is in an incorrect format";
}
