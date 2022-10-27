<?php

require_once "../config.php";

//register users
function registerUser($fullnames, $email, $password, $gender, $country){
    //create a connection variable using the db function in config.php
    $conn = db();
    

    if ( mysqli_num_rows( mysqli_query( $conn, 'SELECT * FROM students WHERE Email = `$email`' ) ) >= 1 ) {
        echo "<script> alert('the user of the email  already exists')</script>";
        echo $email;

        // header( 'refresh:0.5; url = ../forms/register.html' );
    } else {
        $sql = ( "insert into `students` (Full_names,Email,Password,Country,Gender )values('$fullnames','$email','$password','$country','$gender')" );
        $result = mysqli_query( $conn, $sql );
        if ( $result ) {
            echo "<script> alert('the user registered successfully')</script>";
            header( 'refresh:2; url = ../forms/login.html' );
        } else {
            die( mysqli_error( $conn ) );
        }
    }
   //check if user with this email already exist in the database
}


//login users
function loginUser($email, $password){
    //create a connection variable using the db function in config.php
    $conn = db();

    echo "<h1 style='color: red'> LOG ME IN (IMPLEMENT ME) </h1>";
    $sql = "SELECT * from `students` where Email = `$email` AND Password = `$password`";
    $result = mysqli_query( $conn, $sql );

    if ( mysqli_num_rows( $result ) >= 1 ) {
        session_start();
        $_SESSION[ 'username' ] = $email;

        header( 'location: ../dashboard.php' );
    } else {
        header( 'Location: ../forms/login.html?message=invalid' );

    }
    //open connection to the database and check if username exist in the database
    //if it does, check if the password is the same with what is given
    //if true then set user session for the user and redirect to the dasbboard
}


function resetPassword($email, $password){
    //create a connection variable using the db function in config.php
    $conn = db();
    echo "<h1 style='color: red'>RESET YOUR PASSWORD (IMPLEMENT ME)</h1>";
    if ( mysqli_num_rows( mysqli_query( $conn, 'SELECT * FROM students WHERE Email = `$email`' ) ) >= 1 ) {

        $sql = "UPDATE  table `students` SET Password = '$password'  WHERE Email = '$email'" ;
        $result = mysqli_query( $conn, $sql );
        if ( $result ) {
            echo "<script> alert('password reset successfully')</script>";

        } else {
            echo "<script> alert('try again please')</script>";

        }

    }
    
    
    //eopen connection to the database and check if username exist in the database
    //if it does, replace the password with $password given
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
                "<td style='width: 50px; background: blue'>" . $data['Id'] . "</td>
                <td style='width: 150px'>" . $data['Full_names'] ."</td> 
                <td style='width: 150px'>" . $data['Email'] ."</td> 
                <td style='width: 150px'>" . $data['Gender'] .  "</td> 
                <td style='width: 150px'>" . $data['Country'] . "</td>
                <form action='action.php' method='post'>
                <input type='hidden' name='id'" .
                 "value=" . $data['Id'] . ">".
                "<td style='width: 150px'> <button type='submit', name='delete'> DELETE </button>".
                "</tr>";
        }
        echo "</table></table></center></body></html>";
    }
    //return users from the database
    //loop through the users and display them on a table
}

 function deleteaccount($id){
     $conn = db();
     if ( mysqli_num_rows( mysqli_query( $conn, 'SELECT * FROM students WHERE Id = `$id`' ) ) ) {
        $sql = "delete from `students` where Id= $id";
        $result = mysqli_query( $conn, $sql );
        if ( $result ) {
            echo "<script> alert('data deleted successfully')</script>";
            header( 'refresh:0.5; url =action.php?all' );
        }

    }
}
     //delete user with the given id from the database
 
