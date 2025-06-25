<?php 
	
	session_start();
	require_once "handlers/_generics.php";
	
	$o = new _init;
	if(isset($_SESSION['authkey'])) { $exception = $o->validateKey(); if($o->exception != 0) {	$URL = $HTTP_REFERER . "login/index.php?exception=" . $o->exception; } } else { $URL = $HTTP_REFERER . "login"; }
	if($URL) { header("Location: $URL"); };

?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<title>Black Smokehaus</title>
	<link rel="icon" type="image/x-icon" href="favicon.ico" />
	<link href="ui-assets/themes/smoothness/jquery-ui.css" rel="stylesheet" type="text/css" />
	<link href="style/style.css" rel="stylesheet" type="text/css" />
	<link href="style/dropMenu.css" rel="stylesheet" type="text/css" />
	<script language="javascript" src="ui-assets/jquery/jquery-1.12.3.js"></script>
	<script language="javascript" src="ui-assets/themes/smoothness/jquery-ui.js"></script>
	<script language="javascript" src="js/jquery.dialogextend.js"></script>
	<script language="javascript" src="js/main.js?sid=<?php echo uniqid(); ?>"></script>
	<script language="javascript" src="js/dropMenu.js"></script>
</head>
<body bgcolor="#ffffff" leftmargin="0" bottommargin="0" rightmargin="0" topmargin="0" <?php if($o->cpass == 'Y') { echo "onLoad=\"showChangePass();\""; } ?>>
 <table height="100%" width="100%" border="0" cellspacing="0" cellpadding="0" >
	<tr bgcolor="#ad1920">
		<td colspan=2 height=37 style="padding-left: 3px;">
			<a href="#" onclick="showOptions();"><img src="images/icons/button-menu.png" width=24 height=24 align=absmiddle></a>
		</td>
		<td align=right style="padding-right: 10px;"><img src="images/icons/user.png" align=absmiddle border=0 width=18 height=18 /><span style="font-size: 11px; font-weight: bold; color: #ffffff;">&nbsp;<?php $o->getUname($_SESSION['userid']); ?>&nbsp;&nbsp;&nbsp;|</span>&nbsp;<a href="logout.php" style="font-size: 12px; font-weight: bold; color: #ffffff; text-decoration: none;" title="Click to Logout"><img src="images/button-logout.png" align=absmiddle border=0 width=24 height=24 />Logout</a></td>
	</tr>
	<tr height=90%>
		<td colspan=3>
			<table width="100%" height="100%" align="center" valign=middle>
				<tr>
					<td align=center>
						<img src="images/logo.png">
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan=3>
			<table width="100%" height="100%" cellpadding=0 cellspacing=0 align="center" valign=middle>
				<tr bgcolor="#ad1920">
					<td align=center style="font-family: arial, helvetica, sans-serif; color: #fefefe; font-size: 11px; font-weight: bold;">&copy; Exclusively Developed for Black Smokehaus by Port80 Business Solutions.</td>
				</tr>
			</table>
		</td>
	</tr>
 </table>

 <div id="salesReportMain" style="display: none;">
	<div style="padding: 20px;">
		<div>Main Menu</div>
		<div><hr width=100% height=1></hr></div>
		<div style="height: 10px;"></div>
		<!-- <div class="fileObjects"><a href="#" onclick="showSI();"><img src="images/icons/cashregister.png" width=60 height=60 /><br/><br/>Point of Sale</a></div> -->
		<!-- <div class="fileObjects"><a href="#" onclick="showCR();"><img src="images/icons/collections.png" width=60 height=60 /><br/><br/>Receive Payments</a></div> -->
		<!-- <div class="fileObjects"><a href="#" onclick="showPCV();"><img src="images/icons/apv256.png" width=60 height=60 /><br/><br/>Petty Cash Voucher</a></div> -->
		<div class="fileObjects"><a href="#" onclick="showRRList();"><img src="images/icons/crr.png" width=60 height=60 /><br/><br/>Receive Stocks from Supplier</a></div>
		<div class="fileObjects"><a href="#" onclick="showSW();"><img src="images/icons/widraw.png" width=60 height=60 /><br/><br/>Stocks Withdrawal</a></div>
		<div class="fileObjects"><a href="#" onclick="showSRR();"><img src="images/icons/receiving.png" width=60 height=60 /><br/><br/>Stocks Receiving Slip</a></div>
		<div class="fileObjects"><a href="#" onclick="showPOList();"><img src="images/icons/purchaseorder.png" width=60 height=60 /><br/><br/>Purchase Order</a></div>
		<div class="fileObjects"><a href="#" onclick="showCust('');"><img src="images/icons/employee.png" width=60 height=60 /><br/><br/>Address Book</a></div>
		<div class="fileObjects"><a href="#" onclick="showItems();"><img src="images/icons/serials.png" width=60 height=60 /><br/><br/>Products</a></div>
		<?php if($_SESSION['userid'] == 1 || $_SESSION['userid'] == 2) { ?>
			<div class="fileObjects"><a href="#" onclick="showUsers();"><img src="images/icons/personalinfo.png" width=60 height=60 /><br/><br/>System Users</a></div>
		<?php } ?>
	</div>
	<div style="clear: both;"></div>
	<div style="padding: 20px;">
		<div>Reports</div>
		<div><hr width=100% height=1></hr></div>
		<div style="height: 10px;"></div>
		<!-- <div class="fileObjects" onclick="showSalesReport();"><a href="#"><img src="images/icons/ordering128.png" width=60 height=60 /><br/><br/>Sales Report</a></div> -->
		<!-- <div class="fileObjects" onclick="showGrossProfitSales();"><a href="#"><img src="images/icons/reports256.png" width=60 height=60 /><br/><br/>Gross Profit Sales Report</a></div> -->
		<!-- <div class="fileObjects" onclick="showDSCR();"><a href="#"><img src="images/icons/catalog256.png" width=60 height=60 /><br/><br/>Daily Sales & Collection Report</a></div>
		<div class="fileObjects" onclick="showAR();"><a href="#"><img src="images/icons/dscr.png" width=60 height=60 /><br/><br/>Accounts Receivable Summary</a></div>
		<div class="fileObjects" onclick="showPettyCashSummary();"><a href="#"><img src="images/icons/reports256.png" width=60 height=60 /><br/><br/>Petty Cash Summary</a></div> -->
		<div class="fileObjects" onclick="showInventoryReport();"><a href="#"><img src="images/icons/trading.png" width=60 height=60 /><br/><br/>Inventory Summary Report</a></div>
		<div class="fileObjects" onclick="showReceiveSummary();"><a href="#"><img src="images/icons/dscr.png" width=60 height=60 /><br/><br/>Summary of Goods Received</a></div>
		<div class="fileObjects" onclick="showWithdrawalReport();"><a href="#"><img src="images/icons/widraw.png" width=60 height=60 /><br/><br/>Withdrawal Summary</a></div>
	</div>
