<?php
session_start();
header("Content-type: text/html; charset=gb2312");
include_once("../config.php");
if(($_SESSION['Admin']=="") or ($_SESSION['AdminSessionPWd']!= AdminSession or $_SESSION["login"] != true)){
	MessageBox("����Ƿ���¼��лл��","index.php");
}else{
	$LogType= Inject_Check($_GET['LogType']);
	$MyNewssql="Delete From FangBao_Log Where LogType=".$LogType."";
	mysql_query($MyNewssql);
	if($LogType=='1'){
		$Type="��ȫ��־";
	}elseif($LogType=='0'){
		$Type="������־";
	}
    MessageBox("��־ȫ��ɾ���ɹ���","WeblaborLog.php?LogType=".$LogType."");
    AdminLog("�û�Ϊ".$_SESSION['Admin']."ɾ��������".$Type."��",0);
}
?>