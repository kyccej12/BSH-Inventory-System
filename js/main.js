/* Percentage of Screen Size */
var wWidth = $(window).width();
var xWidth = wWidth * 0.8;
//var xWidth = wWidth * 0.95;

var monthNames = ["January", "February", "March", "April", "May", "June",
  "July", "August", "September", "October", "November", "December"
];

function popSaver() {
	$('#popSaver').fadeIn('fast').delay(1000).fadeOut('slow');
}

function stripComma(val) {
	return val.replace(/,/g,"");
}

function kSeparator(val) {
	var val = parseFloat(val);
		val = val.toFixed(2);
	var a = val.split(".");
	var kValue = a[0];
	//if(a[1] == '' || a[1] == 'undefined') { a[1] = '00'; }

	var sRegExp = new RegExp('(-?[0-9]+)([0-9]{3})');
	while(sRegExp.test(kValue)) {
		kValue = kValue.replace(sRegExp, '$1,$2');
	}

	if(a[1] != "") {
		kValue = kValue + "." + a[1]; 
		return kValue;
	} else {
		return kValue + ".00";
	}
}
	
function addCommas(nStr)
{
	nStr += '';
	x = nStr.split('.');
	x1 = x[0];
	x2 = x.length > 1 ? '.' + x[1] : '';
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(x1)) {
		x1 = x1.replace(rgx, '$1' + ',' + '$2');
	}
	return x1 + x2;
}	

function sendErrorMessage(msg) {
	$("#message").html(msg);
	$("#errorMessage").dialog({
		width: 400,
		resizable: false,
		modal: true,
		buttons: {
			"OK": function() { $(this).dialog("close"); }
		}
	})
}

function showLoaderMessage() {
	$("#loaderMessage").dialog({ show: 'fade', width: 480, height: 180, closable: false, modal: true,  open: function(event, ui) {
        $(".ui-dialog-titlebar-close", ui.dialog | ui).hide();
    }});
}

/* Sales */
function showOptions() {
	$("#salesReportMain").dialog({ show: 'fade', title: "Main Menu", width: 960, height: 540, closable: false, modal: true,  open: function(event, ui) {
      
    }});
}

function showItems(icode) {
	var txtHTML = "<iframe id='frmcust' frameborder=0 width='100%' height='100%' src='items.master.php?sid="+Math.random()+"&icode="+icode+"'></iframe>";
	$("#itemlist").html(txtHTML);
	$("#itemlist").dialog({title: "Products & Supplies", width: xWidth, height: 500,resizable: false,  show: 'fade' }).dialogExtend({
		"closable" : true,
	    "maximizable" : false,
	    "minimizable" : true
	});
}

function showItemInfo(rid) {
	var txtHTML = "<iframe id='frmcust' frameborder=0 width='100%' height='100%' src='items.details.php?id="+rid+"&mod=1&sid="+Math.random()+"'></iframe>";
	$("#itemdetails").html(txtHTML);
	$("#itemdetails").dialog({title: "Product Details", width: 1024, height: 480, resizable: false, modal: true, show: 'fade' }).dialogExtend({
		"closable" : true,
		"maximizable" : false,
		"minimizable" : true
	});
}

function showSI() {
	var txtHTML = "<iframe id='frmcust' frameborder=0 width='100%' height='100%' src='si.list.php'></iframe>";
	$("#silist").html(txtHTML);
	$("#silist").dialog({title: "Sales Invoice Summary", width: xWidth, height: 540, resizable: false, show: 'fade' }).dialogExtend({
		"closable" : true,
	    "maximizable" : false,
	    "minimizable" : true
	});
}

function viewSI(docno) {
	var txtHTML = "<iframe id='siFrame' frameborder=0 width='100%' height='100%' src='si.details.php?docno="+docno+"&sid="+Math.random()+"'></iframe>";
	$("#sidetails").html(txtHTML);
	$("#sidetails").dialog({title: "Sales Invoice Details", width: xWidth, height: 600, resizable: true, show: 'fade' }).dialogExtend({
		"closable" : true,
	    "maximizable" : true,
	    "minimizable" : true,
		"maximize": function(event, ui) { 
			$('#siFrame').contents().find('#details').css({"height":"55vh", "overflow-x": "auto"});
		},
		"restore": function(event, ui) { 
			$('#siFrame').contents().find('#details').css({"height":"120px", "overflow-x": "auto"});
		}
	});
}

