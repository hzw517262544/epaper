<?php
session_start();
header("Content-type: text/html; charset=gb2312");
include_once("../config.php");
if(($_SESSION['Admin']=="") or ($_SESSION['AdminSessionPWd']!= AdminSession or $_SESSION["login"] != true)){
	MessageBox("请勿非法登录，谢谢！","index.php");
}else{
	$IsShow=Inject_Check($_GET['IsShow']);
	$PingLunID=Inject_Check($_GET['PingLunID']);
	if($IsShow==0){
		$text="关闭";
	}else{
		$text="显示";
	}
	if($IsShow<>""){
		mysql_query("Update `FangBao_PingLun` Set `IsShow`=".$IsShow." Where PingLunID=".$PingLunID);
		AdminLog("用户为".$_SESSION['Admin']."审核了一条ID为：".$PingLunID."的评论",0);
		MessageBox($text."评论成功！","Comment.php");
	}else{
		$PingLunsql="Delete From `FangBao_PingLun` Where PingLunID=".$PingLunID;
		mysql_query($PingLunsql);
		AdminLog("用户为".$_SESSION['Admin']."删除了一条ID为：".$PingLunID."的评论",0);
		MessageBox("评论删除成功！","Comment.php");
	}
}
?>