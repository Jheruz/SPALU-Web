<?php
if(isset($_POST['department'])){
	$querySubject = mysqli_query($conn, "SELECT * FROM subject WHERE department = '".$_POST['department']."'");
} else {
	$querySubject = mysqli_query($conn, "SELECT * FROM subject");
}
?>
<div class="w3-container w3-animate-zoom well">
	<div class="row">
		<div class="col-md-12">
			<form id='form' method='POST'>
				<select class='form-control' name="department" style="float:right; width:200px; margin:10px" onChange="myFunction()">
					<option selected disabled>Select By Program</option>
					<?php
					$query = mysqli_query($conn, "SELECT * FROM department GROUP BY code");
					while($res = mysqli_fetch_array($query)){
						if(isset($_POST['department']) && $_POST['department'] == "".$res[code].""){
							echo"<option selected value='".$res[code]."'>".$res[code]."</option>";
						} else {
							echo"<option value='".$res[code]."'>".$res[code]."</option>";
						}
					}
					?>
				</select>
			</form>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div style="overflow-x:auto;">
				<script>
					$(document).ready(function() {
						$('#data').DataTable();
					} );
				</script>
				<table id="data" class="table table-responsive table-striped">
					<thead>
						<tr class="w3-blue">
							<th class = 'w3-center' width="10%">No</th>
							<th class = 'w3-center'>Subject No.</th>
							<th class = 'w3-center'>Subject Code</th>
							<th width="40%">Subject Description</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$i=1;
						while($res = mysqli_fetch_array($querySubject)){
							echo "<tr>
							<td class = 'w3-center'>$i</td>
							<td class = 'w3-center'>".$res['No']."</td>
							<td class = 'w3-center'>".$res['Subject_Code']."</td>
							<td>".$res['Subject_Description']."</td>
							</tr>";
							$i++;
						}
						if(mysqli_num_rows($querySubject) == 0){
							echo "<tr>
							<td colspan=4 class = 'w3-center'><b>No data to display</b></td>
							</tr>";
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<script>
	function myFunction(){
		document.getElementById("form").submit();
	}
</script>