<div class="w3-container w3-animate-zoom">
<?php
if(isset($_GET['create'])){
	echo "<div width='10%' class='w3-khaki'><center><h4>Account Created Successfully</h4></center></div>";
}else if(isset($_GET['delete'])){
	echo "<div width='10%' class='w3-red'><center><h4>Account Deleted Successfully</h4></center></div>";
}else if(isset($_GET['update'])){
	echo "<div width='10%' class='w3-green'><center><h4>Account Updated Successfully</h4></center></div>";
}
include('modalCreateTeacher.php');
include('modalEditTeacher.php');
?>
<style>
.modal-backdrop {
  z-index: -1;
}
</style>
<?php
if(isset($_GET['InfoID'])){

?>
<script type="text/javascript"> 
	$(document).ready(function(){
		$("#viewInfo").modal("show");
	});
</script>
	<div class="modal fade" id="viewInfo" role="dialog">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header w3-teal">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h2 class="modal-title"><center>Teacher Subject List</center></h2>
				</div>
				<div class="modal-body">
					<table class="w3-table w3-striped w3-bordered">
						<thead>
							<tr class="w3-blue">
								<th width="10%">No.</th>
								<th>Subject Code</th>
								<th>Subject Description</th>
							</tr>
						</thead>
						<?php
						$teacherSubject = mysqli_query($conn, "SELECT * FROM subject WHERE ProfID = ".$_GET['InfoID']."  GROUP BY Subject_Code");
						$no = 1;
						while($res = mysqli_fetch_array($teacherSubject)){
							//$Prof_ID = $res['profid'];
							echo "
							<tr>
								<td>$no</td>
								<td>".$res['Subject_Code']."</td>
								<td>".$res['Subject_Description']."</td>
							</tr>";
							$no++;
						}
						if(mysqli_num_rows($teacherSubject) == 0){
							echo"
							<tr>
								<td class='w3-center' colspan = 3><b>No Teacher subject To Display Please Add excel file Account</b></td>
							</tr>
							";
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
<?php
}
?>
<script type="text/javascript">
	$(document).ready(function() {
		$('#data').DataTable();
	} );
</script>
<div class="w3-container w3-animate-zoom well">
	<div class="row">
		<div class="col-md-12">
			<button class='btn btn-primary w3-right' id="add">Add Teacher</button><br><br>
			<div style="overflow-x:auto;">
				<table  id="data" class="table table-responsive table-striped">
					<thead>
						<tr class="w3-blue">
							<th class = 'w3-center'>No.</th>
							<th class = 'w3-center'>Name</th>
							<th class = 'w3-center'>Username</th>
							<th class = 'w3-center'>Password</th>
							<th class = 'w3-center'>Action</th>
						</tr>
					</thead>
					<tbody>
					<?php
						$allteacher = mysqli_query($conn, "SELECT * FROM teacher_information");
						$i=1;
						while($res = mysqli_fetch_array($allteacher)){
							echo "<tr>
							<td class = 'w3-center'>$i</td>
							<td class = 'w3-center'><a href='teacher.php?InfoID=".$res['id']."' style='color:black'>".$res['First_Name']." ".$res['Last_Name']."</a></td>
							<td class = 'w3-center'>".$res['Username']."</td>
							<td class = 'w3-center'>".$res['Password']."</td>
							<td class = 'w3-center'>
							<a href='uploadExcel.php?id=".$res['id']."' class='btn btn-primary' >+</a>
							<a href='teacher.php?id=".$res['id']."' class='btn btn-success'>Edit</a>
							<a href='deleteAccount.php?id=".$res['id']."' class='btn btn-danger'>Delete</a>
							</td>
							</tr>";
							$i++;
						}
						if(mysqli_num_rows($allteacher) == 0){
							echo"
							<tr>
							<td class='w3-center' colspan = 6><b>No Teacher account To Display Please Add teacher account Account</b></td>
							</tr>
							";
						}
					?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<script>
var editModal = document.getElementById("editModal");
var modal = document.getElementById("myModal");
var btn = document.getElementById("add");
var span = document.getElementsByClassName("close")[0];
var span2 = document.getElementsByClassName("close")[1];
btn.onclick = function() {
	modal.style.display = "block";
}
span.onclick = function() {
	modal.style.display = "none";
}
span2.onclick = function() {
	editModal.style.display = "none";
}
window.onclick = function(event) {
	if (event.target == modal) {
		modal.style.display = "none";
	}
	if (event.target == editModal) {
		editModal.style.display = "none";
	}
}

function func(){
	editModal.style.display = "block";
}
</script>