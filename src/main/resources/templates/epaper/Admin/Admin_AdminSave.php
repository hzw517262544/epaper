<?php
session_start();
include_once("../config.php");
header("Content-type: text/html; charset=gb2312");
if(($_SESSION['Admin']=="") or ($_SESSION['AdminSessionPWd']!= AdminSession or $_SESSION["login"] != true)){
	MessageBox("请勿非法登录，谢谢！","index.php");
}else{
  $Acction=Inject_Check($_GET['Acction']);
  $ID=Inject_Check(intval($_GET['ID']));
  if(Inject_Check($_POST['submit']) && $Acction=='Add'){
    $Admin=Inject_Check($_POST[Admin]);
    $PassWord=Inject_Check(md5($_POST[PassWord]));
    $oMySql="Select * From `FangBao_Admin` where `Admin`='".$Admin."'";
    $oQuery=mysql_query($oMySql);
    $oRs=mysql_fetch_array($oQuery);
    if ($oRs[Admin]<>""){
      MessageBox("该账户已经存在，请重新添加！","Admin_Admin.php");
    }else{
      $Mysql="Insert Into `FangBao_Admin`(`Admin`,`PassWord`) values ('$Admin','$PassWord')";
      mysql_query($Mysql);
      AdminLog("用户为".$_SESSION['Admin']."添加了一名管理员账号，此管理员账号为：".$_POST[Admin]."",0);
      MessageBox("用户添加成功！","Admin_Admin.php");
    }
  }else{
    if(Inject_Check($_POST['submit'])){
      $Admin      = Inject_Check($_POST['Admin']);
      $OldPwd   = Inject_Check(md5($_POST['OldPwd']));
      $PassWord   = Inject_Check(md5($_POST['PassWord']));
      $oMySql="Select * From `FangBao_Admin` where `Admin`='".$Admin."'";
      $oQuery=mysql_query($oMySql);
      $oRs=mysql_fetch_array($oQuery);
      if ($oRs[PassWord]!=$OldPwd){
        echo "<script language='javascript'>alert('旧密码输入不正确，请输入正确的旧密码！');history.back();</script>";
        //MessageBox("旧密码输入不正确，请输入正确的旧密码！","");
      }else{
        $sql="Update `FangBao_Admin` Set `Admin`='".$Admin."',`PassWord`='".$PassWord."' Where `ID`=".$ID;
        mysql_query($sql);
        AdminLog("用户为".$_SESSION['Admin']."修改了一名管理员账号信息，此管理员账号为：".$_POST[Admin]."",0);
        MessageBox("用户信息修改成功！","Admin_Admin.php");
      }
    }
  }
}
?>