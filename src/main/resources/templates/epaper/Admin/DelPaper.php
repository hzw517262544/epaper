<?php
session_start();
header("Content-type: text/html; charset=gb2312");
include_once("../config.php");
if(($_SESSION['Admin']=="") or ($_SESSION['AdminSessionPWd']!= AdminSession or $_SESSION["login"] != true)){
	MessageBox("请勿非法登录，谢谢！","index.php");
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
	AdminLog("用户为".$_SESSION['Admin']."在删除".$PublishDate."发刊的报刊的".$VerOrder."",0);
	$MyNewssql="Delete From `FangBao_News` Where `VerOrderID`=".$ID;
	mysql_query($MyNewssql);
	AdminLog("用户为".$_SESSION['Admin']."在删除".$PublishDate."发刊的报刊的".$VerOrder."时删除该版面的所有新闻",0);
	$MyPingLunsql="Delete From `FangBao_Pinglun` Where `VerOrderID`=".$ID;
	mysql_query($MyPingLunsql);
	AdminLog("用户为".$_SESSION['Admin']."在删除".$PublishDate."发刊的报刊的".$VerOrder."时删除该版面的所有新闻的评论",0);
	MessageBox("期刊数据删除成功！","HotManage.php");
}
?>