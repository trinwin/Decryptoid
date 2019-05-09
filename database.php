<?php
/**
 * Created by PhpStorm.
 * User: TrinhNg
 * Date: 2019-05-08
 * Time: 22:02
 */

/**
 *
 *
 *
    CREATE TABLE IF NOT EXISTS users (
    username VARCHAR(32) NOT NULL UNIQUE,
    password VARCHAR(32) NOT NULL,
    email VARCHAR(50) NOT NULL
    );

    CREATE TABLE IF NOT EXISTS dataEntry(
    entryTimeStamp TIMESTAMP NOT NULL,
    username VARCHAR(32) NOT NULL,
    textInput TEXT,
    fileInput BLOB,
    convertedOutput BLOB
 *
 *
 */
