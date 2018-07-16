<!--<button class='btn btn-primary w3-right' id='add'>Add Program</button><br><br>-->
<?php
if(isset($_GET['create'])){
	echo "<div width='10%' class='w3-khaki'><center><h4>Program Created Successfully</h4></center></div>";
}else if(isset($_GET['delete'])){
	echo "<div width='10%' class='w3-red'><center><h4>Program Deleted Successfully</h4></center></div>";
}else if(isset($_GET['update'])){
	echo "<div width='10%' class='w3-green'><center><h4>Program Updated Successfully</h4></center></div>";
}
include('modalEditDepartment.php');
?>
<script>
	$(document).ready(function() {
		$('#data').DataTable();
	} );
</script>
<div class="w3-container w3-animate-zoom well">
	<div class="row">
		<div class="col-md-12">
			<div style="overflow-x:auto;">
				<table  id="data" class="table table-responsive table-striped">
					<thead>
						<tr class="w3-blue">
							<th class = 'w3-center' width='10%'>No.</th>
							<th width="20%">Program Code</th>
							<th >Program Name</th>
							<th class = 'w3-center'>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$allteacher = mysqli_query($conn, "SELECT * FROM department GROUP BY code");
						$i=1;
						while($res = mysqli_fetch_array($allteacher)){
							echo "<tr>
							<td class = 'w3-center' style='padding:10px;'>$i</td>
							<td style='padding:10px;'>".$res['code']."</td>
							<td style='padding:10px;'>".$res['department_name']."</td>
							<td class = 'w3-center'>
							<a href='programs.php?id=".$res['id']."' class='btn btn-sm btn-success'>Edit</a>
							<a href='deleteDepartment.php?id=".$res['id']."' class='btn btn-sm btn-danger'>Delete</a>
							</td>
							</tr>";
							$i++;
						}
						if(mysqli_num_rows($allteacher) == 0){
							echo"
							<tr>
							<td class='w3-center' colspan = 4><b>No Program To Display Please Add Program</b></td>
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