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
		AdminLog("�û�Ϊ".$Admin."���û��ɹ���¼ϵͳ",1);
		$_SESSION['Admin']=$Rs[Admin];
		$_SESSION["AdminSessionPWd"] = AdminSession;
		$_SESSION["login"] = true;
		$_SESSION["logins"] = $Yzm;	   
		echo "<script language=\"javascript\">location.href='Manage.php';</script>";
	}else{
		  AdminLog("������û��������룬����".$Admin."�Ƿ���¼ϵͳ",1);
		  MessageBox("�û��������벻��ȷ������Ƿ�������","index.php");
	}
	mysql_close();
}else{
	MessageBox("��֤�벻��ȷ��","index.php");
}
?>