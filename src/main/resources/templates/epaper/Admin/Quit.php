<?php
	session_start();
	header("Content-type: text/html; charset=gb2312");
	include_once("../config.php");
	AdminLog("用户为".$_SESSION['Admin']."成功退出了后台",1);	
	$_SESSION['Admin']="";
	$_SESSION["login"]= false;
	$_SESSION["AdminSessionPWd"] = "";
	MessageBox("成功退出后台，感谢您的使用！","index.php");
?>