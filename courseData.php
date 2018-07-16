<div class="w3-container w3-animate-zoom">
<button class='w3-btn w3-teal w3-round w3-ripple w3-right' id='add'>Add Course</button><br><br>
<?php
if(isset($_GET['add'])){
	echo "<div width='10%' class='w3-khaki'><center><h4>Course Added Successfully</h4></center></div>";
}else if(isset($_GET['add'])){
	echo "<div width='10%' class='w3-red'><center><h4>Course Deleted Successfully</h4></center></div>";
}else if(isset($_GET['update'])){
	echo "<div width='10%' class='w3-green'><center><h4>Course Updated Successfully</h4></center></div>";
}
include('modalAddCourse.php');
?>
	<table class="w3-table w3-striped w3-bordered w3-card-4">
		<thead>
			<tr class="w3-blue">
				<th class = 'w3-center'>ID</th>
				<th class = 'w3-center'>Course Name</th>
				<th class = 'w3-center'>Description</th>
				<th class = 'w3-center'>Action</th>
			</tr>
		</thead>
		<?php
		$allteacher = mysql_query("SELECT * FROM course");
		while($res = mysql_fetch_array($allteacher)){
			echo "<tr>
				<td class = 'w3-center'>".$res['id']."</td>
				<td class = 'w3-center'>".$res['Course_Name']."</td>
				<td class = 'w3-center'>".$res['Description']."</td>
				<td class = 'w3-center'>
					<a href='editTeacher.php?id=".$res['id']."' class='btn btn-success'>Edit</a>
					<a href='deleteCourse.php?id=".$res['id']."' class='btn btn-danger'>Delete</a>
				</td>
			</tr>";
		}
		?>
	</table>
	<br>
</div>
<script>
var modal = document.getElementById("myModal");
var btn = document.getElementById("add");
var span = document.getElementsByClassName("close")[0];
btn.onclick = function() {
	modal.style.display = "block";
}
span.onclick = function() {
	modal.style.display = "none";
}
window.onclick = function(event) {
	if (event.target == modal) {
		modal.style.display = "none";
	}
}

$(document).ready(function(){
    $('[data-toggle="popover"]').popover({title: "<center>Select Action</center>",
    	content: "<center><button class='btn btn-primary'>Add Subject</button> <button class='btn btn-primary'>Upload Excell</button></center>",
    	html: true,
    	placement: "top"}); 
});
</script>