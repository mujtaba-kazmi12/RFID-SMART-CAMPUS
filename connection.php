<?php

$servername="localhost";
$username="root";
$password="";
$database="db_fyp";

$conn=mysqli_connect($servername,$username,$password,$database);

if(!$conn){
    die("Failed to connect to database due to:".mysqli_connect_error());
}


?>