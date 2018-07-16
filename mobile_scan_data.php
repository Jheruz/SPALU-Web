<?php
	include('config.php');
	$querySettings = mysqli_query($conn, "SELECT * FROM settings");
	while($row = mysqli_fetch_array($querySettings)){
		$result["sem"] = $row['sem'];
		$result["ay"] = $row['academic_year'];
	}
	$queryStudent = mysqli_query($conn, "SELECT * FROM student_information WHERE stat = 0");
	$stud = 0;
	while($row = mysqli_fetch_array($queryStudent)){
		$result["qs_id"][$stud] = $row['id'];
		$result["qs_studentno"][$stud] = $row['Student_No'];
		$result["qs_name"][$stud] = $row['Name'];
		$result["qs_gender"][$stud] = $row['Gender'];
		$result["qs_course"][$stud] = $row['Course'];
		$result["qs_year"][$stud] = $row['Year'];
		$result["qs_profid"][$stud] = $row['Prof_ID'];
		$result["qs_cc"][$stud] = $row['Class_Code'];
		$stud++;
	}
	$querySubject = mysqli_query($conn, "SELECT * FROM subject WHERE stat = 0");
	$sub = 0;
	while($row = mysqli_fetch_array($querySubject)){
		$result["qsub_id"][$sub] = $row['id'];
		$result["qsub_profid"][$sub] = $row['ProfID'];
		$result["qsub_sc"][$sub] = $row['Subject_Code'];
		$result["qsub_sd"][$sub] = $row['Subject_Description'];
		$sub++;
	}
	$queryTeacher = mysqli_query($conn, "SELECT * FROM teacher_information");
	$teacher = 0;
	while($row = mysqli_fetch_array($queryTeacher)){
		$result["qt_id"][$teacher] = $row['id'];
		$result["qt_fn"][$teacher] = $row['First_Name'];
		$result["qt_ln"][$teacher] = $row['Last_Name'];
		$result["qt_user"][$teacher] = $row['Username'];
		$result["qt_pass"][$teacher] = $row['Password'];
		$teacher++;
	}
	echo json_encode($result);
?>