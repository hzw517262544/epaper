<?php
include_once("../../config.php");
//========================把日期写入JS中============================
function GhostPhp_JS(){
   	$MySql="Select * From FangBao_Paper Order By PublishID Asc";
   	$Result=mysql_query($MySql);
   	while($Rs=mysql_fetch_array($Result)){
      echo $Rs[PublishDate]."|";
	}
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<link rel="stylesheet" type="text/css" href="../../Images/calendar.css">
<script src="../../GhostJS/GhostDate.js" language="Javascript"></script>
<script src="../../GhostJS/dyCalendar.js" language="Javascript"></script>
<title>日期查阅</title>
</head>
<body onLoad="calendarInit();">
<input id="hidden_dates" name="hidden_dates" value="<? GhostPhp_JS()?>" type="hidden" />
<div id="calendar" class="calendar"></div>
</body>
</html>