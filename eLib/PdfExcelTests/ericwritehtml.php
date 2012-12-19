<?php
//Toycode to create an excel spreadbased upon hardcoded vals

/** Error reporting */
error_reporting(E_ALL);

/** PHPExcel */
//require_once '../Classes/PHPExcel.php';

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

echo date('H:i:s') . " Set orientation to landscape\n";
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

$path = "c:\\www\\webroot\\dataminer\\output\\ericwritexls.htm";
//$path .= __FILE__ ;  //the default path and filename which is php script name and same loc

echo date('H:i:s') . " Write to HTML format\n";                                                       
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'HTML');                                  
$objWriter->setSheetIndex(0);                                                                         
//$objWriter->setImagesRoot('http://www.example.com');                                                
$objWriter->save(str_replace('.php', '.htm', $path));                                              
                                                                                                      
// Echo memory peak usage                                                                             
echo date('H:i:s') . " Peak memory usage: " . (memory_get_peak_usage(true) / 1024 / 1024) . " MB\r\n";
                                                                                                      
// Echo done                                                                                          
echo date('H:i:s') . " Done writing files.\r\n";                                                      
