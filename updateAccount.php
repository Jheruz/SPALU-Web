<?php
session_start();
if (!isset($_SESSION['name']))
{
	header('location:login.php');
}
else{
	include_once('config.php');
	$id = $_POST['id'];
	$fName = $_POST['ffname'];
	$lName = $_POST['llname'];
	$user = $_POST['uuname'];
	$pass = $_POST['ppass'];
	mysqli_query($conn, "UPDATE teacher_information SET First_Name='$fName', Last_Name='$lName', Username='$user', Password='$pass' WHERE id=$id");
	header('location:teacher.php?update=true');
}
?>