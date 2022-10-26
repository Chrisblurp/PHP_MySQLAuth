<?php


function db() {
    //set your configs here
    $servername = "127.0.0.1";
    $username = "root";
    $dbname = "zuriphp.";
    $password = "";
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if(!$conn){
        echo "<script> alert('Error connecting to the database') </script>";
    }
    return $conn;

}