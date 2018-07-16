<?php
	$student_no = $_GET['id'];
	$studentInfo = mysql_fetch_object(mysql_query("SELECT * FROM student_information WHERE Student_No = '$student_no'"));
?>
<div class="w3-container w3-animate-zoom">
	<h3><b><?php echo $studentInfo->Name; ?><b></h3>
	<table class="w3-table w3-bordered w3-striped ">
		<thead>
			<tr class="w3-blue">
				<th class='w3-center' width="30%">Subject</th>
				<th class='w3-center' width="50%">Subject Description</th>
				<th class='w3-center' width="30%">Grade</th>
			</tr>
		</thead>
		<?php
		$total = 0;
			$query = mysql_query("SELECT * FROM student_grade WHERE Student_No = '$student_no'");
			while($res = mysql_fetch_array($query)){
				$subject = $res['Subject_Code'];
				$subjectInfo = mysql_fetch_object(mysql_query("SELECT * FROM subject WHERE Subject_Code = '$subject'"));
				echo"
				<tr>
					<td class='w3-center' >$subject</td>
					<td class='w3-center' >".$subjectInfo->Subject_Description."</td>
					<td class='w3-center' >".$res['Average']."</td>
				</tr>
				";
				$total += $res['Average'];
			}
			if(!isset($query)){
				header('location:index.php');
			}
			if($total / mysql_num_rows($query) < 86){
				header('location:index.php');
			}
		?>
			<tr>
				<td></td>
				<td class='w3-center'>Average</td>
				<td class='w3-center'><?php echo $total / mysql_num_rows($query) ?></td>
			</tr>
	</table>
</div>