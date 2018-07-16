<?php
include_once('config.php');
$getId = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM teacher_information WHERE id = $getId");
while($row = mysqli_fetch_array($query)){
$fullname = $row['First_Name'] ." ". $row['Last_Name'];
}
?>
<div class="w3-container w3-animate-zoom">
	<div class='well w3-container'>
	<?php
		if(isset($_GET['success'])){
			echo "<div width='10%' class='w3-khaki'><center><h4>File Uploaded Successfully</h4></center></div>";
		} if(isset($_GET['alreadyExist'])){
			echo "<div width='10%' class='w3-red'><center><h4>File Aleady Exist</h4></center></div>";
		} if(isset($_GET['noSelected'])){
			echo "<div width='10%' class='w3-red'><center><h4>No Excel selected Please Select excel file first before uploading</h4></center></div>";
		}
		if(isset($getId)){
	?>
		<p><form action="uploadToServer.php" class='w3-container' method="POST" enctype="multipart/form-data">
			<label class='w3-label'><h2><b>Prof Name:</b> <?php echo $fullname; ?></h2></label><br>
			<label class='w3-label w3-third'><h3><b>Select Excel File</b></h3></label>
			<input class="w3-input" type='file' name="fileToUpload" id="file" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"> <p></p>
			<input class="w3-input" type='file' name="fileToUpload1" id="file1" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"> <p></p>
			<input class="w3-input" type='file' name="fileToUpload2" id="file2" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"> <p></p>
			<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
			<p><a href="teacher.php" class="btn btn-danger">back</a>
			<input type= "submit" class="btn btn-primary" name='submit' value ="Upload"></p>
		</form></p>
	</div>
</div>
<?php
	//include('uploadToServer.php');
	}
	else{
		header('location:teacher.php');
	}
?>