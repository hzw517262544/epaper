<?php
session_start();
include_once("../config.php");
header("Content-type: text/html; charset=gb2312");
if(($_SESSION['Admin']=="") or ($_SESSION['AdminSessionPWd']!= AdminSession or $_SESSION["login"] != true)){
	MessageBox("����Ƿ���¼��лл��","index.php");
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
      MessageBox("���˻��Ѿ����ڣ���������ӣ�","Admin_Admin.php");
    }else{
      $Mysql="Insert Into `FangBao_Admin`(`Admin`,`PassWord`) values ('$Admin','$PassWord')";
      mysql_query($Mysql);
      AdminLog("�û�Ϊ".$_SESSION['Admin']."�����һ������Ա�˺ţ��˹���Ա�˺�Ϊ��".$_POST[Admin]."",0);
      MessageBox("�û���ӳɹ���","Admin_Admin.php");
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
        echo "<script language='javascript'>alert('���������벻��ȷ����������ȷ�ľ����룡');history.back();</script>";
        //MessageBox("���������벻��ȷ����������ȷ�ľ����룡","");
      }else{
        $sql="Update `FangBao_Admin` Set `Admin`='".$Admin."',`PassWord`='".$PassWord."' Where `ID`=".$ID;
        mysql_query($sql);
        AdminLog("�û�Ϊ".$_SESSION['Admin']."�޸���һ������Ա�˺���Ϣ���˹���Ա�˺�Ϊ��".$_POST[Admin]."",0);
        MessageBox("�û���Ϣ�޸ĳɹ���","Admin_Admin.php");
      }
    }
  }
}
?>