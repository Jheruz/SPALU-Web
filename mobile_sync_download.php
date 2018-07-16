<?php
if(isset($_GET['prof_id'])){
	include('config.php');
    $profid = $_GET['prof_id'];
	$deviceSyncDate = $_GET['sync_date'];
	$querySyncDate = mysqli_query($conn, "SELECT * FROM backup_syncdate WHERE profid = $profid");
	$result["date"] = "";
	while($row = mysqli_fetch_array($querySyncDate)){
		$result["date"] = $row['date'];
	}
	if($result["date"] != "" && $result['date'] != $deviceSyncDate){
	    $queryPassingGrade = mysqli_query($conn, "SELECT * FROM backup_passing_grade WHERE profid = $profid");
	    $result["passingGrade"] = 0;
    	while($row = mysqli_fetch_array($queryPassingGrade)){
    		$result["passingGrade"] = $row['grade'];
    	}
    	
    	$queryTerm = mysqli_query($conn, "SELECT * FROM backup_term WHERE profid = $profid");
	    $term = 0;
    	while($row = mysqli_fetch_array($queryTerm)){
    		$result["qTerm_sc"][$term] = $row['subjectcode'];
    		$result["qTerm_ct"][$term] = $row['currentterm'];
    		$term++;
    	}
    	
    	$queryCategory = mysqli_query($conn, "SELECT * FROM backup_grade_category WHERE profid = $profid");
	    $cat = 0;
    	while($row = mysqli_fetch_array($queryCategory)){
    		$result["qCat_id"][$cat] = $row['id'];
    		$result["qCat_sc"][$cat] = $row['subjectcode'];
    		$result["qCat_name"][$cat] = $row['name'];
    		$cat++;
    	}
    	
    	$queryRaw = mysqli_query($conn, "SELECT * FROM backup_raw_score WHERE profid = $profid");
	    $raw = 0;
    	while($row = mysqli_fetch_array($queryRaw)){
    		$result["qRaw_gradeid"][$raw] = $row['gradeid'];
    		$result["qRaw_rs"][$raw] = $row['rawscore'];
    		$raw++;
    	}
    	
    	$queryPercent = mysqli_query($conn, "SELECT * FROM backup_grade_percentage WHERE profid = $profid");
	    $gp = 0;
    	while($row = mysqli_fetch_array($queryPercent)){
    		$result["qGp_catid"][$gp] = $row['categoryid'];
    		$result["qGp_percent"][$gp] = $row['percent'];
    		$gp++;
    	}
    	
    	$queryPrelim = mysqli_query($conn, "SELECT * FROM backup_prelim_grade WHERE profid = $profid");
	    $pg = 0;
    	while($row = mysqli_fetch_array($queryPrelim)){
    		$result["qp_studentno"][$pg] = $row['studentno'];
    		$result["qp_sc"][$pg] = $row['subjectcode'];
    		$result["qp_catid"][$pg] = $row['categoryid'];
    		$result["qp_caption"][$pg] = $row['caption'];
    		$result["qp_date"][$pg] = $row['date'];
    		$result["qp_grade"][$pg] = $row['grade'];
    		$pg++;
    	}
    	
    	$queryMidterm = mysqli_query($conn, "SELECT * FROM backup_midterm_grade WHERE profid = $profid");
	    $mg = 0;
    	while($row = mysqli_fetch_array($queryMidterm)){
    		$result["qm_studentno"][$mg] = $row['studentno'];
    		$result["qm_sc"][$mg] = $row['subjectcode'];
    		$result["qm_catid"][$mg] = $row['categoryid'];
    		$result["qm_caption"][$mg] = $row['caption'];
    		$result["qm_date"][$mg] = $row['date'];
    		$result["qm_grade"][$mg] = $row['grade'];
    		$mg++;
    	}
    	
    	$queryFinals = mysqli_query($conn, "SELECT * FROM backup_finals_grade WHERE profid = $profid");
	    $fg = 0;
    	while($row = mysqli_fetch_array($queryFinals)){
    		$result["qf_studentno"][$fg] = $row['studentno'];
    		$result["qf_sc"][$fg] = $row['subjectcode'];
    		$result["qf_catid"][$fg] = $row['categoryid'];
    		$result["qf_caption"][$fg] = $row['caption'];
    		$result["qf_date"][$fg] = $row['date'];
    		$result["qf_grade"][$fg] = $row['grade'];
    		$fg++;
    	}
    	
    	$queryNotif = mysqli_query($conn, "SELECT * FROM backup_notification WHERE profid = $profid");
	    $notif = 0;
    	while($row = mysqli_fetch_array($queryNotif)){
    		$result["notif_studentno"][$notif] = $row['studentno'];
    		$result["notif_name"][$notif] = $row['name'];
    		$result["notif_sc"][$notif] = $row['subjectcode'];
    		$result["notif_description"][$notif] = $row['description'];
    		$result["notif_type"][$notif] = $row['type'];
    		$result["notif_status"][$notif] = $row['status'];
    		$result["notif_tag"][$notif] = $row['tag'];
    		$notif++;
    	}
    	
    	$queryLastUpdate = mysqli_query($conn, "SELECT * FROM backup_last_update WHERE profid = $profid");
    	while($row = mysqli_fetch_array($queryLastUpdate)){
    		$result["lu_date"] = $row['date'];
    	}
    	
    	$queryGSubmit = mysqli_query($conn, "SELECT * FROM backup_gradetosubmit WHERE profid = $profid");
	    $submit = 0;
    	while($row = mysqli_fetch_array($queryGSubmit)){
    		$result["gts_studentno"][$submit] = $row['studentno'];
    		$result["gts_sc"][$submit] = $row['subjectcode'];
    		$result["gts_prelim"][$submit] = $row['prelim'];
    		$result["gts_midterm"][$submit] = $row['midterm'];
    		$result["gts_finals"][$submit] = $row['finals'];
    		$result["gts_average"][$submit] = $row['average'];
    		$result["gts_remarks"][$submit] = $row['remarks'];
    		$submit++;
    	}
    	
    	$queryArchive = mysqli_query($conn, "SELECT * FROM backup_archive WHERE profid = $profid");
	    $archive = 0;
    	while($row = mysqli_fetch_array($queryArchive)){
    		$result["archive_studentno"][$archive] = $row['studentno'];
    		$result["archive_name"][$archive] = $row['name'];
    		$result["archive_year"][$archive] = $row['year'];
    		$result["archive_sc"][$archive] = $row['subjectcode'];
    		$result["archive_sd"][$archive] = $row['subjectdescription'];
    		$result["archive_ay"][$archive] = $row['ay'];
    		$result["archive_sem"][$archive] = $row['sem'];
    		$result["archive_prelim"][$archive] = $row['prelim'];
    		$result["archive_midterm"][$archive] = $row['midterm'];
    		$result["archive_finals"][$archive] = $row['finals'];
    		$result["archive_average"][$archive] = $row['average'];
    		$result["archive_equivalent"][$archive] = $row['equivalent'];
    		$archive++;
    	}
    	
    	$queryProfile = mysqli_query($conn, "SELECT * FROM teacher_information WHERE id = $profid");
    	while($row = mysqli_fetch_array($queryProfile)){
    		$result["info_username"] = $row['Username'];
    		$result["info_password"] = $row['Password'];
    	}
    	
    	$querySyncDate = mysqli_query($conn, "SELECT * FROM backup_syncdate WHERE profid = $profid");
    	while($row = mysqli_fetch_array($querySyncDate)){
    		$result["sync_date"] = $row['date'];
    	}
		echo json_encode($result);
	}
}
?>