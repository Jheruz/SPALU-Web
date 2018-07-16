<?php
include_once('config.php');
session_start();
if(!isset($_SESSION['name'])){
	header('location:login.php');
}
else{
	$fname = $_POST['fname'];
	$lname = $_POST['lname'];
						
	$addToStaff = mysqli_query($conn, "INSERT INTO department (code, department_name) VALUES ('$fname','$lname')");
	
	header('location:department.php?create=true');
}
?>