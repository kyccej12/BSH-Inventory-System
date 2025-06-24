<?php
	require_once "_generics.php";
	class myRR extends _init {
		
		function updateHeaderAmt($rr_no) {
			list($amt) = parent::getArray("select sum(amount) from rr_details where rr_no = '$rr_no' and branch = '1';");
			parent::dbquery("update ignore rr_header set amount = '$amt' where rr_no = '$rr_no' and branch = '1';");
		}
		
		function setHeaderControls($status,$rr_no,$uid) {
			
			$headerControls = '';
			
		
			switch($status) {
				case "Finalized":
					if($uid == "1" || $uid == '2') {
						$headerControls = "<a href=\"#\" class=\"topClickers\" onclick=\"javascript: reopenRR('$rr_no');\"><img src='images/icons/edit.png' align=absmiddle width=16 height=16 />&nbsp;Set this Document to Active Status</a>&nbsp;";
					}
					$headerControls = $headerControls . "&nbsp;<a href=\"#\" class=\"topClickers\" onClick=\"javascript:parent.printRR('$rr_no','$_SESSION[userid]','N');\"><img src=\"images/icons/print.png\" width=16 height=16 border=0 align=\"absmiddle\">&nbsp;Print Receiving Report</a>&nbsp;";
				break;
				case "Cancelled":
					if($uid == "1" || $uid == '2') {
						$headerControls = $headerControls . "<a href=\"#\" class=\"topClickers\" onclick=\"javascript:reuseRR('$rr_no');\" style=\"padding: 5px;\"><img src=\"images/icons/refresh.png\" width=16 height=16 border=0 align=\"absmiddle\">&nbsp;Recycle this Document</a>";	
					}
				break;
				case "Active": default:
					$headerControls = "<a href=\"#\" class=\"topClickers\" onClick=\"javascript: printRR('$rr_no','$_SESSION[userid]');\"><img src=\"images/icons/ok.png\" width=16 height=16 border=0 align=\"absmiddle\">&nbsp;Finalize Receiving Report</a>&nbsp;&nbsp;<a href=\"#\" class=\"topClickers\" onclick=\"javascript:saveRRHeader();\"><img src=\"images/save.png\" width=16 height=16 border=0 align=\"absmiddle\">&nbsp;Save Changes</a>&nbsp;&nbsp;<a href=\"#\" class=\"topClickers\" onclick=\"javascript:downloadPO();\"><img src=\"images/icons/copy.png\" width=16 height=16 border=0 align=\"absmiddle\">&nbsp;Copy From Purchase Order</a>&nbsp;";
					if($uid == "1" || $uid == '2') {
						$headerControls = $headerControls . "&nbsp;<a href=\"#\" class=\"topClickers\" onclick=\"javascript:cancelRR('$rr_no');\"><img src=\"images/icons/cancel.png\" width=16 height=16 border=0 align=\"absmiddle\">&nbsp;Cancel this Document</a>&nbsp;";
					}
				break;
			}
		
			echo $headerControls;
		}
		
		function setNavButtons($rr_no) {
			
			$nav = '';
			
			list($fwd) = parent::getArray("select rr_no from rr_header where rr_no > $rr_no and branch = '1' limit 1;");
			list($prev) = parent::getArray("select rr_no from rr_header where rr_no < $rr_no and branch = '1' order by rr_no desc limit 1;");
			list($last) = parent::getArray("select rr_no from rr_header where branch = '1' order by rr_no desc limit 1;");
			list($first) = parent::getArray("select rr_no from rr_header where branch = '1' order by rr_no asc limit 1;");
			if($prev)
				$nav = $nav . "<a href=# onclick=\"parent.viewRR('$prev');\"><img src='images/resultset_previous.png'  title='Previous Record' /></a>";
			if($fwd) 
				$nav = $nav . "<a href=# onclick=\"parent.viewRR('$fwd');\"><img src='images/resultset_next.png' 'title='Next Record' /></a>";
			echo "<a href=# onclick=\"parent.viewRR('$first');\"><img src='images/resultset_first.png' title='First Record' /><a>" . $nav . "<a href=# onclick=\"parent.viewRR('$last');\"><img src='images/resultset_last.png' title='Last Record' /></a>";
		}
		
		function RRDETAILS($rr_no,$status) {
			$i = 0; $t = 0;
			$details = parent::dbquery("select line_id, rr_no, lpad(po_no,6,0) as po_no, date_format(po_date,'%m/%d/%Y') as po_date, item_code, description, qty, cost, unit, amount from rr_details where rr_no = '$rr_no' and branch = '$_SESSION[branchid]';");
			echo '<table width=100% cellspacing=0 cellpadding=0 onMouseOut="javascript:highlightTableRowVersionA(0);">';
				
				if(mysqli_num_rows($details)) {
					while(list($line_id, $rr_no, $po_no, $po_date, $item_code, $description, $qty, $price, $unit, $amount) = $details->fetch_array()) {
						 if($po_no!='') { list($poQty,$poTdld) = parent::getArray("select qty,qty_dld as tqty from po_details where item_code = '$item_code' and  po_no = '$po_no' and branch = '$_SESSION[branchid]';"); } else { $poQTY = 0; $poQTY = 0; }
						 echo '<tr bgcolor="'.parent::initBackground($i).'" onmouseover="highlightTableRowVersionA(this, \'#3399ff\');" id="obj_'.$line_id.'" onclick="selectLine(this,\''.$line_id.'\');">
								<td align=center class="grid" width="8%">'.$po_no.'</td>
								<td align=center class="grid" width="10%">'.$po_date.'</td>
								<td align=center class="grid" width="10%">'.$item_code.'</td>
								<td align=left class="grid" width="31%">'.strtoupper($description).'</td>
								<td align=center class="grid" width="10%">'.$unit.'</td>
								<td align=center class="grid" width="10%">';
							if(($status == 'Active' || $status == '') && $lock != 'Y') {
									echo '<input type="text" id="qty['.$line_id.']" style="border: none; width: 90%; text-align: center; background-color: '.parent::initBackground($i).'" value="'.number_format($qty,2).'" onchange="updateQty(this.value,\''.$rr_no.'\',\''.$line_id.'\',\''. $price . '\',\''.$qty.'\',\''.$po_no.'\',\''.$poQty.'\',\''.$poTdld.'\');">';
								} else { echo number_format($qty,2); }
							echo '</td>
								<td align=center class="grid" width="10%">'.number_format($price,2).'</td>
								<td align=right class="grid" style="padding-right: 20px;"><span id="amt['.$line_id.']">'.number_format($amount,2).'</span></td>
							</tr>';	
						$i++;						
					}
				}
					
			
				if($i < 8) { for($i; $i <= 7; $i++) {
					echo '<tr bgcolor='.parent::initBackground($i).'>
								<td align=left class="grid" width="100%" colspan=9>&nbsp;</td>
						</tr>';
					}
				}
			echo '</table>';
		}
	}
	

?>