function printSI(docno,rePrint) {
	var txtHTML = "<iframe id='frmcust' frameborder=0 width='100%' height='100%' src='print/si.print.php?docno="+docno+"&rePrint="+rePrint+"&sid="+Math.random()+"'></iframe>";
	$("#siprint").html(txtHTML);
	$("#siprint").dialog({title: "PRINT >> SALES INVOICE", width: 560, height: 620, resizable: true }).dialogExtend({
		"closable" : true,
	    "maximizable" : true,
	    "minimizable" : true
	});
}

function jumpSIPage(pageNum,stext,sdetails) {
	var txtHTML = "<iframe id='frmcust' frameborder=0 width='100%' height='100%' src='si.list.php?page="+pageNum+"&searchtext="+stext+"&includeDetails="+sdetails+"'></iframe>";
	$("#silist").html(txtHTML);
	$("#silist").dialog({title: "Sales Invoice Summary", width: xWidth, height: 540, resizable: false, show: 'fade' }).dialogExtend({
		"closable" : true,
	    "maximizable" : false,
	    "minimizable" : true
	});
}

function showCR() {
	var txtHTML = "<iframe id='frmcust' frameborder=0 width='100%' height='100%' src='cr.list.php'></iframe>";
	$("#crlist").html(txtHTML);
	$("#crlist").dialog({title: "Collection Receipts Summary", width: xWidth, height: 540, resizable: false }).dialogExtend({
		"closable" : true,
	    "maximizable" : false,
	    "minimizable" : true
	});
}

function viewCR(trans_no) {
	var txtHTML = "<iframe id='crFrame' frameborder=0 width='100%' height='100%' src='cr.details.php?trans_no="+trans_no+"'></iframe>";
	$("#crdetails").html(txtHTML);
	$("#crdetails").dialog({title: "Collection Receipt Details", width: 1200, height: 600, resizable: true }).dialogExtend({
		"closable" : true,
	    "maximizable" : true,
	    "minimizable" : true,
		"maximize": function(event, ui) { 
			$('#crFrame').contents().find('#details').css({"height":"52vh", "overflow-x": "auto"});
		},
		"restore": function(event, ui) { 
			$('#crFrame').contents().find('#details').css({"height":"120px", "overflow-x": "auto"});
		}
	});	
}

function printCR(trans_no,uid,rePrint) {
	var txtHTML = "<iframe id='frmcust' frameborder=0 width='100%' height='100%' src='print/cr.print.php?trans_no="+trans_no+"&rePrint="+rePrint+"&sid="+Math.random()+"&user="+uid+"'></iframe>";
	$("#crprint").html(txtHTML);
	$("#crprint").dialog({title: "PRINT >> COLLECTION RECEIPT", width: 560, height: 620, resizable: true }).dialogExtend({
		"closable" : true,
	    "maximizable" : true,
	    "minimizable" : true
	});
}

function showPOList() {
	var txtHTML = "<iframe id='frmcust' frameborder=0 width='100%' height='100%' src='po.list.php'></iframe>";
	$("#polist").html(txtHTML);
	$("#polist").dialog({title: "Purchase Order Summary", width: xWidth, height: 540, resizable: false, show: 'fade' }).dialogExtend({
		"closable" : true,
	    "maximizable" : false,
	    "minimizable" : true
	});
}

function viewPO(po_no) {
	var txtHTML = "<iframe id='frmcust' frameborder=0 width='100%' height='100%' src='po.details.php?po_no="+po_no+"'></iframe>";
	$("#podetails").html(txtHTML);
	$("#podetails").dialog({title: "Purchase Order Details", width: xWidth, height: 540, resizable: true, show: 'fade' }).dialogExtend({
		"closable" : true,
	    "maximizable" : false,
	    "minimizable" : true
	});
}

