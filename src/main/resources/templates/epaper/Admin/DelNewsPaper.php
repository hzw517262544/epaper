<?php
session_start();
header("Content-type: text/html; charset=gb2312");
include_once("../config.php");
if(($_SESSION['Admin']=="") or ($_SESSION['AdminSessionPWd']!= AdminSession or $_SESSION["login"] != true)){
	MessageBox("请勿非法登录，谢谢！","index.php");
}else{
	$PublishDate=Inject_Check($_GET['PublishDate']);
	$FilePath="../html/".$PublishDate."";
	DelFolder($FilePath);
	$MyPublishDatesql="Delete From `FangBao_Paper` Where `PublishDate`='".$PublishDate."'";
	mysql_query($MyPublishDatesql);
	AdminLog("用户为".$_SESSION['Admin']."删除了".$PublishDate."发刊的报刊",0);
	$tMySql="Select * From `FangBao_Rect` Where `PublishDate`='".$PublishDate."'";
	$tResult=mysql_query($tMySql);
	while ($tRs=mysql_fetch_array($tResult)){
		$MyPingLunsql="Delete From `FangBao_Pinglun` Where `VerOrderID`=".$tRs[ID];
		mysql_query($MyPingLunsql);
	}
	AdminLog("用户为".$_SESSION['Admin']."在删除".$PublishDate."发刊的报刊时删除该报刊的所有新闻的相关评论",0);
	$MySmallClasssql="Delete From `FangBao_Rect` Where `PublishDate`='".$PublishDate."'";
	mysql_query($MySmallClasssql);
	AdminLog("用户为".$_SESSION['Admin']."在删除".$PublishDate."发刊的报刊时删除该报刊的所有版面",0);
	$MyNewssql="Delete From `FangBao_News` Where `PublishDate`='".$PublishDate."'";
	mysql_query($MyNewssql);
	AdminLog("用户为".$_SESSION['Admin']."在删除".$PublishDate."发刊的报刊时删除该报刊的所有新闻",0);
	MessageBox("期刊数据删除成功！","HotManage.php");
}
?>