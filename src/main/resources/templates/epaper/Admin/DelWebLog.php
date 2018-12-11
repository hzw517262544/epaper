<?php
session_start();
header("Content-type: text/html; charset=gb2312");
include_once("../config.php");
if(($_SESSION['Admin']=="") or ($_SESSION['AdminSessionPWd']!= AdminSession or $_SESSION["login"] != true)){
	MessageBox("请勿非法登录，谢谢！","index.php");
}else{
	$LogType= Inject_Check($_GET['LogType']);
	$MyNewssql="Delete From FangBao_Log Where LogType=".$LogType."";
	mysql_query($MyNewssql);
	if($LogType=='1'){
		$Type="安全日志";
	}elseif($LogType=='0'){
		$Type="操作日志";
	}
    MessageBox("日志全部删除成功！","WeblaborLog.php?LogType=".$LogType."");
    AdminLog("用户为".$_SESSION['Admin']."删除了所有".$Type."！",0);
}
?>