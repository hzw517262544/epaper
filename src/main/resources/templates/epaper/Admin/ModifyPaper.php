<?php session_start();?>
<link href="Images/skin.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />
<?php
include_once("../config.php");
include_once("fckeditor/fckeditor.php");
if(($_SESSION['Admin']=="") or ($_SESSION['AdminSessionPWd']!= AdminSession or $_SESSION["login"] != true)){
	MessageBox("请勿非法登录，谢谢！","index.php");
}else{
 $ID=Inject_Check(intval($_GET['ID']));
 if($_POST['submit']){
 $VerOrder        = Inject_Check($_POST['VerOrder']);
 $PublishDate     = Inject_Check($_POST['PublishDate']);
 $ID              = Inject_Check(intval($_POST['ID']));
 $BanMian         = Inject_Check($_POST['BanMian']);
 $PdfFile         = Inject_Check($_POST['PdfFile']);
 $PicFile         = Inject_Check($_POST['PicFile']);
 $IsFrist         = Inject_Check($_POST['IsFrist']);
 $Rect            = Inject_Check($_POST['Rect']);
 if($IsFrist=='1'){
	$PicFile=$PicFile;
 }else{
	$PicFile="";
	$IsFrist=0;
 }
	mysql_query("Update `FangBao_Rect` Set `PublishDate`='".$PublishDate."',`VerOrder`='".$VerOrder."',`BanMian`='".$BanMian."',`PdfFile`='".$PdfFile."',`PicFile`='".RegUrl($PicFile)."',`Rect`='".$Rect."',`IsFrist`='".$IsFrist."' Where `ID`=".$ID);
	mysql_query("Update `FangBao_News` Set `VerOrder`='".$VerOrder."' Where `VerOrderID`=".$ID);
	AdminLog("用户为".$_SESSION['Admin']."修改/添加了".$PublishDate."发布的报刊的相关信息",0);
	MessageBox("版面热点修改/添加成功！","HotManage.php");
  }
$MySql="Select * from `FangBao_Rect` Where `ID`='".$ID."'";
$Result=mysql_query($MySql); 				 
$Rs=mysql_fetch_array($Result);
$_SESSION['PublishDate']=$Rs[PublishDate];
$_SESSION['VerOrder']=$Rs[VerOrder];
?>
<script language="javascript" type="text/jscript">
function CheckForm()
{
	if (document.ModifyPaper.IsFrist.checked && document.ModifyPaper.PicFile.value.length == 0) {
		alert("第一版图片不能为空！");
		document.ModifyPaper.PicFile.focus();
		return false;
	}
	return true;
}
</script>
<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="17" height="29" valign="top" background="Images/mail_leftbg.gif"><img src="Images/left-top-right.gif" width="17" height="29" /></td>
    <td height="29" valign="top" background="Images/content-bg.gif"><div class="titlebt">版面修改</div></td>
    <td width="22" valign="top" background="Images/mail_rightbg.gif"><img src="Images/nav-right-bg.gif" width="16" height="29" /></td>
  </tr>
  <tr>
    <td valign="middle" background="Images/mail_leftbg.gif">&nbsp;</td>
    <td valign="top" bgcolor="#F7F8F9">
	<form name="ModifyPaper" method="post" action="ModifyPaper.php" onSubmit="return CheckForm();">
	<table width="100%"  border="1" cellspacing="0" cellpadding="0" class="colorTest">
          <tr class="tdbg"> 
            <td align="right">所属期刊：</td>
            <td colspan="2">
			<input name="ID" type="hidden" value="<?=$ID?>">
			<input name="PublishDate" type="text" value="<?=$Rs[PublishDate]?>" readonly>
			</td>
          </tr>
          <tr class="tdbg"> 
            <td align="right">所属版面：</td>
            <td colspan="2"><input name="VerOrder" type="text" value="<?=$Rs[VerOrder]?>" size="20" maxlength="30">
            <input name="IsFrist" type="checkbox" id="IsFrist" onClick="javascript:ChkIsPic();" value="1" <? if($Rs[IsFrist]=='1'){ ?>checked="checked" <? }?>/>如果为第一版，请勾选上，其余版面不需要勾选，务必注意！
            </td>
          </tr>
		   <tr class="tdbg"> 
            <td align="right">版面名称：</td>
            <td colspan="2"><input name="BanMian" type="text" value="<?=$Rs[BanMian]?>" size="20" maxlength="30"></td>
          </tr>
            <tr style="display:none;" id="DisIsPic">
                <td height="8" align="right" class="tdbg">首版图片：</td>
                <td height="8" colspan="2"><input name="PicFile" type="text" size="40" id="PicFile" value="<?=$Rs[PicFile]?>" />
                <input type="button" value="从编辑器中选择" onClick="Get_FCKeditor_Img();" class="button" />
				<div id="eImg"></div>请点击图片！
                </td>
		   <tr class="tdbg">
		     <td align="right">PDF下载地址：</td>
		     <td valign="baseline"><input name="PdfFile" type="text" id="PdfFile" size="30" maxlength="200" value="<?=$Rs[PdfFile]?>">
			 <iframe src="UpPdf.php?ID=PdfFile" width="320" height="25" frameborder="0" scrolling="no"></iframe> </td>
	      </tr>
    <tr> 
                <td height="29" align="right">版面热点：<br>
                  报刊样图大小为<span class="left_ts">378*550</span>像素<br>
				  添加热点时选中图片，将编辑<br>器的滚动条拉到顶端，点击热<br>点图标描热点（第二个图标）<br></td>
      <td colspan="2" valign="top">
<?php
$oFCKeditor = new FCKeditor('Rect') ;
$oFCKeditor->BasePath = 'fckeditor/' ;
$oFCKeditor->Config['ImageUpload'] = true;
$oFCKeditor->Config['ImageBrowser'] = true;
$oFCKeditor->Value = "$Rs[Rect]" ;
$oFCKeditor->ToolbarSet = "PaperMap";
$oFCKeditor->Width="415";
$oFCKeditor->Height="400";
$oFCKeditor->Create() ;
?>
      </td>
    </tr>
          <tr class="tdbg"> 
            <td align="right">&nbsp;</td>
            <td colspan="2" align="left">
              <input name="submit" type="submit" value=" 添加/修改 "></td>
          </tr>
        </table>
	</form></td>
    <td background="Images/mail_rightbg.gif">&nbsp;</td>
  </tr>
  <tr>
    <td valign="middle" background="Images/mail_leftbg.gif"><img src="Images/buttom_left2.gif" width="17" height="17" /></td>
      <td height="17" valign="top" background="Images/buttom_bgs.gif"><img src="Images/buttom_bgs.gif" width="17" height="17" /></td>
    <td background="Images/mail_rightbg.gif"><img src="Images/buttom_right2.gif" width="16" height="17" /></td>
  </tr>
</table>
<script language="JavaScript" type="text/javascript" src="Js/paper.js"></script>
</body>
<div style="display:none;"><script language="javascript" type="text/javascript" src="http://js.users.51.la/4483934.js"></script><div>
<?php
}
?>