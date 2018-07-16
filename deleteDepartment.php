<?php
session_start();
if(!isset($_SESSION['name'])){
	header('location:login.php');
}
else{
	include_once('config.php');
	$id = $_GET['id'];
	mysqli_query($conn, "DELETE FROM department where id=$id");
	header('location:programs.php?delete=true');
}
?>