<div class="w3-container w3-animate-zoom">
<div>
  <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#home">School Record</a></li>
    <li><a data-toggle="tab" href="#menu1">Grade Record</a></li>
  </ul>
<script type="javascript/text">
$(document).ready(function() {
    $('#example').DataTable();
} );
</script>
  <div class="tab-content">
    <div id="home" class="tab-pane fade in active">
     	<h2 style="float:left">School Record</h2>
		<form id='form' method='POST'>
			<select class='form-control' name="sem" style="float:right; width:250px; margin:20px" onChange="myFunction()">
				<option selected disabled>Select By Sem</option>
				<?php
					if(isset($_POST['sem']) && $_POST['sem'] == '1st'){
						echo"<option selected value='1st'>1st</option>";
					} else {
						echo"<option value='1st'>1st</option>";
					}
					if(isset($_POST['sem']) && $_POST['sem'] == '2nd'){
						echo"<option selected value='2nd'>2nd</option>";
					} else {
						echo"<option value='2nd'>2nd</option>";
					}
				?>
			</select>
		</form>
		<table id="example" class="table table-responsive table-striped w3-card-4" cellspacing="0" width="100%">
			<thead>
				<tr class="w3-blue">
					<th class = 'w3-center'>ID</th>
					<th class = 'w3-center'>Semester</th>
					<th class = 'w3-center'>Academic Year</th>
					<th class = 'w3-center'>No.</th>
					<th class = 'w3-center'>Units</th>
					<th class = 'w3-center'>Day</th>
					<th class = 'w3-center'>Time</th>
					<th class = 'w3-center'>Room</th>
				</tr>
			</thead>
			<?php
			if(isset($_POST['sem'])){
				$records = mysqli_query($conn, "SELECT * FROM records WHERE semester = '".$_POST['sem']."'");
			} else {
				$records = mysqli_query($conn, "SELECT * FROM records");
			}
			if(mysqli_num_rows($records) > 0){
				while($res = mysqli_fetch_array($records)){
				echo "<tr>
					<td class = 'w3-center'>".$res['id']."</td>
					<td class = 'w3-center'>".$res['semester']."</td>
					<td class = 'w3-center'>".$res['academic_year']."</td>
					<td class = 'w3-center'>".$res['no']."</td>
					<td class = 'w3-center'>".$res['units']."</td>
					<td class = 'w3-center'>".$res['day']."</td>
					<td class = 'w3-center'>".$res['time']."</td>
					<td class = 'w3-center'>".$res['room']."</td>
				</tr>";
				}
			} else {
				echo"<tr>
					<td colspan='8' class='w3-center'>No data to display</td>
				</tr>";
			}
			?>
		</table>
    </div>

	<script>
		function myFunction(){
			document.getElementById("form").submit();
		}
	</script>

    <div id="menu1" class="tab-pane fade">
     	<h2>Student Grade Record</h2>
     	<div class="w3-container">
		<?php
		$i = 0;
		$teacherList = mysqli_query($conn, "SELECT * FROM teacher_information");
		while($res = mysqli_fetch_array($teacherList)){
			$id = $res['id'];
			$settings = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM settings"));
			$sem = $settings->sem;
			$ay = $settings->academic_year;
			echo "<h2>".$res['First_Name']." ".$res['Last_Name']."</h2>";
			$querySubject = mysqli_query($conn, "SELECT * FROM teacher_submit_grade WHERE profid = $id  AND sem = '$sem' AND ay = '$ay'");
			while($rows = mysqli_fetch_array($querySubject)){
				echo"
					<div class='panel panel-default'>
					 	<div class='panel-heading'>
							<h4 class='panel-title'>
					        	<a data-toggle='collapse' data-parent='#accordion' href='#collapse_$i' style='text-decoration:none'>Subject Name: ".$rows['subject']."&nbsp;&nbsp;&nbsp;&nbsp; Date: ".$rows['date']."</a>
					        </h4>
						</div>
						<div id='collapse_$i' class='panel-collapse collapse'>
					        <div class='panel-body'><a href='getExcelData.php?id=$id&sem=$sem&ay=$ay&subject=".$rows['subject']."' class='btn btn-primary w3-right' id='add'>Downoad</a><br><br>
								<table class='w3-table w3-striped w3-bordered'>
									<thead>
										<tr>
											<tr class='w3-blue'>
												<th class = 'w3-center'>ID</th>
												<th class = 'w3-center'>A.Y</th>
												<th class = 'w3-center'>Student No</th>
												<th class = 'w3-center'>Prelim</th>
												<th class = 'w3-center'>Midterm</th>
												<th class = 'w3-center'>Finals</th>
												<th class = 'w3-center'>Average</th>
												<th class = 'w3-center'>Remarks</th>
											</tr>
										</tr>
									</thead>";
							        $queryGrade = mysqli_query($conn, "SELECT * FROM student_grade WHERE Prof_ID = $id AND Subject_Code = '".$rows['subject']."'  AND Sem = '$sem' AND AY = '$ay'");
							        while($res = mysqli_fetch_assoc($queryGrade)){
							        	echo"
							        	<tr>
											<td class = 'w3-center'>".$res['id']."</td>
											<td class = 'w3-center'>".$res['AY']."</td>
											<td class = 'w3-center'>".$res['Student_No']."</td>
											<td class = 'w3-center'>".$res['Prelim']."</td>
											<td class = 'w3-center'>".$res['Midterm']."</td>
											<td class = 'w3-center'>".$res['Finals']."</td>
											<td class = 'w3-center'>".$res['Average']."</td>
											<td class = 'w3-center'>".$res['Remarks']."</td>
							        	</tr>
							        	";
							        }
							        if(mysqli_num_rows($queryGrade) == 0){
							        	echo"<tr><td rowspan='8' align='w3-center'>No data</td></tr>";
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
    </div>
  </div>
</div>
</div>
<br>