<?php
session_start();
if (!isset($_SESSION['name'])){
	header('location:login.php');
}
else{
	include_once('config.php');
	$id = $_POST['id'];
	$code = $_POST['code'];
	$name = $_POST['name'];
	mysqli_query($conn, "UPDATE department SET code='$code', department_name='$name' WHERE id=$id");
	header('location:programs.php?update=true');
}
?>