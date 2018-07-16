<?php
//query
$query = "";
if(isset($_POST['filterYear']) || isset($_POST['filterSem']) || isset($_POST['filterProgram']) || isset($_POST['filterAY'])){
	$query = "where";
	if(isset($_POST["filterYear"])){
		if ($query != "where") {
			$query .= " and ";
		}
		$query .= " Year = '".$_POST['filterYear']."'";
	}
	if(isset($_POST['filterSem'])){
		if ($query != "where") {
			$query .= " and ";
		}
		$query .= " Sem = '".$_POST['filterSem']."'";
	}
	if(isset($_POST['filterProgram'])){
		if ($query != "where") {
			$query .= " and ";
		}
		$query .= " Course = '".$_POST['filterProgram']."'";
	}
	if(isset($_POST['filterAY'])){
		if ($query != "where") {
			$query .= " and ";
		}
		$query .= " AY = '".$_POST['filterAY']."'";	
	}
}
$studentQuery = mysqli_query($conn, "SELECT * FROM student_information ".$query." GROUP BY Student_No");

if(isset($_GET['print_id'])){

?>
<style>
.modal-backdrop {
  z-index: -1;
}
</style>
<script type="text/javascript"> 
	$(document).ready(function(){
		$("#print").modal('show');
	});
</script>
<script>
function printGrade(id){
	var printContents = document.getElementById(id).innerHTML;
    var originalContents = document.body.innerHTML;

    document.body.innerHTML = printContents;

    window.print();

    document.body.innerHTML = originalContents;
}
</script>
<!-- Modal -->
<div class="modal fade" id="print" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header w3-teal">
				<a href='student.php'><button type="button" class="close">&times;</button></a>
				<h2 class="modal-title"><center>Print Grade of Student</center></h2>
			</div>
			<!-- eto ung piprint -->
			<div class="modal-body">
				<div id="printThis">
				<?php
				$studentInfo = mysqli_query($conn, "SELECT * FROM student_information WHERE id = ".$_GET['print_id']);
				while($res = mysqli_fetch_array($studentInfo)){
					$studentNo = $res['Student_No'];
					$studentName = $res['Name'];
					$program = $res['Course'];
					$year = $res['Year'];
				}
				$settings = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM settings"));
				?>
				<table width=100% class="w3-table-responsive">
					<tr>
						<td rowspan=6 align="right"><img src="image/lulogo.png" height="80px"></td>
					</tr>
					<tr>
						<td class="w3-center"><font size="3px" color="green"><b>LAGUNA UNIVERSITY<b></font></td>
						<td class="w3-center">LU From No. 2</td>
					</tr>
					<tr>
						<td class="w3-center"><b>Office of the Registrar</b></td>
						<td class="w3-center">Classcard</td>
					</tr>
					<tr>
						<td class="w3-center">Laguna Sports Complex, Brgy Bubukal, Sta Cruz, Laguna</td>
					</tr>
					<tr>
						<td class="w3-center">Tel No.: (049) 501-4360</td>
					</tr>
					<tr>
						<td class="w3-center"><?php echo "<b>".$settings->sem."</b>"; ?>&nbsp;&nbsp;&nbsp;
							Semester, Academic Year 
							&nbsp;&nbsp;&nbsp;<?php echo "<b>".$settings->academic_year."</b>"; ?></td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td>Date: &nbsp;&nbsp;<?php echo date('m/d/Y'); ?></td>
					</tr>
				</table>
				<table class="w3-table-responsive">
					<tr>
						<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Student No:</td>
						<td>&nbsp;&nbsp;&nbsp;<b><font size="4px"><?php echo $studentNo;?></font></b></td>
					</tr>
					<tr>
						<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Name:</td>
						<td>&nbsp;&nbsp;&nbsp;<b><font size="4px"><?php echo $studentName;?></font></b></td>
					</tr>
					<tr>
						<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Program:</td>
						<td>&nbsp;&nbsp;&nbsp;<?php echo $program;?></td>
					</tr>
					<tr>
						<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Year:</td>
						<td>&nbsp;&nbsp;&nbsp;<?php echo $year;?></td>
					</tr>
				</table>
				<br>
				<table width="100%" class="w3-table-responsive w3-striped">
					<thead>
						<tr>
							<th width="20%">Course Code</th>
							<th width="40%" class='w3-center'>Descriptive Title</th>
							<th width="10%" class='w3-center'>Units</th>
							<th width="10%" class='w3-center'>&nbsp;Equivalent</th>
							<th width="10%" class='w3-center'>&nbsp;Completion</th>
							<th width="10%" class='w3-center'>&nbsp;Remarks</th>
						</tr>
					</thead>
					<?php
					$studentGrade = mysqli_query($conn, "SELECT * FROM student_grade WHERE Student_No = '$studentNo'");
					while($res = mysqli_fetch_array($studentGrade)){
						$subcode = $res['Subject_Code'];
						$subequivalent = $res['Average'];
						$subremarks = $res['Remarks'];
						$subjectQuery = mysqli_query($conn, "SELECT * FROM subject WHERE Subject_Code = '$subcode'");
						while($rows = mysqli_fetch_array($subjectQuery)){
							$subno = $rows['No'];
							$subtitle = $rows['Subject_Description'];
						}
						$recordsQuery = mysqli_query($conn, "SELECT * FROM records WHERE no = $subno");
						while($rows = mysqli_fetch_array($recordsQuery)){
							$subunits = $rows['units'];
						}
						echo "
						<tr>
							<td>$subcode</td>
							<td>$subtitle</td>
							<td class='w3-center'>$subunits</td>
							<td class='w3-center'>$subequivalent</td>
							<td class='w3-center'>--</td>
							<td class='w3-center'>$subremarks</td>
						</tr>
						";
					}
					if(mysqli_num_rows($studentGrade) == 0){
						echo"
						<tr>
							<td colspan='8' class='w3-center'>No data to display</td>
						</tr>
						";
					}
					?>
					</table>
					<br>
					<font size="1px"><b>Grading System:</b><br>
					<table width=50% class="w3-table-responsive">
						<tr>
							<td>1.00 = 98% and above</td>
							<td>3.00 = 75%</td>
						</tr>
						<tr>
							<td>1.25 = 94%-97%</td>
							<td>5.00 = Failed</td>
						</tr>
						<tr>
							<td>1.50 = 90%-93%</td>
							<td>INC - Incomplete</td>
						</tr>
						<tr>
							<td>1.75 = 86%-89%</td>
							<td>DRP - Drop</td>
						</tr>
						<tr>
							<td>2.00 = 85%</td>
							<td>UD - Unofficially Drop</td>
						</tr>
						<tr>
							<td>2.25 = 82%-84%</td>
							<td></td>
						</tr>
						<tr>
							<td>2.50 = 80%-81%</td>
							<td></td>
						</tr>
						<tr>
							<td>2.75 = 76%-79%</td>
							<td></td>
						</tr>
					</table>
					</font>
					</div>
				</div>
			<div class="modal-footer">
				<a href='student.php'><button type="button" class="btn btn-default">Close</button></a>
				<button type="button" class="btn btn-primary" onClick="printGrade('printThis')">Print</button>
			</div>
		</div>
	</div>
</div>
<?php
}
?>
<div class="row">
	<div class="col-md-12">
		<div class="container-fluid w3-animate-zoom well">
			<div class="row">
				<div class="col-md-12">
					<br>
					<form action="student.php" method='POST'>
						<div class="col-md-2">
							<select class='form-control form-group' name="filterYear">
								<option selected disabled>Filter By Year</option>
								<?php
								if(isset($_POST['filterYear']) && $_POST['filterYear'] == "1st"){
									echo "<option selected value='1st'>1st Year</option>";
								} else {
									echo "<option value='1st'>1st Year</option>";
								}
								if(isset($_POST['filterYear']) && $_POST['filterYear'] == "2nd"){
									echo "<option selected value='2nd'>2nd Year</option>";
								} else {
									echo "<option value='2nd'>2nd Year</option>";
								}
								if(isset($_POST['filterYear']) && $_POST['filterYear'] == "3rd"){
									echo "<option selected value='3rd'>3rd Year</option>";
								} else {
									echo "<option value='3rd'>3rd Year</option>";
								}
								if(isset($_POST['filterYear']) && $_POST['filterYear'] == "4th"){
									echo "<option selected value='4th'>4th Year</option>";
								} else {
									echo "<option value='4th'>4th Year</option>";
								}
								if(isset($_POST['filterYear']) && $_POST['filterYear'] == "5th"){
									echo "<option selected value='5th'>5th Year</option>";
								} else {
									echo "<option value='5th'>5th Year</option>";
								}
								?>
							</select>
						</div>
						<div class="col-md-2">
							<select class='form-control form-group' name="filterSem">
								<option selected disabled>Filter By Sem</option>
								<?php
								if(isset($_POST['filterSem']) && $_POST['filterSem'] == "1st"){
									echo "<option selected value='1st'>1st Semester</option>";
								} else {
									echo "<option value='1st'>1st Semester</option>";
								}
								if(isset($_POST['filterSem']) && $_POST['filterSem'] == "2nd"){
									echo "<option selected value='2nd'>2nd Semester</option>";
								} else {
									echo "<option value='2nd'>2nd Semester</option>";
								}
								?>
							</select>
						</div>
						<div class="col-md-3">
							<select class='form-control form-group' name="filterProgram">
								<option selected disabled>Filter By Program</option>
								<?php
								$programQuery = mysqli_query($conn, "SELECT * FROM department GROUP BY code");
								while($rows = mysqli_fetch_array($programQuery)){
									if(isset($_POST['filterProgram']) && $_POST['filterProgram'] == "".$rows[code].""){
										echo "<option selected value='".$rows['code']."'>".$rows['code']."</option>";
									} else {
										echo "<option value='".$rows['code']."'>".$rows['code']."</option>";
									}
								}
								?>
							</select>
						</div>
						<div class="col-md-3">
							<select class='form-control form-group' name="filterAY">
								<option selected disabled>Filter By A.Y</option>
								<?php
								$ay = "2017";
								for($i=0;$i<15;$i++){
									$nextYear = $ay+1;
									$completeAY = $ay."-".$nextYear;
									$ay++;
									if(isset($_POST['filterAY']) && $_POST['filterAY'] == "$completeAY"){
										echo "<option selected value='$completeAY'>$completeAY</option>";
									} else {
										echo "<option value='$completeAY'>$completeAY</option>";
									}
								}
								?>
							</select>
						</div>
						<div class="col-md-2">
							<button type="submit" name="submit" class="btn btn-primary" style="width: 100%">Submit</button>
						</div> <br>
					</form>
				</div>
			</div>
			<script>
				$(document).ready(function() {
					$('#data').DataTable();
				} );
			</script>

			<div class="row">
				<div class="col-md-12">
					<div style="overflow-x:auto;">
						<table  id="data" class="table table-responsive table-striped">
							<thead>
								<tr class="w3-blue">
									<th width="10%">No.</th>
									<th class = 'w3-center'>Student No.</th>
									<th>Name</th>
									<th class = 'w3-center'>Gender</th>
									<th class = 'w3-center'>Program</th>
									<th class = 'w3-center'>Year</th>
									<th class = 'w3-center'>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$i = 1;
								while($res=mysqli_fetch_array($studentQuery)){
									$id = $res['id'];
									echo "<tr>
									<td>$i</td>
									<td class = 'w3-center'>".$res['Student_No']."</td>
									<td>".$res['Name']."</td>
									<td class = 'w3-center'>".$res['Gender']."</td>
									<td class = 'w3-center'>".$res['Course']."</td>
									<td class = 'w3-center'>".$res['Year']."</td>
									<td class = 'w3-center'><a href='student.php?print_id=$id'>Print Grade</a></td>
									";
									$i++;
								}
								?>
							</tbody>
						</table>
						<br>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>