<?php
	include("../handlers/initDB.php");

	$con = new myDB();

	$data = array();
	$datares = $con->dbquery("SELECT record_id, item_code, a.barcode, b.mgroup as category, a.description, c.description as unit, a.unit_cost, a.srp, '' as onhand FROM products_master a left join options_mgroup b on a.category = b.mid left join options_units c on a.unit = c.unit where `active` = 'Y' ORDER BY item_code ASC");
	while($row = $datares->fetch_array()){

	  list($end) = $con->getArray("select sum(purchases+inbound-outbound-pullouts-sold) as currentbalance from ibook where item_code = '$row[item_code]' and doc_date between '2023-05-22' and '".date('Y-m-d')."';");
	  $row['onhand'] = $end;
	  $data[] = array_map('utf8_encode',$row);
	}
	$results = ["sEcho" => 1,"iTotalRecords" => count($data),"iTotalDisplayRecords" => count($data),"aaData" => $data];
	echo json_encode($results);
?>