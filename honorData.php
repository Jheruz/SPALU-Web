<?php
$settings = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM settings"));
$sem = $settings->sem;
$ay = $settings->academic_year;
?>
<div class="w3-container w3-animate-zoom">
<div>
  <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#home">Dean Lister</a></li>
    <li><a data-toggle="tab" href="#menu1"></a></li>
  </ul>

  <div class="tab-content">
    <div id="home" class="tab-pane fade in active">
     	<h2>Dean Lister</h2>
     	<?php
		$i = 0;
		$queryDepartment = mysqli_query($conn, "SELECT * FROM department GROUP BY code");
		while($rows = mysqli_fetch_array($queryDepartment)){
			$department = $rows['code'];
			$departmentname = $rows['department_name'];
			$subjectQuery = mysqli_query($conn, "SELECT department, Subject_Code from subject WHERE department = '$department' GROUP BY department");
			while($res = mysqli_fetch_array($subjectQuery)){
				$subject = $res['Subject_Code'];
			echo"
				<div class='panel panel-default'>
				 	<div class='panel-heading'>
						<h4 class='panel-title'>
				        	<a data-toggle='collapse' data-parent='#accordion' href='#collapse_$i' style='text-decoration:none'>$department - $departmentname</a>
				        </h4>
					</div>
					<div id='collapse_$i' class='panel-collapse collapse'>
				        <div class='panel-body'>
							<table class='w3-table w3-striped w3-bordered'>
								<thead>
									<tr class='w3-blue'>
										<th width=10%>No.</th>
										<th>Name</th>
									</tr>
								</thead>";
								$gg=1;
								$grade = mysqli_query($conn, "SELECT DISTINCT Student_No FROM student_grade WHERE Subject_Code = '$subject'");
								while($res=mysqli_fetch_array($grade)){
									$student_no = $res['Student_No'];
									$query = mysqli_fetch_object(mysqli_query($conn, "SELECT id, Student_No, AVG(Average) as Average FROM student_grade WHERE Student_No = '$student_no' AND Sem = '$sem' AND AY = '$ay' "));
									$student_info = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM student_information WHERE Student_no = '".$query->Student_No."'"));
									if($query->Average >= 86){
										echo"
										<tr>
											<td>$gg</td>
											<td><a href='honorStudentDetails.php?id=".$query->Student_No."'>".$student_info->Name."</a></td>
										</td>
										";
										$gg++;
									}
								}
								if(mysqli_num_rows($grade) == 0){
									echo"<tr>
										<td colspan='9' class='w3-center'>No data to display</td>
									</tr>";
								}
								echo"
								<tr class='w3-blue'>
								  	<td colspan=8><b>Honor Student in Past Year</b></td>
								</tr>
								";

								$g=1;
								$grade = mysqli_query($conn, "SELECT DISTINCT Student_No FROM student_grade WHERE Subject_Code = '$subject'");
								while($res=mysqli_fetch_array($grade)){
									$student_no = $res['Student_No'];
									$query = mysqli_fetch_object(mysqli_query($conn, "SELECT id, Student_No, AVG(Average) as Average FROM student_grade WHERE Student_No = '$student_no' "));
									$student_info = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM student_information WHERE Student_no = '".$query->Student_No."'"));
									if($query->Average >= 86){
										echo"
										<tr>
											<td>$g</td>
											<td><a href='honorStudentDetails.php?id=".$query->Student_No."'>".$student_info->Name."</a></td>
										</td>
										";
										$g++;
									}
								}
								if(mysqli_num_rows($grade) == 0){
									echo"<tr>
										<td colspan='9' class='w3-center'>No data to display</td>
									</tr>";
								}
							echo"</table>
				      	</div>
				    </div>
				</div>";
			$i++;
			}
		}
		?>
    </div>

    <div id="menu1" class="tab-pane fade">
     	<h2>Dean Lister</h2>
		<label>No Data Yet</label>
    </div>
  </div>
</div>
</div>
<br>