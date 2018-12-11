<?php
session_start();
include_once("../config.php");
if(($_SESSION['Admin']=="") or ($_SESSION['AdminSessionPWd']!= AdminSession or $_SESSION["login"] != true)){
	MessageBox("请勿非法登录，谢谢！","index.php");
}else{
$PublishID    = Inject_Check(intval($_GET['PublishID']));
$PublishDate  = Inject_Check($_GET['PublishDate']);
 if(Inject_Check($_POST['submit'])){
 $PublishDate     = Inject_Check($_POST['PublishDate']);
 $OldPublishDate  = Inject_Check($_POST['OldPublishDate']);
  $UpBigSql="Update `FangBao_Paper` Set `PublishDate`='".$PublishDate."' Where `PublishDate`='".$OldPublishDate."'";
  mysql_query($UpBigSql);
  $UpSql="Update `FangBao_Rect` Set `PublishDate`='".$PublishDate."' Where `PublishDate`='".$OldPublishDate."'";
  mysql_query($UpSql);
  $UpNewsSql="Update `FangBao_News` Set `PublishDate`='".$PublishDate."' Where `PublishDate`='".$OldPublishDate."'";
  mysql_query($UpNewsSql);
  AdminLog("用户为".$_SESSION['Admin']."修改了第".$PublishID."期报刊",0);
  MessageBox("修改成功，请返回！","HotManage.php");
 }
?>
<link href="Images/skin.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="17" height="29" valign="top" background="Images/mail_leftbg.gif"><img src="Images/left-top-right.gif" width="17" height="29" /></td>
    <td height="29" valign="top" background="Images/content-bg.gif"><div class="titlebt">修改期刊</div></td>
    <td width="22" valign="top" background="Images/mail_rightbg.gif"><img src="Images/nav-right-bg.gif" width="16" height="29" /></td>
  </tr>
  <tr>
    <td valign="middle" background="Images/mail_leftbg.gif">&nbsp;</td>
    <td valign="top" bgcolor="#F7F8F9">
	<form name="ModifyPaper" method="post" action="ModifyNewsPaper.php">
<table width="100%"  border="1" cellspacing="0" cellpadding="0" class="colorTest">
              <tr>
                <td height="30" align="right">报纸期数：</td>
                <td width="19%" height="30"> <input name="PublishID" type="text" size="30" maxlength="30" value="<?=$PublishID?>" readonly> </td>
                <td width="45%" height="30">此处不能修改</td>
              </tr>
              <tr>
                <td height="30" align="right">发行时间：</td>
                <td height="30">
				<input name="PublishDate" type="text" value="<?=$PublishDate?>" size="30" maxlength="20" onFocus="setday(this)"/>
				<input name="OldPublishDate" type="hidden" id="OldPublishDate" value="<?=$PublishDate?>">
				</td>
                <td height="30">点击文本框选择</td>
              </tr>
              <tr>
                <td height="27" align="right">&nbsp;</td>
                <td height="27">
				<input name="submit" type="submit" value=" 修 改 ">
                <input type="reset" value="取  消" name="reset"/>
				</td>
                <td height="27">&nbsp;</td>
              </tr>
            </table></form></td>
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