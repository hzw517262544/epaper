<?php
session_start();
header("Content-type: text/html; charset=gb2312");
include_once("../config.php");
if(($_SESSION['Admin']=="") or ($_SESSION['AdminSessionPWd']!= AdminSession or $_SESSION["login"] != true)){
	MessageBox("����Ƿ���¼��лл��","index.php");
}else{
	$IsShow=Inject_Check($_GET['IsShow']);
	$PingLunID=Inject_Check($_GET['PingLunID']);
	if($IsShow==0){
		$text="�ر�";
	}else{
		$text="��ʾ";
	}
	if($IsShow<>""){
		mysql_query("Update `FangBao_PingLun` Set `IsShow`=".$IsShow." Where PingLunID=".$PingLunID);
		AdminLog("�û�Ϊ".$_SESSION['Admin']."�����һ��IDΪ��".$PingLunID."������",0);
		MessageBox($text."���۳ɹ���","Comment.php");
	}else{
		$PingLunsql="Delete From `FangBao_PingLun` Where PingLunID=".$PingLunID;
		mysql_query($PingLunsql);
		AdminLog("�û�Ϊ".$_SESSION['Admin']."ɾ����һ��IDΪ��".$PingLunID."������",0);
		MessageBox("����ɾ���ɹ���","Comment.php");
	}
}
?>