function printPO(po_no,uid,rePrint) {
	var txtHTML = "<iframe id='frmcust' frameborder=0 width='100%' height='100%' src='print/po.print.php?po_no="+po_no+"&rePrint="+rePrint+"&sid="+Math.random()+"&user="+uid+"'></iframe>";
	$("#poprint").html(txtHTML);
	$("#poprint").dialog({title: "PRINT >> PURCHASE ORDER", width: 560, height: 620, resizable: true, show: 'fade' }).dialogExtend({
		"closable" : true,
	    "maximizable" : true,
	    "minimizable" : true
	});
}

function showRRList() {
	var txtHTML = "<iframe id='frmcust' frameborder=0 width='100%' height='100%' src='rr.list.php'></iframe>";
	$("#rrlist").html(txtHTML);
	$("#rrlist").dialog({title: "Receiving Report Summary", width: xWidth, height: 540, resizable: false, show: 'fade' }).dialogExtend({
		"closable" : true,
	    "maximizable" : false,
	    "minimizable" : true
	});
}

function viewRR(rr_no) {
	var txtHTML = "<iframe id='frmcust' frameborder=0 width='100%' height='100%' src='rr.details.php?rr_no="+rr_no+"'></iframe>";
	$("#rrdetails").html(txtHTML);
	$("#rrdetails").dialog({title: "Receiving Report Details", width: xWidth, height: 560, resizable: true, show: 'fade' }).dialogExtend({
		"closable" : true,
	    "maximizable" : false,
	    "minimizable" : true
	});
}
function jumpRRPage(pageNum,stext,sdetails) {
	var txtHTML = "<iframe id='frmcust' frameborder=0 width='100%' height='100%' src='rr.list.php?page="+pageNum+"&searchtext="+stext+"&includeDetails="+sdetails+"'></iframe>";
	$("#rrlist").html(txtHTML);
	$("#rrlist").dialog({title: "Receiving Report Summary", width: xWidth, height: 540, resizable: false, show: 'fade' }).dialogExtend({
		"closable" : true,
	    "maximizable" : false,
	    "minimizable" : true
	});
}

function printRR(rr_no,uid,rePrint) {
	var txtHTML = "<iframe id='frmcust' frameborder=0 width='100%' height='100%' src='print/rr.print.php?rr_no="+rr_no+"&rePrint="+rePrint+"&sid="+Math.random()+"&user="+uid+"'></iframe>";
	$("#rrprint").html(txtHTML);
	$("#rrprint").dialog({title: "PRINT >> RECEIVING REPORT", width: 560, height: 620, resizable: true, show: 'fade' }).dialogExtend({
		"closable" : true,
	    "maximizable" : true,
	    "minimizable" : true
	});
}

function showSW() {
	var txtHTML = "<iframe id='frmcust' frameborder=0 width='100%' height='100%' src='sw.list.php'></iframe>";
	$("#swlist").html(txtHTML);
	$("#swlist").dialog({title: "Stocks Withdrawal Slip Summary", width: xWidth, height: 540, resizable: false, show: 'fade' }).dialogExtend({
		"closable" : true,
	    "maximizable" : false,
	    "minimizable" : true
	});
}

function viewSW(sw_no) {
	var txtHTML = "<iframe id='frmcust' frameborder=0 width='100%' height='100%' src='sw.details.php?sw_no="+sw_no+"'></iframe>";
	$("#swdetails").html(txtHTML);
	$("#swdetails").dialog({title: "Stocks Withdrawal Slip Details", width: xWidth, height: 560, resizable: true, show: 'fade' }).dialogExtend({
		"closable" : true,
	    "maximizable" : false,
	    "minimizable" : true
	});
}

