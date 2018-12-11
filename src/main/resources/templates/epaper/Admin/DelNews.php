<?php
session_start();
header("Content-type: text/html; charset=gb2312");
include_once("../config.php");
if(($_SESSION['Admin']=="") or ($_SESSION['AdminSessionPWd']!= AdminSession or $_SESSION["login"] != true)){
	MessageBox("请勿非法登录，谢谢！","index.php");
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
	AdminLog("用户为".$_SESSION['Admin']."删除了一条ID为：".$ID."的新闻",0);
	$MyPingLunsql="Delete From `FangBao_Pinglun` Where `ID`=".$ID;
	mysql_query($MyPingLunsql);
	AdminLog("用户为".$_SESSION['Admin']."在删除新闻时删除了ID为：".$ID."的评论",0);
	MessageBox("文章删除成功！","NewsManage.php");
}
?>