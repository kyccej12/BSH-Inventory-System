<?php
	require_once "_generics.php";
	
	class myPCV extends _init {
		function setHeaderControls($status,$locked,$pcv_no,$uid,$dS,$urights) {
			$headerControls = '';
			if($locked != 'Y') {
				switch($status) {
					case "Finalized":	
						if($urights == "admin") {
							$headerControls = "<a href=\"#\" class=\"topClickers\" onclick=\"javascript: reopen();\"><img src='images/icons/edit.png' align=absmiddle width=16 height=16 />&nbsp;Make Changes</a>&nbsp;&nbsp;<a href=\"#\" class=\"topClickers\" onclick=\"javascript: encodeInvoices();\"><img src='images/icons/invoice.png' align=absmiddle width=16 height=16 />&nbsp;View Liquidation Details</a>&nbsp;";
						}
						$headerControls .= "&nbsp;<a href=\"#\" class=\"topClickers\"  onClick=\"javascript:parent.printPCV('$pcv_no','$_SESSION[userid]','N');\"><img src=\"images/icons/print.png\" width=16 height=16 border=0 align=\"absmiddle\">&nbsp;Print Petty Cash Voucher</a>&nbsp;&nbsp;<a href=\"#\" class=\"topClickers\"  onClick=\"javascript:postPCV('$pcv_no');\"><img src=\"images/icons/ok.png\" width=16 height=16 border=0 align=\"absmiddle\">&nbsp;Post to Ledger</a>&nbsp;";
					break;
					case "Posted":
						$headerControls .= "&nbsp;<a href=\"#\" class=\"topClickers\" onClick=\"javascript:unpostVoucher('$pcv_no');\"><img src=\"images/icons/edit.png\" width=16 height=16 border=0 align=\"absmiddle\">&nbsp;Unpost Voucher From Ledger</a>&nbsp;&nbsp;<a href=\"#\" class=\"topClickers\" onclick=\"javascript: viewLiquidation();\"><img src='images/icons/invoice.png' align=absmiddle width=16 height=16 />&nbsp;View Liquidation Details</a>&nbsp;";
					break;
					case "Cancelled":
						if($urights == "admin") {
							$headerControls .= "&nbsp;<a href=\"#\" class=\"topClickers\" onclick=\"javascript:reuse();\" ><img src=\"images/icons/refresh.png\" width=16 height=16 border=0 align=\"absmiddle\">&nbsp;Recycle this Document</a>";	
						}
					break;
					case "Active": default:
						$headerControls = "<a href=\"#\" class=\"topClickers\" onClick=\"javascript:finalize();\"><img src=\"images/icons/ok.png\" width=16 height=16 border=0 align=\"absmiddle\">&nbsp;Finalize Voucher</a>&nbsp;&nbsp;<a href=\"#\" class=\"topClickers\" onclick=\"javascript:saveHeader();\"><img src=\"images/save.png\" width=16 height=16 border=0 align=\"absmiddle\">&nbsp;Save Changes</a>&nbsp;&nbsp;<a href=\"#\" class=\"topClickers\" onclick=\"javascript:encodeInvoices();\"><img src=\"images/icons/invoice.png\" width=16 height=16 border=0 align=\"absmiddle\">&nbsp;Attach Invoices</a>&nbsp;&nbsp;";
						if($urights == "admin" && $dS != 1) {
							$headerControls .= "&nbsp;<a href=\"#\" class=\"topClickers\" onclick=\"javascript:cancel();\"><img src=\"images/icons/cancel.png\" width=16 height=16 border=0 align=\"absmiddle\">&nbsp;Cancel Record</a>";
						}
					break;
				}
			} else {
				$headerControls .= "&nbsp;<a href=\"#\" class=\"topClickers\" onClick=\"javascript:parent.printPCV('$pcv_no','$_SESSION[userid]','Y');\"><img src=\"images/icons/print.png\" width=16 height=16 border=0 align=\"absmiddle\">&nbsp;Re-Print Voucher</a>";
			}
			echo $headerControls;
		}
		
		function setNavButtons($pcv_no) {
			
			$nav = '';
			
			list($fwd) = parent::getArray("select pcvNO from pcv where pcvNO > $pcv_no and branch = '1' limit 1;");
			list($prev) = parent::getArray("select pcvNO from pcv where pcvNO < $pcv_no and branch = '1' order by pcvNO desc limit 1;");
			list($last) = parent::getArray("select pcvNO from pcv where branch = '1' order by pcvNO desc limit 1;");
			list($first) = parent::getArray("select pcvNO from pcv where branch = '1' order by pcvNO asc limit 1;");
			if($prev)
				$nav = $nav . "<a href=# onclick=\"parent.viewPCV('$prev');\"><img src='images/resultset_previous.png'  title='Previous Record' /></a>";
			if($fwd) 
				$nav = $nav . "<a href=# onclick=\"parent.viewPCV('$fwd');\"><img src='images/resultset_next.png' 'title='Next Record' /></a>";
			echo "<a href=# onclick=\"parent.viewPCV('$first');\"><img src='images/resultset_first.png' title='First Record' /><a>" . $nav . "<a href=# onclick=\"parent.viewCV('$last');\"><img src='images/resultset_last.png' title='Last Record' /></a>";
		
		}
		
	}

?>