<?php
	
	require_once("_generics.php");	
	class myPO extends _init {
		
		function setHeaderControls($status,$po_no,$uid) {

			$headerControls = '';


			switch($status) {
				case "Finalized":
					list($posted_by,$posted_on) = parent::getArray("select fullname as name, date_format(updated_on,'%m/%d/%Y %p') as date_posted from po_header a left join user_info b on a.updated_by=b.emp_id where a.po_no='$po_no';");
					
					if($uid == 1 || $uid == 2) {
						$headerControls = $headerControls . "&nbsp;<a href=\"#\" class=\"topClickers\" onclick=\"javascript: reopenPO('$po_no');\"><img src='images/icons/edit.png' align=absmiddle width=16 height=16 />&nbsp;Set this Document to Active Status</a>&nbsp;";
					}
					$headerControls = $headerControls . "&nbsp;<a href=\"#\" class=\"topClickers\" onClick=\"javascript:parent.printPO('$po_no','$_SESSION[userid]','N');\"><img src=\"images/icons/print.png\" width=16 height=16 border=0 align=\"absmiddle\">&nbsp;Print Purchase Order</a>&nbsp;";
				break;
				case "Cancelled":
					if($uid == 1 || $uid == 2) {
						$headerControls = $headerControls . "<a href=\"#\" class=\"topClickers\" onclick=\"javascript:reusePO('$po_no');\" style=\"padding: 5px;\"><img src=\"images/icons/refresh.png\" width=16 height=16 border=0 align=\"absmiddle\">&nbsp;Recycle this Document</a>&nbsp;";	
					}
				break;
				case "Active": default:
					$headerControls = "<a href=\"#\" class=\"topClickers\" onClick=\"javascript:printPO('$po_no','$_SESSION[userid]');\"><img src=\"images/icons/ok.png\" width=16 height=16 border=0 align=\"absmiddle\">&nbsp;Finalize Purchase Order</a>&nbsp;&nbsp;<a href=\"#\" class=\"topClickers\" onclick=\"javascript:savePOHeader();\"><img src=\"images/save.png\" width=16 height=16 border=0 align=\"absmiddle\">&nbsp;Save Changes</a>&nbsp;";
					if($uid == 1 || $uid == 2) {
						$headerControls = $headerControls . "<a href=\"#\" class=\"topClickers\" onclick=\"javascript:cancelPO('$po_no');\"><img src=\"images/icons/cancel.png\" width=16 height=16 border=0 align=\"absmiddle\">&nbsp;Cancel this Document</a>&nbsp;";
					}
				break;
			}
			
			echo $headerControls;
		}
		
		function setJOHeaderControls($status,$lock,$doc_no,$uid,$urights) {

			$headerControls = '';

			if($lock != 'Y') {
				switch($status) {
					case "Finalized":
						list($posted_by,$posted_on) = parent::getArray("select fullname as name, date_format(updated_on,'%m/%d/%Y %p') as date_posted from joborder a left join user_info b on a.updated_by = b.emp_id where a.doc_no='$doc_no';");
						
						if($urights == "admin") {
							$headerControls = $headerControls . "&nbsp;<a href=\"#\" class=\"topClickers\" onclick=\"javascript: reopenJO('$doc_no');\"><img src='images/icons/edit.png' align=absmiddle width=16 height=16 />&nbsp;Set this Document to Active Status</a>&nbsp;";
						}
						$headerControls = $headerControls . "&nbsp;<a href=\"#\" class=\"topClickers\" onClick=\"javascript:parent.printJO('$doc_no');\"><img src=\"images/icons/print.png\" width=16 height=16 border=0 align=\"absmiddle\">&nbsp;Print Job Order</a>&nbsp;";
					break;
					case "Cancelled":
						if($urights == "admin") {
							$headerControls = $headerControls . "<a href=\"#\" class=\"topClickers\" onclick=\"javascript:reuseJO('$doc_no');\" style=\"padding: 5px;\"><img src=\"images/icons/refresh.png\" width=16 height=16 border=0 align=\"absmiddle\">&nbsp;Recycle this Document</a>&nbsp;";	
						}
					break;
					case "Active": default:
						$headerControls = "<a href=\"#\" class=\"topClickers\" onClick=\"javascript:finalizeJO('$doc_no');\"><img src=\"images/icons/ok.png\" width=16 height=16 border=0 align=\"absmiddle\">&nbsp;Finalize Job Order</a>&nbsp;&nbsp;<a href=\"#\" class=\"topClickers\" onclick=\"javascript:saveJOHeader();\"><img src=\"images/save.png\" width=16 height=16 border=0 align=\"absmiddle\">&nbsp;Save Changes</a>&nbsp;";
						if($urights == "admin") {
							$headerControls = $headerControls . "<a href=\"#\" class=\"topClickers\" onclick=\"javascript:cancelJO('$doc_no');\"><img src=\"images/icons/cancel.png\" width=16 height=16 border=0 align=\"absmiddle\">&nbsp;Cancel this Document</a>&nbsp;";
						}
					break;
				}
			} else {
				$headerControls = $headerControls . "&nbsp;<a href=\"#\" class=\"topClickers\" onClick=\"javascript:parent.printJO('$doc_no');\"><img src=\"images/icons/print.png\" width=16 height=16 border=0 align=\"absmiddle\">&nbsp;Re-Print Job Order</a>&nbsp;";
			}
			echo $headerControls;
		}
		
		function setNavButtons($po_no) {
			
			$nav = '';
			
			list($fwd) = parent::getArray("select po_no from po_header where po_no > $po_no and branch = '1' limit 1;");
			list($prev) = parent::getArray("select po_no from po_header where po_no < $po_no and branch = '1' order by po_no desc limit 1;");
			list($last) = parent::getArray("select po_no from po_header where branch = '1' order by po_no desc limit 1;");
			list($first) = parent::getArray("select po_no from po_header where branch = '1' order by po_no asc limit 1;");
			if($prev)
				$nav = $nav . "<a href=# onclick=\"parent.viewPO('$prev');\"><img src='images/resultset_previous.png'  title='Previous Record' /></a>";
			if($fwd) 
				$nav = $nav . "<a href=# onclick=\"parent.viewPO('$fwd');\"><img src='images/resultset_next.png' 'title='Next Record' /></a>";
			echo "<a href=# onclick=\"parent.viewPO('$first');\"><img src='images/resultset_first.png' title='First Record' /><a>" . $nav . "<a href=# onclick=\"parent.viewPO('$last');\"><img src='images/resultset_last.png' title='Last Record' /></a>";
		}
		
		function setJONavButtons($doc_no) {
			
			$nav = '';
			
			list($fwd) = parent::getArray("select doc_no from joborder where doc_no > $doc_no limit 1;");
			list($prev) = parent::getArray("select doc_no from joborder where doc_no < $doc_no order by doc_no desc limit 1;");
			list($last) = parent::getArray("select doc_no from joborder order by doc_no desc limit 1;");
			list($first) = parent::getArray("select doc_no from joborder order by doc_no asc limit 1;");
			if($prev)
				$nav = $nav . "<a href=# onclick=\"parent.viewJO('$prev');\"><img src='images/resultset_previous.png'  title='Previous Record' /></a>";
			if($fwd) 
				$nav = $nav . "<a href=# onclick=\"parent.viewJO('$fwd');\"><img src='images/resultset_next.png' 'title='Next Record' /></a>";
			echo "<a href=# onclick=\"parent.viewJO('$first');\"><img src='images/resultset_first.png' title='First Record' /><a>" . $nav . "<a href=# onclick=\"parent.viewJO('$last');\"><img src='images/resultset_last.png' title='Last Record' /></a>";
		}
		
		function PODETAILS($po_no,$status,$lock) {
			$i = 1; $t = 0; $pct = 0; $line_id = 0;
			$details = parent::dbquery("select line_id, po_no, item_code, description, qty, cost, ROUND(qty * discount,2), unit, amount, qty_dld, ROUND(qty * cost,2) as linegross, if(custom_description!='',concat('<br/><b>Other Description:</b> ',custom_description),'') as custDesc from po_details where po_no='$po_no' and branch = '1';");
			echo '<table width=100% cellspacing=0 cellpadding=0 onMouseOut="javascript:highlightTableRowVersionA(0);">';
			while(list($line_id, $po_no, $item_code, $description, $qty, $price, $discount, $unit, $amount, $dld, $linegross, $custDesc) = $details->fetch_array(MYSQLI_BOTH)) {
			  if($discount > 0 && $pct == 0) {
				$myDiscount =  number_format($discount,2);
			  } else { if($pct > 0) { $myDiscount = "$pct%"; } else { $myDiscount = ''; }}
			  echo '<tr bgcolor="'.parent::initBackground($i).'" onmouseover="highlightTableRowVersionA(this, \'#3399ff\');" id="obj_'.$line_id.'" onclick="selectLine(this,\''.$line_id.'\');">
						<td align=left class="grid" width="10%">'.$item_code.'</td>
						<td align=left class="grid" width="50%">'.strtoupper($description).$custDesc.'</td>
						<td align=center class="grid" width="10%">'.parent::identUnit($unit).'</td>
						<td align=center class="grid" width="10%">';
					if(($status == 'Active' || $status == '') && $lock != 'Y') {
							echo '<input type="text" id="qty['.$line_id.']" style="border: none; width: 90%; text-align: center; background-color: '.parent::initBackground($i).'" value="'.number_format($qty,2).'" onchange="updateQty(this.value,\''.$po_no.'\',\''.$line_id.'\',\''. $price . '\');">';
					} else { echo number_format($qty,2); }
					echo '</td>
						<td align=center class="grid" width="10%">';
					if(($status == 'Active' || $status == '') && $lock != 'Y') {
						echo '<input type="text" id="price['.$line_id.']" style="border: none; width: 90%; text-align: center; background-color: '.parent::initBackground($i).'" value="'.number_format($price,2).'" onchange="updatePrice(this.value,\''.$po_no.'\',\''.$line_id.'\');">';
					} else { echo number_format($price,2); }
						
					echo '</td>
						<td align=right class="grid" style="padding-right: 20px;" width="10%"><span id="amt['.$line_id.']">'.number_format($amount,2).'</span></td>
					</tr>';	
				$i++;						
			}
			if($i < 8) { for($i; $i <= 7; $i++) { echo '<tr bgcolor='.parent::initBackground($i).'><td align=left class="grid" width="100%" colspan=8>&nbsp;</td></tr>'; }}
			echo '</table>';
		}
		
		function updateHeaderAmt($po_no) {
			list($amt,$discount) = parent::getArray("select sum(ROUND(qty*cost,2)) as amount, sum(ROUND(qty*discount,2)) as discount from po_details where po_no = '$po_no' and branch = '1';");
			parent::dbquery("update ignore po_header set amount='0$amt',discount='0$discount', net=('0$amt'-'0$discount') where po_no = '$po_no' and branch = '1';");
		}
		
	}



?>