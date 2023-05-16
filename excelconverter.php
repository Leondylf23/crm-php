<?php

// Include PHPExcel library
// require_once '../../php/PHPExcel/Classes/PHPExcel.php';

// // Create new PHPExcel object
// $objPHPExcel = new PHPExcel();

// // Set active sheet
// $objPHPExcel->setActiveSheetIndex(0);

// // Add data to cells
// $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Name');
// $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Age');
// $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Email');

// // Loop through data table and add to cells
// $row = 2;
// foreach ($data as $item) {
//     $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $item['name']);
//     $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $item['age']);
//     $objPHPExcel->getActiveSheet()->setCellValue('C'.$row, $item['email']);
//     $row++;
// }

// // Set headers for Excel file
// header('Content-Type: application/vnd.ms-excel');
// header('Content-Disposition: attachment;filename="data.xlsx"');
// header('Cache-Control: max-age=0');

// // Write Excel file to output
// $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
// $objWriter->save('php://output');




?>