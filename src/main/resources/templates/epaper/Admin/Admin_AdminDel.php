<?php
session_start();
include_once("../config.php");
header("Content-type: text/html; charset=gb2312");
if(($_SESSION['Admin']=="") or ($_SESSION['AdminSessionPWd']!= AdminSession or $_SESSION["login"] != true)){
  MessageBox("����Ƿ���¼��лл��","index.php");
}else{
  $ID=Inject_Check(intval($_GET['ID']));
  $Mysql="Delete From `FangBao_Admin` Where `ID`='".$ID."'";
  mysql_query($Mysql);
  AdminLog("�û�Ϊ".$_SESSION['Admin']."ɾ��һ������Ա�˺ţ��˹���ԱIDΪ��".$ID."",0);
  MessageBox("�û�ɾ���ɹ���","Admin_Admin.php");
}
?>