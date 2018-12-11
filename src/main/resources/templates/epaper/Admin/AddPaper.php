<?php session_start();?>
<link href="Images/skin.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<?php
include_once("../config.php");
if(($_SESSION['Admin']=="") or ($_SESSION['AdminSessionPWd']!= AdminSession or $_SESSION["login"] != true)){
  MessageBox("请误非法登录，谢谢！","index.php");
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
      echo "<script language='javascript'>alert('此期刊中已添加该报纸版面".$VerOrder."，请添加其他版面！');history.back();</script>";
   }else{
      $jMySql="Insert Into `FangBao_Rect` (`VerOrder`,`PublishDate`,`BanMian`) Values ('$VerOrder','$PublishDate','$BanMian')";
      mysql_query($jMySql);
      AdminLog("用户为".$_SESSION['Admin']."添加了".$PublishDate."发布的期刊的".$BanMian."",0);
      MessageBox("版面添加成功！","HotManage.php");
    }
}
?>
<script language="javascript" type="text/javascript">
function checksmall()
{
  if (document.AddPaper.VerOrder.value=="")
  {
    alert("所属版面名称不能为空！");
	document.AddPaper.VerOrder.focus();
	return false;
  }
  if (document.AddPaper.BanMian.value=="")
  {
    alert("版面名称不能为空！");
	document.AddPaper.BanMian.focus();
	return false;
  }
}
</script>
<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="17" height="29" valign="top" background="Images/mail_leftbg.gif"><img src="Images/left-top-right.gif" width="17" height="29" /></td>
    <td height="29" valign="top" background="Images/content-bg.gif"><div class="titlebt">添加版面</div></td>
    <td width="22" valign="top" background="Images/mail_rightbg.gif"><img src="Images/nav-right-bg.gif" width="16" height="29" /></td>
  </tr>
  <tr>
    <td height="111" valign="middle" background="Images/mail_leftbg.gif">&nbsp;</td>
    <td valign="top" bgcolor="#F7F8F9">
	<form name="AddPaper" method="post" action="AddPaper.php" onSubmit="return checksmall()">
<table width="100%"  border="1" cellspacing="0" cellpadding="0" class="colorTest">
              <tr>
                <td width="36%" height="30" align="right">所属期刊：</td>
                <td width="64%" height="30"><input name="PublishDate" type="text" size="30" maxlength="30" value="<?=$PublishDate?>" readonly="">　<font color="#FF0000">自动填写，不需要修改！</font></td>
              </tr>
              <tr>
                <td height="30" align="right">所属版面：</td>
                <td height="30"><input name="VerOrder" type="text" size="30" maxlength="30"><font color="#FF0000">格式：第一版、第A1版等！</font></td>
              </tr>
              <tr>
                <td height="30" align="right">版面名称：</td>
                <td height="30"> <input name="BanMian" type="text" size="30" maxlength="30"><font color="#FF0000">格式：新闻、综合新闻等！</font></td>
              </tr> 
			              <tr>
              <td height="28" colspan="2" align="center">
                <input name="submit" type="submit" value=" 添 加 "> 
                <input type="reset" value="取  消" name="B12" />
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