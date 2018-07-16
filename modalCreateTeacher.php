<div id="myModal" class="modal w3-animate-top">
	<div class="modal-content">
		<span class="close">×</span>
		<header class="w3-container w3-teal"><h2 align='center'>Create Teacher Account</h2></header>
		
		<div class='w3-container'>
			<form action="createAccount.php" method="POST" id='createForm'>
				<p><label class="w3-label w3-validate">First Name</label><input class="form-control" type="text" name="fname" id='fname' required></p>
				<p><label>Last Name</label><input class="form-control" type="text" name="lname" id='lname'></p>
				<!-- <p>
					<label>Department</label>
					<select name="dept" class='form-control'>
						<?php
							/*$result = mysql_query("SELECT * FROM department");
							while($res=mysql_fetch_array($result)){
								$code = $res['code'];
								$name = $res['department_name'];

								echo "<option value='$code'>$code - $name</option>";
							}
							if(mysql_num_rows($result) == 0){
								echo "<option id='dept' value='Not_Available'>All Rooms is Occupied No Rooms Available!</option>";
								}
							else{
								echo "<input type='hidden' id='dept' value='Available'>";
							}*/
						?>
					</select>
				</p> -->
				<p><label>Username</label><input class="form-control" type="text" name="uname" id='uname'></p>
				<p><label>Password</label><input class="form-control" type="text" name="pass" id='pass'></p>
				<p><input type='button' class="w3-input w3-teal w3-hover-blue" onClick='createAccount()' value='Create Account'></p>
			</form>
		</div>
		
		<script>
		function createAccount(){
			var fname = document.getElementById("fname");
			var lname = document.getElementById("lname");
			var uname = document.getElementById("uname");
			var password = document.getElementById("pass");
			if(fname.value == ""){
				alert('First Name cannot be empty.');
			} else if(lname.value == ""){
				alert('Last Name cannot be empty.');
			} else if(uname.value == ""){
				alert('Username cannot be empty.');
			} else if(pass.value == ""){
				alert('Password cannot be empty.');
			} else{
				document.getElementById("createForm").submit();
			}
		}
		</script>
	</div>
</div>	