</div>


<div id="userrights" style="display: none;"></div>
<div id="userdetails" style="display: none;"></div>
<div id="userlist" style="display: none;"></div>
<div id="silist" style="display: none;"></div>
<div id="sidetails" style="display: none;"></div>
<div id="siprint" style="display: none;"></div>
<div id="rrlist" style="display: none;"></div>
<div id="rrdetails" style="display: none;"></div>
<div id="rrprint" style="display: none;"></div>
<div id="polist" style="display: none;"></div>
<div id="podetails" style="display: none;"></div>
<div id="poprint" style="display: none;"></div>
<div id="swlist" style="display: none;"></div>
<div id="swdetails" style="display: none;"></div>
<div id="swprint" style="display: none;"></div>
<div id="silist" style="display: none;"></div>
<div id="sidetails" style="display: none;"></div>
<div id="siprint" style="display: none;"></div>
<div id="itemlist" style="display: none;"></div>
<div id="itemdetails" style="display: none;"></div>
<div id="customerlist" style="display: none;"></div>
<div id="customerdetails" style="display: none;"></div>
<div id="pcvlist" style="display: none;"></div>
<div id="pcvdetails" style="display: none;"></div>
<div id="changepass" style="display: none;"></div>
<div id="srrlist" style="display: none;"></div>
<div id="srrdetails" style="display: none;"></div>
<div id="srrprint" style="display: none;"></div>
<div id="crlist" style="display: none;"></div>
<div id="crdetails" style="display: none;"></div>
<div id="crprint" style="display: none;"></div>

<?php for($rpt = 1; $rpt <= 10; $rpt++) { echo "<div id=\"report$rpt\" style=\"display: none;\"></div>"; } ?>

<div id="salesinquiry" style="display:none;">	
	<table border="0" cellpadding="0" cellspacing="0" width=100% style="padding: 10px;">
		<tr>
			<td width=35%><span class="spandix-l">Sales Date :</span></td>
			<td>
				<input type="text" id="sinq_date" class="gridInput" style="width: 80%;" value="<?php echo date('m/d/Y'); ?>" />
			</td>
		</tr>
	</table>
</div>

