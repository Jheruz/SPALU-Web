<?php
$conn = mysqli_connect('localhost', 'root', '', 'studentperformance');
if(!$conn){
	echo "error: ".mysql_connect_error();
	exit();
}
?>