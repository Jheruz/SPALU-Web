<?php
if(isset($_GET['id'])){
	$getId = $_GET['id'];
	$query = mysqli_query($conn, "SELECT * FROM teacher_information WHERE id = $getId");
	while($res = mysqli_fetch_array($query)){
		$fname = $res['First_Name'];
		$lname = $res['Last_Name'];
		$username = $res['Username'];
		$pass = $res['Password'];
	}
	?>
	<script>
		window.onload=function(){
			func();
		}
	</script>
	<div id="editModal" class="modal w3-animate-zoom">
		<div class="modal-content">
			<span class="close">×</span>
			<header class="w3-container w3-teal"><h2 align='center'>Edit Teacher Account</h2></header>	
			<div class='w3-container w3-card-4'>
				<form action="updateAccount.php" method="POST" id='editForm'>
					<input type="hidden" name="id" value='<?php echo $getId; ?>'>
					<p><label>First Name</label><input class="w3-input" type="text" name="ffname" id='ffname' value='<?php echo $fname; ?>'></p>
					<p><label>Last Name</label><input class="w3-input" type="text" name="llname" id='llname' value='<?php echo $lname; ?>'></p>
					<p><label>Username</label><input class="w3-input" type="text" name="uuname" id='uuname' value='<?php echo $username; ?>'></p>
					<p><label>Password</label><input class="w3-input" type="text" name="ppass" id='ppass' value='<?php echo $pass; ?>'></p>
					<p><a href='teacher.php' class="w3-btn w3-half w3-red w3-hover-khaki">Back</a></p>
					<p><input type='button' class="w3-input w3-half w3-green w3-hover-light-blue" onClick='updateAccount()' value='Update Account'></p>
				</form>
				<br><br><br>
			</div>

			<script>
				function updateAccount(){
					var ffname = document.getElementById("ffname");
					var llname = document.getElementById("llname");
					var uuname = document.getElementById("uuname");
					var ppassword = document.getElementById("ppass");
					if(ffname.value == ""){
						alert('First Name Field Cannot be empty.');
					}else if(llname.value == ""){
						alert('Last Name Field Cannot be empty.');
					}else if(uuname.value == ""){
						alert('Username Field Cannot be empty.');
					}else if(ppassword.value == ""){
						alert('Password Field Cannot be empty.');
					}else{
						document.getElementById("editForm").submit();
					}
				}
			</script>
		</div>
	</div>
	<?php
}
?>