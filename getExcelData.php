<?php
include('PHPExcel-1.8/Classes/PHPExcel.php');
include('PHPExcel-1.8/Classes/PHPExcel/Writer/Excel2007.php');
include('config.php');
$id = $_GET['id'];
$sem = $_GET['sem'];
$ay = $_GET['ay'];
$subject = $_GET['subject'];
if(isset($id) && isset($sem) && isset($ay) && isset($subject)){
  $queryProf = mysqli_query($conn, "SELECT * FROM teacher_information WHERE id = $id");
  $queryProf = mysqli_fetch_object($queryProf);
  $queryProfSubject = mysqli_query($conn, "SELECT * FROM subject WHERE ProfID = $id AND Subject_Code = '$subject'");
  $queryProfSubject = mysqli_fetch_object($queryProfSubject);
  $profName = $queryProf->Last_Name;
  $subjectNo = $queryProfSubject->No;
  $sub = mysqli_query($conn, "SELECT * FROM subject WHERE Subject_Code = '$subject'");
  $sub = mysqli_fetch_object($sub);
  $ayQuery = mysqli_query($conn, "SELECT * FROM records WHERE No = $subjectNo");
  $ayQuery = mysqli_fetch_object($ayQuery);

  $borderAll = array(
            'borders' => array(
                'outline' => array(
                  'style' => PHPExcel_Style_Border::BORDER_THIN,
                )
            )
        );
  $borderData = array(
            'borders' => array(
                'allborders' => array(
                  'style' => PHPExcel_Style_Border::BORDER_THIN,
                )
            )
        );
  $schoolName = array(
  		'font'  => array(
  			'bold' => true,
  			'size' => 22,
  			'name' => 'Times New Roman'),
          'alignment' => array(
              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
          )
      );
  $address = array(
  		'font'  => array(
  			'size' => 11,
  			'name' => 'Calibri'),
          'alignment' => array(
              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
          )
      );
  $excelType = array(
  		'font'  => array(
  			'bold' => true,
  			'size' => 18,
  			'name' => 'Calibri'),
          'alignment' => array(
              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
          )
      );
  $body = array(
      'font'  => array(
        'bold' => true,
        'size' => 11,
        'name' => 'Calibri'),
  );
  $bodyValue = array(
      'font'  => array(
        'bold' => true,
        'size' => 11,
        'name' => 'Arial'),
          'alignment' => array(
              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
  );
  $forDescription = array(
      'font'  => array(
        'bold' => true,
        'size' => 11,
        'name' => 'Arial'),
  );
  $bodyRightAlign = array(
  		'font'  => array(
  			'bold' => true,
  			'size' => 11,
  			'name' => 'Calibri'),
          'alignment' => array(
              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT),
  );
  $columnLabelData  = array(
  		'font'  => array(
  			'bold' => true,
  			'size' => 11,
  			'name' => 'Calibri'),
          'alignment' => array(
              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
  );
  $bottomBorder  = array(
  		'borders' => array(
            'bottom' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
            )
        )
  );
  $data = array(
  		'font'  => array(
  			'size' => 11,
  			'name' => 'Calibri'),
          'alignment' => array(
              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
  );
  $dataBorder  = array(
  		'borders' => array(
            'bottom' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
            ),
  		  'top' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
            ),
  		  'left' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
            ),
  		  'right' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
            )
        )
  );

  $objPHPExcel = new PHPExcel();
  $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(4.14);
  $objPHPExcel->getActiveSheet()->getRowDimension('11')->setRowHeight(30.75);
  $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(8.43);
  $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25.57);
  $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(8.43);
  $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(7.00);
  $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(12.00);
  $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(12.00);
  $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(12.00);
  $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(8.43);
  $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(8.43);
  $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(8.43);
  $objPHPExcel->getActiveSheet()->setShowGridlines(false);

  $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'LAGUNA UNIVERSITY')->mergeCells('A1:K1')->getStyle('A1:K1')->applyFromArray($schoolName);
  $objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Laguna Sports Complex, Bubukal, Santa Cruz, Laguna')->mergeCells('A2:K2')->getStyle('A2:F3')->applyFromArray($address);
  $objPHPExcel->getActiveSheet()->SetCellValue('A3', 'FINAL RATING SHEET')->mergeCells('A3:K3')->getStyle('A3:K3')->applyFromArray($excelType);
  $objPHPExcel->getActiveSheet()->getStyle('D4')->applyFromArray($bottomBorder);
  $objPHPExcel->getActiveSheet()->SetCellValue('D4', $sem)->getStyle('D4')->applyFromArray($bodyValue);
  $objPHPExcel->getActiveSheet()->SetCellValue('C4', 'Semester:')->getStyle('C4')->applyFromArray($columnLabelData);
  $objPHPExcel->getActiveSheet()->mergeCells('H4:I4')->getStyle('H4:I4')->applyFromArray($bottomBorder);
  $objPHPExcel->getActiveSheet()->SetCellValue('H4', $ay)->getStyle('H4')->applyFromArray($bodyValue);
  $objPHPExcel->getActiveSheet()->SetCellValue('F4', 'Academic Year:')->getStyle('F4')->applyFromArray($body);
  $objPHPExcel->getActiveSheet()->getStyle('C6')->applyFromArray($bottomBorder);
  $objPHPExcel->getActiveSheet()->SetCellValue('C6', $subjectNo)->getStyle('C6')->applyFromArray($bodyValue);
  $objPHPExcel->getActiveSheet()->SetCellValue('A6', 'No:')->getStyle('A6')->applyFromArray($body);
  $objPHPExcel->getActiveSheet()->getStyle('C7')->applyFromArray($bottomBorder);
  $objPHPExcel->getActiveSheet()->SetCellValue('C7', $subject)->getStyle('C7')->applyFromArray($bodyValue);
  $objPHPExcel->getActiveSheet()->SetCellValue('A7', 'Code:')->getStyle('A7')->applyFromArray($body);
  $objPHPExcel->getActiveSheet()->getStyle('C8:G8')->applyFromArray($bottomBorder);
  $objPHPExcel->getActiveSheet()->SetCellValue('C8', $sub->Subject_Description)->getStyle('C8')->applyFromArray($forDescription);
  $objPHPExcel->getActiveSheet()->SetCellValue('A8', 'Description:')->getStyle('A8')->applyFromArray($body);
  $objPHPExcel->getActiveSheet()->getStyle('F6:G6')->applyFromArray($bottomBorder);
  $objPHPExcel->getActiveSheet()->SetCellValue('F6', $ayQuery->units)->getStyle('F6')->applyFromArray($bodyValue);
  $objPHPExcel->getActiveSheet()->SetCellValue('E6', 'Units:')->getStyle('E6')->applyFromArray($body);
  $objPHPExcel->getActiveSheet()->getStyle('F7:G7')->applyFromArray($bottomBorder);
  $objPHPExcel->getActiveSheet()->SetCellValue('F7', $ayQuery->day)->getStyle('F7')->applyFromArray($bodyValue);
  $objPHPExcel->getActiveSheet()->SetCellValue('E7', 'Day:')->getStyle('E7')->applyFromArray($body);
  $objPHPExcel->getActiveSheet()->getStyle('I6:K6')->applyFromArray($bottomBorder);
  $objPHPExcel->getActiveSheet()->SetCellValue('J6', $ayQuery->time)->getStyle('J6')->applyFromArray($bodyValue);
  $objPHPExcel->getActiveSheet()->SetCellValue('H6', 'Time:')->getStyle('H6')->applyFromArray($body);
  $objPHPExcel->getActiveSheet()->getStyle('I7:K7')->applyFromArray($bottomBorder);
  $objPHPExcel->getActiveSheet()->SetCellValue('J7', $ayQuery->room)->getStyle('J7')->applyFromArray($bodyValue);
  $objPHPExcel->getActiveSheet()->SetCellValue('H7', 'Room:')->getStyle('H7')->applyFromArray($body);
  $objPHPExcel->getActiveSheet()->getStyle('I8:K8')->applyFromArray($bottomBorder);
  $objPHPExcel->getActiveSheet()->SetCellValue('J8', "Prof. ".$profName)->getStyle('J8')->applyFromArray($bodyValue);
  $objPHPExcel->getActiveSheet()->SetCellValue('H8', 'Professor:')->getStyle('H8')->applyFromArray($body);
  $highestRow = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
  $objPHPExcel->getActiveSheet()->SetCellValue('A11', 'No.')->getStyle('A11')->applyFromArray($columnLabelData)
  ->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
  $objPHPExcel->getActiveSheet()->SetCellValue('B11', 'Student No.')->getStyle('B11')->applyFromArray($columnLabelData)
  ->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
  $objPHPExcel->getActiveSheet()->SetCellValue('C11', 'Name')->getStyle('C11')->applyFromArray($columnLabelData)
  ->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
  $objPHPExcel->getActiveSheet()->SetCellValue('D11', 'Course')->getStyle('D11')->applyFromArray($columnLabelData)
  ->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
  $objPHPExcel->getActiveSheet()->SetCellValue('E11', 'Gender')->getStyle('E11')->applyFromArray($columnLabelData)
  ->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
  $objPHPExcel->getActiveSheet()->SetCellValue('F11', 'Prelim')->getStyle('F11')->applyFromArray($columnLabelData)
  ->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
  $objPHPExcel->getActiveSheet()->SetCellValue('G11', 'Midterm')->getStyle('G11')->applyFromArray($columnLabelData)
  ->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
  $objPHPExcel->getActiveSheet()->SetCellValue('H11', 'Finals')->getStyle('H11')->applyFromArray($columnLabelData)
  ->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
  $objPHPExcel->getActiveSheet()->SetCellValue('I11', 'Average')->getStyle('I11')->applyFromArray($columnLabelData)
  ->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
  $objPHPExcel->getActiveSheet()->SetCellValue('J11', 'Equiv.')->getStyle('J11')->applyFromArray($columnLabelData)
  ->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
  $objPHPExcel->getActiveSheet()->SetCellValue('K11', 'Remarks')->getStyle('K11')->applyFromArray($columnLabelData)
  ->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

  $query = mysqli_query($conn, "SELECT * FROM student_grade WHERE Prof_ID = $id AND Subject_Code = '$subject'  AND Sem = '$sem' AND AY = '$ay'");
  $i = 12;
  $count = 1;
  while($row = mysqli_fetch_array($query)){
    $stundent_no = $row['Student_No'];
    $grade = $row['Average'];
    $queryStudent = mysqli_query($conn, "SELECT * FROM student_information WHERE Student_No = '$stundent_no'");
    while($res = mysqli_fetch_array($queryStudent)){
      $name = $res['Name'];
      $course = $res['Course'];
      $gender = $res['Gender'];
    }
    if(round($grade) >= 98 && round($grade) <= 100){
      $equivalent = 1.0;
    } else if(round($grade) >= 94 && round($grade) <= 97){
      $equivalent = 1.25;
    } else if(round($grade) >= 90 && round($grade) <= 93){
      $equivalent = 1.5;
    } else if(round($grade) >= 86 && round($grade) <= 89){
      $equivalent = 1.75;
    } else if(round($grade) == 85){
      $equivalent = 2.0;
    } else if(round($grade) >= 82 && round($grade) <= 84){
      $equivalent = 2.25;
    } else if(round($grade) >= 80 && round($grade) <= 81){
      $equivalent = 2.5;
    } else if(round($grade) >= 76 && round($grade) <= 79){
      $equivalent = 2.75;
    } else if(round($grade) == 75){
      $equivalent = 3.0;
    } else if(round($grade) <= 74){
      $equivalent = 5.0;
    }
  	$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, $count)->getStyle('A'.$i)->applyFromArray($data);
  	$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $stundent_no)->getStyle('B'.$i)->applyFromArray($data);
  	$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, $name)->getStyle('C'.$i)->applyFromArray($data);
    $objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, $course)->getStyle('D'.$i)->applyFromArray($data);
    $objPHPExcel->getActiveSheet()->SetCellValue('E'.$i, $gender)->getStyle('E'.$i)->applyFromArray($data);
    $objPHPExcel->getActiveSheet()->SetCellValue('F'.$i, $row['Prelim'])->getStyle('F'.$i)->applyFromArray($data);
    $objPHPExcel->getActiveSheet()->SetCellValue('G'.$i, $row['Midterm'])->getStyle('G'.$i)->applyFromArray($data);
    $objPHPExcel->getActiveSheet()->SetCellValue('H'.$i, $row['Finals'])->getStyle('H'.$i)->applyFromArray($data);
    $objPHPExcel->getActiveSheet()->SetCellValue('I'.$i, $grade)->getStyle('I'.$i)->applyFromArray($data);
    $objPHPExcel->getActiveSheet()->SetCellValue('J'.$i, $equivalent)->getStyle('J'.$i)->applyFromArray($data);
    $objPHPExcel->getActiveSheet()->SetCellValue('K'.$i, $row['Remarks'])->getStyle('K'.$i)->applyFromArray($data);
  	$i++;
    $count++;
  }
  $overAll = mysqli_num_rows($query) + 2;
  $objPHPExcel->getActiveSheet()->getStyle('A1:K1'. $overAll)->applyFromArray($borderAll);
  //echo $highestRow;
  $objPHPExcel->getActiveSheet()->getStyle('A11:K11'. $highestRow)->applyFromArray($borderData);
  $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
  //changing name of file
  $tempLname = "";
  for($i=0;$i<strlen($profName);$i++){
    if($profName{$i} == ' '){
      $tempLname .= '-';
    } else {
      $tempLname .= $profName{$i};
    }
  }
  $tempSubject = "";
  for($i=0;$i<strlen($subject);$i++){
    if($subject{$i} == ' '){
      $tempSubject .= '-';
    } else {
      $tempSubject .= $subject{$i};
    }
  }
  $filename = $tempLname."-".$subjectNo."-".$tempSubject."-".$sem."Sem-AY".$ay.".xlsx";
  $objWriter->save(str_replace(__FILE__,'uploads/'.$filename,__FILE__));
  $objPHPExcel->disconnectWorksheets();
  unset($objWriter, $objPHPExcel);
  header('location:uploads/'.$filename);
} else {
  header('location:index.php');
}
?>