<?php
if(isset($_POST['prof_id'])){
    include('config.php');
    $id = $_POST['prof_id'];
    
    //prelim
    if(isset($_POST['prelim'])){
        mysqli_query($conn, "DELETE FROM backup_prelim_grade WHERE profid = $id");
        $JSON_received = $_POST["prelim"];
        $obj = json_decode($JSON_received, true);
        foreach ($obj as $key => $value) 
        {
            mysqli_query($conn, "INSERT INTO backup_prelim_grade (profid, studentno, subjectcode, categoryid, caption, date, grade) VALUES ($id,'".$value['p_studentno']."','".$value['p_subjectcode']."', ".$value['p_categoryid'].", '".$value['p_caption']."', '".$value['p_date']."', ".$value['p_grade'].")");
        }
    }
    
    //midterm
    if(isset($_POST['midterm'])){
        mysqli_query($conn, "DELETE FROM backup_midterm_grade WHERE profid = $id");
        $JSON_received = $_POST["midterm"];
        $obj = json_decode($JSON_received, true);
        foreach ($obj as $key => $value) 
        {
            mysqli_query($conn, "INSERT INTO backup_midterm_grade (profid, studentno, subjectcode, categoryid, caption, date, grade) VALUES ($id,'".$value['m_studentno']."','".$value['m_subjectcode']."', ".$value['m_categoryid'].", '".$value['m_caption']."', '".$value['m_date']."', ".$value['m_grade'].")");
        }
    }
    
    //finals
    if(isset($_POST['finals'])){
        mysqli_query($conn, "DELETE FROM backup_finals_grade WHERE profid = $id");
        $JSON_received = $_POST["finals"];
        $obj = json_decode($JSON_received, true);
        foreach ($obj as $key => $value) 
        {
            mysqli_query($conn, "INSERT INTO backup_finals_grade (profid, studentno, subjectcode, categoryid, caption, date, grade) VALUES ($id,'".$value['f_studentno']."','".$value['f_subjectcode']."', ".$value['f_categoryid'].", '".$value['f_caption']."', '".$value['f_date']."', ".$value['f_grade'].")");
        }
    }
    
    //passing grade
    if(isset($_POST['passing'])){
        mysqli_query($conn, "DELETE FROM backup_passing_grade WHERE profid = $id");
        $JSON_received = $_POST["passing"];
        $obj = json_decode($JSON_received, true);
        foreach ($obj as $key => $value) 
        {
            mysqli_query($conn, "INSERT INTO backup_passing_grade (profid, grade) VALUES ($id, ".$value['passingGrade'].")");
        }
    }
    
    //raw grade
    if(isset($_POST['raw_score'])){
        mysqli_query($conn, "DELETE FROM backup_raw_score WHERE profid = $id");
        $JSON_received = $_POST["raw_score"];
        $obj = json_decode($JSON_received, true);
        foreach ($obj as $key => $value) 
        {
            mysqli_query($conn, "INSERT INTO backup_raw_score (profid, gradeid, rawscore) VALUES ($id, ".$value['raw_gradeid'].", '".$value['raw_rawscore']."')");
        }
    }
    
    //percentage
    if(isset($_POST['percentage'])){
        mysqli_query($conn, "DELETE FROM backup_grade_percentage WHERE profid = $id");
        $JSON_received = $_POST["percentage"];
        $obj = json_decode($JSON_received, true);
        foreach ($obj as $key => $value) 
        {
            mysqli_query($conn, "INSERT INTO backup_grade_percentage (profid, categoryid, percent) VALUES ($id, ".$value['percent_categoryid'].", ".$value['percent_percent'].")");
        }
    }
    
    //notification
    if(isset($_POST['notification'])){
        mysqli_query($conn, "DELETE FROM backup_notification WHERE profid = $id");
        $JSON_received = $_POST["notification"];
        $obj = json_decode($JSON_received, true);
        foreach ($obj as $key => $value) 
        {
            mysqli_query($conn, "INSERT INTO backup_notification (profid, studentno, name, subjectcode, description, type, status, tag) VALUES ($id, '".$value['notif_studentno']."', '".$value['notif_name']."', '".$value['notif_subjectcode']."', '".$value['notif_description']."','".$value['notif_type']."', '".$value['notif_status']."', '".$value['notif_tag']."')");
        }
    }
    
    //term
    if(isset($_POST['term'])){
        mysqli_query($conn, "DELETE FROM backup_term WHERE profid = $id");
        $JSON_received = $_POST["term"];
        $obj = json_decode($JSON_received, true);
        foreach ($obj as $key => $value) 
        {
            mysqli_query($conn, "INSERT INTO backup_term (profid, subjectcode, currentterm) VALUES ($id, '".$value['term_subjectcode']."', ".$value['term_currentterm'].")");
        }
    }
    
    //grade to submit
    if(isset($_POST['gts'])){
        mysqli_query($conn, "DELETE FROM backup_gradetosubmit WHERE profid = $id");
        $JSON_received = $_POST["gts"];
        $obj = json_decode($JSON_received, true);
        foreach ($obj as $key => $value) 
        {
            mysqli_query($conn, "INSERT INTO backup_gradetosubmit (profid, subjectcode, studentno, prelim, midterm, finals, average, remarks) VALUES ($id, '".$value['gts_subjectcode']."', '".$value['gts_studentno']."', ".$value['gts_prelim'].", ".$value['gts_midterm'].", ".$value['gts_finals'].", ".$value['gts_average'].", '".$value['gts_remarks']."')");
        }
    }
    
    //category
    if(isset($_POST['category'])){
        mysqli_query($conn, "DELETE FROM backup_grade_category WHERE profid = $id");
        $JSON_received = $_POST["category"];
        $obj = json_decode($JSON_received, true);
        foreach ($obj as $key => $value) 
        {
            mysqli_query($conn, "INSERT INTO backup_grade_category (id, profid, subjectcode, name) VALUES (".$value['cat_id'].", $id, '".$value['cat_subjectcode']."', '".$value['cat_name']."')");
        }
    }
    
    //last update
    if(isset($_POST['lu'])){
        mysqli_query($conn, "DELETE FROM backup_last_update WHERE profid = $id");
        $JSON_received = $_POST["lu"];
        $obj = json_decode($JSON_received, true);
        foreach ($obj as $key => $value) 
        {
            mysqli_query($conn, "INSERT INTO backup_last_update (profid, date) VALUES ($id, '".$value['lu_date']."')");
        }
    }
    
    //archive
    if(isset($_POST['archive'])){
        mysqli_query($conn, "DELETE FROM backup_archive WHERE profid = $id");
        $JSON_received = $_POST["archive"];
        $obj = json_decode($JSON_received, true);
        foreach ($obj as $key => $value) 
        {
            mysqli_query($conn, "INSERT INTO backup_archive (studentno, name, year, profid, subjectcode, subjectdescription, ay, sem, prelim, midterm, finals, average, equivalent) VALUES ('".$value['arc_studentno']."', '".$value['arc_name']."', '".$value['arc_year']."',$id, '".$value['arc_subjectcode']."', '".$value['arc_subjectdescription']."', '".$value['arc_ay']."', '".$value['arc_sem']."', ".$value['arc_prelim'].", ".$value['arc_midterm'].", ".$value['arc_finals'].", ".$value['arc_average'].", ".$value['arc_equivalent'].")");
        }
    }
    
    //user account
    if(isset($_POST['user_account'])){
        $JSON_received = $_POST["user_account"];
        $obj = json_decode($JSON_received, true);
        foreach ($obj as $key => $value) 
        {
            mysqli_query($conn, "UPDATE teacher_information set Username = '".$value['info_username']."', Password = '".$value['info_password']."' WHERE id = $id");
        }
    }
    
    //sync date
    if(isset($_POST['sync'])){
        mysqli_query($conn, "DELETE FROM backup_syncdate WHERE profid = $id");
        $JSON_received = $_POST["sync"];
        $obj = json_decode($JSON_received, true);
        foreach ($obj as $key => $value) 
        {
            mysqli_query($conn, "INSERT INTO backup_syncdate (profid, date) VALUES ($id, '".$value['sync_date']."')");
        }
    }
}
?>