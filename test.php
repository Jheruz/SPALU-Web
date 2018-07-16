<?php
include_once('config.php');
ini_set('max_execution_time',0); 
//query for chart
$male = array();
$female = array();
$all = array();

$i = 0;
$maleAverage = "";
$femaleAverage = "";
$allAverage = "";

$departmentMale = array();
$departmentFemale = array();
$departmentAll = array();

$ii = 0;
$departmentMaleAverage = "";
$departmentFemaleAverage = "";
$departmentAllAverage = "";

$additionalQuery = "";
if(isset($_POST['year'])){
	if($_POST['year'] != ""){
		$additionalQuery .=" AND si.Year = '".$_POST['year']."' ";
	}
}
if(isset($_POST['sem'])){
	$additionalQuery .=" AND si.Sem = '".$_POST['sem']."' ";
}
if(isset($_POST['academic_year'])){
	$additionalQuery .=" AND si.AY = '".$_POST['academic_year']."' ";
}

echo"<script>var title = 'Grade Average in Laguna University';</script>";
///////



/////
$maleQuery = mysql_query("SELECT * FROM lu_charts");
while($row = mysql_fetch_array($maleQuery)){
	echo $row[1]."<br>";
	$male[$i] = array("y" => 0, "label" => $row[1]);
	$female[$i] = array("y" => 0, "label" => $row[1]);
	$all[$i] = array("y" => 0, "label" => $row[1]);
	if(!empty($row[0]) && !empty($row[2])){
		if($row[1] == "Male"){
			$male[$i] = array("y" => $row[0], "label" => $row[1]);
		} else {
			$female[$i] = array("y" => $row[0], "label" => $row[1]);
		}
		$avg = 
		$all[$i] = array("y" => $row[0], "label" => $row[1]);
	}
	$i++;
}


/*$departmentQuery = mysql_query("SELECT AVG(Average) as Average FROM department dept,
	INNER JOIN student_grade sg,

 GROUP BY dept.code");
while($res=mysql_fetch_array($departmentQuery)){
	$tempDepartment = $res['code'];
	$maleQuery = mysql_query("SELECT AVG(Average) as Average FROM student_grade sg 
		JOIN student_information si ON si.Student_No = sg.Student_No
		JOIN subject sub ON sub.Subject_Code = si.Class_Code
		JOIN department dept ON dept.code = sub.department
		WHERE si.Gender = 'Male' AND dept.code = '$tempDepartment' ".$additionalQuery);
	$femaleQuery = mysql_query("SELECT AVG(Average) as Average FROM student_grade sg 
		JOIN student_information si ON si.Student_No = sg.Student_No
		JOIN subject sub ON sub.Subject_Code = si.Class_Code
		JOIN department dept ON dept.code = sub.department
		WHERE si.Gender = 'Female' AND dept.code = '$tempDepartment' ".$additionalQuery);
	$allQuery = mysql_query("SELECT AVG(Average) as Average FROM student_grade sg 
		JOIN student_information si ON si.Student_No = sg.Student_No
		JOIN subject sub ON sub.Subject_Code = si.Class_Code
		JOIN department dept ON dept.code = sub.department
		WHERE dept.code = '$tempDepartment' ".$additionalQuery); 
	while($temp = mysql_fetch_array($maleQuery)){
		$maleAverage = $temp['Average'];
	}
	while($temp = mysql_fetch_array($femaleQuery)){
		$femaleAverage = $temp['Average'];
	}
	while($temp = mysql_fetch_array($allQuery)){
		$allAverage = $temp['Average'];
	}
	if($maleAverage != ""){
		$male[$i] = array("y" => $maleAverage, "label" => $tempDepartment);
	} else {
		$male[$i] = array("y" => 0, "label" => $tempDepartment);
	}
	if($femaleAverage != ""){
		$female[$i] = array("y" => $femaleAverage, "label" => $tempDepartment);
	} else {
		$female[$i] = array("y" => 0, "label" => $tempDepartment);
	} 
	if($allAverage != ""){
		$all[$i] = array("y" => $allAverage, "label" => $tempDepartment);
	} else {
		$all[$i] = array("y" => 0, "label" => $tempDepartment);
	}
	$i++;
}*/

?>
<div id='myChart'></div>
  <script src="canvasjs/canvasjs.min.js"></script>
<script type="text/javascript">
/*
	window.onload = function(){showChart();}
function showChart(){
	var chart = new CanvasJS.Chart("myChart", {
	animationEnabled: true,
	title: {
		text: "title"
	},
		legend:{
			cursor: "pointer",
            itemclick: function (e) {
                if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                    e.dataSeries.visible = false;
                } else {
                    e.dataSeries.visible = true;
                }

                e.chart.render();
            }
		},
		data: [{
            showInLegend: true,
            legendText: "Male",
			type: "line",
			dataPoints: <?php echo json_encode($male, JSON_NUMERIC_CHECK); ?>
		},
		{
            showInLegend: true,
            legendText: "Female",
			type: "line",
			dataPoints: <?php echo json_encode($female, JSON_NUMERIC_CHECK); ?>
		},
		{
            showInLegend: true,
            legendText: "Both",
			type: "line",
			//indexLabel: "{label} , {y}",
			dataPoints: <?php echo json_encode($all, JSON_NUMERIC_CHECK); ?>
		}]
	});
	chart.render();

	var chart = new CanvasJS.Chart("departmentChart", {
	animationEnabled: true,
	title: {
		text: departmentTitle
	},
		legend:{
			cursor: "pointer",
            itemclick: function (e) {
                if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                    e.dataSeries.visible = false;
                } else {
                    e.dataSeries.visible = true;
                }

                e.chart.render();
            }
		},
		data: [{
            showInLegend: true,
            legendText: "Male",
			type: "line",
			dataPoints: <?php echo json_encode($departmentMale, JSON_NUMERIC_CHECK); ?>
		},
		{
            showInLegend: true,
            legendText: "Female",
			type: "line",
			dataPoints: <?php echo json_encode($departmentFemale, JSON_NUMERIC_CHECK); ?>
		},
		{
            showInLegend: true,
            legendText: "Both",
			type: "line",
			//indexLabel: "{label} , {y}",
			dataPoints: <?php echo json_encode($departmentAll, JSON_NUMERIC_CHECK); ?>
		}]
	});
	chart.render();
}
*/
</script>