function printSW(sw_no,uid,rePrint) {
	var txtHTML = "<iframe id='frmcust' frameborder=0 width='100%' height='100%' src='print/sw.print.php?sw_no="+sw_no+"&uid="+uid+"&rePrint="+rePrint+"&sid="+Math.random()+"'></iframe>";
	$("#srrprint").html(txtHTML);
	$("#srrprint").dialog({title: "PRINT >> STOCKS WITHDRAWAL SLIP", width: 560, height: 620, resizable: true, show: 'fade' }).dialogExtend({
		"closable" : true,
	    "maximizable" : true,
	    "minimizable" : true
	});
}

function showSRR() {
	var txtHTML = "<iframe id='frmcust' frameborder=0 width='100%' height='100%' src='srr.list.php'></iframe>";
	$("#srrlist").html(txtHTML);
	$("#srrlist").dialog({title: "Stocks Receiving Slip Summary", width: xWidth, height: 540, resizable: false }).dialogExtend({
		"closable" : true,
	    "maximizable" : false,
	    "minimizable" : true
	});
}

function viewSRR(srr_no) {
	var txtHTML = "<iframe id='siFrame' frameborder=0 width='100%' height='100%' src='srr.details.php?srr_no="+srr_no+"'></iframe>";
	$("#srrdetails").html(txtHTML);
	$("#srrdetails").dialog({title: "Stocks Receiving Slip Details", width: 960, height: 560, resizable: true }).dialogExtend({
		"closable" : true,
	    "maximizable" : true,
	    "minimizable" : true,
		"maximize": function(event, ui) { 
			$('#siFrame').contents().find('#details').css({"height":"47vh", "overflow-x": "auto"});
		},
		"restore": function(event, ui) { 
			$('#siFrame').contents().find('#details').css({"height":"160px", "overflow-x": "auto"});
		}
	});
}

function jumpSRRPage(pageNum,stext,sdetails) {
	var txtHTML = "<iframe id='frmcust' frameborder=0 width='100%' height='100%' src='srr.list.php?page="+pageNum+"&searchtext="+stext+"&includeDetails="+sdetails+"'></iframe>";
	$("#srrlist").html(txtHTML);
	$("#srrlist").dialog({title: "Stocks Receiving Slip Summary", width: xWidth, height: 540, resizable: false }).dialogExtend({
		"closable" : true,
	    "maximizable" : false,
	    "minimizable" : true
	});
}

function printSRR(srr_no,uid,rePrint) {
	var txtHTML = "<iframe id='frmcust' frameborder=0 width='100%' height='100%' src='print/srr.print.php?srr_no="+srr_no+"&uid="+uid+"&rePrint="+rePrint+"&sid="+Math.random()+"'></iframe>";
	$("#srrprint").html(txtHTML);
	$("#srrprint").dialog({title: "PRINT >> STOCKS RECEIVING SLIP", width: 560, height: 620, resizable: true }).dialogExtend({
		"closable" : true,
	    "maximizable" : true,
	    "minimizable" : true
	});
}

function showPCV() {
	var txtHTML = "<iframe id='frmcust' frameborder=0 width='100%' height='100%' src='pcv.list.php'></iframe>";
	$("#pcvlist").html(txtHTML);
	$("#pcvlist").dialog({title: "Petty Cash Voucher", width: xWidth, height: 540, resizable: false }).dialogExtend({
		"closable" : true,
	    "maximizable" : false,
	    "minimizable" : true
	});
}

function viewPCV(pcv_no) {
	var txtHTML = "<iframe id='frmcust' frameborder=0 width='100%' height='100%' src='pcv.details.php?pcv_no="+pcv_no+"'></iframe>";
	$("#pcvdetails").html(txtHTML);
	$("#pcvdetails").dialog({title: "Petty Cash Voucher", width: 960, height: 400, resizable: true }).dialogExtend({
		"closable" : true,
	    "maximizable" : true,
	    "minimizable" : true
	});
}


/* REPORTS */

