<?php
session_start();
header("Content-type: text/html; charset=gb2312");
include_once("../config.php");
if(($_SESSION['Admin']=="") or ($_SESSION['AdminSessionPWd']!= AdminSession or $_SESSION["login"] != true)){
	MessageBox("����Ƿ���¼��лл��","index.php");
}else{
	$PublishDate   = Inject_Check($_GET['PublishDate']);
	$ID            = Inject_Check(intval($_GET['ID']));
	$MySql="Select * From `FangBao_Rect` Where `ID`=".$ID;
	$Rs=mysql_fetch_array(mysql_query($MySql));
	$IsFrist = $Rs[IsFrist];
	if ($IsFrist=='1'){
		$HtmlFiles = "../html/".$PublishDate."/qpaper.html";
	}else{
		$HtmlFiles = "../html/".$PublishDate."/qpaper_".$ID.".Html";
	}
	if(file_exists($HtmlFiles)){
		unlink ($HtmlFiles);
	}
	$oMySql="Select * From `FangBao_News` Where `VerOrderID`=".$ID;
	$oResult=mysql_query($oMySql);
	while ($oRs=mysql_fetch_array($oResult)){
		$HtmlFiles="../html/".$PublishDate."/".$oRs[ID].".html";
		if(file_exists($HtmlFiles)){
			unlink ($HtmlFiles);
		}
	}
	$MySmallClasssql="Delete From `FangBao_Rect` Where `ID`=".$ID;
	mysql_query($MySmallClasssql);
	AdminLog("�û�Ϊ".$_SESSION['Admin']."��ɾ��".$PublishDate."�����ı�����".$VerOrder."",0);
	$MyNewssql="Delete From `FangBao_News` Where `VerOrderID`=".$ID;
	mysql_query($MyNewssql);
	AdminLog("�û�Ϊ".$_SESSION['Admin']."��ɾ��".$PublishDate."�����ı�����".$VerOrder."ʱɾ���ð������������",0);
	$MyPingLunsql="Delete From `FangBao_Pinglun` Where `VerOrderID`=".$ID;
	mysql_query($MyPingLunsql);
	AdminLog("�û�Ϊ".$_SESSION['Admin']."��ɾ��".$PublishDate."�����ı�����".$VerOrder."ʱɾ���ð�����������ŵ�����",0);
	MessageBox("�ڿ�����ɾ���ɹ���","HotManage.php");
}
?>