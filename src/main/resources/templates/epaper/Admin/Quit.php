<?php
	session_start();
	header("Content-type: text/html; charset=gb2312");
	include_once("../config.php");
	AdminLog("�û�Ϊ".$_SESSION['Admin']."�ɹ��˳��˺�̨",1);	
	$_SESSION['Admin']="";
	$_SESSION["login"]= false;
	$_SESSION["AdminSessionPWd"] = "";
	MessageBox("�ɹ��˳���̨����л����ʹ�ã�","index.php");
?>