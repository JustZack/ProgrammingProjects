<?php
    //Get the Id of the survey that is going to be deleted
    $idNUM = $_GET['id'];
    //Databse credentials
    $serverName = 'localhost';
    $userName = 'root';
    $password = '';
    $dbname = 'quiz_db';
    //Connect to the databse and check for errors
    $db_connection = new mysqli($serverName, $userName, $password, $dbname);
    if($db_connection->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    //Remove the survey from the database, and check for errors
    $sql = "DELETE FROM `quiz_data` WHERE `quiz_data`.`id` = '$idNUM'";
    if($db_connection->query($sql) === TRUE)
    {
        header('location: index.php');
    }
    else {
        echo "error: "  .$db_connection->error;
    }
?>