<div id="arSummary" style="display:none;">	
	<table border="0" cellpadding="0" cellspacing="0" width=100% style="padding: 10px;">
		<tr>
			<td width=35%><span class="spandix-l">Customer :</span></td>
			<td>
				<select id="ar_customer" style="width: 80%; font-size: 11px;" class="gridInput" />
					<option value = ''>- All Customer -</option>
					<?php
						$cQuery = $o->dbquery("select customer,customer_name from invoice_header where customer != 0 group by customer;");
						while($cRow = $cQuery->fetch_array()) {
							
							echo "<option value='$cRow[0]'>$cRow[1]</option>";
							
						}
					?>
				</select>
			</td>
		</tr>
		<tr><td height=4></td></tr>
		<tr>
			<td width=35%><span class="spandix-l">Covered Period :</span></td>
			<td>
				<input type="text" id="ar_asof" class="gridInput" style="width: 80%;" value="<?php echo date('m/01/Y'); ?>" />
			</td>
		</tr>
	</table>
</div>

<div id="dailySales" style="display:none;">	
	<table border="0" cellpadding="0" cellspacing="0" width=100% style="padding: 10px;">
		<tr>
			<td width=35% valign=top><span class="spandix-l">Product Group :</span></td>
			<td>
				<select id = "ds_group" class="gridInput" style="width: 80%; font-size: 11px;">
					<option value=''>- All -</option>
					<?php
						$gQuery = $o->dbquery("select mid, mgroup from options_mgroup order by mgroup;");
						while($gRow = $gQuery->fetch_array()) {
							echo "<option value='$gRow[0]'>$gRow[1]</option>";
						}
					?>
				</select>
			</td>
		</tr>
		<tr><td height=4></td></tr>
		<tr>
			<td width=35% valign=top><span class="spandix-l">Product Description :</span></td>
			<td>
				<input type="text" id="ds_desc" class="gridInput" style="width: 80%;" value="" /><br/><span style="font-size: 10px;">(Optional Search String)</span>
			</td>
		</tr>
		<tr><td height=4></td></tr>
		<tr>
			<td width=35%><span class="spandix-l">Covered Period :</span></td>
			<td>
				<input type="text" id="ds_dtf" class="gridInput" style="width: 80%;" value="<?php echo date('m/01/Y'); ?>" />
			</td>
		</tr>
		<tr><td height=4></td></tr>
		<tr>
			<td width=35%><span class="spandix-l"></span></td>
			<td>
				<input type="text" id="ds_dt2" class="gridInput" style="width: 80%;" value="<?php echo date('m/d/Y'); ?>" />
			</td>
		</tr>
	</table>
</div>

<div id="inventoryReport" style="display:none;">	
	<table border="0" cellpadding="0" cellspacing="0" width=100% style="padding: 10px;">
		<tr>
			<td width=35% valign=top><span class="spandix-l">Product Group :</span></td>
			<td>
				<select id = "ir_group" class="gridInput" style="width: 80%; font-size: 11px;">
					<option value=''>- All -</option>
					<?php
						$gQuery = $o->dbquery("select mid, mgroup from options_mgroup order by mgroup;");
						while($gRow = $gQuery->fetch_array()) {
							echo "<option value='$gRow[0]'>$gRow[1]</option>";
						}
					?>
				</select>
			</td>
		</tr>
		<tr><td height=4></td></tr>
		<tr>
			<td width=35%><span class="spandix-l">Covered Period :</span></td>
			<td>
				<input type="text" id="ir_dtf" class="gridInput" style="width: 80%;" value="<?php echo date('m/01/Y'); ?>" />
			</td>
		</tr>
		<tr><td height=4></td></tr>
		<tr>
			<td width=35%><span class="spandix-l"></span></td>
			<td>
				<input type="text" id="ir_dt2" class="gridInput" style="width: 80%;" value="<?php echo date('m/d/Y'); ?>" />
			</td>
		</tr>
	</table>
</div>

<div id="grossProfitSales" style="display:none;">	
	<table border="0" cellpadding="0" cellspacing="0" width=100% style="padding: 10px;">
		<tr>
			<td width=35% valign=top><span class="spandix-l">Product Group :</span></td>
			<td>
				<select id = "gps_group" class="gridInput" style="width: 80%; font-size: 11px;">
					<option value=''>- All -</option>
					<?php
						$gQuery = $o->dbquery("select mid, mgroup from options_mgroup order by mgroup;");
						while($gRow = $gQuery->fetch_array()) {
							echo "<option value='$gRow[0]'>$gRow[1]</option>";
						}
					?>
				</select>
			</td>
		</tr>
		<tr><td height=4></td></tr>
		<tr>
			<td width=35%><span class="spandix-l">Covered Period :</span></td>
			<td>
				<input type="text" id="gps_dtf" class="gridInput" style="width: 80%;" value="<?php echo date('m/01/Y'); ?>" />
			</td>
		</tr>
		<tr><td height=4></td></tr>
		<tr>
			<td width=35%><span class="spandix-l"></span></td>
			<td>
				<input type="text" id="gps_dt2" class="gridInput" style="width: 80%;" value="<?php echo date('m/d/Y'); ?>" />
			</td>
		</tr>
	</table>
