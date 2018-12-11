<?php
session_start();
include_once("CreatePageHtml.php");
if(($_SESSION['Admin']=="") or ($_SESSION['AdminSessionPWd']!= AdminSession or $_SESSION["login"] != true)){
	MessageBox("请勿非法登录，谢谢！","index.php");
}else{
	$action       = Inject_Check($_GET['action']);
	$ID           = Inject_Check($_GET['ID']);
	$RectID       = Inject_Check($_GET['RectID']);
	$VerOrder     = Inject_Check($_GET['VerOrder']);
	$PublishDate  = Inject_Check($_GET['PublishDate']);
	switch ($action) {
		Case "List_Html":
            create_review_html();
			create_date_html();
			create_qpaper_html($RectID);
			create_news_html_rect($PublishDate,$VerOrder);
			break;
		Case "Page_Html":
			create_news_html($ID);
			break;
		Case "All_Html":
            create_review_html();
			create_date_html();
			create_qpaper_all_html($PublishDate);
			create_news_html_rectall($PublishDate);
			break;
	}
    MessageBox("恭喜您，生成成功！","HotManage.php");
}
?>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-color: #F8F9FA;
	font-size:12px;
}
-->
</style>
<script language="javascript">
parent.pre_ok=true;
</script>