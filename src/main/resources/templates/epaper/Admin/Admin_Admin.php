<?php session_start();?>
<link href="Images/skin.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<?php
include_once("../config.php");
if(($_SESSION['Admin']=="") or ($_SESSION['AdminSessionPWd']!= AdminSession or $_SESSION["login"] != true)){
	MessageBox("请勿非法登录，谢谢！","index.php");
}else{
?>
<script language = "JavaScript">
function CheckForm()
{

	if (document.AddAdmin.Admin.value.length == 0) {
		alert("用户名不能为空！");
		document.AddAdmin.Admin.focus();
		return false;
	}
	if (document.AddAdmin.PassWord.value.length == 0) {
		alert("密码不能为空！");
		document.AddAdmin.PassWord.focus();
		return false;
	}
return true;
}
</script>
<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="17" height="29" valign="top" background="Images/mail_leftbg.gif"><img src="Images/left-top-right.gif" width="17" height="29" /></td>
    <td height="29" valign="top" background="Images/content-bg.gif"><div class="titlebt">用户管理</div></td>
    <td width="22" valign="top" background="Images/mail_rightbg.gif"><img src="Images/nav-right-bg.gif" width="16" height="29" /></td>
  </tr>
  <tr>
    <td valign="middle" background="Images/mail_leftbg.gif">&nbsp;</td>
    <td valign="top" bgcolor="#F7F8F9">
    <table width="100%"  border="1" cellspacing="0" cellpadding="0" class="colorTest">
            <tr class="sec1">
             <td width="8%" align="center">ID</td>
                  <td width="13%" align="center">用户</td>
                  <td width="33%" align="center">密码(加密)</td>
                  <td width="11%" align="center">修改</td>
                  <td width="10%" align="center">删除</td>
            </tr>
<?php
  $dMySql="Select * from FangBao_Admin Order By ID Asc";
  $eQuery=mysql_query($dMySql);
  while($cRs=mysql_fetch_array($eQuery)){
?>
<tr onMouseOver="this.style.backgroundColor='#ffffcc'" onMouseOut="this.style.backgroundColor=''">
                  <td width="8%" height="30" align="center"><?=$cRs[ID]?></td>
                  <td width="13%" height="30" align="center" ><?=$cRs[Admin]?></td>
                  <td width="33%" height="30" align="center" ><?=$cRs[PassWord]?></td>
                  <td width="11%" height="30" align="center" ><a href="Admin_Adminmodify.php?ID=<?=$cRs[ID]?>">修改</a></td>
                  <td width="10%" height="30" align="center" ><a onclick='{if(confirm("您确定删除吗?此操作将不能恢复!")){return true;}return false;}' href="Admin_AdminDel.php?ID=<?=$cRs[ID]?>">删除</a></td>
                  </tr>
<?php
}
?>
            <tr>
              <td colspan="6">
          <form name="AddAdmin" method="post" action="Admin_AdminSave.php?Acction=Add" onSubmit="return CheckForm();">
			<table width="100%"  border="1" cellspacing="0" cellpadding="0" class="colorTest">
              <tr>
                <td colspan="2" align="center" class="left_ts">增加管理员</td>
                </tr>
              <tr>
                <td width="462" align="right">用户名：</td>
                <td width="690"><input  type="text" name="Admin" size="30" /></td>
              </tr>
              <tr>
                <td width="462" align="right">密　码：</td>
                <td><input  type="PassWord" name="PassWord" size="30" /></td>
              </tr>
              <tr>
                <td colspan="2" align="center"><input type="submit" name="submit" value="添加"></td>
                </tr>
            </table>
            </form>
		</td>
            </tr>
          </table>
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