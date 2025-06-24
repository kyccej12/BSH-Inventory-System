<?php
	session_start();
	require_once '../lib/PHPExcel/PHPExcel.php';
	include("../includes/dbUSE.php");
	ini_set("max_execution_time",-1);
	

	date_default_timezone_set('Asia/Manila');
	set_time_limit(0);

	/* MYSQL QUERIES SECTION */
		$now = date("m/d/Y h:i a");
		$co = getArray("select * from companies where company_id = '1';");
		
		if($_GET['group'] != "") { $fs1 = " and b.category = '$_GET[group]' "; }
		$query = dbquery("SELECT a.item_code, b.description, c.description AS unit FROM ibook a LEFT JOIN products_master b ON a.item_code = b.item_code left join options_units c on a.uom = c.unit WHERE 1=1 and b.file_status != 'DELETED' $fs1 GROUP BY b.item_code ORDER BY b.description");
				

	$headerStyle = array(
		'font' => array('bold' => true),
		'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
		'borders' => array('outline' => array('style' =>PHPExcel_Style_Border::BORDER_THIN)),
	);
	
	$contentStyle = array(
		'borders' => array('outline' => array('style' => PHPExcel_Style_Border::BORDER_THIN))
	);
	
	$totalStyle = array(
		'font' => array('bold' => true),
		'borders' => array('outline' => array('style' => PHPExcel_Style_Border::BORDER_THIN))
	);
	
	
	$objPHPExcel = new PHPExcel();
	$objPHPExcel->getDefaultStyle()->getFont()->setSize(7);
	$objPHPExcel->getProperties()->setCreator("Rolan Paderanga")
								 ->setLastModifiedBy("Rolan Paderanga")
								 ->setTitle("Bata Esensyal - INVENTORY BOOK")
								 ->setSubject("Bata Esensyal - INVENTORY BOOK")
								 ->setDescription("Bata Esensyal - INVENTORY BOOK")
								 ->setKeywords("office 2007 openxml php")
								 ->setCategory("Test result file");
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue("A1",$co['company_name']);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue("A2",$co['company_address']);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue("A3",$co['tel_no']);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue("A4",$co['email']);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue("A4","Inventory Report Covering the Period $_GET[dtf] to $_GET[dt2]");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue("A5","");
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue("A7","ITEM CODE");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue("B7","DESCRIPTION");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue("C7","UNIT");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue("D7","BEG.");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue("E7","PURCHASES");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue("F7","STOCK-IN/RETURNS");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue("G7","WITHDRAWALS");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue("H7","SOLD");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue("I7","INVENTORY END");
	
	$objPHPExcel->getActiveSheet()->getColumnDimension("A")->setWidth(16);
	$objPHPExcel->getActiveSheet()->getColumnDimension("B")->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension("C")->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension("D")->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension("E")->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension("F")->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension("G")->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension("H")->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension("I")->setAutoSize(true);
	
	$objPHPExcel->getActiveSheet()->getStyle('A7')->applyFromArray($headerStyle);
	$objPHPExcel->getActiveSheet()->getStyle('B7')->applyFromArray($headerStyle);
	$objPHPExcel->getActiveSheet()->getStyle('C7')->applyFromArray($headerStyle);
	$objPHPExcel->getActiveSheet()->getStyle('D7')->applyFromArray($headerStyle);
	$objPHPExcel->getActiveSheet()->getStyle('E7')->applyFromArray($headerStyle);
	$objPHPExcel->getActiveSheet()->getStyle('F7')->applyFromArray($headerStyle);
	$objPHPExcel->getActiveSheet()->getStyle('G7')->applyFromArray($headerStyle);
	$objPHPExcel->getActiveSheet()->getStyle('H7')->applyFromArray($headerStyle);
	$objPHPExcel->getActiveSheet()->getStyle('I7')->applyFromArray($headerStyle);

	$row = 8;
	

				
	while($data = mysql_fetch_array($query)) {

	
		/* Running Inventory Before Period */ 
		$run = getArray("SELECT SUM(purchases+inbound-pullouts-outbound-sold) FROM ibook WHERE item_code = '$data[item_code]' and doc_date < '".formatDate($_GET['dtf'])."';");
		
		/* Current Inventory */
		$cur = getArray("SELECT ifnull(sum(purchases),0) as purchases, ifnull(sum(outbound),0) as withdrawals, ifnull(sum(inbound),0) as returns, ifnull(sum(sold),0) as sold, IFNULL(SUM(purchases+inbound-pullouts-sold),0) AS currentbalance FROM ibook where doc_date between '".formatDate($_GET['dtf'])."' and '".formatDate($_GET['dt2'])."' and item_code = '$data[item_code]';");
		
		/* Balance End */
		$end = ROUND($run[0] + $cur['currentbalance'],2);
					
					
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0,$row,$data['item_code']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1,$row,$data['description']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(2,$row,$data['unit']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(3,$row,$run[0]);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(4,$row,$cur['purchases']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(5,$row,$cur['returns']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(6,$row,$cur['withdrawals']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(7,$row,$cur['sold']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(8,$row,$end);
		
		$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0,$row)->applyFromArray($contentStyle);
		$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(1,$row)->applyFromArray($contentStyle);
		$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(2,$row)->applyFromArray($contentStyle);
		$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(3,$row)->applyFromArray($contentStyle);
		$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(4,$row)->applyFromArray($contentStyle);
		$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(5,$row)->applyFromArray($contentStyle);
		$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(6,$row)->applyFromArray($contentStyle);
		$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(7,$row)->applyFromArray($contentStyle);
		$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(8,$row)->applyFromArray($contentStyle);

		$row++;
	}
	
	// Rename worksheet
	$objPHPExcel->getActiveSheet()->setTitle("INVENTORY REPORT");
	
	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);
			
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="inventoryreport.xlsx"');
	header('Cache-Control: max-age=0');
	
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save('php://output');
	exit;
?>
