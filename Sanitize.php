<?php

/**
 * Decryptoid (v1)
 * Server_side Web Programming
 * Team Members: Mandeep Pabla, Trinh Nguyen, Victor Nguyen
 * IDE: PhpStorm
 * Date: 05/19/2019
 */

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

function mysql_entities_fix_string($connect, $string)
{
    return htmlentities(mysql_fix_string($connect, $string));
}

function mysql_fix_string($connect, $string)
{
    if (get_magic_quotes_gpc()) $string = stripslashes($string);
    return $connect->real_escape_string($string);
}
?>