</div>

<div id="goodsReceivedSummary" style="display:none;">	
	<table border="0" cellpadding="0" cellspacing="0" width=100% style="padding: 10px;">
		<tr>
			<td width=35%><span class="spandix-l">Covered Period :</span></td>
			<td>
				<input type="text" id="grs_dtf" class="gridInput" style="width: 80%;" value="<?php echo date('m/01/Y'); ?>" />
			</td>
		</tr>
		<tr><td height=4></td></tr>
		<tr>
			<td width=35%><span class="spandix-l"></span></td>
			<td>
				<input type="text" id="grs_dt2" class="gridInput" style="width: 80%;" value="<?php echo date('m/d/Y'); ?>" />
			</td>
		</tr>
	</table>
</div>

<div id="goodsWithdrawnSummary" style="display:none;">	
	<table border="0" cellpadding="0" cellspacing="0" width=100% style="padding: 10px;">
		<tr>
			<td width=35%><span class="spandix-l">Covered Period :</span></td>
			<td>
				<input type="text" id="gws_dtf" class="gridInput" style="width: 80%;" value="<?php echo date('m/01/Y'); ?>" />
			</td>
		</tr>
		<tr><td height=4></td></tr>
		<tr>
			<td width=35%><span class="spandix-l"></span></td>
			<td>
				<input type="text" id="gws_dt2" class="gridInput" style="width: 80%;" value="<?php echo date('m/d/Y'); ?>" />
			</td>
		</tr>
	</table>
</div>

<div id="pettyCashSummary" style="display:none;">	
	<table border="0" cellpadding="0" cellspacing="0" width=100% style="padding: 10px;">
		<tr>
			<td width=35%><span class="spandix-l">Report Type :</span></td>
			<td>
				<select id="pcs_type" style="width: 80%; font-size: 11px;" class="gridInput" />
					<option value="">- All -</option>
					<option value="Y">- Liquidated -</option>
					<option value="N">- Unliquidated -</option>
				</select>
			</td>
		</tr>
		<tr><td height=4></td></tr>
		<tr>
			<td width=35%><span class="spandix-l">Payee :</span></td>
			<td>
				<input type="text" id="pcs_name" class="inputSearch2" style="width: 80%;padding-left: 22px;" />
			</td>
		</tr>
		<tr><td height=4></td></tr>
		<tr>
			<td width=35%><span class="spandix-l">Covered Period :</span></td>
			<td>
				<input type="text" id="pcs_dtf" class="gridInput" style="width: 80%;" value="<?php echo date('m/01/Y'); ?>" />
			</td>
		</tr>
		<tr><td height=4></td></tr>
		<tr>
			<td width=35%><span class="spandix-l"></span></td>
			<td>
				<input type="text" id="pcs_dt2" class="gridInput" style="width: 80%;" value="<?php echo date('m/d/Y'); ?>" />
			</td>
		</tr>
	</table>
</div>

<div id="loaderMessage" style="display: none;">
	<table width=100%>
		<tr>
			<td align=center style="color:grey; padding-top: 40px; font-size: 11px;"><img src="images/ajax-loader.gif" align=absmiddle>&nbsp;Please wait while the system is processing your request...</td>
		</tr>
	</table>
</div>
<div id = "popSaver" class = "popSaver">Record Has Been Successfully Saved...</div>
<div id="errorMessage" title="Error Message" style="display: none;">
	<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span><b>Unable to continue due to the following error(s):</b></p>
	<p style="margin-left: 20px; text-align: justify;" id="message"></span></p>
</div>
<div id="mainLoading" style="display:none; width:100%;height:100%;position:absolute;top:0;margin:auto;"> 
	<div style="background-color:white;width:10%;height:20%;;margin:auto;position:relative;top:100;">
		<img style="display:block;margin-left:auto;margin-right:auto;" src="images/ajax-loader.gif" width=128 height=128 align=absmiddle /> 
	</div>
	<div id="mainLoading2" style="background-color:white;width:100%;height:100%;position:absolute;top:0;margin:auto;opacity:0.5;"> </div>
</div>
<div class="suggestionsBox" id="suggestions" style="display: none;">
	<div class="suggestionList" id="autoSuggestionsList">&nbsp;</div>
</div>
</body>
</html>