function showDSCR() {
	$("#sinq_date").datepicker();
	$("#salesinquiry").dialog({
		title: "Daily Sales & Collection Report", 
		width: 400,
		buttons: {
			"Generate Report": function() {
				var txtHTML = "<iframe id='frmcust' frameborder=0 width='100%' height='100%' src='reports/dscr.php?date="+$("#sinq_date").val()+"&branch="+$("#sinq_branch").val()+"&sid="+Math.random()+"'></iframe>";
				$("#report3").html(txtHTML);
				$("#report3").dialog({title: "Daily Sales & Collection Report", width: 560, height: 620, resizable: true }).dialogExtend({
					"closable" : true,
					"maximizable" : true,
					"minimizable" : true
				});
			},
			"Close": function() { 
				$(this).dialog("close");
			}
		}
	});
}

function generateInquiry() {
	var txtHTML = "<iframe id='frmcust' frameborder=0 width='100%' height='100%' src='reports/dscr.php?date="+$("#sinq_date").val()+"&branch="+$("#sinq_branch").val()+"&sid="+Math.random()+"'></iframe>";
	$("#report3").html(txtHTML);
	$("#report3").dialog({title: "Daily Sales & Collection Report", width: 560, height: 620, resizable: true }).dialogExtend({
		"closable" : true,
		"maximizable" : true,
		"minimizable" : true
	});
}

function showSalesReport() {

	$("#ds_dtf").datepicker({ changeMonth: true, changeYear: true });
	$("#ds_dt2").datepicker({ changeMonth: true, changeYear: true });

	$("#dailySales").dialog({
		title: "Sales Report",
		width: 400,
		resizable: false,
		modal: true,
		buttons: {
			"Generate Report": function() { 
				var txtHTML = "<iframe id='frmSalesReport' frameborder=0 width='100%' height='100%' src='reports/salesreport.php?dtf="+$("#ds_dtf").val()+"&dt2="+$("#ds_dt2").val()+"&group="+$("#ds_group").val()+"&desc="+$("#ds_desc").val()+"&sid="+Math.random()+"'></iframe>";
				$("#report1").html(txtHTML);
				$("#report1").dialog({title: "Sales Report", width: 560, height: 620, resizable: true }).dialogExtend({
					"closable" : true,
					"maximizable" : true,
					"minimizable" : true
				});
			},
			"Export Report to Excel": function() {
				window.open("export/salesreport.php?group="+$("#ds_group").val()+"&dtf="+$("#ds_dtf").val()+"&dt2="+$("#ds_dt2").val()+"&sid="+Math.random()+"","Sales Report","location=1,status=1,scrollbars=1,width=640,height=720");
				
			}
		}
	});
}

function showInventoryReport() {

	$("#ir_dtf").datepicker({ changeMonth: true, changeYear: true });
	$("#ir_dt2").datepicker({ changeMonth: true, changeYear: true });

	$("#inventoryReport").dialog({
		title: "Inventory Report",
		width: 400,
		resizable: false,
		modal: true,
		buttons: {
			"Generate Report in Excel": function() {
				window.open("export/ibook.php?group="+$("#ir_group").val()+"&dtf="+$("#ir_dtf").val()+"&dt2="+$("#ir_dt2").val()+"&sid="+Math.random()+"","Inventory Book","location=1,status=1,scrollbars=1,width=640,height=720");
			}
		}
	});
}

function showAR() {

	$("#ar_asof").datepicker({ changeMonth: true, changeYear: true });

	$("#arSummary").dialog({
		title: "Accounts Receivable Summary",
		width: 400,
		resizable: false,
		modal: true,
		buttons: {
			"Generate Report": function() {
				var txtHTML = "<iframe id='frmGrossProfitSales' frameborder=0 width='100%' height='100%' src='reports/ar_summary.php?cid="+$("#ar_customer").val()+"&asof="+$("#ar_asof").val()+"&sid="+Math.random()+"'></iframe>";
				$("#report2").html(txtHTML);
				$("#report2").dialog({title: "Gross Profit Report", width: 560, height: 620, resizable: true }).dialogExtend({
					"closable" : true,
					"maximizable" : true,
					"minimizable" : true
				});

			}
		}
	});
}

