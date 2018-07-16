<?php
ini_set('max_execution_time',0); 
echo"<script>var title = '';</script>";
	$settings = mysqli_query($conn, "SELECT * FROM settings");
    if(mysqli_num_rows($settings) != 0){
        $settings = mysqli_fetch_object($settings);
        $sem = $settings->sem;
        $academic_year = $settings->academic_year;

		$Submitted = mysqli_query($conn, "SELECT DISTINCT profid, name FROM teacher_submit_grade WHERE sem = '$sem' AND ay = '$academic_year'");
		$studentCount = mysqli_query($conn, "SELECT DISTINCT Student_No FROM student_information");
		$teacherCount = mysqli_query($conn, "SELECT * FROM teacher_information");
		$subjectCount = mysqli_query($conn, "SELECT * FROM subject GROUP BY Subject_Code");
    } else {

    	$Submitted = mysqli_query($conn, "SELECT DISTINCT profid, name FROM teacher_submit_grade");
		$studentCount = mysqli_query($conn, "SELECT DISTINCT Student_No FROM student_information");
		$teacherCount = mysqli_query($conn, "SELECT * FROM teacher_information");
		$subjectCount = mysqli_query($conn, "SELECT * FROM subject GROUP BY Subject_Code");
    }


	//query for chart
	$male = array();
	$female = array();
	$all = array();

	$i = 0;
	$maleAverage = "";
	$femaleAverage = "";
	$allAverage = "";

	$departmentMale = array();
	$departmentFemale = array();
	$departmentAll = array();

	$ii = 0;
	$departmentMaleAverage = "";
	$departmentFemaleAverage = "";
	$departmentAllAverage = "";

	if(isset($_POST['submit'])){
		if(isset($_POST['year'])){
			$filterYear = $_POST['year'];
			//echo $year;
		}
		if(isset($_POST['sem'])){
			$filterSem = $_POST['sem'];
			//echo $filterSem;
		}
		if(isset($_POST['academic_year'])){
			$academic_year = $_POST['academic_year'];
			//echo $academic_year;
		}
		if(isset($filterYear) && isset($filterSem) && isset($academic_year)){
			if($filterYear == "all" && $filterSem == "all" && $academic_year == "all"){
				echo"<script>var title = 'All year and All Sem and All Academic Year Grade Average';</script>";
				$outerQuery = mysqli_query($conn, "SELECT * FROM department GROUP BY code");
				while($res=mysqli_fetch_array($outerQuery)){
					$tempDepartment = $res['code'];
					$maleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Gender = 'Male' AND dept.code = '$tempDepartment'");
					$femaleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Gender = 'Female' AND dept.code = '$tempDepartment'");
					$allQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE dept.code = '$tempDepartment'");
					while($temp = mysqli_fetch_array($maleQuery)){
						if(!is_null($temp['Average'])){
							$maleAverage = $temp['Average'];
						}
					}
					while($temp = mysqli_fetch_array($femaleQuery)){
						if(!is_null($temp['Average'])){
							$femaleAverage = $temp['Average'];
						}
					}
					while($temp = mysqli_fetch_array($allQuery)){
						if(!is_null($temp['Average'])){
							$allAverage = $temp['Average'];
						}
					}
					if($maleAverage != ""){
						$male[$i] = array("y" => $maleAverage, "label" => $tempDepartment);
					} else {
						$male[$i] = array("y" => 0, "label" => $tempDepartment);
					}
					if($femaleAverage != ""){
						$female[$i] = array("y" => $femaleAverage, "label" => $tempDepartment);
					} else {
						$female[$i] = array("y" => 0, "label" => $tempDepartment);
					}
					if($allAverage != ""){
						$all[$i] = array("y" => $allAverage, "label" => $tempDepartment);
					} else {
						$all[$i] = array("y" => 0, "label" => $tempDepartment);
					}
					$i++;
				}
			} else if($filterYear != "all" && $filterSem == "all" && $academic_year == "all"){
				echo"<script>var title = '".$filterYear." year and All Sem and All Academic Year Grade Average';</script>";
				$outerQuery = mysqli_query($conn, "SELECT * FROM department GROUP BY code");
				while($res=mysqli_fetch_array($outerQuery)){
					$tempDepartment = $res['code'];
					$maleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Gender = 'Male' AND si.Year = '$filterYear' AND dept.code = '$tempDepartment'");
					$femaleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Gender = 'Female' AND si.Year = '$filterYear' AND dept.code = '$tempDepartment'");
					$allQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Year = '$filterYear' AND dept.code = '$tempDepartment'");
					while($temp = mysqli_fetch_array($maleQuery)){
						if(!is_null($temp['Average'])){
							$maleAverage = $temp['Average'];
						}
					}
					while($temp = mysqli_fetch_array($femaleQuery)){
						if(!is_null($temp['Average'])){
							$femaleAverage = $temp['Average'];
						}
					}
					while($temp = mysqli_fetch_array($allQuery)){
						if(!is_null($temp['Average'])){
							$allAverage = $temp['Average'];
						}
					}
					if($maleAverage != ""){
						$male[$i] = array("y" => $maleAverage, "label" => $tempDepartment);
					} else {
						$male[$i] = array("y" => 0, "label" => $tempDepartment);
					}
					if($femaleAverage != ""){
						$female[$i] = array("y" => $femaleAverage, "label" => $tempDepartment);
					} else {
						$female[$i] = array("y" => 0, "label" => $tempDepartment);
					}
					if($allAverage != ""){
						$all[$i] = array("y" => $allAverage, "label" => $tempDepartment);
					} else {
						$all[$i] = array("y" => 0, "label" => $tempDepartment);
					}
					$i++;
				}
			} else if($filterYear == "all" && $filterSem != "all" && $academic_year != "all"){
				echo"<script>var title = 'All year and ".$filterSem." Sem and ".$academic_year." Grade Average';</script>";
				$outerQuery = mysqli_query($conn, "SELECT * FROM department GROUP BY code");
				while($res=mysqli_fetch_array($outerQuery)){
					$tempDepartment = $res['code'];
					$maleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Gender = 'Male' AND si.Sem = '$filterSem' AND si.AY = '$academic_year' AND dept.code = '$tempDepartment'");
					$femaleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Gender = 'Female' AND si.Sem = '$filterSem' AND si.AY = '$academic_year' AND dept.code = '$tempDepartment'");
					$allQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Sem = '$filterSem' AND si.AY = '$academic_year' AND dept.code = '$tempDepartment'");
					while($temp = mysqli_fetch_array($maleQuery)){
						if(!is_null($temp['Average'])){
							$maleAverage = $temp['Average'];
						}
					}
					while($temp = mysqli_fetch_array($femaleQuery)){
						if(!is_null($temp['Average'])){
							$femaleAverage = $temp['Average'];
						}
					}
					while($temp = mysqli_fetch_array($allQuery)){
						if(!is_null($temp['Average'])){
							$allAverage = $temp['Average'];
						}
					}
					if($maleAverage != ""){
						$male[$i] = array("y" => $maleAverage, "label" => $tempDepartment);
					} else {
						$male[$i] = array("y" => 0, "label" => $tempDepartment);
					}
					if($femaleAverage != ""){
						$female[$i] = array("y" => $femaleAverage, "label" => $tempDepartment);
					} else {
						$female[$i] = array("y" => 0, "label" => $tempDepartment);
					}
					if($allAverage != ""){
						$all[$i] = array("y" => $allAverage, "label" => $tempDepartment);
					} else {
						$all[$i] = array("y" => 0, "label" => $tempDepartment);
					}
					$i++;
				}
			} else if($filterYear == "all" && $filterSem == "all" && $academic_year != "all"){
				echo"<script>var title = 'All year and All Sem and ".$academic_year." Grade Average';</script>";
				$outerQuery = mysqli_query($conn, "SELECT * FROM department GROUP BY code");
				while($res=mysqli_fetch_array($outerQuery)){
					$tempDepartment = $res['code'];
					$maleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Gender = 'Male' AND si.AY = '$academic_year' AND dept.code = '$tempDepartment'");
					$femaleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Gender = 'Female' AND si.AY = '$academic_year' AND dept.code = '$tempDepartment'");
					$allQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.AY = '$academic_year' AND dept.code = '$tempDepartment'");
					while($temp = mysqli_fetch_array($maleQuery)){
						if(!is_null($temp['Average'])){
							$maleAverage = $temp['Average'];
						}
					}
					while($temp = mysqli_fetch_array($femaleQuery)){
						if(!is_null($temp['Average'])){
							$femaleAverage = $temp['Average'];
						}
					}
					while($temp = mysqli_fetch_array($allQuery)){
						if(!is_null($temp['Average'])){
							$allAverage = $temp['Average'];
						}
					}
					if($maleAverage != ""){
						$male[$i] = array("y" => $maleAverage, "label" => $tempDepartment);
					} else {
						$male[$i] = array("y" => 0, "label" => $tempDepartment);
					}
					if($femaleAverage != ""){
						$female[$i] = array("y" => $femaleAverage, "label" => $tempDepartment);
					} else {
						$female[$i] = array("y" => 0, "label" => $tempDepartment);
					}
					if($allAverage != ""){
						$all[$i] = array("y" => $allAverage, "label" => $tempDepartment);
					} else {
						$all[$i] = array("y" => 0, "label" => $tempDepartment);
					}
					$i++;
				}
			} else if($filterYear != "all" && $filterSem != "all" && $academic_year == "all"){
				echo"<script>var title = '".$filterYear." year, ".$filterSem." Sem and All Academic Year Grade Average';</script>";
				$outerQuery = mysqli_query($conn, "SELECT * FROM department GROUP BY code");
				while($res=mysqli_fetch_array($outerQuery)){
					$tempDepartment = $res['code'];
					$maleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Gender = 'Male' AND si.Year = '$filterYear' AND si.Sem = '$filterSem' AND dept.code = '$tempDepartment'");
					$femaleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Gender = 'Female' AND si.Year = '$filterYear' AND si.Sem = '$filterSem' AND dept.code = '$tempDepartment'");
					$allQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Year = '$filterYear' AND si.Sem = '$filterSem' AND si.AY = '$academic_year' AND dept.code = '$tempDepartment'");
					while($temp = mysqli_fetch_array($maleQuery)){
						if(!is_null($temp['Average'])){
							$maleAverage = $temp['Average'];
						}
					}
					while($temp = mysqli_fetch_array($femaleQuery)){
						if(!is_null($temp['Average'])){
							$femaleAverage = $temp['Average'];
						}
					}
					while($temp = mysqli_fetch_array($allQuery)){
						if(!is_null($temp['Average'])){
							$allAverage = $temp['Average'];
						}
					}
					if($maleAverage != ""){
						$male[$i] = array("y" => $maleAverage, "label" => $tempDepartment);
					} else {
						$male[$i] = array("y" => 0, "label" => $tempDepartment);
					}
					if($femaleAverage != ""){
						$female[$i] = array("y" => $femaleAverage, "label" => $tempDepartment);
					} else {
						$female[$i] = array("y" => 0, "label" => $tempDepartment);
					}
					if($allAverage != ""){
						$all[$i] = array("y" => $allAverage, "label" => $tempDepartment);
					} else {
						$all[$i] = array("y" => 0, "label" => $tempDepartment);
					}
					$i++;
				}
			} else if($filterYear != "all" && $filterSem == "all" && $academic_year != "all"){
				echo"<script>var title = '".$filterYear." year, All Sem in ".$academic_year." Academic Year Grade Average';</script>";
				$outerQuery = mysqli_query($conn, "SELECT * FROM department GROUP BY code");
				while($res=mysqli_fetch_array($outerQuery)){
					$tempDepartment = $res['code'];
					$maleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Gender = 'Male' AND si.Year = '$filterYear' AND dept.code = '$tempDepartment'");
					$femaleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Gender = 'Female' AND si.Year = '$filterYear' AND dept.code = '$tempDepartment'");
					$allQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Year = '$filterYear' AND si.AY = '$academic_year' AND dept.code = '$tempDepartment'");
					while($temp = mysqli_fetch_array($maleQuery)){
						if(!is_null($temp['Average'])){
							$maleAverage = $temp['Average'];
						}
					}
					while($temp = mysqli_fetch_array($femaleQuery)){
						if(!is_null($temp['Average'])){
							$femaleAverage = $temp['Average'];
						}
					}
					while($temp = mysqli_fetch_array($allQuery)){
						if(!is_null($temp['Average'])){
							$allAverage = $temp['Average'];
						}
					}
					if($maleAverage != ""){
						$male[$i] = array("y" => $maleAverage, "label" => $tempDepartment);
					} else {
						$male[$i] = array("y" => 0, "label" => $tempDepartment);
					}
					if($femaleAverage != ""){
						$female[$i] = array("y" => $femaleAverage, "label" => $tempDepartment);
					} else {
						$female[$i] = array("y" => 0, "label" => $tempDepartment);
					}
					if($allAverage != ""){
						$all[$i] = array("y" => $allAverage, "label" => $tempDepartment);
					} else {
						$all[$i] = array("y" => 0, "label" => $tempDepartment);
					}
					$i++;
				}
			} else if($filterYear != "all" && $filterSem != "all" && $academic_year != "all"){
				echo"<script>var title = '".$filterYear." year, ".$filterSem." Sem and ".$academic_year." Grade Average';</script>";
				$outerQuery = mysqli_query($conn, "SELECT * FROM department GROUP BY code");
				while($res=mysqli_fetch_array($outerQuery)){
					$tempDepartment = $res['code'];
					$maleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Gender = 'Male' AND si.Year = '$filterYear' AND si.Sem = '$filterSem' AND si.AY = '$academic_year' AND dept.code = '$tempDepartment'");
					$femaleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Gender = 'Female' AND si.Year = '$filterYear' AND si.Sem = '$filterSem' AND si.AY = '$academic_year' AND dept.code = '$tempDepartment'");
					$allQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Year = '$filterYear' AND si.Sem = '$filterSem' AND si.AY = '$academic_year' AND dept.code = '$tempDepartment'");
					while($temp = mysqli_fetch_array($maleQuery)){
						if(!is_null($temp['Average'])){
							$maleAverage = $temp['Average'];
						}
					}
					while($temp = mysqli_fetch_array($femaleQuery)){
						if(!is_null($temp['Average'])){
							$femaleAverage = $temp['Average'];
						}
					}
					while($temp = mysqli_fetch_array($allQuery)){
						if(!is_null($temp['Average'])){
							$allAverage = $temp['Average'];
						}
					}
					if($maleAverage != ""){
						$male[$i] = array("y" => $maleAverage, "label" => $tempDepartment);
					} else {
						$male[$i] = array("y" => 0, "label" => $tempDepartment);
					}
					if($femaleAverage != ""){
						$female[$i] = array("y" => $femaleAverage, "label" => $tempDepartment);
					} else {
						$female[$i] = array("y" => 0, "label" => $tempDepartment);
					}
					if($allAverage != ""){
						$all[$i] = array("y" => $allAverage, "label" => $tempDepartment);
					} else {
						$all[$i] = array("y" => 0, "label" => $tempDepartment);
					}
					$i++;
				}
			}
		}
		if(isset($filterYear) && !isset($filterSem) && !isset($academic_year)){
			if($filterYear == "all"){
				echo"<script>var title = 'All Year Grade Average in Laguna University';</script>";
				$outerQuery = mysqli_query($conn, "SELECT * FROM department GROUP BY code");
				while($res=mysqli_fetch_array($outerQuery)){
					$tempDepartment = $res['code'];
					$maleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Gender = 'Male' AND si.Year = '$filterYear' AND dept.code = '$tempDepartment'");
					$femaleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Gender = 'Female' AND si.Year = '$filterYear' AND dept.code = '$tempDepartment'");
					$allQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Year='$filterYear' AND dept.code = '$tempDepartment'");
					while($temp = mysqli_fetch_array($maleQuery)){
						if(!is_null($temp['Average'])){
							$maleAverage = $temp['Average'];
						}
					}
					while($temp = mysqli_fetch_array($femaleQuery)){
						if(!is_null($temp['Average'])){
							$femaleAverage = $temp['Average'];
						}
					}
					while($temp = mysqli_fetch_array($allQuery)){
						if(!is_null($temp['Average'])){
							$allAverage = $temp['Average'];
						}
					}
					if($maleAverage != ""){
						$male[$i] = array("y" => $maleAverage, "label" => $tempDepartment);
					} else {
						$male[$i] = array("y" => 0, "label" => $tempDepartment);
					}
					if($femaleAverage != ""){
						$female[$i] = array("y" => $femaleAverage, "label" => $tempDepartment);
					} else {
						$female[$i] = array("y" => 0, "label" => $tempDepartment);
					}
					if($allAverage != ""){
						$all[$i] = array("y" => $allAverage, "label" => $tempDepartment);
					} else {
						$all[$i] = array("y" => 0, "label" => $tempDepartment);
					}
					$i++;
				}
			} else {
				echo"<script>
					var title = '".$filterYear." Year Grade Average in Laguna University';
				</script>";
				$outerQuery = mysqli_query($conn, "SELECT * FROM department GROUP BY code");
				while($res=mysqli_fetch_array($outerQuery)){
					$tempDepartment = $res['code'];
					$maleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Gender = 'Male' AND si.Year = '$filterYear' AND dept.code = '$tempDepartment'");
					$femaleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Gender = 'Female' AND si.Year = '$filterYear' AND dept.code = '$tempDepartment'");
					$allQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Year='$filterYear' AND dept.code = '$tempDepartment'");
					while($temp = mysqli_fetch_array($maleQuery)){
						if(!is_null($temp['Average'])){
							$maleAverage = $temp['Average'];
						}
					}
					while($temp = mysqli_fetch_array($femaleQuery)){
						if(!is_null($temp['Average'])){
							$femaleAverage = $temp['Average'];
						}
					}
					while($temp = mysqli_fetch_array($allQuery)){
						if(!is_null($temp['Average'])){
							$allAverage = $temp['Average'];
						}
					}
					if($maleAverage != ""){
						$male[$i] = array("y" => $maleAverage, "label" => $tempDepartment);
					} else {
						$male[$i] = array("y" => 0, "label" => $tempDepartment);
					}
					if($femaleAverage != ""){
						$female[$i] = array("y" => $femaleAverage, "label" => $tempDepartment);
					} else {
						$female[$i] = array("y" => 0, "label" => $tempDepartment);
					}
					if($allAverage != ""){
						$all[$i] = array("y" => $allAverage, "label" => $tempDepartment);
					} else {
						$all[$i] = array("y" => 0, "label" => $tempDepartment);
					}
					$i++;
				}
			}
		} else if(!isset($filterYear) && isset($filterSem) && !isset($academic_year)){
			if($filterSem == "all"){
				echo"<script>var title = 'All Sem Grade Average in Laguna University';</script>";
				$outerQuery = mysqli_query($conn, "SELECT * FROM department GROUP BY code");
				while($res=mysqli_fetch_array($outerQuery)){
					$tempDepartment = $res['code'];
					$maleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Gender = 'Male' AND si.Year = '$filterYear' AND dept.code = '$tempDepartment'");
					$femaleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Gender = 'Female' AND si.Year = '$filterYear' AND dept.code = '$tempDepartment'");
					$allQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Year='$filterYear' AND dept.code = '$tempDepartment'");
					while($temp = mysqli_fetch_array($maleQuery)){
						if(!is_null($temp['Average'])){
							$maleAverage = $temp['Average'];
						}
					}
					while($temp = mysqli_fetch_array($femaleQuery)){
						if(!is_null($temp['Average'])){
							$femaleAverage = $temp['Average'];
						}
					}
					while($temp = mysqli_fetch_array($allQuery)){
						if(!is_null($temp['Average'])){
							$allAverage = $temp['Average'];
						}
					}
					if($maleAverage != ""){
						$male[$i] = array("y" => $maleAverage, "label" => $tempDepartment);
					} else {
						$male[$i] = array("y" => 0, "label" => $tempDepartment);
					}
					if($femaleAverage != ""){
						$female[$i] = array("y" => $femaleAverage, "label" => $tempDepartment);
					} else {
						$female[$i] = array("y" => 0, "label" => $tempDepartment);
					}
					if($allAverage != ""){
						$all[$i] = array("y" => $allAverage, "label" => $tempDepartment);
					} else {
						$all[$i] = array("y" => 0, "label" => $tempDepartment);
					}
					$i++;
				}
			} else {
				echo"<script>
					var title = '".$filterSem." Sem Grade Average in Laguna University';
				</script>";
				$outerQuery = mysqli_query($conn, "SELECT * FROM department GROUP BY code");
				while($res=mysqli_fetch_array($outerQuery)){
					$tempDepartment = $res['code'];
					$maleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Gender = 'Male' AND si.Sem = '$filterSem' AND dept.code = '$tempDepartment'");
					$femaleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Gender = 'Female' AND si.Sem = '$filterSem' AND dept.code = '$tempDepartment'");
					$allQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Sem='$filterSem' AND dept.code = '$tempDepartment'");
					while($temp = mysqli_fetch_array($maleQuery)){
						if(!is_null($temp['Average'])){
							$maleAverage = $temp['Average'];
						}
					}
					while($temp = mysqli_fetch_array($femaleQuery)){
						if(!is_null($temp['Average'])){
							$femaleAverage = $temp['Average'];
						}
					}
					while($temp = mysqli_fetch_array($allQuery)){
						if(!is_null($temp['Average'])){
							$allAverage = $temp['Average'];
						}
					}
					if($maleAverage != ""){
						$male[$i] = array("y" => $maleAverage, "label" => $tempDepartment);
					} else {
						$male[$i] = array("y" => 0, "label" => $tempDepartment);
					}
					if($femaleAverage != ""){
						$female[$i] = array("y" => $femaleAverage, "label" => $tempDepartment);
					} else {
						$female[$i] = array("y" => 0, "label" => $tempDepartment);
					}
					if($allAverage != ""){
						$all[$i] = array("y" => $allAverage, "label" => $tempDepartment);
					} else {
						$all[$i] = array("y" => 0, "label" => $tempDepartment);
					}
					$i++;
				}
			}
		} else if(!isset($filterYear) && !isset($filterSem) && isset($academic_year)){
			if($academic_year == "all"){
				echo"<script>var title = 'All academic year Grade Average in Laguna University';</script>";
				$outerQuery = mysqli_query($conn, "SELECT * FROM department GROUP BY code");
				while($res=mysqli_fetch_array($outerQuery)){
					$tempDepartment = $res['code'];
					$maleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Gender = 'Male' AND si.AY = '$academic_year' AND dept.code = '$tempDepartment'");
					$femaleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Gender = 'Female' AND si.AY = '$academic_year' AND dept.code = '$tempDepartment'");
					$allQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.AY='$academic_year' AND dept.code = '$tempDepartment'");
					while($temp = mysqli_fetch_array($maleQuery)){
						if(!is_null($temp['Average'])){
							$maleAverage = $temp['Average'];
						}
					}
					while($temp = mysqli_fetch_array($femaleQuery)){
						if(!is_null($temp['Average'])){
							$femaleAverage = $temp['Average'];
						}
					}
					while($temp = mysqli_fetch_array($allQuery)){
						if(!is_null($temp['Average'])){
							$allAverage = $temp['Average'];
						}
					}
					if($maleAverage != ""){
						$male[$i] = array("y" => $maleAverage, "label" => $tempDepartment);
					} else {
						$male[$i] = array("y" => 0, "label" => $tempDepartment);
					}
					if($femaleAverage != ""){
						$female[$i] = array("y" => $femaleAverage, "label" => $tempDepartment);
					} else {
						$female[$i] = array("y" => 0, "label" => $tempDepartment);
					}
					if($allAverage != ""){
						$all[$i] = array("y" => $allAverage, "label" => $tempDepartment);
					} else {
						$all[$i] = array("y" => 0, "label" => $tempDepartment);
					}
					$i++;
				}
			} else {
				echo"<script>
					var title = '".$academic_year." Grade Average in Laguna University';
				</script>";
				$outerQuery = mysqli_query($conn, "SELECT * FROM department GROUP BY code");
				while($res=mysqli_fetch_array($outerQuery)){
					$tempDepartment = $res['code'];
					$maleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Gender = 'Male' AND si.AY = '$academic_year' AND dept.code = '$tempDepartment'");
					$femaleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Gender = 'Female' AND si.AY = '$academic_year' AND dept.code = '$tempDepartment'");
					$allQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.AY='$academic_year' AND dept.code = '$tempDepartment'");
					while($temp = mysqli_fetch_array($maleQuery)){
						if(!is_null($temp['Average'])){
							$maleAverage = $temp['Average'];
						}
					}
					while($temp = mysqli_fetch_array($femaleQuery)){
						if(!is_null($temp['Average'])){
							$femaleAverage = $temp['Average'];
						}
					}
					while($temp = mysqli_fetch_array($allQuery)){
						if(!is_null($temp['Average'])){
							$allAverage = $temp['Average'];
						}
					}
					if($maleAverage != ""){
						$male[$i] = array("y" => $maleAverage, "label" => $tempDepartment);
					} else {
						$male[$i] = array("y" => 0, "label" => $tempDepartment);
					}
					if($femaleAverage != ""){
						$female[$i] = array("y" => $femaleAverage, "label" => $tempDepartment);
					} else {
						$female[$i] = array("y" => 0, "label" => $tempDepartment);
					}
					if($allAverage != ""){
						$all[$i] = array("y" => $allAverage, "label" => $tempDepartment);
					} else {
						$all[$i] = array("y" => 0, "label" => $tempDepartment);
					}
					$i++;
				}
			}
		} else if(isset($filterYear) && isset($filterSem) && !isset($academic_year)){
			if($filterYear == "all" && $filterSem == "all"){
				echo"<script>
					var title = 'All year and All Sem Grade Average';
				</script>";
				$outerQuery = mysqli_query($conn, "SELECT * FROM department GROUP BY code");
				while($res=mysqli_fetch_array($outerQuery)){
					$tempDepartment = $res['code'];
					$maleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Gender = 'Male' AND dept.code = '$tempDepartment'");
					$femaleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Gender = 'Female' AND dept.code = '$tempDepartment'");
					$allQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE dept.code = '$tempDepartment'");
					while($temp = mysqli_fetch_array($maleQuery)){
						if(!is_null($temp['Average'])){
							$maleAverage = $temp['Average'];
						}
					}
					while($temp = mysqli_fetch_array($femaleQuery)){
						if(!is_null($temp['Average'])){
							$femaleAverage = $temp['Average'];
						}
					}
					while($temp = mysqli_fetch_array($allQuery)){
						if(!is_null($temp['Average'])){
							$allAverage = $temp['Average'];
						}
					}
					if($maleAverage != ""){
						$male[$i] = array("y" => $maleAverage, "label" => $tempDepartment);
					} else {
						$male[$i] = array("y" => 0, "label" => $tempDepartment);
					}
					if($femaleAverage != ""){
						$female[$i] = array("y" => $femaleAverage, "label" => $tempDepartment);
					} else {
						$female[$i] = array("y" => 0, "label" => $tempDepartment);
					}
					if($allAverage != ""){
						$all[$i] = array("y" => $allAverage, "label" => $tempDepartment);
					} else {
						$all[$i] = array("y" => 0, "label" => $tempDepartment);
					}
					$i++;
				}
			} else if($filterYear == "all" || $filterSem == "all"){}
				echo"<script>
					var title = '".$filterYear." year and ".$filterSem." Sem Grade Average';
				</script>";
				$outerQuery = mysqli_query($conn, "SELECT * FROM department GROUP BY code");
				while($res=mysqli_fetch_array($outerQuery)){
					$tempDepartment = $res['code'];
					$maleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Gender = 'Male' AND si.Year = '$filterYear' OR si.Sem = '$filterSem' AND dept.code = '$tempDepartment'");
					$femaleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Gender = 'Female' AND si.Year = '$filterYear' OR si.Sem = '$filterSem' AND dept.code = '$tempDepartment'");
					$allQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Year='$filterYear' OR si.Sem = '$filterSem' AND dept.code = '$tempDepartment'");
					while($temp = mysqli_fetch_array($maleQuery)){
						if(!is_null($temp['Average'])){
							$maleAverage = $temp['Average'];
						}
					}
					while($temp = mysqli_fetch_array($femaleQuery)){
						if(!is_null($temp['Average'])){
							$femaleAverage = $temp['Average'];
						}
					}
					while($temp = mysqli_fetch_array($allQuery)){
						if(!is_null($temp['Average'])){
							$allAverage = $temp['Average'];
						}
					}
					if($maleAverage != ""){
						$male[$i] = array("y" => $maleAverage, "label" => $tempDepartment);
					} else {
						$male[$i] = array("y" => 0, "label" => $tempDepartment);
					}
					if($femaleAverage != ""){
						$female[$i] = array("y" => $femaleAverage, "label" => $tempDepartment);
					} else {
						$female[$i] = array("y" => 0, "label" => $tempDepartment);
					}
					if($allAverage != ""){
						$all[$i] = array("y" => $allAverage, "label" => $tempDepartment);
					} else {
						$all[$i] = array("y" => 0, "label" => $tempDepartment);
					}
					$i++;
				}
			} else {
				echo"<script>
					var title = '".$filterYear." year and ".$filterSem." Sem Grade Average';
				</script>";
				$outerQuery = mysqli_query($conn, "SELECT * FROM department GROUP BY code");
				while($res=mysqli_fetch_array($outerQuery)){
					$tempDepartment = $res['code'];
					$maleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Gender = 'Male' AND si.Year = '$filterYear' AND si.Sem = '$filterSem' AND dept.code = '$tempDepartment'");
					$femaleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Gender = 'Female' AND si.Year = '$filterYear' AND si.Sem = '$filterSem' AND dept.code = '$tempDepartment'");
					$allQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Year='$filterYear' AND si.Sem = '$filterSem' AND dept.code = '$tempDepartment'");
					while($temp = mysqli_fetch_array($maleQuery)){
						if(!is_null($temp['Average'])){
							$maleAverage = $temp['Average'];
						}
					}
					while($temp = mysqli_fetch_array($femaleQuery)){
						if(!is_null($temp['Average'])){
							$femaleAverage = $temp['Average'];
						}
					}
					while($temp = mysqli_fetch_array($allQuery)){
						if(!is_null($temp['Average'])){
							$allAverage = $temp['Average'];
						}
					}
					if($maleAverage != ""){
						$male[$i] = array("y" => $maleAverage, "label" => $tempDepartment);
					} else {
						$male[$i] = array("y" => 0, "label" => $tempDepartment);
					}
					if($femaleAverage != ""){
						$female[$i] = array("y" => $femaleAverage, "label" => $tempDepartment);
					} else {
						$female[$i] = array("y" => 0, "label" => $tempDepartment);
					}
					if($allAverage != ""){
						$all[$i] = array("y" => $allAverage, "label" => $tempDepartment);
					} else {
						$all[$i] = array("y" => 0, "label" => $tempDepartment);
					}
					$i++;
				}
			}
		} else if(isset($filterYear) && !isset($filterSem) && isset($academic_year)){
			if($filterYear == "all" && $academic_year == "all"){
				echo"<script>
					var title = 'All year and All Academic_year Grade Average';
				</script>";
				$outerQuery = mysqli_query($conn, "SELECT * FROM department GROUP BY code");
				while($res=mysqli_fetch_array($outerQuery)){
					$tempDepartment = $res['code'];
					$maleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Gender = 'Male' AND dept.code = '$tempDepartment'");
					$femaleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Gender = 'Female' AND dept.code = '$tempDepartment'");
					$allQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE dept.code = '$tempDepartment'");
					while($temp = mysqli_fetch_array($maleQuery)){
						if(!is_null($temp['Average'])){
							$maleAverage = $temp['Average'];
						}
					}
					while($temp = mysqli_fetch_array($femaleQuery)){
						if(!is_null($temp['Average'])){
							$femaleAverage = $temp['Average'];
						}
					}
					while($temp = mysqli_fetch_array($allQuery)){
						if(!is_null($temp['Average'])){
							$allAverage = $temp['Average'];
						}
					}
					if($maleAverage != ""){
						$male[$i] = array("y" => $maleAverage, "label" => $tempDepartment);
					} else {
						$male[$i] = array("y" => 0, "label" => $tempDepartment);
					}
					if($femaleAverage != ""){
						$female[$i] = array("y" => $femaleAverage, "label" => $tempDepartment);
					} else {
						$female[$i] = array("y" => 0, "label" => $tempDepartment);
					}
					if($allAverage != ""){
						$all[$i] = array("y" => $allAverage, "label" => $tempDepartment);
					} else {
						$all[$i] = array("y" => 0, "label" => $tempDepartment);
					}
					$i++;
				}
			} else if($filterYear == "all" || $academic_year == "all"){
				echo"<script>
					var title = '".$filterYear." year and ".$academic_year." Sem Grade Average';
				</script>";
				$outerQuery = mysqli_query($conn, "SELECT * FROM department GROUP BY code");
				while($res=mysqli_fetch_array($outerQuery)){
					$tempDepartment = $res['code'];
					$maleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Gender = 'Male' AND si.Year = '$filterYear' OR si.AY = '$academic_year' AND dept.code = '$tempDepartment'");
					$femaleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Gender = 'Female' AND si.Year = '$filterYear' OR si.AY = '$academic_year' AND dept.code = '$tempDepartment'");
					$allQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Year='$filterYear' AND si.AY = '$academic_year' OR dept.code = '$tempDepartment'");
					while($temp = mysqli_fetch_array($maleQuery)){
						if(!is_null($temp['Average'])){
							$maleAverage = $temp['Average'];
						}
					}
					while($temp = mysqli_fetch_array($femaleQuery)){
						if(!is_null($temp['Average'])){
							$femaleAverage = $temp['Average'];
						}
					}
					while($temp = mysqli_fetch_array($allQuery)){
						if(!is_null($temp['Average'])){
							$allAverage = $temp['Average'];
						}
					}
					if($maleAverage != ""){
						$male[$i] = array("y" => $maleAverage, "label" => $tempDepartment);
					} else {
						$male[$i] = array("y" => 0, "label" => $tempDepartment);
					}
					if($femaleAverage != ""){
						$female[$i] = array("y" => $femaleAverage, "label" => $tempDepartment);
					} else {
						$female[$i] = array("y" => 0, "label" => $tempDepartment);
					}
					if($allAverage != ""){
						$all[$i] = array("y" => $allAverage, "label" => $tempDepartment);
					} else {
						$all[$i] = array("y" => 0, "label" => $tempDepartment);
					}
					$i++;
				}
			} else {
				echo"<script>
					var title = '".$filterYear." year and ".$academic_year." Sem Grade Average';
				</script>";
				$outerQuery = mysqli_query($conn, "SELECT * FROM department GROUP BY code");
				while($res=mysqli_fetch_array($outerQuery)){
					$tempDepartment = $res['code'];
					$maleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Gender = 'Male' AND si.Year = '$filterYear' AND si.AY = '$academic_year' AND dept.code = '$tempDepartment'");
					$femaleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Gender = 'Female' AND si.Year = '$filterYear' AND si.AY = '$academic_year' AND dept.code = '$tempDepartment'");
					$allQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Year='$filterYear' AND si.AY = '$academic_year' AND dept.code = '$tempDepartment'");
					while($temp = mysqli_fetch_array($maleQuery)){
						if(!is_null($temp['Average'])){
							$maleAverage = $temp['Average'];
						}
					}
					while($temp = mysqli_fetch_array($femaleQuery)){
						if(!is_null($temp['Average'])){
							$femaleAverage = $temp['Average'];
						}
					}
					while($temp = mysqli_fetch_array($allQuery)){
						if(!is_null($temp['Average'])){
							$allAverage = $temp['Average'];
						}
					}
					if($maleAverage != ""){
						$male[$i] = array("y" => $maleAverage, "label" => $tempDepartment);
					} else {
						$male[$i] = array("y" => 0, "label" => $tempDepartment);
					}
					if($femaleAverage != ""){
						$female[$i] = array("y" => $femaleAverage, "label" => $tempDepartment);
					} else {
						$female[$i] = array("y" => 0, "label" => $tempDepartment);
					}
					if($allAverage != ""){
						$all[$i] = array("y" => $allAverage, "label" => $tempDepartment);
					} else {
						$all[$i] = array("y" => 0, "label" => $tempDepartment);
					}
					$i++;
				}
			}
		} else if(!isset($filterYear) && isset($filterSem) && isset($academic_year)){
			if($filterSem == "all" && $academic_year == "all"){
				echo"<script>
					var title = 'All year and All Academic_year Grade Average';
				</script>";
				$outerQuery = mysqli_query($conn, "SELECT * FROM department GROUP BY code");
				while($res=mysqli_fetch_array($outerQuery)){
					$tempDepartment = $res['code'];
					$maleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Gender = 'Male' AND dept.code = '$tempDepartment'");
					$femaleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Gender = 'Female' AND dept.code = '$tempDepartment'");
					$allQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE dept.code = '$tempDepartment'");
					while($temp = mysqli_fetch_array($maleQuery)){
						if(!is_null($temp['Average'])){
							$maleAverage = $temp['Average'];
						}
					}
					while($temp = mysqli_fetch_array($femaleQuery)){
						if(!is_null($temp['Average'])){
							$femaleAverage = $temp['Average'];
						}
					}
					while($temp = mysqli_fetch_array($allQuery)){
						if(!is_null($temp['Average'])){
							$allAverage = $temp['Average'];
						}
					}
					if($maleAverage != ""){
						$male[$i] = array("y" => $maleAverage, "label" => $tempDepartment);
					} else {
						$male[$i] = array("y" => 0, "label" => $tempDepartment);
					}
					if($femaleAverage != ""){
						$female[$i] = array("y" => $femaleAverage, "label" => $tempDepartment);
					} else {
						$female[$i] = array("y" => 0, "label" => $tempDepartment);
					}
					if($allAverage != ""){
						$all[$i] = array("y" => $allAverage, "label" => $tempDepartment);
					} else {
						$all[$i] = array("y" => 0, "label" => $tempDepartment);
					}
					$i++;
				}
			} else if($filterSem == "all" || $academic_year == "all"){
				echo"<script>
					var title = '".$filterSem." Sem in ".$academic_year." Academic Year Grade Average';
				</script>";
				$outerQuery = mysqli_query($conn, "SELECT * FROM department GROUP BY code");
				while($res=mysqli_fetch_array($outerQuery)){
					$tempDepartment = $res['code'];
					$maleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Gender = 'Male' AND si.Sem = '$filterSem' OR si.AY = '$academic_year' AND dept.code = '$tempDepartment'");
					$femaleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Gender = 'Female' AND si.Sem = '$filterSem' OR si.AY = '$academic_year' AND dept.code = '$tempDepartment'");
					$allQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Sem='$filterSem' OR si.AY = '$academic_year' AND dept.code = '$tempDepartment'");
					while($temp = mysqli_fetch_array($maleQuery)){
						if(!is_null($temp['Average'])){
							$maleAverage = $temp['Average'];
						}
					}
					while($temp = mysqli_fetch_array($femaleQuery)){
						if(!is_null($temp['Average'])){
							$femaleAverage = $temp['Average'];
						}
					}
					while($temp = mysqli_fetch_array($allQuery)){
						if(!is_null($temp['Average'])){
							$allAverage = $temp['Average'];
						}
					}
					if($maleAverage != ""){
						$male[$i] = array("y" => $maleAverage, "label" => $tempDepartment);
					} else {
						$male[$i] = array("y" => 0, "label" => $tempDepartment);
					}
					if($femaleAverage != ""){
						$female[$i] = array("y" => $femaleAverage, "label" => $tempDepartment);
					} else {
						$female[$i] = array("y" => 0, "label" => $tempDepartment);
					}
					if($allAverage != ""){
						$all[$i] = array("y" => $allAverage, "label" => $tempDepartment);
					} else {
						$all[$i] = array("y" => 0, "label" => $tempDepartment);
					}
					$i++;
				}
			} else {
				echo"<script>
					var title = '".$filterSem." Sem in ".$academic_year." Academic Year Grade Average';
				</script>";
				$outerQuery = mysqli_query($conn, "SELECT * FROM department GROUP BY code");
				while($res=mysqli_fetch_array($outerQuery)){
					$tempDepartment = $res['code'];
					$maleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Gender = 'Male' AND si.Sem = '$filterSem' AND si.AY = '$academic_year' AND dept.code = '$tempDepartment'");
					$femaleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Gender = 'Female' AND si.Sem = '$filterSem' AND si.AY = '$academic_year' AND dept.code = '$tempDepartment'");
					$allQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Sem='$filterSem' AND si.AY = '$academic_year' AND dept.code = '$tempDepartment'");
					while($temp = mysqli_fetch_array($maleQuery)){
						if(!is_null($temp['Average'])){
							$maleAverage = $temp['Average'];
						}
					}
					while($temp = mysqli_fetch_array($femaleQuery)){
						if(!is_null($temp['Average'])){
							$femaleAverage = $temp['Average'];
						}
					}
					while($temp = mysqli_fetch_array($allQuery)){
						if(!is_null($temp['Average'])){
							$allAverage = $temp['Average'];
						}
					}
					if($maleAverage != ""){
						$male[$i] = array("y" => $maleAverage, "label" => $tempDepartment);
					} else {
						$male[$i] = array("y" => 0, "label" => $tempDepartment);
					}
					if($femaleAverage != ""){
						$female[$i] = array("y" => $femaleAverage, "label" => $tempDepartment);
					} else {
						$female[$i] = array("y" => 0, "label" => $tempDepartment);
					}
					if($allAverage != ""){
						$all[$i] = array("y" => $allAverage, "label" => $tempDepartment);
					} else {
						$all[$i] = array("y" => 0, "label" => $tempDepartment);
					}
					$i++;
				}
			}
	} else {
		//for lu
		echo"<script>var title = 'Grade Average in Laguna University';</script>";
		$outerQuery = mysqli_query($conn, "SELECT * FROM department GROUP BY code");
		while($res=mysqli_fetch_array($outerQuery)){
			$tempDepartment = $res['code'];
			$maleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
									JOIN student_information si ON si.Student_No = sg.Student_No
								    JOIN subject sub ON sub.Subject_Code = si.Class_Code
								    JOIN department dept ON dept.code = sub.department
								    WHERE si.Gender = 'Male' AND dept.code = '$tempDepartment'");
			$femaleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
									JOIN student_information si ON si.Student_No = sg.Student_No
								    JOIN subject sub ON sub.Subject_Code = si.Class_Code
								    JOIN department dept ON dept.code = sub.department
								    WHERE si.Gender = 'Female' AND dept.code = '$tempDepartment'");
			$allQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
									JOIN student_information si ON si.Student_No = sg.Student_No
								    JOIN subject sub ON sub.Subject_Code = si.Class_Code
								    JOIN department dept ON dept.code = sub.department
								    WHERE dept.code = '$tempDepartment'");
			while($temp = mysqli_fetch_array($maleQuery)){
				$maleAverage = $temp['Average'];
			}
			while($temp = mysqli_fetch_array($femaleQuery)){
				$femaleAverage = $temp['Average'];
			}
			while($temp = mysqli_fetch_array($allQuery)){
				$allAverage = $temp['Average'];
			}
			if($maleAverage != ""){
				$male[$i] = array("y" => $maleAverage, "label" => $tempDepartment);
			} else {
				$male[$i] = array("y" => 0, "label" => $tempDepartment);
			}
			if($femaleAverage != ""){
				$female[$i] = array("y" => $femaleAverage, "label" => $tempDepartment);
			} else {
				$female[$i] = array("y" => 0, "label" => $tempDepartment);
			}
			if($allAverage != ""){
				$all[$i] = array("y" => $allAverage, "label" => $tempDepartment);
			} else {
				$all[$i] = array("y" => 0, "label" => $tempDepartment);
			}
			$i++;
		}
	}
	if(isset($_POST['submitDepartment'])){
		$selectedDepartment = $_POST['filterDepartment'];
		if(isset($_POST['deptyear'])){
			$filterYear = $_POST['deptyear'];
		}
		if(isset($_POST['deptsem'])){
			$filterSem = $_POST['deptsem'];
		}
		if(isset($_POST['deptacademic_year'])){
			$academic_year = $_POST['deptacademic_year'];
		}
		if(isset($filterYear) && isset($filterSem) && isset($academic_year)){
			if($filterYear == "all" && $filterSem == "all" && $academic_year == "all"){
				echo"<script>var departmentTitle = '".$selectedDepartment.", All Year and All Sem and All Academic Year Grade Average';</script>";
				$outerQuery = mysqli_query($conn, "SELECT * FROM subject WHERE department = '$selectedDepartment' GROUP BY department");
				while($res=mysqli_fetch_array($outerQuery)){
					$tempDepartment = $res['Subject_Code'];
					$maleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Gender = 'Male' AND sub.Subject_Code = '$tempDepartment'");
					$femaleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Gender = 'Female' AND sub.Subject_Code = '$tempDepartment'");
					$allQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE sub.Subject_Code = '$tempDepartment'");
					while($temp = mysqli_fetch_array($maleQuery)){
						$departmentMaleAverage = $temp['Average'];
					}
					while($temp = mysqli_fetch_array($femaleQuery)){
						$departmentFemaleAverage = $temp['Average'];
					}
					while($temp = mysqli_fetch_array($allQuery)){
						$departmentAllAverage = $temp['Average'];
					}
					if($departmentMaleAverage != ""){
						$departmentMale[$ii] = array("y" => $departmentMaleAverage, "label" => $tempDepartment);
					} else {
						$departmentMale[$ii] = array("y" => 0, "label" => $tempDepartment);
					}
					if($departmentFemaleAverage != ""){
						$departmentFemale[$ii] = array("y" => $departmentFemaleAverage, "label" => $tempDepartment);
					} else {
						$departmentFemale[$ii] = array("y" => 0, "label" => $tempDepartment);
					}
					if($departmentAllAverage != ""){
						$departmentAll[$ii] = array("y" => $departmentAllAverage, "label" => $tempDepartment);
					} else {
						$departmentAll[$ii] = array("y" => 0, "label" => $tempDepartment);
					}
					$ii++;
				}
			} else if($filterYear != "all" && $filterSem == "all" && $academic_year == "all"){
				echo"<script>var departmentTitle = '".$selectedDepartment.", ".$filterYear." Year and All Sem and All Academic Year Grade Average';</script>";
				$outerQuery = mysqli_query($conn, "SELECT * FROM subject WHERE department = '$selectedDepartment' GROUP BY department");
				while($res=mysqli_fetch_array($outerQuery)){
					$tempDepartment = $res['Subject_Code'];
					$maleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Gender = 'Male' AND si.Year = '$filterYear' AND sub.Subject_Code = '$tempDepartment'");
					$femaleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Gender = 'Female' AND si.Year = '$filterYear' AND  sub.Subject_Code = '$tempDepartment'");
					$allQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Year = '$filterYear' AND  sub.Subject_Code = '$tempDepartment'");
					while($temp = mysqli_fetch_array($maleQuery)){
						$departmentMaleAverage = $temp['Average'];
					}
					while($temp = mysqli_fetch_array($femaleQuery)){
						$departmentFemaleAverage = $temp['Average'];
					}
					while($temp = mysqli_fetch_array($allQuery)){
						$departmentAllAverage = $temp['Average'];
					}
					if($departmentMaleAverage != ""){
						$departmentMale[$ii] = array("y" => $departmentMaleAverage, "label" => $tempDepartment);
					} else {
						$departmentMale[$ii] = array("y" => 0, "label" => $tempDepartment);
					}
					if($departmentFemaleAverage != ""){
						$departmentFemale[$ii] = array("y" => $departmentFemaleAverage, "label" => $tempDepartment);
					} else {
						$departmentFemale[$ii] = array("y" => 0, "label" => $tempDepartment);
					}
					if($departmentAllAverage != ""){
						$departmentAll[$ii] = array("y" => $departmentAllAverage, "label" => $tempDepartment);
					} else {
						$departmentAll[$ii] = array("y" => 0, "label" => $tempDepartment);
					}
					$ii++;
				}
			} else if($filterYear == "all" && $filterSem != "all" && $academic_year != "all"){
				echo"<script>var departmentTitle = '".$selectedDepartment.", All Year and ".$filterSem." Sem and ".$academic_year." Academic Year Grade Average';</script>";
				$outerQuery = mysqli_query($conn, "SELECT * FROM subject WHERE department = '$selectedDepartment' GROUP BY department");
				while($res=mysqli_fetch_array($outerQuery)){
					$tempDepartment = $res['Subject_Code'];
					$maleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Gender = 'Male' AND si.Sem = '$filterSem' AND si.AY = '$academic_year' AND sub.Subject_Code = '$tempDepartment'");
					$femaleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Gender = 'Female' AND si.Sem = '$filterSem' AND si.AY = '$academic_year'  AND  sub.Subject_Code = '$tempDepartment'");
					$allQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Sem = '$filterSem' AND si.AY = '$academic_year' AND sub.Subject_Code = '$tempDepartment'");
					while($temp = mysqli_fetch_array($maleQuery)){
						$departmentMaleAverage = $temp['Average'];
					}
					while($temp = mysqli_fetch_array($femaleQuery)){
						$departmentFemaleAverage = $temp['Average'];
					}
					while($temp = mysqli_fetch_array($allQuery)){
						$departmentAllAverage = $temp['Average'];
					}
					if($departmentMaleAverage != ""){
						$departmentMale[$ii] = array("y" => $departmentMaleAverage, "label" => $tempDepartment);
					} else {
						$departmentMale[$ii] = array("y" => 0, "label" => $tempDepartment);
					}
					if($departmentFemaleAverage != ""){
						$departmentFemale[$ii] = array("y" => $departmentFemaleAverage, "label" => $tempDepartment);
					} else {
						$departmentFemale[$ii] = array("y" => 0, "label" => $tempDepartment);
					}
					if($departmentAllAverage != ""){
						$departmentAll[$ii] = array("y" => $departmentAllAverage, "label" => $tempDepartment);
					} else {
						$departmentAll[$ii] = array("y" => 0, "label" => $tempDepartment);
					}
					$ii++;
				}
			} else if($filterYear == "all" && $filterSem == "all" && $academic_year != "all"){
				echo"<script>var departmentTitle = '".$selectedDepartment.", All Year and All Sem and ".$academic_year." Academic Year Grade Average';</script>";
				$outerQuery = mysqli_query($conn, "SELECT * FROM subject WHERE department = '$selectedDepartment' GROUP BY department");
				while($res=mysqli_fetch_array($outerQuery)){
					$tempDepartment = $res['Subject_Code'];
					$maleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Gender = 'Male' AND si.AY = '$academic_year' AND sub.Subject_Code = '$tempDepartment'");
					$femaleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Gender = 'Female' AND si.AY = '$academic_year'  AND  sub.Subject_Code = '$tempDepartment'");
					$allQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.AY = '$academic_year' AND sub.Subject_Code = '$tempDepartment'");
					while($temp = mysqli_fetch_array($maleQuery)){
						$departmentMaleAverage = $temp['Average'];
					}
					while($temp = mysqli_fetch_array($femaleQuery)){
						$departmentFemaleAverage = $temp['Average'];
					}
					while($temp = mysqli_fetch_array($allQuery)){
						$departmentAllAverage = $temp['Average'];
					}
					if($departmentMaleAverage != ""){
						$departmentMale[$ii] = array("y" => $departmentMaleAverage, "label" => $tempDepartment);
					} else {
						$departmentMale[$ii] = array("y" => 0, "label" => $tempDepartment);
					}
					if($departmentFemaleAverage != ""){
						$departmentFemale[$ii] = array("y" => $departmentFemaleAverage, "label" => $tempDepartment);
					} else {
						$departmentFemale[$ii] = array("y" => 0, "label" => $tempDepartment);
					}
					if($departmentAllAverage != ""){
						$departmentAll[$ii] = array("y" => $departmentAllAverage, "label" => $tempDepartment);
					} else {
						$departmentAll[$ii] = array("y" => 0, "label" => $tempDepartment);
					}
					$ii++;
				}
			} else if($filterYear != "all" && $filterSem != "all" && $academic_year == "all"){
				echo"<script>var departmentTitle = '".$selectedDepartment.", ".$filterYear." Year and ".$filterSem." Sem and All Academic Year Academic Year Grade Average';</script>";
				$outerQuery = mysqli_query($conn, "SELECT * FROM subject WHERE department = '$selectedDepartment' GROUP BY department");
				while($res=mysqli_fetch_array($outerQuery)){
					$tempDepartment = $res['Subject_Code'];
					$maleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Gender = 'Male' AND si.Year = '$filterYear' AND si.Sem = '$filterSem' AND sub.Subject_Code = '$tempDepartment'");
					$femaleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Gender = 'Female' AND si.Year = '$filterYear' AND si.Sem = '$filterSem' AND sub.Subject_Code = '$tempDepartment'");
					$allQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Year = '$filterYear' AND si.Sem = '$filterSem' AND sub.Subject_Code = '$tempDepartment'");
					while($temp = mysqli_fetch_array($maleQuery)){
						$departmentMaleAverage = $temp['Average'];
					}
					while($temp = mysqli_fetch_array($femaleQuery)){
						$departmentFemaleAverage = $temp['Average'];
					}
					while($temp = mysqli_fetch_array($allQuery)){
						$departmentAllAverage = $temp['Average'];
					}
					if($departmentMaleAverage != ""){
						$departmentMale[$ii] = array("y" => $departmentMaleAverage, "label" => $tempDepartment);
					} else {
						$departmentMale[$ii] = array("y" => 0, "label" => $tempDepartment);
					}
					if($departmentFemaleAverage != ""){
						$departmentFemale[$ii] = array("y" => $departmentFemaleAverage, "label" => $tempDepartment);
					} else {
						$departmentFemale[$ii] = array("y" => 0, "label" => $tempDepartment);
					}
					if($departmentAllAverage != ""){
						$departmentAll[$ii] = array("y" => $departmentAllAverage, "label" => $tempDepartment);
					} else {
						$departmentAll[$ii] = array("y" => 0, "label" => $tempDepartment);
					}
					$ii++;
				}
			} else if($filterYear != "all" && $filterSem == "all" && $academic_year != "all"){
				echo"<script>var departmentTitle = '".$selectedDepartment.", ".$filterYear." Year and All Sem and ".$academic_year." Academic Year Academic Year Grade Average';</script>";
				$outerQuery = mysqli_query($conn, "SELECT * FROM subject WHERE department = '$selectedDepartment' GROUP BY department");
				while($res=mysqli_fetch_array($outerQuery)){
					$tempDepartment = $res['Subject_Code'];
					$maleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Gender = 'Male' AND si.Year = '$filterYear' AND si.AY = '$academic_year' AND sub.Subject_Code = '$tempDepartment'");
					$femaleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Gender = 'Female' AND si.Year = '$filterYear' AND si.AY = '$academic_year' AND sub.Subject_Code = '$tempDepartment'");
					$allQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Year = '$filterYear' AND si.AY = '$academic_year' AND sub.Subject_Code = '$tempDepartment'");
					while($temp = mysqli_fetch_array($maleQuery)){
						$departmentMaleAverage = $temp['Average'];
					}
					while($temp = mysqli_fetch_array($femaleQuery)){
						$departmentFemaleAverage = $temp['Average'];
					}
					while($temp = mysqli_fetch_array($allQuery)){
						$departmentAllAverage = $temp['Average'];
					}
					if($departmentMaleAverage != ""){
						$departmentMale[$ii] = array("y" => $departmentMaleAverage, "label" => $tempDepartment);
					} else {
						$departmentMale[$ii] = array("y" => 0, "label" => $tempDepartment);
					}
					if($departmentFemaleAverage != ""){
						$departmentFemale[$ii] = array("y" => $departmentFemaleAverage, "label" => $tempDepartment);
					} else {
						$departmentFemale[$ii] = array("y" => 0, "label" => $tempDepartment);
					}
					if($departmentAllAverage != ""){
						$departmentAll[$ii] = array("y" => $departmentAllAverage, "label" => $tempDepartment);
					} else {
						$departmentAll[$ii] = array("y" => 0, "label" => $tempDepartment);
					}
					$ii++;
				}
			} else if($filterYear != "all" && $filterSem != "all" && $academic_year != "all"){
				echo"<script>var departmentTitle = '".$selectedDepartment.", ".$filterYear." Year and ".$filterSem." Sem and ".$academic_year." Academic Year Academic Year Grade Average';</script>";
				$outerQuery = mysqli_query($conn, "SELECT * FROM subject WHERE department = '$selectedDepartment' GROUP BY department");
				while($res=mysqli_fetch_array($outerQuery)){
					$tempDepartment = $res['Subject_Code'];
					$maleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Gender = 'Male' AND si.Year = '$filterYear' AND si.Sem = '$filterSem' AND si.AY = '$academic_year' AND sub.Subject_Code = '$tempDepartment'");
					$femaleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Gender = 'Female' AND si.Year = '$filterYear' AND si.Sem = '$filterSem'  AND si.AY = '$academic_year' AND sub.Subject_Code = '$tempDepartment'");
					$allQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Year = '$filterYear' AND si.Sem = '$filterSem'  AND si.AY = '$academic_year' AND sub.Subject_Code = '$tempDepartment'");
					while($temp = mysqli_fetch_array($maleQuery)){
						$departmentMaleAverage = $temp['Average'];
					}
					while($temp = mysqli_fetch_array($femaleQuery)){
						$departmentFemaleAverage = $temp['Average'];
					}
					while($temp = mysqli_fetch_array($allQuery)){
						$departmentAllAverage = $temp['Average'];
					}
					if($departmentMaleAverage != ""){
						$departmentMale[$ii] = array("y" => $departmentMaleAverage, "label" => $tempDepartment);
					} else {
						$departmentMale[$ii] = array("y" => 0, "label" => $tempDepartment);
					}
					if($departmentFemaleAverage != ""){
						$departmentFemale[$ii] = array("y" => $departmentFemaleAverage, "label" => $tempDepartment);
					} else {
						$departmentFemale[$ii] = array("y" => 0, "label" => $tempDepartment);
					}
					if($departmentAllAverage != ""){
						$departmentAll[$ii] = array("y" => $departmentAllAverage, "label" => $tempDepartment);
					} else {
						$departmentAll[$ii] = array("y" => 0, "label" => $tempDepartment);
					}
					$ii++;
				}
			}
		}
		if(isset($filterYear) && !isset($filterSem) && !isset($academic_year)){
			if($filterYear == "all"){
				echo"<script>var departmentTitle = '".$selectedDepartment.", All Year Grade Average';</script>";
				$outerQuery = mysqli_query($conn, "SELECT * FROM subject WHERE department = '$selectedDepartment' GROUP BY department");
				while($res=mysqli_fetch_array($outerQuery)){
					$tempDepartment = $res['Subject_Code'];
					$maleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Gender = 'Male' AND sub.Subject_Code = '$tempDepartment'");
					$femaleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Gender = 'Female' AND sub.Subject_Code = '$tempDepartment'");
					$allQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE sub.Subject_Code = '$tempDepartment'");
					while($temp = mysqli_fetch_array($maleQuery)){
						$departmentMaleAverage = $temp['Average'];
					}
					while($temp = mysqli_fetch_array($femaleQuery)){
						$departmentFemaleAverage = $temp['Average'];
					}
					while($temp = mysqli_fetch_array($allQuery)){
						$departmentAllAverage = $temp['Average'];
					}
					if($departmentMaleAverage != ""){
						$departmentMale[$ii] = array("y" => $departmentMaleAverage, "label" => $tempDepartment);
					} else {
						$departmentMale[$ii] = array("y" => 0, "label" => $tempDepartment);
					}
					if($departmentFemaleAverage != ""){
						$departmentFemale[$ii] = array("y" => $departmentFemaleAverage, "label" => $tempDepartment);
					} else {
						$departmentFemale[$ii] = array("y" => 0, "label" => $tempDepartment);
					}
					if($departmentAllAverage != ""){
						$departmentAll[$ii] = array("y" => $departmentAllAverage, "label" => $tempDepartment);
					} else {
						$departmentAll[$ii] = array("y" => 0, "label" => $tempDepartment);
					}
					$ii++;
				}
			} else {
				echo"<script>var departmentTitle = '".$selectedDepartment.", ".$filterYear." Year Grade Average';</script>";
				$outerQuery = mysqli_query($conn, "SELECT * FROM subject WHERE department = '$selectedDepartment' GROUP BY department");
				while($res=mysqli_fetch_array($outerQuery)){
					$tempDepartment = $res['Subject_Code'];
					$maleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Gender = 'Male' AND si.Year = '$filterYear' AND sub.Subject_Code = '$tempDepartment'");
					$femaleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Gender = 'Female' AND si.Year = '$filterYear' AND sub.Subject_Code = '$tempDepartment'");
					$allQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Year = '$filterYear' AND sub.Subject_Code = '$tempDepartment'");
					while($temp = mysqli_fetch_array($maleQuery)){
						$departmentMaleAverage = $temp['Average'];
					}
					while($temp = mysqli_fetch_array($femaleQuery)){
						$departmentFemaleAverage = $temp['Average'];
					}
					while($temp = mysqli_fetch_array($allQuery)){
						$departmentAllAverage = $temp['Average'];
					}
					if($departmentMaleAverage != ""){
						$departmentMale[$ii] = array("y" => $departmentMaleAverage, "label" => $tempDepartment);
					} else {
						$departmentMale[$ii] = array("y" => 0, "label" => $tempDepartment);
					}
					if($departmentFemaleAverage != ""){
						$departmentFemale[$ii] = array("y" => $departmentFemaleAverage, "label" => $tempDepartment);
					} else {
						$departmentFemale[$ii] = array("y" => 0, "label" => $tempDepartment);
					}
					if($departmentAllAverage != ""){
						$departmentAll[$ii] = array("y" => $departmentAllAverage, "label" => $tempDepartment);
					} else {
						$departmentAll[$ii] = array("y" => 0, "label" => $tempDepartment);
					}
					$ii++;
				}
			}
		} else if(!isset($filterYear) && isset($filterSem) && !isset($academic_year)){
			if($filterSem == "all"){
				echo"<script>var departmentTitle = '".$selectedDepartment.", All Sem Grade Average';</script>";
				$outerQuery = mysqli_query($conn, "SELECT * FROM subject WHERE department = '$selectedDepartment' GROUP BY department");
				while($res=mysqli_fetch_array($outerQuery)){
					$tempDepartment = $res['Subject_Code'];
					$maleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Gender = 'Male' AND sub.Subject_Code = '$tempDepartment'");
					$femaleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Gender = 'Female' AND sub.Subject_Code = '$tempDepartment'");
					$allQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE sub.Subject_Code = '$tempDepartment'");
					while($temp = mysqli_fetch_array($maleQuery)){
						$departmentMaleAverage = $temp['Average'];
					}
					while($temp = mysqli_fetch_array($femaleQuery)){
						$departmentFemaleAverage = $temp['Average'];
					}
					while($temp = mysqli_fetch_array($allQuery)){
						$departmentAllAverage = $temp['Average'];
					}
					if($departmentMaleAverage != ""){
						$departmentMale[$ii] = array("y" => $departmentMaleAverage, "label" => $tempDepartment);
					} else {
						$departmentMale[$ii] = array("y" => 0, "label" => $tempDepartment);
					}
					if($departmentFemaleAverage != ""){
						$departmentFemale[$ii] = array("y" => $departmentFemaleAverage, "label" => $tempDepartment);
					} else {
						$departmentFemale[$ii] = array("y" => 0, "label" => $tempDepartment);
					}
					if($departmentAllAverage != ""){
						$departmentAll[$ii] = array("y" => $departmentAllAverage, "label" => $tempDepartment);
					} else {
						$departmentAll[$ii] = array("y" => 0, "label" => $tempDepartment);
					}
					$ii++;
				}
			} else {
				echo"<script>var departmentTitle = '".$selectedDepartment.", ".$filterSem." Sem Grade Average';</script>";
				$outerQuery = mysqli_query($conn, "SELECT * FROM subject WHERE department = '$selectedDepartment' GROUP BY department");
				while($res=mysqli_fetch_array($outerQuery)){
					$tempDepartment = $res['Subject_Code'];
					$maleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Gender = 'Male' AND si.Sem = '$filterSem' AND sub.Subject_Code = '$tempDepartment'");
					$femaleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Gender = 'Female' AND si.Sem = '$filterSem' AND sub.Subject_Code = '$tempDepartment'");
					$allQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Sem = '$filterSem' AND sub.Subject_Code = '$tempDepartment'");
					while($temp = mysqli_fetch_array($maleQuery)){
						$departmentMaleAverage = $temp['Average'];
					}
					while($temp = mysqli_fetch_array($femaleQuery)){
						$departmentFemaleAverage = $temp['Average'];
					}
					while($temp = mysqli_fetch_array($allQuery)){
						$departmentAllAverage = $temp['Average'];
					}
					if($departmentMaleAverage != ""){
						$departmentMale[$ii] = array("y" => $departmentMaleAverage, "label" => $tempDepartment);
					} else {
						$departmentMale[$ii] = array("y" => 0, "label" => $tempDepartment);
					}
					if($departmentFemaleAverage != ""){
						$departmentFemale[$ii] = array("y" => $departmentFemaleAverage, "label" => $tempDepartment);
					} else {
						$departmentFemale[$ii] = array("y" => 0, "label" => $tempDepartment);
					}
					if($departmentAllAverage != ""){
						$departmentAll[$ii] = array("y" => $departmentAllAverage, "label" => $tempDepartment);
					} else {
						$departmentAll[$ii] = array("y" => 0, "label" => $tempDepartment);
					}
					$ii++;
				}
			}
		} else if(!isset($filterYear) && !isset($filterSem) && isset($academic_year)){
			if($academic_year == "all"){
				echo"<script>var departmentTitle = '".$selectedDepartment.", All Academic Year Grade Average';</script>";
				$outerQuery = mysqli_query($conn, "SELECT * FROM subject WHERE department = '$selectedDepartment' GROUP BY department");
				while($res=mysqli_fetch_array($outerQuery)){
					$tempDepartment = $res['Subject_Code'];
					$maleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Gender = 'Male' AND sub.Subject_Code = '$tempDepartment'");
					$femaleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Gender = 'Female' AND sub.Subject_Code = '$tempDepartment'");
					$allQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE sub.Subject_Code = '$tempDepartment'");
					while($temp = mysqli_fetch_array($maleQuery)){
						$departmentMaleAverage = $temp['Average'];
					}
					while($temp = mysqli_fetch_array($femaleQuery)){
						$departmentFemaleAverage = $temp['Average'];
					}
					while($temp = mysqli_fetch_array($allQuery)){
						$departmentAllAverage = $temp['Average'];
					}
					if($departmentMaleAverage != ""){
						$departmentMale[$ii] = array("y" => $departmentMaleAverage, "label" => $tempDepartment);
					} else {
						$departmentMale[$ii] = array("y" => 0, "label" => $tempDepartment);
					}
					if($departmentFemaleAverage != ""){
						$departmentFemale[$ii] = array("y" => $departmentFemaleAverage, "label" => $tempDepartment);
					} else {
						$departmentFemale[$ii] = array("y" => 0, "label" => $tempDepartment);
					}
					if($departmentAllAverage != ""){
						$departmentAll[$ii] = array("y" => $departmentAllAverage, "label" => $tempDepartment);
					} else {
						$departmentAll[$ii] = array("y" => 0, "label" => $tempDepartment);
					}
					$ii++;
				}
			} else {
				echo"<script>var departmentTitle = '".$selectedDepartment.", ".$academic_year." Academic Year Grade Average';</script>";
				$outerQuery = mysqli_query($conn, "SELECT * FROM subject WHERE department = '$selectedDepartment' GROUP BY department");
				while($res=mysqli_fetch_array($outerQuery)){
					$tempDepartment = $res['Subject_Code'];
					$maleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Gender = 'Male' AND si.AY = '$academic_year' AND sub.Subject_Code = '$tempDepartment'");
					$femaleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Gender = 'Female' AND si.AY = '$academic_year' AND sub.Subject_Code = '$tempDepartment'");
					$allQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.AY = '$academic_year' AND sub.Subject_Code = '$tempDepartment'");
					while($temp = mysqli_fetch_array($maleQuery)){
						$departmentMaleAverage = $temp['Average'];
					}
					while($temp = mysqli_fetch_array($femaleQuery)){
						$departmentFemaleAverage = $temp['Average'];
					}
					while($temp = mysqli_fetch_array($allQuery)){
						$departmentAllAverage = $temp['Average'];
					}
					if($departmentMaleAverage != ""){
						$departmentMale[$ii] = array("y" => $departmentMaleAverage, "label" => $tempDepartment);
					} else {
						$departmentMale[$ii] = array("y" => 0, "label" => $tempDepartment);
					}
					if($departmentFemaleAverage != ""){
						$departmentFemale[$ii] = array("y" => $departmentFemaleAverage, "label" => $tempDepartment);
					} else {
						$departmentFemale[$ii] = array("y" => 0, "label" => $tempDepartment);
					}
					if($departmentAllAverage != ""){
						$departmentAll[$ii] = array("y" => $departmentAllAverage, "label" => $tempDepartment);
					} else {
						$departmentAll[$ii] = array("y" => 0, "label" => $tempDepartment);
					}
					$ii++;
				}
			}
		} else if(isset($filterYear) && isset($filterSem) && !isset($academic_year)){
			if($filterYear == "all" && $filterSem == "all"){
				echo"<script>var departmentTitle = '".$selectedDepartment.", All Year and All Sem Grade Average';</script>";
				$outerQuery = mysqli_query($conn, "SELECT * FROM subject WHERE department = '$selectedDepartment' GROUP BY department");
				while($res=mysqli_fetch_array($outerQuery)){
					$tempDepartment = $res['Subject_Code'];
					$maleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Gender = 'Male' AND sub.Subject_Code = '$tempDepartment'");
					$femaleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Gender = 'Female' AND sub.Subject_Code = '$tempDepartment'");
					$allQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE sub.Subject_Code = '$tempDepartment'");
					while($temp = mysqli_fetch_array($maleQuery)){
						$departmentMaleAverage = $temp['Average'];
					}
					while($temp = mysqli_fetch_array($femaleQuery)){
						$departmentFemaleAverage = $temp['Average'];
					}
					while($temp = mysqli_fetch_array($allQuery)){
						$departmentAllAverage = $temp['Average'];
					}
					if($departmentMaleAverage != ""){
						$departmentMale[$ii] = array("y" => $departmentMaleAverage, "label" => $tempDepartment);
					} else {
						$departmentMale[$ii] = array("y" => 0, "label" => $tempDepartment);
					}
					if($departmentFemaleAverage != ""){
						$departmentFemale[$ii] = array("y" => $departmentFemaleAverage, "label" => $tempDepartment);
					} else {
						$departmentFemale[$ii] = array("y" => 0, "label" => $tempDepartment);
					}
					if($departmentAllAverage != ""){
						$departmentAll[$ii] = array("y" => $departmentAllAverage, "label" => $tempDepartment);
					} else {
						$departmentAll[$ii] = array("y" => 0, "label" => $tempDepartment);
					}
					$ii++;
				}
			} else if($filterYear == "all" || $filterSem == "all"){
				echo"<script>var departmentTitle = '".$selectedDepartment.", ".$filterYear." Year and ".$filterSem." Sem Grade Average';</script>";
				$outerQuery = mysqli_query($conn, "SELECT * FROM subject WHERE department = '$selectedDepartment' GROUP BY department");
				while($res=mysqli_fetch_array($outerQuery)){
					$tempDepartment = $res['Subject_Code'];
					$maleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Gender = 'Male' AND si.Year = '$filterYear' OR si.Sem = '$filterSem' AND sub.Subject_Code = '$tempDepartment'");
					$femaleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Gender = 'Female' AND si.Year = '$filterYear' OR si.Sem = '$filterSem' AND sub.Subject_Code = '$tempDepartment'");
					$allQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Year = '$filterYear' OR si.Sem = '$filterSem' AND sub.Subject_Code = '$tempDepartment'");
					while($temp = mysqli_fetch_array($maleQuery)){
						$departmentMaleAverage = $temp['Average'];
					}
					while($temp = mysqli_fetch_array($femaleQuery)){
						$departmentFemaleAverage = $temp['Average'];
					}
					while($temp = mysqli_fetch_array($allQuery)){
						$departmentAllAverage = $temp['Average'];
					}
					if($departmentMaleAverage != ""){
						$departmentMale[$ii] = array("y" => $departmentMaleAverage, "label" => $tempDepartment);
					} else {
						$departmentMale[$ii] = array("y" => 0, "label" => $tempDepartment);
					}
					if($departmentFemaleAverage != ""){
						$departmentFemale[$ii] = array("y" => $departmentFemaleAverage, "label" => $tempDepartment);
					} else {
						$departmentFemale[$ii] = array("y" => 0, "label" => $tempDepartment);
					}
					if($departmentAllAverage != ""){
						$departmentAll[$ii] = array("y" => $departmentAllAverage, "label" => $tempDepartment);
					} else {
						$departmentAll[$ii] = array("y" => 0, "label" => $tempDepartment);
					}
					$ii++;
				}
			} else {
				echo"<script>var departmentTitle = '".$selectedDepartment.", ".$filterYear." Year and ".$filterSem." Sem Grade Average';</script>";
				$outerQuery = mysqli_query($conn, "SELECT * FROM subject WHERE department = '$selectedDepartment' GROUP BY department");
				while($res=mysqli_fetch_array($outerQuery)){
					$tempDepartment = $res['Subject_Code'];
					$maleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Gender = 'Male' AND si.Year = '$filterYear' AND si.Sem = '$filterSem' AND sub.Subject_Code = '$tempDepartment'");
					$femaleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Gender = 'Female' AND si.Year = '$filterYear' AND si.Sem = '$filterSem' AND sub.Subject_Code = '$tempDepartment'");
					$allQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Year = '$filterYear' AND si.Sem = '$filterSem' AND sub.Subject_Code = '$tempDepartment'");
					while($temp = mysqli_fetch_array($maleQuery)){
						$departmentMaleAverage = $temp['Average'];
					}
					while($temp = mysqli_fetch_array($femaleQuery)){
						$departmentFemaleAverage = $temp['Average'];
					}
					while($temp = mysqli_fetch_array($allQuery)){
						$departmentAllAverage = $temp['Average'];
					}
					if($departmentMaleAverage != ""){
						$departmentMale[$ii] = array("y" => $departmentMaleAverage, "label" => $tempDepartment);
					} else {
						$departmentMale[$ii] = array("y" => 0, "label" => $tempDepartment);
					}
					if($departmentFemaleAverage != ""){
						$departmentFemale[$ii] = array("y" => $departmentFemaleAverage, "label" => $tempDepartment);
					} else {
						$departmentFemale[$ii] = array("y" => 0, "label" => $tempDepartment);
					}
					if($departmentAllAverage != ""){
						$departmentAll[$ii] = array("y" => $departmentAllAverage, "label" => $tempDepartment);
					} else {
						$departmentAll[$ii] = array("y" => 0, "label" => $tempDepartment);
					}
					$ii++;
				}
			}
		} else if(isset($filterYear) && !isset($filterSem) && isset($academic_year)){
			if($filterYear == "all" && $academic_year == "all"){
				echo"<script>var departmentTitle = '".$selectedDepartment.", All Year and All Academic Year Grade Average';</script>";
				$outerQuery = mysqli_query($conn, "SELECT * FROM subject WHERE department = '$selectedDepartment' GROUP BY department");
				while($res=mysqli_fetch_array($outerQuery)){
					$tempDepartment = $res['Subject_Code'];
					$maleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Gender = 'Male' AND sub.Subject_Code = '$tempDepartment'");
					$femaleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Gender = 'Female' AND sub.Subject_Code = '$tempDepartment'");
					$allQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE sub.Subject_Code = '$tempDepartment'");
					while($temp = mysqli_fetch_array($maleQuery)){
						$departmentMaleAverage = $temp['Average'];
					}
					while($temp = mysqli_fetch_array($femaleQuery)){
						$departmentFemaleAverage = $temp['Average'];
					}
					while($temp = mysqli_fetch_array($allQuery)){
						$departmentAllAverage = $temp['Average'];
					}
					if($departmentMaleAverage != ""){
						$departmentMale[$ii] = array("y" => $departmentMaleAverage, "label" => $tempDepartment);
					} else {
						$departmentMale[$ii] = array("y" => 0, "label" => $tempDepartment);
					}
					if($departmentFemaleAverage != ""){
						$departmentFemale[$ii] = array("y" => $departmentFemaleAverage, "label" => $tempDepartment);
					} else {
						$departmentFemale[$ii] = array("y" => 0, "label" => $tempDepartment);
					}
					if($departmentAllAverage != ""){
						$departmentAll[$ii] = array("y" => $departmentAllAverage, "label" => $tempDepartment);
					} else {
						$departmentAll[$ii] = array("y" => 0, "label" => $tempDepartment);
					}
					$ii++;
				}
			} else if($filterYear == "all" || $academic_year == "all"){
				echo"<script>var departmentTitle = '".$selectedDepartment.", ".$filterYear." Year and ".$academic_year." Academic Year Grade Average';</script>";
				$outerQuery = mysqli_query($conn, "SELECT * FROM subject WHERE department = '$selectedDepartment' GROUP BY department");
				while($res=mysqli_fetch_array($outerQuery)){
					$tempDepartment = $res['Subject_Code'];
					$maleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Gender = 'Male' AND si.Year = '$filterYear' OR si.AY = '$academic_year' AND sub.Subject_Code = '$tempDepartment'");
					$femaleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Gender = 'Female' AND si.Year = '$filterYear' OR si.AY = '$academic_year' AND sub.Subject_Code = '$tempDepartment'");
					$allQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Year = '$filterYear' OR si.AY = '$academic_year' AND sub.Subject_Code = '$tempDepartment'");
					while($temp = mysqli_fetch_array($maleQuery)){
						$departmentMaleAverage = $temp['Average'];
					}
					while($temp = mysqli_fetch_array($femaleQuery)){
						$departmentFemaleAverage = $temp['Average'];
					}
					while($temp = mysqli_fetch_array($allQuery)){
						$departmentAllAverage = $temp['Average'];
					}
					if($departmentMaleAverage != ""){
						$departmentMale[$ii] = array("y" => $departmentMaleAverage, "label" => $tempDepartment);
					} else {
						$departmentMale[$ii] = array("y" => 0, "label" => $tempDepartment);
					}
					if($departmentFemaleAverage != ""){
						$departmentFemale[$ii] = array("y" => $departmentFemaleAverage, "label" => $tempDepartment);
					} else {
						$departmentFemale[$ii] = array("y" => 0, "label" => $tempDepartment);
					}
					if($departmentAllAverage != ""){
						$departmentAll[$ii] = array("y" => $departmentAllAverage, "label" => $tempDepartment);
					} else {
						$departmentAll[$ii] = array("y" => 0, "label" => $tempDepartment);
					}
					$ii++;
				}
			} else {
				echo"<script>var departmentTitle = '".$selectedDepartment.", ".$filterYear." Year and ".$academic_year." Academic Year Grade Average';</script>";
				$outerQuery = mysqli_query($conn, "SELECT * FROM subject WHERE department = '$selectedDepartment' GROUP BY department");
				while($res=mysqli_fetch_array($outerQuery)){
					$tempDepartment = $res['Subject_Code'];
					$maleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Gender = 'Male' AND si.Year = '$filterYear' AND si.AY = '$academic_year' AND sub.Subject_Code = '$tempDepartment'");
					$femaleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Gender = 'Female' AND si.Year = '$filterYear' AND si.AY = '$academic_year' AND sub.Subject_Code = '$tempDepartment'");
					$allQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Year = '$filterYear' AND si.AY = '$academic_year' AND sub.Subject_Code = '$tempDepartment'");
					while($temp = mysqli_fetch_array($maleQuery)){
						$departmentMaleAverage = $temp['Average'];
					}
					while($temp = mysqli_fetch_array($femaleQuery)){
						$departmentFemaleAverage = $temp['Average'];
					}
					while($temp = mysqli_fetch_array($allQuery)){
						$departmentAllAverage = $temp['Average'];
					}
					if($departmentMaleAverage != ""){
						$departmentMale[$ii] = array("y" => $departmentMaleAverage, "label" => $tempDepartment);
					} else {
						$departmentMale[$ii] = array("y" => 0, "label" => $tempDepartment);
					}
					if($departmentFemaleAverage != ""){
						$departmentFemale[$ii] = array("y" => $departmentFemaleAverage, "label" => $tempDepartment);
					} else {
						$departmentFemale[$ii] = array("y" => 0, "label" => $tempDepartment);
					}
					if($departmentAllAverage != ""){
						$departmentAll[$ii] = array("y" => $departmentAllAverage, "label" => $tempDepartment);
					} else {
						$departmentAll[$ii] = array("y" => 0, "label" => $tempDepartment);
					}
					$ii++;
				}
			}
		} else if(!isset($filterYear) && isset($filterSem) && isset($academic_year)){
			if($filterSem == "all" && $academic_year == "all"){
				echo"<script>var departmentTitle = '".$selectedDepartment.", All Sem and All Academic Year Grade Average';</script>";
				$outerQuery = mysqli_query($conn, "SELECT * FROM subject WHERE department = '$selectedDepartment' GROUP BY department");
				while($res=mysqli_fetch_array($outerQuery)){
					$tempDepartment = $res['Subject_Code'];
					$maleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Gender = 'Male' AND sub.Subject_Code = '$tempDepartment'");
					$femaleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Gender = 'Female' AND sub.Subject_Code = '$tempDepartment'");
					$allQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE sub.Subject_Code = '$tempDepartment'");
					while($temp = mysqli_fetch_array($maleQuery)){
						$departmentMaleAverage = $temp['Average'];
					}
					while($temp = mysqli_fetch_array($femaleQuery)){
						$departmentFemaleAverage = $temp['Average'];
					}
					while($temp = mysqli_fetch_array($allQuery)){
						$departmentAllAverage = $temp['Average'];
					}
					if($departmentMaleAverage != ""){
						$departmentMale[$ii] = array("y" => $departmentMaleAverage, "label" => $tempDepartment);
					} else {
						$departmentMale[$ii] = array("y" => 0, "label" => $tempDepartment);
					}
					if($departmentFemaleAverage != ""){
						$departmentFemale[$ii] = array("y" => $departmentFemaleAverage, "label" => $tempDepartment);
					} else {
						$departmentFemale[$ii] = array("y" => 0, "label" => $tempDepartment);
					}
					if($departmentAllAverage != ""){
						$departmentAll[$ii] = array("y" => $departmentAllAverage, "label" => $tempDepartment);
					} else {
						$departmentAll[$ii] = array("y" => 0, "label" => $tempDepartment);
					}
					$ii++;
				}
			} else if($filterSem == "all" || $academic_year == "all"){
				echo"<script>var departmentTitle = '".$selectedDepartment.", ".$filterSem." Sem and ".$academic_year." Academic Year Grade Average';</script>";
				$outerQuery = mysqli_query($conn, "SELECT * FROM subject WHERE department = '$selectedDepartment' GROUP BY department");
				while($res=mysqli_fetch_array($outerQuery)){
					$tempDepartment = $res['Subject_Code'];
					$maleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Gender = 'Male' AND si.Sem = '$filterSem' OR si.AY = '$academic_year' AND sub.Subject_Code = '$tempDepartment'");
					$femaleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Gender = 'Female' AND si.Sem = '$filterSem' OR si.AY = '$academic_year' AND sub.Subject_Code = '$tempDepartment'");
					$allQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Sem = '$filterSem' OR si.AY = '$academic_year' AND sub.Subject_Code = '$tempDepartment'");
					while($temp = mysqli_fetch_array($maleQuery)){
						$departmentMaleAverage = $temp['Average'];
					}
					while($temp = mysqli_fetch_array($femaleQuery)){
						$departmentFemaleAverage = $temp['Average'];
					}
					while($temp = mysqli_fetch_array($allQuery)){
						$departmentAllAverage = $temp['Average'];
					}
					if($departmentMaleAverage != ""){
						$departmentMale[$ii] = array("y" => $departmentMaleAverage, "label" => $tempDepartment);
					} else {
						$departmentMale[$ii] = array("y" => 0, "label" => $tempDepartment);
					}
					if($departmentFemaleAverage != ""){
						$departmentFemale[$ii] = array("y" => $departmentFemaleAverage, "label" => $tempDepartment);
					} else {
						$departmentFemale[$ii] = array("y" => 0, "label" => $tempDepartment);
					}
					if($departmentAllAverage != ""){
						$departmentAll[$ii] = array("y" => $departmentAllAverage, "label" => $tempDepartment);
					} else {
						$departmentAll[$ii] = array("y" => 0, "label" => $tempDepartment);
					}
					$ii++;
				}
			} else {
				echo"<script>var departmentTitle = '".$selectedDepartment.", ".$filterSem." Sem and ".$academic_year." Academic Year Grade Average';</script>";
				$outerQuery = mysqli_query($conn, "SELECT * FROM subject WHERE department = '$selectedDepartment' GROUP BY department");
				while($res=mysqli_fetch_array($outerQuery)){
					$tempDepartment = $res['Subject_Code'];
					$maleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Gender = 'Male' AND si.Sen = '$filterSem' AND si.AY = '$academic_year' AND sub.Subject_Code = '$tempDepartment'");
					$femaleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Gender = 'Female' AND si.Sen = '$filterSem' AND si.AY = '$academic_year' AND sub.Subject_Code = '$tempDepartment'");
					$allQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
											JOIN student_information si ON si.Student_No = sg.Student_No
										    JOIN subject sub ON sub.Subject_Code = si.Class_Code
										    JOIN department dept ON dept.code = sub.department
										    WHERE si.Sem = '$filterSem' AND si.AY = '$academic_year' AND sub.Subject_Code = '$tempDepartment'");
					while($temp = mysqli_fetch_array($maleQuery)){
						$departmentMaleAverage = $temp['Average'];
					}
					while($temp = mysqli_fetch_array($femaleQuery)){
						$departmentFemaleAverage = $temp['Average'];
					}
					while($temp = mysqli_fetch_array($allQuery)){
						$departmentAllAverage = $temp['Average'];
					}
					if($departmentMaleAverage != ""){
						$departmentMale[$ii] = array("y" => $departmentMaleAverage, "label" => $tempDepartment);
					} else {
						$departmentMale[$ii] = array("y" => 0, "label" => $tempDepartment);
					}
					if($departmentFemaleAverage != ""){
						$departmentFemale[$ii] = array("y" => $departmentFemaleAverage, "label" => $tempDepartment);
					} else {
						$departmentFemale[$ii] = array("y" => 0, "label" => $tempDepartment);
					}
					if($departmentAllAverage != ""){
						$departmentAll[$ii] = array("y" => $departmentAllAverage, "label" => $tempDepartment);
					} else {
						$departmentAll[$ii] = array("y" => 0, "label" => $tempDepartment);
					}
					$ii++;
				}
			}
		} else if(isset($selectedDepartment) && !isset($filterYear) && !isset($filterSem) && !isset($academic_year)){
			echo"<script>var departmentTitle = '".$selectedDepartment." Grade Average';</script>";
			$outerQuery = mysqli_query($conn, "SELECT * FROM subject WHERE department = '$selectedDepartment' GROUP BY department");
			while($res=mysqli_fetch_array($outerQuery)){
				$tempDepartment = $res['Subject_Code'];
				$maleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
										JOIN student_information si ON si.Student_No = sg.Student_No
									    JOIN subject sub ON sub.Subject_Code = si.Class_Code
									    JOIN department dept ON dept.code = sub.department
									    WHERE si.Gender = 'Male' AND sub.Subject_Code = '$tempDepartment'");
				$femaleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
										JOIN student_information si ON si.Student_No = sg.Student_No
									    JOIN subject sub ON sub.Subject_Code = si.Class_Code
									    JOIN department dept ON dept.code = sub.department
									    WHERE si.Gender = 'Female' AND sub.Subject_Code = '$tempDepartment'");
				$allQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
										JOIN student_information si ON si.Student_No = sg.Student_No
									    JOIN subject sub ON sub.Subject_Code = si.Class_Code
									    JOIN department dept ON dept.code = sub.department
									    WHERE sub.Subject_Code = '$tempDepartment'");
				while($temp = mysqli_fetch_array($maleQuery)){
					$departmentMaleAverage = $temp['Average'];
				}
				while($temp = mysqli_fetch_array($femaleQuery)){
					$departmentFemaleAverage = $temp['Average'];
				}
				while($temp = mysqli_fetch_array($allQuery)){
					$departmentAllAverage = $temp['Average'];
				}
				if($departmentMaleAverage != ""){
					$departmentMale[$ii] = array("y" => $departmentMaleAverage, "label" => $tempDepartment);
				} else {
					$departmentMale[$ii] = array("y" => 0, "label" => $tempDepartment);
				}
				if($departmentFemaleAverage != ""){
					$departmentFemale[$ii] = array("y" => $departmentFemaleAverage, "label" => $tempDepartment);
				} else {
					$departmentFemale[$ii] = array("y" => 0, "label" => $tempDepartment);
				}
				if($departmentAllAverage != ""){
					$departmentAll[$ii] = array("y" => $departmentAllAverage, "label" => $tempDepartment);
				} else {
					$departmentAll[$ii] = array("y" => 0, "label" => $tempDepartment);
				}
				$ii++;
			}
		}
	} else {
		//for department
		$subsubsub = mysqli_query($conn, "SELECT * FROM department GROUP BY code LIMIT 1");
		if(mysqli_num_rows($subsubsub) > 0){
			$subsubsub = mysqli_fetch_object($subsubsub);
			echo"<script>var departmentTitle = '".$subsubsub->code." Grade Average';</script>";
			$outerQuery = mysqli_query($conn, "SELECT * FROM subject WHERE department = '$subsubsub->code' GROUP BY department");
			while($res=mysqli_fetch_array($outerQuery)){
				$tempDepartment = $res['Subject_Code'];
				$maleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
										JOIN student_information si ON si.Student_No = sg.Student_No
									    JOIN subject sub ON sub.Subject_Code = si.Class_Code
									    JOIN department dept ON dept.code = sub.department
									    WHERE si.Gender = 'Male' AND sub.Subject_Code = '$tempDepartment'");
				$femaleQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
										JOIN student_information si ON si.Student_No = sg.Student_No
									    JOIN subject sub ON sub.Subject_Code = si.Class_Code
									    JOIN department dept ON dept.code = sub.department
									    WHERE si.Gender = 'Female' AND sub.Subject_Code = '$tempDepartment'");
				$allQuery = mysqli_query($conn, "SELECT AVG(Average) as Average FROM student_grade sg 
										JOIN student_information si ON si.Student_No = sg.Student_No
									    JOIN subject sub ON sub.Subject_Code = si.Class_Code
									    JOIN department dept ON dept.code = sub.department
									    WHERE sub.Subject_Code = '$tempDepartment'");
				while($temp = mysqli_fetch_array($maleQuery)){
					$maleAverage = $temp['Average'];
				}
				while($temp = mysqli_fetch_array($femaleQuery)){
					$femaleAverage = $temp['Average'];
				}
				while($temp = mysqli_fetch_array($allQuery)){
					$allAverage = $temp['Average'];
				}
				if($maleAverage != ""){
					$departmentMale[$ii] = array("y" => $maleAverage, "label" => $tempDepartment);
				} else {
					$departmentMale[$ii] = array("y" => 0, "label" => $tempDepartment);
				}
				if($femaleAverage != ""){
					$departmentFemale[$ii] = array("y" => $femaleAverage, "label" => $tempDepartment);
				} else {
					$departmentFemale[$ii] = array("y" => 0, "label" => $tempDepartment);
				}
				if($allAverage != ""){
					$departmentAll[$ii] = array("y" => $allAverage, "label" => $tempDepartment);
				} else {
					$departmentAll[$ii] = array("y" => 0, "label" => $tempDepartment);
				}
				$ii++;
			}
		}
	}

//check sem and ay
$checkSemAy = mysqli_query($conn, "SELECT * FROM settings");
if(mysqli_num_rows($checkSemAy) == 0){
	echo "
	<script type='text/javascript'> 
	$(document).ready(function(){
		$('#modalSettings').modal({
			backdrop: 'static',
			keyboard: true
		});
		$('#modalSettings').modal('show');
	});
	</script>
	";
}
?>
<style type="text/css">
.panel-body  {
    word-break:break-all
}
.modal-backdrop {
	z-index: -1;
}
</style>
<script>
var chartType = "line";
var departmentChartType = "line";
function changeChart(chart){
	chartType = chart;
	showChart();
}
function departmentChart(chart){
	departmentChartType = chart;
	showChart();
}
<?php
	if(isset($selectedDepartment)){
?>
		$(document).ready(function() {
		    $('.nav-tabs a[href="#menu1"]').tab('show');
		});
<?php
	}
?>
</script>
<div class="w3-animate-zoom" id='noSetting'>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-3">
				<div class="panel panel-default">
					<div class="panel-body" style="background-color: #efba1c">
						<img src="image/student.png" width="45" class="img-responsive" style="float:right">
						<label style="color:white"><?php echo mysqli_num_rows($studentCount); ?><br>Students</label></div>
					<div class="panel-footer" style="background-color: #efba1c; opacity: 0.8">
						<center>
			    		<a href='student.php' style="color:white">View More Info</a>
			    		</center>
					</div>
				</div>
			</div>

			<div class="col-md-3">
				<div class="panel panel-default">
					<div class="panel-body" style="background-color: #5d65dd">
						<img src="image/teacher.png" width="45" class="img-responsive" style="float:right">
						<label style="color:white"><?php echo mysqli_num_rows($teacherCount); ?><br>Teachers</label></div>
					<div class="panel-footer" style="background-color: #5d65dd; opacity: 0.8">
						<center>
			    		<a href='teacher.php' style="color:white">View More Info</a>
			    		</center>
					</div>
				</div>
			</div>

			<div class="col-md-3">
				<div class="panel panel-default">
					<div class="panel-body" style="background-color: #3ac96a">
						<img src="image/subject.png" width="45" class="img-responsive" style="float:right">
						<label style="color:white"><?php echo mysqli_num_rows($subjectCount); ?><br>Subjects</label></div>
					<div class="panel-footer" style="background-color: #3ac96a; opacity: 0.8">
						<center>
			    		<a href='subject.php' style="color:white">View More Info</a>
			    		</center>
					</div>
				</div>
			</div>

			<div class="col-md-3">
				<div class="panel panel-default">
					<div class="panel-body" style="background-color: #e03e3e">
						<img src="image/submitted.png" width="45" class="img-responsive" style="float:right">
						<label style="color:white"><?php echo mysqli_num_rows($Submitted); ?><br>Submitted Grade</label></div>
					<div class="panel-footer" style="background-color: #e03e3e; opacity: 0.8">
						<center>
			    		<a href='#' data-toggle="modal" data-target="#myModal" style="color:white">View More Info</a>
			    		</center>
					</div>
				</div>
			</div>
		</div>
	</div>

	<a href='#' data-toggle="modal" data-target="#modalSettings"><img src="image/settings.png" style="float:right; width:30px; height:30px"></a>
	<ul class="nav nav-tabs">
		<li class="active"><a data-toggle="tab" id = "bs-tab1" href="#home">Laguna University</a></li>
		<li><a data-toggle="tab" id = "bs-tab2" href="#menu1">By Department</a></li>
	</ul>

	<div class="tab-content">
	    <div id="home" class="tab-pane fade in active">
	     	<h3>Overall Grade Average in Laguna University</h3>
	     	<!-- Content1 here -->
			<ul class="nav nav-tabs">
				<li class="active"><a data-toggle="tab" href="#chart1.1" onClick="changeChart('line')">Line Chart</a></li>
				<li><a data-toggle="tab" href="#chart1.2" onClick="changeChart('column')">Bar Chart</a></li>
				<li><a data-toggle="tab" href="#chart1.3" onClick="changeChart('bar')">H-Bar Chart</a></li>
			</ul>
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-3">
						<br>
						<form method="POST">
							<fieldset>
								<legend><center>Filter Data</center></legend>
								<select class='form-control' name="year">
									<option selected disabled>Year Level</option>
									<?php
									if(isset($_POST['year']) && $_POST['year'] == "all"){
										echo "<option selected value='all'>All</option>";
									} else {
										echo "<option value='all'>All</option>";
									}
									if(isset($_POST['year']) && $_POST['year'] == "1st"){
										echo "<option selected value='1st'>1st</option>";
									} else {
										echo "<option value='1st'>1st</option>";
									}
									if(isset($_POST['year']) && $_POST['year'] == "2nd"){
										echo "<option selected value='2nd'>2nd</option>";
									} else {
										echo "<option value='2nd'>2nd</option>";
									}
									if(isset($_POST['year']) && $_POST['year'] == "3rd"){
										echo "<option selected value='3rd'>3rd</option>";
									} else {
										echo "<option value='3rd'>3rd</option>";
									}
									if(isset($_POST['year']) && $_POST['year'] == "4th"){
										echo "<option selected value='4th'>4th</option>";
									} else {
										echo "<option value='4th'>4th</option>";
									}
									if(isset($_POST['year']) && $_POST['year'] == "5th"){
										echo "<option selected value='5th'>5th</option>";
									} else {
										echo "<option value='5th'>5th</option>";
									}
									?>
								</select><br>
								<select class='form-control' name="sem">
									<option selected disabled>Semester</option>
									<?php
									if(isset($_POST['sem']) && $_POST['sem'] == "all"){
										echo "<option selected value='all'>All</option>";
									} else {
										echo "<option value='all'>All</option>";
									}
									if(isset($_POST['sem']) && $_POST['sem'] == "1st"){
										echo "<option selected value='1st'>1st Semester</option>";
									} else {
										echo "<option value='1st'>1st Semester</option>";
									}
									if(isset($_POST['sem']) && $_POST['sem'] == "2nd"){
										echo "<option selected value='2nd'>2nd Semester</option>";
									} else {
										echo "<option value='2nd'>2nd Semester</option>";
									}
									?>
								</select><br>
								<select class='form-control' name="academic_year">
									<option selected disabled>Academic Year</option>
									<?php
									if(isset($_POST['academic_year']) && $_POST['academic_year'] == "all"){
										echo "<option selected value='all'>All</option>";
									} else {
										echo "<option value='all'>All</option>";
									}
									$ay = "2017";
									for($i=0;$i<15;$i++){
										$nextYear = $ay+1;
										$completeAY = $ay."-".$nextYear;
										$ay++;
										if(isset($_POST['academic_year']) && $_POST['academic_year'] == "$completeAY"){
											echo "<option selected value='$completeAY'>$completeAY</option>";
										} else {
											echo "<option value='$completeAY'>$completeAY</option>";
										}
									}
									?>
								</select><br>
								<center><input type="submit" class="btn btn-primary" name="submit" value="Submit"></center>
								<br>
							</fieldset>
						</form>
					</div>
					<div class="col-md-9">
						<div id='myChart'></div>
					</div>
				</div>
			</div>
			<br>
		<!-- Content1 end here-->
		</div>

	    <div id="menu1" class="tab-pane fade">
	    <h3>Grade Average per Department</h3>
	    <!-- Content2 here -->
	    <ul class="nav nav-tabs">
				<li class="active"><a data-toggle="tab" href="#chart1.1" onClick="departmentChart('line')">Line Chart</a></li>
				<li><a data-toggle="tab" href="#chart1.2" onClick="departmentChart('column')">Bar Chart</a></li>
				<li><a data-toggle="tab" href="#chart1.3" onClick="departmentChart('bar')">Horizontal Bar Chart</a></li>
			</ul>
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-3">
						<br>
						<form method="POST">
							<fieldset>
								<legend><center>Filter Data</center></legend>
								<select class='form-control' name="filterDepartment">
									<?php
									$deptIndex = 0;
									$deptQuery = mysqli_query($conn, "SELECT * FROM department GROUP BY code");
									while($rows = mysqli_fetch_array($deptQuery)){
										$deptCode = $rows['code'];
										if(isset($_POST['filterDepartment']) && $_POST['filterDepartment'] == "$deptCode"){
											echo"<option selected value='$deptCode'>$deptCode</option>";
										} else if($deptIndex == 0){
											echo"<option selected value='$deptCode'>$deptCode</option>";
										} else {
											echo"<option value='$deptCode'>$deptCode</option>";
										}
										$deptIndex++;
									}
									if(mysqli_num_rows($deptQuery) == 0){
										echo"<option selected>No Department Found</option>";
									}
									?>
								</select><br>
								<select class='form-control' name="deptyear">
									<option selected disabled>Year Level</option>
									<?php
									if(isset($_POST['deptyear']) && $_POST['deptyear'] == "all"){
										echo "<option selected value='all'>All</option>";
									} else {
										echo "<option value='all'>All</option>";
									}
									if(isset($_POST['deptyear']) && $_POST['deptyear'] == "1st"){
										echo "<option selected value='1st'>1st</option>";
									} else {
										echo "<option value='1st'>1st</option>";
									}
									if(isset($_POST['deptyear']) && $_POST['deptyear'] == "2nd"){
										echo "<option selected value='2nd'>2nd</option>";
									} else {
										echo "<option value='2nd'>2nd</option>";
									}
									if(isset($_POST['deptyear']) && $_POST['deptyear'] == "3rd"){
										echo "<option selected value='3rd'>3rd</option>";
									} else {
										echo "<option value='3rd'>3rd</option>";
									}
									if(isset($_POST['deptyear']) && $_POST['deptyear'] == "4th"){
										echo "<option selected value='4th'>4th</option>";
									} else {
										echo "<option value='4th'>4th</option>";
									}
									if(isset($_POST['deptyear']) && $_POST['deptyear'] == "5th"){
										echo "<option selected value='5th'>5th</option>";
									} else {
										echo "<option value='5th'>5th</option>";
									}
									?>
								</select><br>
								<select class='form-control' name="deptsem">
									<option selected disabled>Semester</option>
									<?php
									if(isset($_POST['deptsem']) && $_POST['deptsem'] == "all"){
										echo "<option selected value='all'>All</option>";
									} else {
										echo "<option value='all'>All</option>";
									}
									if(isset($_POST['deptsem']) && $_POST['deptsem'] == "1st"){
										echo "<option selected value='1st'>1st Semester</option>";
									} else {
										echo "<option value='1st'>1st Semester</option>";
									}
									if(isset($_POST['deptsem']) && $_POST['deptsem'] == "2nd"){
										echo "<option selected value='2nd'>2nd Semester</option>";
									} else {
										echo "<option value='2nd'>2nd Semester</option>";
									}
									?>
								</select><br>
								<select class='form-control' name="deptacademic_year">
									<option selected disabled>Academic Year</option>
									<?php
									if(isset($_POST['deptacademic_year']) && $_POST['deptacademic_year'] == "all"){
										echo "<option selected value='all'>All</option>";
									} else {
										echo "<option value='all'>All</option>";
									}
									$ay = "2017";
									for($i=0;$i<15;$i++){
										$nextYear = $ay+1;
										$completeAY = $ay."-".$nextYear;
										$ay++;
										if(isset($_POST['deptacademic_year']) && $_POST['deptacademic_year'] == "$completeAY"){
											echo "<option selected value='$completeAY'>$completeAY</option>";
										} else {
											echo "<option value='$completeAY'>$completeAY</option>";
										}
									}
									?>
								</select><br>
								<center>
								<?php
									if(mysqli_num_rows($deptQuery) == 0){
										echo "<input type='button' class='btn btn-primary disabled' name='gg' value='Submit'>";
									} else {
										echo "<input type='submit' class='btn btn-primary' name='submitDepartment' value='Submit'>";
									}
								?>
								</center>
							<br>
							</fieldset>
						</form>
					</div>
					<div class="col-md-9">
						<div id="departmentChart"></div>
					</div>
				</div>
			</div>
			<br>
		<!-- Content2 end here-->
		</div>
	</div>
</div>

	<!-- Modal -->
	<div class="modal fade" id="myModal" role="dialog">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header w3-teal">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h2 class="modal-title"><center>Teachers Submitted grade</center></h2>
				</div>
				<div class="modal-body">
					<table class="w3-table w3-striped w3-bordered">
						<thead>
							<tr class="w3-blue">
								<th width="10%">No.</th>
								<th>Prof Name</th>
							</tr>
						</thead>
						<?php
						$no = 1;
							if(mysqli_num_rows($Submitted) > 0){
								while($res = mysqli_fetch_array($Submitted)){
									$Prof_ID = $res['profid'];
									echo "
									<tr>
										<td>$no</td>
										<td><a href='SubmittedGrade.php?id=$Prof_ID&sem=$sem&ay=$academic_year'>".$res['name']."</a></td>
									</tr>";
								$no++;
								}
							} else {
								echo"<tr>
									<td colspan='8' class='w3-center'>No data to display</td>
								</tr>";
							}
						?>
						</table>
					</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal Settings -->
	<div id='modalSettings' class='modal fade modal-dialog'>
		<div class='modal-content'>
			<div class='modal-header w3-teal'>
				<?php
				while($gg = mysqli_fetch_array($checkSemAy)){
					$settingsAY = $gg['academic_year'];
					$settingsSem = $gg['sem'];
				}
				if(mysqli_num_rows($checkSemAy) > 0){
					echo"<button type='button' class='close' data-dismiss='modal'>&times;</button>";
				}
				?>
				<h2 class="modal-title"><center>Settings</center></h2>
			</div>
			<div class='modal-body'>
					<div class='row'>
						<div class="w3-blue" style="margin-left:10px; margin-right:10px; margin-bottom:10px; padding:10px; font-size: 18px">Semester and Academic Year</div>	
					</div>
					<div class="row">
						<?php
							if(mysqli_num_rows($checkSemAy) == 0){
								echo "<center><span style='color:red; font-size: 18px'>Sem and AY not set yet please configure</span></center>";
							}
						?>
					</div>
					<div class="row">
						<div class="col-md-6 col-sm-6">
							<?php
								if(mysqli_num_rows($checkSemAy) == 0){
									echo "<form action='settingChanges.php?save=true' method='POST'>";
								} else {
									echo "<form action='settingChanges.php?update=true' method='POST'>";
								}
							?>
							<select name="sem" class="form-control form-group">
								<option selected disabled>Sem</option>
								<?php
									if(isset($settingsSem) && $settingsSem == "1st"){
										echo "<option selected value='1st'>1st</option>";
									} else {
										echo "<option value='1st'>1st</option>";
									}
									if(isset($settingsSem) && $settingsSem == "2nd"){
										echo "<option selected value='2nd'>2nd</option>";
									} else {
										echo "<option value='2nd'>2nd</option>";
									}
								?>
							</select>
						</div>
						<div class="col-md-6 col-sm-6">
							<select name="ay" class="form-control form-group">
								<option selected disabled>Academic Year</option>
								<?php
									$ay = "2017";
									for($i=0;$i<15;$i++){
										$nextYear = $ay+1;
										$completeAY = $ay."-".$nextYear;
										$ay++;
										if(isset($settingsAY) && $settingsAY == "$completeAY"){
											echo "<option selected value='$completeAY'>$completeAY</option>";
										} else {
											echo "<option value='$completeAY'>$completeAY</option>";
										}
									}
								?>
							</select>
						</div>
					</div>
			</div>
			<div class='modal-footer'>
				<?php
					if(mysqli_num_rows($checkSemAy) > 0){
						echo "<button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>";
					}
				?>
				<button type="submit" name="submit" class="btn btn-primary">Save</button>
			</form>
			</div>
		</div>
	</div>
	<!--<div class="modal fade" id="modalSettings" role="dialog">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header w3-teal">
					<?php
						while($gg = mysqli_fetch_array($checkSemAy)){
							$settingsAY = $gg['academic_year'];
							$settingsSem = $gg['sem'];
						}
						if(mysqli_num_rows($checkSemAy) > 0){
							echo"<button type='button' class='close' data-dismiss='modal'>&times;</button>";
						}
					?>
					<h2 class="modal-title"><center>Settings</center></h2>
				</div>
				<div class="modal-body">
					<div class="col-md-12">
						<div class="row">
							<div class="col-md-12">
								<div class="w3-blue" style="padding:10px; font-size: 18px">Semester and Academic Year</div>
							</div>
						</div>
						<div class="row">
							<?php
								if(mysqli_num_rows($checkSemAy) == 0){
									echo "<center><span style='color:red; font-size: 18px'>Sem and AY not set yet please configure</span></center>";
								}
								if(mysqli_num_rows($checkSemAy) == 0){
									echo "<form action='settingChanges.php?save=true' method='POST'>";
								} else {
									echo "<form action='settingChanges.php?update=true' method='POST'>";
								}
							?>
							<div class="col-sm-6 col-xs-6">
								<select name="sem" class="form-control">
									<option selected disabled>Sem</option>
									<?php
									if(isset($settingsSem) && $settingsSem == "1st"){
										echo "<option selected value='1st'>1st</option>";
									} else {
										echo "<option value='1st'>1st</option>";
									}
									if(isset($settingsSem) && $settingsSem == "2nd"){
										echo "<option selected value='2nd'>2nd</option>";
									} else {
										echo "<option value='2nd'>2nd</option>";
									}
									?>
								</select>
							</div>
							<div class="col-sm-6 col-xs-6">
								<select name="ay" class="form-control">
									<option selected disabled>Academic Year</option>
									<?php
										$ay = "2017";
										for($i=0;$i<15;$i++){
											$nextYear = $ay+1;
											$completeAY = $ay."-".$nextYear;
											$ay++;
											if(isset($settingsAY) && $settingsAY == "$completeAY"){
												echo "<option selected value='$completeAY'>$completeAY</option>";
											} else {
												echo "<option value='$completeAY'>$completeAY</option>";
											}
										}
									?>
								</select>
							</div>
						</div>
					 </div>
				</div>
				<div class="modal-footer">
					<?php
						if(mysqli_num_rows($checkSemAy) > 0){
							echo "<button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>";
						}
					?>
					<button type="submit" name="submit" class="btn btn-primary">Save</button>
					</form>
				</div>
			</div>
		</div>
	</div>-->
<!-- Script -->
<script type="text/javascript">
function showChart(){
	var chart = new CanvasJS.Chart("myChart", {
	animationEnabled: true,
	title: {
		text: title
	},
		legend:{
			cursor: "pointer",
            itemclick: function (e) {
                if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                    e.dataSeries.visible = false;
                } else {
                    e.dataSeries.visible = true;
                }

                e.chart.render();
            }
		},
		data: [{
            showInLegend: true,
            legendText: "Male",
			type: chartType,
			dataPoints: <?php echo json_encode($male, JSON_NUMERIC_CHECK); ?>
		},
		{
            showInLegend: true,
            legendText: "Female",
			type: chartType,
			dataPoints: <?php echo json_encode($female, JSON_NUMERIC_CHECK); ?>
		},
		{
            showInLegend: true,
            legendText: "Both",
			type: chartType,
			//indexLabel: "{label} , {y}",
			dataPoints: <?php echo json_encode($all, JSON_NUMERIC_CHECK); ?>
		}]
	});
	chart.render();

	var chart = new CanvasJS.Chart("departmentChart", {
	animationEnabled: true,
	title: {
		text: departmentTitle
	},
		legend:{
			cursor: "pointer",
            itemclick: function (e) {
                if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                    e.dataSeries.visible = false;
                } else {
                    e.dataSeries.visible = true;
                }

                e.chart.render();
            }
		},
		data: [{
            showInLegend: true,
            legendText: "Male",
			type: departmentChartType,
			dataPoints: <?php echo json_encode($departmentMale, JSON_NUMERIC_CHECK); ?>
		},
		{
            showInLegend: true,
            legendText: "Female",
			type: departmentChartType,
			dataPoints: <?php echo json_encode($departmentFemale, JSON_NUMERIC_CHECK); ?>
		},
		{
            showInLegend: true,
            legendText: "Both",
			type: departmentChartType,
			//indexLabel: "{label} , {y}",
			dataPoints: <?php echo json_encode($departmentAll, JSON_NUMERIC_CHECK); ?>
		}]
	});
	chart.render();
}

$('#bs-tab1').on("shown.bs.tab",function(){
	showChart();
});

$('#bs-tab2').on("shown.bs.tab",function(){
	showChart();
});
</script> 