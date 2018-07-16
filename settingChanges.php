<?php
if(isset($_POST['submit'])){
	include_once('config.php');
	$sem = $_POST['sem'];
	$ay = $_POST['ay'];
	if($sem == "1st"){
		$tempSem = "2nd";
	} else {
		$tempSem = "1st";
	}
	$temp1stYear = "";
	$temp2ndYear = "";
	$isFirstRun = true;
	for($i=0;$i<strlen($ay);$i++){
		if($ay{$i} == '-'){
			$isFirstRun = false;
			$i++;
		}
		if($isFirstRun){
			$temp1stYear .= $ay{$i};
		} else {
			$temp2ndYear .= $ay{$i};
		}
	}
	$temp1stYear --;
	$temp2ndYear --;
	$completeTempAY = $temp1stYear."-".$temp2ndYear;

	if(isset($_GET['save'])){
		mysql_query("INSERT INTO settings (academic_year, sem) VALUES ('$ay','$sem')");
	} else if(isset($_GET['update'])){
		mysql_query("DELETE FROM settings");
		mysql_query("INSERT INTO settings (academic_year, sem) VALUES ('$ay','$sem')");
		$student = mysql_query("UPDATE student_information set stat = 1 WHERE Sem = '$tempSem' AND AY = '$completeTempAY' ");
	}
	header('location:index.php');
} else {
	header('location:index.php');
}
?>