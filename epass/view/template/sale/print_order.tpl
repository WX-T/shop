<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>面单打印</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <script type="text/javascript" src="view/javascript/CreateControl.js"></script>
	<script type="text/javascript" src="view/javascript/GRInstall.js"></script>
    <style type="text/css">
        html,body {
            margin:0;
            height:100%;
        }
    </style>
</head>
<body style="margin:0">

<script type="text/javascript"> 

CreatePrintViewerEx("100%", "100%", "view/javascript/6h.grf","<?php echo $xmlUrl?>/index.php?route=common/printxml&order_ids=<?php echo $order_ids;?>&token=<?php echo $token; ?>", true, "");
Install_InsertReport();
   var Installed = Install_Detect();
   Report = document.getElementById("_ReportOK");
   Report.LoadFromURL("/Content/Report/ExpressWellWinReport.grf");
   Report.LoadDataFromURL("/data/xmlReportWeight.aspx?headGuid="+headGuid);
   Report.Print(true);



</script>
</body>
</html>