<?php
    $idNUM = $_GET['id'];

    $serverName = 'localhost';
    $userName = 'root';
    $password = '';
    $dbname = 'quiz_db';

    $db_connection = new mysqli($serverName, $userName, $password, $dbname);
    if($db_connection->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    $sql = "DELETE FROM `quiz_data` WHERE `quiz_data`.`id` = '$idNUM'";
    if($db_connection->query($sql) === TRUE)
    {
        header('location: index.php');
    }
    else {
        echo "error: "  .$db_connection->error;
    }
?>
