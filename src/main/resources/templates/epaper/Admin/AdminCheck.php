<?php
session_start();
header("Content-type: text/html; charset=gb2312");
include_once("../config.php");
$Admin=Inject_Check(htmlspecialchars(trim($_POST['Admin'])));
$Yzm=Inject_Check(htmlspecialchars(trim($_POST['Yzm'])));
$PassWord=Inject_Check(md5(trim($_POST['PassWord'])));
if($Yzm==$_SESSION["randcode"]){
	$Sql="Select * From `FangBao_Admin` Where `Admin`='".$Admin."' And `PassWord`='".$PassWord."'";
	$result=mysql_query($Sql);
	if ($Rs=mysql_fetch_array($result)){
		AdminLog("用户为".$Admin."的用户成功登录系统",1);
		$_SESSION['Admin']=$Rs[Admin];
		$_SESSION["AdminSessionPWd"] = AdminSession;
		$_SESSION["login"] = true;
		$_SESSION["logins"] = $Yzm;	   
		echo "<script language=\"javascript\">location.href='Manage.php';</script>";
	}else{
		  AdminLog("错误的用户名或密码，想用".$Admin."非法登录系统",1);
		  MessageBox("用户名或密码不正确，请勿非法操作！","index.php");
	}
	mysql_close();
}else{
	MessageBox("验证码不正确！","index.php");
}
?>