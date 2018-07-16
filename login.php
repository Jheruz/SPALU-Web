<?php
include_once('config.php');
if (isset($_POST['login'])){
$admin = $_POST['admin'];
$pass = $_POST['pass'];
$result = mysqli_query($conn, "SELECT * FROM admin where Username = '$admin' and Password = '$pass'");
		
while($res = mysqli_fetch_array($result)){
$id = $res['id'];
$name = $res['username'];
}
				
if(!empty($id)){
session_start();
$_SESSION['name']=$name;
header('location:index.php');
}
else{
	$gg = 1;
}
}
?>
<!DOCTYPE HTML>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<link rel="stylesheet" href="w3.css">
	<link rel="stylesheet" href="bootstrap.min.css">
	<link rel="stylesheet" href="modal.css">
	<script src="canvasjs/canvasjs.min.js"></script>
	<script src="jquery.min.js"></script>
	<script src="bootstrap.min.js"></script>
	<title>Admin</title>
</head>
<body>
<center>
	<div class="w3-container"  style="width:540px; height: 630px; background: url('image/loginbg.jpeg'); background-repeat: no-repeat;">
		<img src="image/lulogo.png"><br>
		<label><b><font color="white" size="4px">Laguna University</font></b></label><br>
		<label><b><font color="white" size="4px">Student Performance Analytics</font></b></label><br>
		<label><b><font color="white" size="5px">Login</font></b></label>
		<form class="w3-container" action="" method="POST">
			<font color="white"><label style="float:left">Username</label></font>
			<input class="w3-input" type="text" name="admin" style="float:left"><br>
			<font color="white"><label style="float:left">Password</label></font>
			<input class="w3-input" type="password" name="pass" style="float:left"><br><br><br>
			<button class="btn btn-primary" type="submit" name="login" style="margin:10px">Login</button>
		</form>
		<?php
		if(isset($gg)){
		    echo"<font color = red><center><label>Incorrect Username or Password!</label></center></font>";
		}
		?>
	</div>
</center>

</body>
</html>
