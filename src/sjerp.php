<?php
	session_start();
	//ini_set("display_errors","On");
	require_once "../handlers/_generics.php";
	
	$con = new _init;
	$date = date('Y-m-d');
	
	switch($_POST['mod']) {
		
		/* USERS DATA */
		case "getUinfo":
			list($uname) = $con->getArray("select fullname from user_info where emp_id = '$_POST[uid]';");
			echo $uname;
		break;
		case "checkUname":
			list($count) = $con->getArray("select count(*) from user_info where username = '$_POST[uname]';"); echo $count;
		break;
		case "checkUnameUID":
			list($count) = $con->getArray("select count(*) from user_info where username = '$_POST[uname]' and emp_id!='$_POST[uid]';"); echo $count;
		break;
		case "addUser":
			$con->dbquery("insert ignore into user_info (username,password,fullname,user_type,r_type,require_change_pass,email) value ('$_POST[uname]',md5('$_POST[pass]'),'".$con->escapeString(htmlentities($_POST['fname']))."','$_POST[utype]','$_POST[rtype]','$_POST[changePass]','$_POST[email]');");
		
		break;
		case "updateUInfo":
			$con->dbquery("update ignore user_info set username = '$_POST[uname]', fullname='".$con->escapeString(htmlentities($_POST['fname']))."', user_type='$_POST[utype]', r_type='$_POST[rtype]', email='$_POST[email]' where emp_id='$_POST[uid]';");
			
		break;
		case "deleteUser":
			$con->dbquery("delete from user_info where emp_id = '$_POST[uid]';");
		break;
		case "checkOldPass":
			list($count) = $con->getArray("select count(*) from user_info where emp_id='$_POST[uid]' and password=md5('$_POST[old_pass]');");	
			if($count>0) { echo "Ok"; } else { echo "noOk"; }
		break;
		case "changePassword":
			$con->dbquery("update ignore user_info set password=md5('$_POST[pass]'), require_change_pass='N' where emp_id='$_POST[uid]';");
		break;
		case "resetPassword":
			$con->dbquery("update ignore user_info set password=md5('123456'), require_change_pass='Y' where emp_id='$_POST[uid]';");
		break;

		/* Products */
		case "getIcode":
			list($code) = $con->getArray("select `code` from options_mgroup where mid = '$_POST[mid]';");
			list($series) = $con->getArray("SELECT LPAD(IFNULL(MAX(series+1),1),3,0) FROM (SELECT TRIM(LEADING '0' FROM(SUBSTRING(`item_code`,3,3))) AS series FROM products_master WHERE category = '$_POST[mid]') a;");	
		
			echo $code.$series;
		break;
		case "checkDupCode":
			if($_POST['rid'] != "") {
				list($isExist) = $con->getArray("select count(*) from products_master where item_code = '$_POST[item_code]' and company = '1' and record_id != '$_POST[rid]';");
			} else {
				list($isExist) = $con->getArray("select count(*) from products_master where item_code = '$_POST[item_code]' and company = '1';");
			}
			
			if($isExist == 0) { echo "NODUPLICATE"; }
		break;
		case "savePInfo":
			if(!$_POST['status']) { $stat = "Y"; } else { $stat = $_POST['status']; }
			if(isset($_POST['rid']) && $_POST['rid'] != "") {
				$con->dbquery("update ignore products_master set barcode = '$_POST[item_barcode]', category = '$_POST[item_category]', subgroup='$_POST[item_sgroup]', item_code='".$con->escapeString($_POST['item_code'])."', brand = '".strtoupper($_POST['item_brand'])."', description='".$con->escapeString(htmlentities($_POST['item_description']))."',full_description='".$con->escapeString(htmlentities($_POST['item_fdescription']))."',beg_qty='".$con->formatDigit($_POST['item_beginning'])."',minimum_level='".$con->formatDigit($_POST['item_mininv'])."',reorder_pt='$_POST[item_reorder]',unit = '$_POST[item_unit]',unit_cost='".$con->formatDigit($_POST['item_unitcost'])."',srp='".$con->formatDigit($_POST['srp'])."',vat_exempt='$_POST[vat_exempt]',rev_acct='$_POST[rev_acct]',cogs_acct='$_POST[cogs_acct]',exp_acct='$_POST[exp_acct]',asset_acct='$_POST[asset_acct]',supplier='$_POST[supplier]',`active`='$stat',updated_by='$_SESSION[userid]', updated_on=now() where record_id = '$_POST[rid]';");
			} else {
				$con->dbquery("insert ignore into products_master (company,category,subgroup,item_code,barcode,brand,description,full_description,unit,unit_cost,srp,beg_qty,minimum_level,reorder_pt,vat_exempt,supplier,rev_acct,cogs_acct,exp_acct,asset_acct,`active`,encoded_by,encoded_on) values ('$_SESSION[company]','$_POST[item_category]','$_POST[item_sgroup]','".$con->escapeString(htmlentities($_POST['item_code']))."','$_POST[item_barcode]','".$con->escapeString(htmlentities($_POST['item_brand']))."','".$con->escapeString(htmlentities($_POST['item_description']))."','".$con->escapeString(htmlentities($_POST['item_fdescription']))."','$_POST[item_unit]','".$con->formatDigit($_POST['item_unitcost'])."','".$con->formatDigit($_POST['srp'])."','".$con->formatDigit($_POST['item_beginning'])."','".$con->formatDigit($_POST['item_mininv'])."','".$con->formatDigit($_POST['item_reorder'])."','$_POST[vat_exempt]','$_POST[supplier]','$_POST[rev_acct]','$_POST[cogs_acct]','$_POST[exp_acct]','$_POST[asset_acct]','$stat','$_SESSION[userid]',now());");
			}
		break;
		case "deletePro":
			$con->dbquery("update products_master set `active` = 'N', file_status = 'Deleted' where record_id = '$_POST[rid]';");
		break;
		case "restorePro":
			$con->dbquery("update products_master set `active` = 'Y', file_status = 'Active' where record_id = '$_POST[rid]';");
		break;

		case "checkItemBarcode":
			list($codeCount) = $con->getArray("select count(*) from products_master where (item_code = '$_POST[bcode]' or barcode = '$_POST[bcode]');");
			echo $codeCount;
		break;

		/* Address Book */
		case "getCities":
			$cq = $con->dbquery("select citymunCode, citymunDesc from options_cities where provCode = '$_POST[pid]';");
			while(list($cid,$ctname) = $cq->fetch_array()) {
				echo "<option value='$cid'>$ctname</option>\n";
			}
		break;
		case "getBrgy":
			$cq = $con->dbquery("select brgyCode, brgyDesc from options_brgy where citymunCode = '$_POST[city]';");
			echo "<option value='0'>- Not Applicable -</option>\n";
			while(list($cid,$ctname) = $cq->fetch_array()) {
				echo "<option value='$cid'>$ctname</option>\n";
			}
		break;
		case "saveCInfo":
			if(isset($_POST['fid']) && $_POST['fid'] != "") {
				$con->dbquery("update ignore contact_info set `type`='$_POST[type]',tradename='".$con->escapeString(htmlentities($_POST['tradename']))."',address='".$con->escapeString(htmlentities($_POST['address']))."',billing_address='".$con->escapeString(htmlentities($_POST['billing_address']))."',shipping_address='".$con->escapeString(htmlentities($_POST['shipping_address']))."',bizstyle='".$con->escapeString($_POST['bizstyle'])."',brgy='$_POST[brgy]', city='$_POST[city]',province='$_POST[province]',country='$_POST[country]',tel_no='".$con->escapeString($_POST['telno'])."',cperson='".$con->escapeString($_POST['cperson'])."',terms='$_POST[terms]',credit_limit='".$con->formatDigit($_POST['climit'])."',email='".$con->escapeString($_POST['email'])."',srep='$_POST[srep]',tin_no='$_POST[tin_no]',vatable='$_POST[vatable]', updated_by='$_SESSION[userid]', updated_on=now() where file_id = '$_POST[fid]';");
				echo "update ignore contact_info set `type`='$_POST[type]',tradename='".$con->escapeString(htmlentities($_POST['tradename']))."',address='".$con->escapeString(htmlentities($_POST['address']))."',billing_address='".$con->escapeString(htmlentities($_POST['billing_address']))."',shipping_address='".$con->escapeString(htmlentities($_POST['shipping_address']))."',bizstyle='".$con->escapeString($_POST['bizstyle'])."',brgy='$_POST[brgy]', city='$_POST[city]',province='$_POST[province]',country='$_POST[country]',tel_no='".$con->escapeString($_POST['telno'])."',cperson='".$con->escapeString($_POST['cperson'])."',terms='$_POST[terms]',credit_limit='".$con->formatDigit($_POST['climit'])."',email='".$con->escapeString($_POST['email'])."',srep='$_POST[srep]',tin_no='$_POST[tin_no]',vatable='$_POST[vatable]', updated_by='$_SESSION[userid]', updated_on=now() where file_id = '$_POST[fid]';";
			} else {
				$con->dbquery("insert ignore into contact_info (`type`,tradename,address,brgy,city,province,country,bizstyle,billing_address,shipping_address,tel_no,email,cperson,srep,terms,credit_limit,vatable,tin_no,created_by,created_on) values ('$_POST[type]','".$con->escapeString(htmlentities($_POST['tradename']))."','".$con->escapeString(htmlentities($_POST['address']))."','$_POST[brgy]','$_POST[city]','$_POST[province]','$_POST[country]','".$con->escapeString($_POST['bizstyle'])."','".$con->escapeString(htmlentities($_POST['billing_address']))."','".$con->escapeString(htmlentities($_POST['shipping_address']))."','".$con->escapeString($_POST['telno'])."','".$con->escapeString($_POST['email'])."','$_POST[cperson]','$_POST[srep]','$_POST[terms]','".$con->formatDigit($_POST['climit'])."','$_POST[vatable]','$_POST[tin_no]','$_SESSION[userid]',now());");
			}
		break;
		case "deleteCust":
			$con->dbquery("update contact_info set record_status = 'Deleted', deleted_by='$_SESSION[userid]', deleted_on=now() where file_id='$_POST[fid]';");
		break;
		case "verifyCID":
			list($iCount) = $con->getArray("select count(*) from contact_info where file_id = '$_POST[cid]';");
			if($iCount > 0) { echo "Ok"; } else { echo "notOk"; }
		break;

	}
?>