function showGrossProfitSales() {

	$("#gps_dtf").datepicker({ changeMonth: true, changeYear: true });
	$("#gps_dt2").datepicker({ changeMonth: true, changeYear: true });

	$("#grossProfitSales").dialog({
		title: "Gross Profit Sales Report",
		width: 400,
		resizable: false,
		modal: true,
		buttons: {
			"Generate Report": function() {
				var txtHTML = "<iframe id='frmGrossProfitSales' frameborder=0 width='100%' height='100%' src='reports/grossprofitsales.php?dtf="+$("#gps_dtf").val()+"&dt2="+$("#gps_dt2").val()+"&group="+$("#gps_group").val()+"&sid="+Math.random()+"'></iframe>";
				$("#report2").html(txtHTML);
				$("#report2").dialog({title: "Gross Profit Report", width: 560, height: 620, resizable: true }).dialogExtend({
					"closable" : true,
					"maximizable" : true,
					"minimizable" : true
				});


			 },
			 "Export Report to Excel": function() {
				window.open("export/grossprofitsales.php?group="+$("#gps_group").val()+"&dtf="+$("#gps_dtf").val()+"&dt2="+$("#gps_dt2").val()+"&sid="+Math.random()+"","Gross Profit Sales","location=1,status=1,scrollbars=1,width=640,height=720");
				
			}
		}
	});
}

function showReceiveSummary() {

	$("#grs_dtf").datepicker({ changeMonth: true, changeYear: true });
	$("#grs_dt2").datepicker({ changeMonth: true, changeYear: true });

	$("#goodsReceivedSummary").dialog({
		title: "Summary of Goods Received",
		width: 400,
		resizable: false,
		modal: true,
		buttons: {
			"Generate Report": function() { }
		}
	});
}

function showWithdrawalReport() {

	$("#gws_dtf").datepicker({ changeMonth: true, changeYear: true });
	$("#gws_dt2").datepicker({ changeMonth: true, changeYear: true });

	$("#goodsWithdrawnSummary").dialog({
		title: "Summary of Goods Withdrawn",
		width: 400,
		resizable: false,
		modal: true,
		buttons: {
			"Generate Report": function() { }
		}
	});
}

function showInventoryStockcard(itemCode) {
	var txtHTML = "<iframe id='frmcust' frameborder=0 width='100%' height='100%' src='stockcard.php?item_code="+itemCode+"'></iframe>";
	$("#customerlist").html(txtHTML);
	$("#customerlist").dialog({title: "Item Inventory Stockcard", width: xWidth, height: 540,resizable: false, show: 'fade' }).dialogExtend({
		"closable" : true,
	    "maximizable" : false,
	    "minimizable" : true
	});
}

function showPettyCashSummary() {
	$("#pcs_dtf").datepicker(); $("#pcs_dt2").datepicker();
	$("#pettyCashSummary").dialog({
		title: "Petty Cash Voucher Summary", 
		width: 400,
		resizable: false,
		modal: false,
		buttons: {
			"Generate Report": function() {
				var txtHTML = "<iframe id='frmglsched' frameborder=0 width='100%' height='100%' src='reports/pettycashsummary.php?dtf="+$("#pcs_dtf").val()+"&dt2="+$("#pcs_dt2").val()+"&payee="+$("#pcs_name").val()+"&type="+$("#pcs_type").val()+"&sid="+Math.random()+"'></iframe>";
				$("#report6").html(txtHTML);
				$("#report6").dialog({title: "Petty Cash Voucher Summary", width: 560, height: 620, resizable: true }).dialogExtend({
					"closable" : true,
					"maximizable" : true,
					"minimizable" : true
				});
			 },
			 "Export Report to Excel": function() {
				window.open("export/pettycashsummary.php?dtf="+$("#pcs_dtf").val()+"&dt2="+$("#pcs_dt2").val()+"&payee="+$("#pcs_name").val()+"&type="+$("#pcs_type").val()+"&sid="+Math.random()+"","PCV Summary","location=1,status=1,scrollbars=1,width=640,height=720");
			}
			
			
		}
	});
}

/* Tools & Others Modules */

