<?php
if(isset($_GET['id'])){
	$getId = $_GET['id'];
	$query = mysqli_query($conn, "SELECT * FROM department WHERE id = $getId");
	while($res = mysqli_fetch_array($query)){
		$code = $res['code'];
		$name = $res['department_name'];
	}
?>
<script>
window.onload=function(){
	func();
}
</script>
<div class="modal animate-zoom" id="editModal" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<a href="programs.php">
					<button type='button' class='close' data-dismiss="modal" aria-label='Close'>
						<span aria-hidden='true'>&times;</span>
					</button>
				</a>
				<h3 align="center" class='modal-title'>Edit Department</h3>
			</div>
			<div class="modal-body">
				<form action="updateDepartment.php" method="POST" id="editForm">
					<div class='row'>
						<div class='col-md-12'>
							<input type="hidden" name="id" value='<?php echo $getId; ?>'>
							<div class='form-group'>
								<label>Department Code</label>
								<input class="w3-input" type="text" name="code" id='ffname' value='<?php echo $code; ?>'>
							</div>
							<div class='form-group'>
								<label>Department Name</label>
								<input class="w3-input" type="text" name="name" id='llname' value='<?php echo $name; ?>'>
							</div>
						</div>
					</div>
			</div>
			<div class='modal-footer'>	
				<a href="programs.php">
          			<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          		</a>
				<button type='button' class='btn btn-primary' onClick='updateAccount()'>Update</button>
				<form>
			</div>
		</div>
	</div>
</div>
<script>
	function updateAccount(){
		var ffname = document.getElementById("ffname");
		var llname = document.getElementById("llname");
		if(ffname.value == ""){
			alert('Department Code Field Cannot be empty.');
		} else if(llname.value == ""){
			alert('Department Name Field Cannot be empty.');
		} else{
			document.getElementById("editForm").submit();
		}
	}
</script>
<?php
}
?>