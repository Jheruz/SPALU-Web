<?php
include_once('config.php');
session_start();
if(!isset($_SESSION['name'])){
	header('location:login.php');
}
else{
	$fname = $_POST['fname'];
	$lname = $_POST['lname'];
	$user = $_POST['uname'];
	$pass = $_POST['pass'];
						
	$addToStaff = mysqli_query($conn, "INSERT INTO teacher_information (First_Name,Last_Name,Username,Password) VALUES ('$fname','$lname','$user','$pass')");
	
	header('location:teacher.php?create=true');
}
?>