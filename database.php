<?php
    // data source name
    $dsn = "mysql:host=localhost;dbname=world";
    $username = 'root';
//    $password = "whateverItIs"

    try {
        $db = new PDO($dsn , $username);
//        $db = new PDO($dsn , $username, $password)
    }catch (PDOException $e) {
        $error_message = 'Database error: ' . $e->getMessage();
        echo $error_message;
        exit();
    }
