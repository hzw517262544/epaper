<?php session_start();?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>���ӱ�����ϵͳ��̨����</title>
</head>
<?php
include_once("../config.php");
if(($_SESSION['Admin']=="") or ($_SESSION['AdminSessionPWd']!= AdminSession or $_SESSION["login"] != true)){
	MessageBox("����Ƿ���¼��лл��","index.php");
}else{
?>
<frameset rows="63,*" cols="*" framespacing="0" frameborder="no" border="0">
  <frame src="Admin_Top.php" name="top" scrolling="no" noresize>
  <frameset rows="*" cols="198,*" framespacing="0" frameborder="no" border="0">
    <frame src="Admin_Left.php" name="left" noresize>
    <frame src="Admin_Main.php" name="main" noresize>
  </frameset>
</frameset>
<?php
}
?>
<noframes><body>
</body></noframes>
</html>