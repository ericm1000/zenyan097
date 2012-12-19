<?php

/** Error reporting */
error_reporting(E_ALL);

/** PHPExcel */
require_once '../Classes/PHPExcel.php';

/** PHPExcel_IOFactory */
require_once '../Classes/PHPExcel/IOFactory.php';

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set properties
$objPHPExcel->getProperties()->setCreator("ericm")
							 ->setLastModifiedBy("ericm")
							 ->setTitle("Office 2007 XLSX Whassup")
							 ->setSubject("Office 2007 XLSX Whassup Subject")
							 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Test result file");


// Add some data
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Hello out there')
            ->setCellValue('A2', 'cruel world!')
            ->setCellValue('B1', 'Goodbye')
            ->setCellValue('B2', 'For Now!');

// Miscellaneous glyphs, UTF-8
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A4', '3')
            ->setCellValue('A5', '=sum(A4*A4)');

// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle('Whatever');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="erictest2.xls"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output'); 
//$objWriter->save('c://www//webroot//excel'); 
exit;