function showCust(mod) {
	var txtHTML = "<iframe id='frmcust' frameborder=0 width='100%' height='100%' src='contact.master.php?mod="+mod+"'></iframe>";
	$("#customerlist").html(txtHTML);
	$("#customerlist").dialog({title: "Address Book", width: xWidth, height: 540,resizable: false, show: 'fade' }).dialogExtend({
		"closable" : true,
	    "maximizable" : false,
	    "minimizable" : true
	});
}

function addPayee() {
	var txtHTML = "<iframe id='frmcust' frameborder=0 width='100%' height='100%' src='contact.details.php?mod=1'></iframe>";
	$("#customerdetails").html(txtHTML);
	$("#customerdetails").dialog({title: "Payees & Suppliers", width: 1024, height: 520,resizable: false, show: 'fade', modal: true }).dialogExtend({
		"closable" : true,
	    "maximizable" : false,
	    "minimizable" : true
	});
}

function showPayeeInfo(fid) {
	var txtHTML = "<iframe id='frmcust' frameborder=0 width='100%' height='100%' src='contact.details.php?fid="+fid+"&mod=1&sid="+Math.random()+"'></iframe>";
	$("#customerdetails").html(txtHTML);
	$("#customerdetails").dialog({title: "Payee/Supplier Info", width: 1024, height: 520, resizable: false, show: 'fade', modal: true }).dialogExtend({
		"closable" : true,
	    "maximizable" : false,
	    "minimizable" : true
	});
}

function showUsers() {
	var txtHTML = "<iframe id='frmcust' frameborder=0 width='100%' height='100%' src='user.master.php'></iframe>";
	$("#userlist").html(txtHTML);
	$("#userlist").dialog({title: "System Users", width: xWidth, height: 540, resizable: false, show: 'fade' }).dialogExtend({
		"closable" : true,
	    "maximizable" : false,
	    "minimizable" : true
	});
}

function showChangePass() {
	$("#userChangePass").dialog({ title: "Update Password", width: 480, height: 190, resizable: false, modal: true, show: 'fade', buttons: {
					"Update my Password": function() {
						var msg = "";

						if($("#pass1").val() == "" || $("#pass2").val() == "") { msg = msg + "The system cannot accept empty password.<br/>"; }
						if($("#pass1").val() != $("#pass2").val()) { msg = msg + "New Passwords do not match.<br/>"; }
					
						if(msg!="") {
							sendErrorMessage(msg);
						} else {

							$.post("src/sjerp.php", { mod: "changePassword", uid:  $("#myUID").val(), pass: $("#pass1").val(), sid: Math.random() },function() {
								alert("You have successfully updated your password!");
								$("#userChangePass").dialog("close");
							});
						}
					},
					"Continue with the System": function () { $(this).dialog("close"); }
				} }).dialogExtend({
		"closable" : true,
	    "maximizable" : false,
	    "minimizable" : true,
	});
}

function addUser() {
	var txtHTML = "<iframe id='frmcust' frameborder=0 width='100%' height='100%' src='user.details.php'></iframe>";
	$("#userdetails").html(txtHTML);
	$("#userdetails").dialog({title: "System User Info.", width: 400, height: 350, resizable: false, show: 'fade' }).dialogExtend({
		"closable" : true,
	    "maximizable" : false,
	    "minimizable" : true,
	});
}

function viewUserInfo(eid) {
	var txtHTML = "<iframe id='frmcust' frameborder=0 width='100%' height='100%' src='user.update.php?eid="+eid+"'></iframe>";
	$("#userdetails").html(txtHTML);
	$("#userdetails").dialog({title: "System User Info.", width: 400, height: 260, resizable: false, show: 'fade' }).dialogExtend({
		"closable" : true,
	    "maximizable" : false,
	    "minimizable" : true,
	});
}

function showChangePass() {
	var txtHTML = "<iframe id='frmcust' frameborder=0 width='100%' height='100%' src='user.changepass.php'></iframe>";
	$("#changepass").html(txtHTML);
	$("#changepass").dialog({title: "Update Password", width: 480, height: 190, resizable: false }).dialogExtend({
		"closable" : true,
	    "maximizable" : false,
	    "minimizable" : true,
	});
}