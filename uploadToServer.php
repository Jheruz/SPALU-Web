<?php
include_once('config.php');
require 'PHPExcel-1.8/Classes/PHPExcel/IOFactory.php';
if(isset($_POST["submit"])) {
	checkExcelUpload(1, false);
}

function checkExcelUpload($index){
$target_dir = "uploads/";
	if($index == 1){
		$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
		if($target_file != "uploads/"){
			// Check if file already exists
			if (file_exists($target_file)) {
				$index++;
				checkExcelUpload($index);
			} else {
				if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
					uploadExcelToDb($target_file, $index);
				}
			}
		} else {
			$index++;
			checkExcelUpload($index);
		}
	} else if($index == 2){
		$target_file1 = $target_dir . basename($_FILES["fileToUpload1"]["name"]);
		if($target_file1 != "uploads/"){
			// Check if file already exists
			if (file_exists($target_file1)) {
				$index++;
				checkExcelUpload($index);
			} else {
				if (move_uploaded_file($_FILES["fileToUpload1"]["tmp_name"], $target_file1)) {
					uploadExcelToDb($target_file1, $index);
				}
			}
		} else {
			$index++;
			checkExcelUpload($index);
		}
	} else if($index == 3){
		$target_file2 = $target_dir . basename($_FILES["fileToUpload2"]["name"]);
		if($target_file2 != "uploads/"){
			// Check if file already exists
			if (file_exists($target_file2)) {
				$index++;
				checkExcelUpload($index);
			} else {
				if (move_uploaded_file($_FILES["fileToUpload2"]["tmp_name"], $target_file2)) {
					uploadExcelToDb($target_file2, $index);
				}
			}
		} else {
			$index++;
			checkExcelUpload($index);
		}
	}
	if($index == 4) {
		echo "asfasf";
		echo "<script>
			window.location.href = 'uploadExcel.php?id=".$_POST[id]."&success=true';
		</script>";
	}
}

function uploadExcelToDb($file, $dataScan){
	echo $dataScan." | ".$file."<br>";
	// Mysql database
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "studentperformance";

	//$fname = "uploads/".basename( $_FILES["fileToUpload"]["name"]);
	$inputfilename = $file;
	$exceldata = array();
	 
	// Create connection
	$conn = mysqli_connect($servername, $username, $password, $dbname);
	// Check connection
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}
	try{
		$inputfiletype = PHPExcel_IOFactory::identify($inputfilename);
		$objReader = PHPExcel_IOFactory::createReader($inputfiletype);
		$objPHPExcel = $objReader->load($inputfilename);
	}
	catch(Exception $e){
		die('Error loading file "'.pathinfo($inputfilename,PATHINFO_BASENAME).'": '.$e->getMessage());
	}
	 
	//  Get worksheet dimensions
	$sheet = $objPHPExcel->getSheet(0); 
	$highestRow = $sheet->getHighestRow(); 
	$highestColumn = $sheet->getHighestColumn();
	
	$id = $_POST['id'];
	$semester = $objPHPExcel->getActiveSheet()->getCell('B4')->getValue();
	$ay = $objPHPExcel->getActiveSheet()->getCell('E4')->getValue();
	$no = $objPHPExcel->getActiveSheet()->getCell('B6')->getValue();
	$unit = $objPHPExcel->getActiveSheet()->getCell('D6')->getValue();
	$time = $objPHPExcel->getActiveSheet()->getCell('F6')->getValue();
	$subcode = $objPHPExcel->getActiveSheet()->getCell('B7')->getValue();
	$day = $objPHPExcel->getActiveSheet()->getCell('D7')->getValue();
	$room = $objPHPExcel->getActiveSheet()->getCell('F7')->getValue();
	$desc = $objPHPExcel->getActiveSheet()->getCell('B8')->getValue();
	$department = $objPHPExcel->getActiveSheet()->getCell('E12')->getValue();

	$query = mysqli_query($conn, "SELECT * FROM subject");
	$proceed = "proceed";
	while($row = mysqli_fetch_array($query)){
		if($row['No'] == $no){
			$proceed = "";
		}
	}
	if($proceed == "proceed"){
		mysqli_query($conn, "INSERT INTO department (code) VALUES ('$department')");
		mysqli_query($conn, "INSERT INTO records (semester, academic_year, no, units, day, time, room) VALUES ('$semester', '$ay', $no, $unit, '$day', '$time', '$room')");
		mysqli_query($conn, "INSERT INTO subject (department, No, Subject_Code, Subject_Description, ProfID, sem, ay) VALUES ('$department', $no, '$subcode', '$desc', $id, '$semester', '$ay')");
		for ($row = 12; $row <= $highestRow; $row++){ 
			//  Read a row of data into an array
			$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
			//  Insert row data array into your database of choice here
			if($rowData[0][2] != ""){
				$saveStudent = mysqli_query($conn, "INSERT INTO student_information (Student_No, Name, Gender, Course, Year, Prof_ID, Class_Code, Sem, AY) VALUES ('".$rowData[0][1]."', '".$rowData[0][2]."', '".$rowData[0][3]."', '".$rowData[0][4]."', '".$rowData[0][5]."', $id, '$subcode', '$semester', '$ay')");
			}
		}
		unlink($file);
		$dataScan++;
		checkExcelUpload($dataScan);
	} else {
		unlink($file);
		$dataScan++;
		checkExcelUpload($dataScan);
	}
}
?>