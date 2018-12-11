<?php session_start();?>
<link href="Images/skin.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<?php
include_once("../config.php");
if(($_SESSION['Admin']=="") or ($_SESSION['AdminSessionPWd']!= AdminSession or $_SESSION["login"] != true)){
	MessageBox("请勿非法登录，谢谢！","index.php");
}else{
  $ID=Inject_Check(intval($_GET['ID']));
  $sMysql="Select * from `FangBao_Admin` where `ID`=".$ID;
  $Fuery=mysql_query($sMysql);
  $sRs=mysql_fetch_array($Fuery);
?>
<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="17" height="29" valign="top" background="Images/mail_leftbg.gif"><img src="Images/left-top-right.gif" width="17" height="29" /></td>
    <td height="29" valign="top" background="Images/content-bg.gif"><div class="titlebt"><span class="left_bt2">修改管理员</span></div></td>
    <td width="22" valign="top" background="Images/mail_rightbg.gif"><img src="Images/nav-right-bg.gif" width="16" height="29" /></td>
  </tr>
  <tr>
    <td valign="middle" background="Images/mail_leftbg.gif">&nbsp;</td>
    <td valign="top" bgcolor="#F7F8F9">
      <form method="post" action="Admin_AdminSave.php?ID=<?=$sRs[ID]?>">
        <table width="100%"  border="1" cellspacing="0" cellpadding="0" class="colorTest">
          <tr>
            <td width="561" align="right">用户名：</td>
            <td><input name="Admin"  type="text" size="28" value="<?=$sRs[Admin]?>"/></td>
          </tr>
          <tr>
            <td align="right">原密码：</td>
            <td width="998"><input  type="Password" name="OldPwd" size="30" /></td>
          </tr>
          <tr>
            <td align="right">新密码：</td>
            <td><input type="PassWord" name="PassWord" size="30"/></td>
          </tr>
          <tr>
            <td colspan="2" align="center"><input type="submit" value=" 修  改 " name="submit" />&nbsp;&nbsp;<input type="reset" value=" 重 置 "></td>
            </tr>
        </table>
      </form>
    </td>
    <td background="Images/mail_rightbg.gif">&nbsp;</td>
  </tr>
  <tr>
    <td valign="middle" background="Images/mail_leftbg.gif"><img src="Images/buttom_left2.gif" width="17" height="17" /></td>
      <td height="17" valign="top" background="Images/buttom_bgs.gif"><img src="Images/buttom_bgs.gif" width="17" height="17" /></td>
    <td background="Images/mail_rightbg.gif"><img src="Images/buttom_right2.gif" width="16" height="17" /></td>
  </tr>
</table>
<?php
}
?>