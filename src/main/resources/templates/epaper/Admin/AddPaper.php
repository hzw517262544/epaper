<?php session_start();?>
<link href="Images/skin.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<?php
include_once("../config.php");
if(($_SESSION['Admin']=="") or ($_SESSION['AdminSessionPWd']!= AdminSession or $_SESSION["login"] != true)){
  MessageBox("����Ƿ���¼��лл��","index.php");
}else{
  $PublishDate   = Inject_Check($_GET['PublishDate']); 
  if($_POST['submit']){
   $BanMian       = Inject_Check($_POST['BanMian']);
   $VerOrder      = Inject_Check($_POST['VerOrder']);
   $PublishDate   = Inject_Check($_POST['PublishDate']);
   $xMySql="Select * From FangBao_Rect Where PublishDate='".$PublishDate."' And VerOrder='".$VerOrder."'";
   $xResult=mysql_query($xMySql); 				 
   $xRs=mysql_fetch_array($xResult);
   if($xRs[PublishDate]!=""){
      echo "<script language='javascript'>alert('���ڿ�������Ӹñ�ֽ����".$VerOrder."��������������棡');history.back();</script>";
   }else{
      $jMySql="Insert Into `FangBao_Rect` (`VerOrder`,`PublishDate`,`BanMian`) Values ('$VerOrder','$PublishDate','$BanMian')";
      mysql_query($jMySql);
      AdminLog("�û�Ϊ".$_SESSION['Admin']."�����".$PublishDate."�������ڿ���".$BanMian."",0);
      MessageBox("������ӳɹ���","HotManage.php");
    }
}
?>
<script language="javascript" type="text/javascript">
function checksmall()
{
  if (document.AddPaper.VerOrder.value=="")
  {
    alert("�����������Ʋ���Ϊ�գ�");
	document.AddPaper.VerOrder.focus();
	return false;
  }
  if (document.AddPaper.BanMian.value=="")
  {
    alert("�������Ʋ���Ϊ�գ�");
	document.AddPaper.BanMian.focus();
	return false;
  }
}
</script>
<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="17" height="29" valign="top" background="Images/mail_leftbg.gif"><img src="Images/left-top-right.gif" width="17" height="29" /></td>
    <td height="29" valign="top" background="Images/content-bg.gif"><div class="titlebt">��Ӱ���</div></td>
    <td width="22" valign="top" background="Images/mail_rightbg.gif"><img src="Images/nav-right-bg.gif" width="16" height="29" /></td>
  </tr>
  <tr>
    <td height="111" valign="middle" background="Images/mail_leftbg.gif">&nbsp;</td>
    <td valign="top" bgcolor="#F7F8F9">
	<form name="AddPaper" method="post" action="AddPaper.php" onSubmit="return checksmall()">
<table width="100%"  border="1" cellspacing="0" cellpadding="0" class="colorTest">
              <tr>
                <td width="36%" height="30" align="right">�����ڿ���</td>
                <td width="64%" height="30"><input name="PublishDate" type="text" size="30" maxlength="30" value="<?=$PublishDate?>" readonly="">��<font color="#FF0000">�Զ���д������Ҫ�޸ģ�</font></td>
              </tr>
              <tr>
                <td height="30" align="right">�������棺</td>
                <td height="30"><input name="VerOrder" type="text" size="30" maxlength="30"><font color="#FF0000">��ʽ����һ�桢��A1��ȣ�</font></td>
              </tr>
              <tr>
                <td height="30" align="right">�������ƣ�</td>
                <td height="30"> <input name="BanMian" type="text" size="30" maxlength="30"><font color="#FF0000">��ʽ�����š��ۺ����ŵȣ�</font></td>
              </tr> 
			              <tr>
              <td height="28" colspan="2" align="center">
                <input name="submit" type="submit" value=" �� �� "> 
                <input type="reset" value="ȡ  ��" name="B12" />
              </td>
              </tr>
        </table>
	  </form>   </td>
    <td background="Images/mail_rightbg.gif">&nbsp;</td>
  </tr>
  <tr>
    <td valign="middle" background="Images/mail_leftbg.gif"><img src="Images/buttom_left2.gif" width="17" height="17" /></td>
      <td height="17" valign="top" background="Images/buttom_bgs.gif"><img src="Images/buttom_bgs.gif" width="17" height="17" /></td>
    <td background="Images/mail_rightbg.gif"><img src="Images/buttom_right2.gif" width="16" height="17" /></td>
  </tr>
</table>
</body>
<?php
}
?>