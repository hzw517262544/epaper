<?php
session_start();
header("Content-type: text/html; charset=gb2312");
include_once("../config.php");
if(($_SESSION['Admin']=="") or ($_SESSION['AdminSessionPWd']!= AdminSession or $_SESSION["login"] != true)){
	MessageBox("����Ƿ���¼��лл��","index.php");
}else{
	$PublishDate=Inject_Check($_GET['PublishDate']);
	$FilePath="../html/".$PublishDate."";
	DelFolder($FilePath);
	$MyPublishDatesql="Delete From `FangBao_Paper` Where `PublishDate`='".$PublishDate."'";
	mysql_query($MyPublishDatesql);
	AdminLog("�û�Ϊ".$_SESSION['Admin']."ɾ����".$PublishDate."�����ı���",0);
	$tMySql="Select * From `FangBao_Rect` Where `PublishDate`='".$PublishDate."'";
	$tResult=mysql_query($tMySql);
	while ($tRs=mysql_fetch_array($tResult)){
		$MyPingLunsql="Delete From `FangBao_Pinglun` Where `VerOrderID`=".$tRs[ID];
		mysql_query($MyPingLunsql);
	}
	AdminLog("�û�Ϊ".$_SESSION['Admin']."��ɾ��".$PublishDate."�����ı���ʱɾ���ñ������������ŵ��������",0);
	$MySmallClasssql="Delete From `FangBao_Rect` Where `PublishDate`='".$PublishDate."'";
	mysql_query($MySmallClasssql);
	AdminLog("�û�Ϊ".$_SESSION['Admin']."��ɾ��".$PublishDate."�����ı���ʱɾ���ñ��������а���",0);
	$MyNewssql="Delete From `FangBao_News` Where `PublishDate`='".$PublishDate."'";
	mysql_query($MyNewssql);
	AdminLog("�û�Ϊ".$_SESSION['Admin']."��ɾ��".$PublishDate."�����ı���ʱɾ���ñ�������������",0);
	MessageBox("�ڿ�����ɾ���ɹ���","HotManage.php");
}
?>