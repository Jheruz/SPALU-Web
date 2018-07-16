<?php
include_once('config.php');
session_start();
if(!isset($_SESSION['name'])){
  header('location:login.php');
} else {
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Student Performance Analytics</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="w3.css">
  <link rel="stylesheet" href="bootstrap.min.css">
  <link rel="stylesheet" href="modal.css">
  <script src="chartjs/Chart.bundle.js"></script>
  <script src="chartjs/utils.js"></script>
  <script src="jquery.min.js"></script>
  <script src="bootstrap.min.js"></script>
  <style>
    canvas{
        -moz-user-select: none;
        -webkit-user-select: none;
        -ms-user-select: none;
    }
    /* Set height of the grid so .sidenav can be 100% (adjust as needed) */
    .row.content {height: 550px}
    
    /* Set gray background color and 100% height */
    .sidenav {
      background-color: #222222;
      height: 120%;
    }
        
    /* On small screens, set height to 'auto' for the grid */
    @media screen and (max-width: 767px) {
      .row.content {height: auto;} 
    }
  </style>
</head>
<body>
<nav class="navbar navbar-inverse visible-xs">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a hef="index.php"><img src="image/ic_analytics.png" width="45" class="img-responsive"></a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li><a href="index.php">Dashboard</a></li>
        <li><a href="Programs.php">Programs</a></li>
        <li class="active"><a href="teacher.php">Teachers</a></li>
        <li><a href="subject.php">Subjects</a></li>
        <li><a href="student.php">Students</a></li>
        <li><a href="honor.php">Honor Student</a></li>
        <li><a href="record.php">Records</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container-fluid">
  <div class="row content">
    <div class="col-sm-2 sidenav hidden-xs">
      <ul class="nav nav-pills nav-stacked" class="marginTop">
        <li><h6><img src="image/ic_analytics.png" width="35%" height="35%"></h6></li>
        <li><a href="index.php">Dashboard</a></li>
        <li><a href="Programs.php">Programs</a></li>
        <li class="active"><a href="teacher.php">Teachers</a></li>
        <li><a href="subject.php">Subjects</a></li>
        <li><a href="student.php">Students</a></li>
        <li><a href="honor.php">Honor Student</a></li>
        <li><a href="record.php">Records</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul><br>
    </div>
    
    <div class="col-sm-10">
      <div class="well w3-teal">
          <h1><center>Student Performance Analytics</center></h1>
      </div>
      <div class="row">
        <div class='col-sm-12'>
            <?php
              include('uploadExcelData.php');
            ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
}
?>
</body>
</html>