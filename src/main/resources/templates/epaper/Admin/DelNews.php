<?php
session_start();
header("Content-type: text/html; charset=gb2312");
include_once("../config.php");
if(($_SESSION['Admin']=="") or ($_SESSION['AdminSessionPWd']!= AdminSession or $_SESSION["login"] != true)){
	MessageBox("����Ƿ���¼��лл��","index.php");
}else{
	$ID=Inject_Check($_GET['ID']);
	$MySql="Select * From `FangBao_News` Where `ID`=".$ID;
	$Rs=mysql_fetch_array(mysql_query($MySql));
	$HtmlFiles="../html/".$Rs[PublishDate]."/".$ID.".html";
	if(file_exists($HtmlFiles)){
		unlink ($HtmlFiles);
	}
	$MyNewssql="Delete From `FangBao_News` Where `ID`=".$ID;
	mysql_query($MyNewssql);
	AdminLog("�û�Ϊ".$_SESSION['Admin']."ɾ����һ��IDΪ��".$ID."������",0);
	$MyPingLunsql="Delete From `FangBao_Pinglun` Where `ID`=".$ID;
	mysql_query($MyPingLunsql);
	AdminLog("�û�Ϊ".$_SESSION['Admin']."��ɾ������ʱɾ����IDΪ��".$ID."������",0);
	MessageBox("����ɾ���ɹ���","NewsManage.php");
}
?>