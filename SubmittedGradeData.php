<?php
$id = $_GET['id'];
$sem = $_GET['sem'];
$ay = $_GET['ay'];
if(!isset($id) && !isset($sem) && !isset($ay)){
	header('location:index.php');
}
$query = mysqli_query($conn, "SELECT * FROM teacher_information WHERE id = $id");
while($rows = mysqli_fetch_array($query)){
	$name = $rows['First_Name'] . " " . $rows['Last_Name'];
}
?>
<div class="w3-container w3-animate-zoom">
	<h3><b><?php echo $name; ?><b></h3>
		<div class='panel-group' id='accordion'>
			<?php
			$i = 0;
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
				echo"</table>
				</div>
				</div>
				</div>";
				$i++;
			}
			?>
		</div>
	</div>