<?php
if(isset($_POST['prof_id'])){
    include('config.php');
    $profid = $_POST['prof_id'];
    $sem = $_POST['sem'];
    $ay = $_POST['ay'];
    $date = $_POST['date'];
    $subject = $_POST['subject'];
    
    mysqli_query($conn, "DELETE FROM student_grade WHERE Prof_ID = $id and Sem ='$sem' and AY = '$ay'");
    mysqli_query($conn, "DELETE FROM teacher_submit_grade WHERE profid = $id and sem ='$sem' and ay = '$ay'");
    
    $JSON_received = $_POST["student_grade"];
    $obj = json_decode($JSON_received, true);
    foreach ($obj as $key => $value) 
    {
        mysqli_query($conn, "INSERT INTO student_grade (Sem, AY, Prof_ID, Subject_Code, Student_No, Prelim, Midterm, Finals, Average, Remarks) VALUES ('$sem', '$ay', $profid, '$subject', '".$value['g_studentno']."', ".$value['g_prelim'].", ".$value['g_midterm'].", ".$value['g_finals'].", ".$value['g_average'].", '".$value['g_remarks']."')");
    }
    
    $JSON_received = $_POST["prof_data"];
    $obj = json_decode($JSON_received, true);
    foreach ($obj as $key => $value) 
    {
        mysqli_query($conn, "INSERT INTO teacher_submit_grade (sem, ay, profid, date, name, subject) VALUES ('$sem', '$ay', $profid, '$date', '".$value['prof_name']."', '$subject')");
    }
    
    mysqli_query($conn, "UPDATE subject set stat = 1 WHERE ProfID = $id AND sem ='$sem' AND ay = '$ay' AND Subject_Code = '$subject'");
    mysqli_query($conn, "UPDATE student_information set stat = 1 WHERE Prof_ID = $id AND Class_Code = '$subject'");
}
?>