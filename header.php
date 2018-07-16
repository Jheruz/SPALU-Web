<header class="w3-container w3-teal">
  <h1><center>Student Performance Analytics</center></h1>
</header>

<div class="w3-bar w3-border w3-card-4 w3-light-grey w3-large">
	<a href="index.php" class="w3-bar-item w3-button w3-hover-green">Home</a>
	<a href="teacher.php" class="w3-bar-item w3-button w3-hide-small">Teachers</a>
	<a href="subject.php" class="w3-bar-item w3-button w3-hide-small">Subjects</a>
	<a href="records.php" class="w3-bar-item w3-button w3-hide-small">Records</a>
	<a href="settings.php" class="w3-bar-item w3-button w3-hide-small">Settings</a>
	<a href="logout.php" class="w3-bar-item w3-button w3-hide-small">Logout</a>
	<a href="javascript:void(0)" class="w3-bar-item w3-button w3-right w3-hide-large w3-hide-medium" onclick="myFunction()">&#9776;</a>
	
</div>
<div id="demo" class="w3-bar-block w3-hide w3-hide-large w3-hide-medium">
	<a href="teacher.php" class="w3-bar-item w3-button">Teachers</a>
	<a href="subject.php" class="w3-bar-item w3-button">Subjects</a>
	<a href="records.php" class="w3-bar-item w3-button">Records</a>
	<a href="settings.php" class="w3-bar-item w3-button">Settings</a>
	<a href="logout.php" class="w3-bar-item w3-button">Logout</a>
</div>
<script>
function myFunction() {
    var x = document.getElementById("demo");
    if (x.className.indexOf("w3-show") == -1) {
        x.className += " w3-show";
    } else { 
        x.className = x.className.replace(" w3-show", "");
    }
}
</script>