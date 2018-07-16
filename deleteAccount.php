<?php
include_once('config.php');
session_start();
if(!isset($_SESSION['name'])){
	header('location:login.php');
}
else{
	$id = $_GET['id'];
	mysqli_query($conn, "DELETE FROM teacher_information where id=$id");
	header('location:teacher.php?delete=true');
}
?>