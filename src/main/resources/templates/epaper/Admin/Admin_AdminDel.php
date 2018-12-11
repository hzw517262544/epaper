<?php
session_start();
include_once("../config.php");
header("Content-type: text/html; charset=gb2312");
if(($_SESSION['Admin']=="") or ($_SESSION['AdminSessionPWd']!= AdminSession or $_SESSION["login"] != true)){
  MessageBox("请勿非法登录，谢谢！","index.php");
}else{
  $ID=Inject_Check(intval($_GET['ID']));
  $Mysql="Delete From `FangBao_Admin` Where `ID`='".$ID."'";
  mysql_query($Mysql);
  AdminLog("用户为".$_SESSION['Admin']."删除一名管理员账号，此管理员ID为：".$ID."",0);
  MessageBox("用户删除成功！","Admin_Admin.php");
}
?>