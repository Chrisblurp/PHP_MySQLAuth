<?php

require_once "../config.php";

//register users
function registerUser($fullnames, $email, $password, $gender, $country){
    //create a connection variable using the db function in config.php
    $conn = db();
   //check if user with this email already exist in the database
   if(mysqli_num_rows(mysqli_query($conn, "SELECT * FROM Students WHERE email = '$email'"))>= 1){
    echo "<script> alert('User Email Already Exist') </script>";
    header("refresh: 0.5; url=../forms/register.html");
   }

   else{
    $sql = "INSERT INTO Students (full_names, country, email, gender, password)
    VALUES('$fullnames', '$country', '$email', '$gender', '$password')";
    if(mysqli_query($conn, $sql)){
        echo "<script> alert('User Successfully registered') </script>";
        header("refresh: 2; url=../forms/login.html");
    }
    else{
        echo "<script> alert('An error occured please try again') </script>";
       }
   }
  
}


//login users
function loginUser($email, $password){
    //create a connection variable using the db function in config.php
    $conn = db();

    //open connection to the database and check if username exist in the database
     //if it does, check if the password is the same with what is given
$query = "SELECT * FROM students WHERE email = '$email' AND password = '$password'";
$result = mysqli_query($conn, $query);

//if true then set user session for the user and redirect to the dasbboard
if (mysqli_num_rows($result) >= 1){
    session_start();
    $_SESSION['username'] = $email;
    header("Location: ../dashboard.php");
}
else {
    header("Location: ../forms/login.html?mesage=invalid");
}
   
    
}


function resetPassword($email, $password){
    //create a connection variable using the db function in config.php
    $conn = db();
    
    //open connection to the database and check if username exist in the database
    if(mysqli_num_rows(mysqli_query($conn, "SELECT * FROM Students WHERE email = '$email'"))>= 1){
      $sql = "UPDATE Students SET password = '$password' WHERE email ='$email'";
       //if it does, replace the password with $password given
      if (mysqli_query($conn, $sql)){
        echo " <script> alert('Password Succesfully Changed') </script>";
        header("refresh: 1; url=../forms/login.html?password=succesful");
      }
      else{
        echo " <script> alert('An Error Occured') </script>";
      }
      
       }
       else {
        echo "<h1 style='color: red'>An Error Occured</h1>";
      }
   
}

function getusers(){
    $conn = db();
    $sql = "SELECT * FROM Students";
    $result = mysqli_query($conn, $sql);
    echo"<html>
    <head></head>
    <body>
    <center><h1><u> ZURI PHP STUDENTS </u> </h1> 
    <table border='1' style='width: 700px; background-color: magenta; border-style: none'; >
    <tr style='height: 40px'><th>ID</th><th>Full Names</th> <th>Email</th> <th>Gender</th> <th>Country</th> <th>Action</th></tr>";
    if(mysqli_num_rows($result) > 0){
        while($data = mysqli_fetch_assoc($result)){
            //show data
            echo "<tr style='height: 30px'>".
                "<td style='width: 50px; background: blue'>" . $data['id'] . "</td>
                <td style='width: 150px'>" . $data['full_names'] .
                "</td> <td style='width: 150px'>" . $data['email'] .
                "</td> <td style='width: 150px'>" . $data['gender'] . 
                "</td> <td style='width: 150px'>" . $data['country'] . 
                "</td>
                <form action='action.php' method='post'>
                <input type='hidden' name='id'" .
                 "value=" . $data['id'] . ">".
                "<td style='width: 150px'> <button type='submit', name='delete'> DELETE </button>".
                "</tr>";
        }
        echo "</table></table></center></body></html>";
    }
    //return users from the database
    //loop through the users and display them on a table
}

function logout(){

    if($_SESSION['username']){
        
        session_unset();
        session_destroy();
        header("Location: ../index.php?message=logout");
        
       
    }
    else{
        header("Location: ../forms/login.html? error you are not logged in");

    }
}

 function deleteaccount($id){
     $conn = db();
     //delete user with the given id from the database

     if(mysqli_num_rows(mysqli_query($conn, "SELECT * FROM Students WHERE id = '$id'"))){
        $sql = "DELETE FROM Students WHERE id=$id";

        if (mysqli_query($conn, $sql)){
            echo " <script> alert('deleted') </script>";
            header("refresh: 1; url=../php/action.php?all=");
        }
     }
 }
