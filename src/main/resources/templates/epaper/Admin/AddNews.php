<?php session_start();?>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link href="Images/skin.css" rel="stylesheet" type="text/css" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />
<script src="Js/plus_format_fck.js" type="text/javascript"></script>
<?php
include_once("../config.php");
include_once("fckeditor/fckeditor.php") ;
if(($_SESSION['Admin']=="") or ($_SESSION['AdminSessionPWd']!= AdminSession or $_SESSION["login"] != true)){
	MessageBox("请勿非法登录，谢谢！","index.php");
}else{
$eMySql="Select * from `FangBao_Rect` Order By PublishDate Desc,ID Desc Limit 0,800";
$eResult=mysql_query($eMySql);
?>
<script language = "JavaScript">
var onecount;
subcat = new Array();//定义一个数组
<?php
        $count = 0;
        while($eRs=mysql_fetch_array($eResult)){
?>
subcat[<?=$count?>] = new Array("<?=$eRs[VerOrder]?>","<?=$eRs[PublishDate]?>","<?=$eRs[VerOrder]?>");
<?php
        $count = $count + 1;
}
?>
onecount=<?=$count?>;

function changelocation(locationid)
    {
    document.AddNews.VerOrder.length = 1; 
    var locationid=locationid;
    var i;
    for (i=0;i < onecount; i++)
        {
            if (subcat[i][1] == locationid)
            { 
                document.AddNews.VerOrder.options[document.AddNews.VerOrder.length] = new Option(subcat[i][0], subcat[i][2]);
            }        
        }
    }    

function CheckForm()
{

	if (document.AddNews.Title.value.length == 0) {
		alert("新闻标题没有填写！");
		document.AddNews.Title.focus();
		return false;
	}
	if (document.AddNews.VerOrder.value.length == 0) {
		alert("版面没有填写！");
		document.AddNews.VerOrder.focus();
		return false;
	}
	if (document.AddNews.User.value.length == 0) {
		alert("新闻作者没有填写！");
		document.AddNews.User.focus();
		return false;
	}
	if(FCKeditorAPI.GetInstance('Content').GetXHTML()=="" || FCKeditorAPI.GetInstance('Content').GetXHTML()=="<br />")
	{
		alert("内容不能为空，请输入！");
		FCKeditorAPI.GetInstance('Content').Focus();
		return false;
	}
return true;
}
</script>
<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="17" height="29" valign="top" background="Images/mail_leftbg.gif"><img src="Images/left-top-right.gif" width="17" height="29" /></td>
    <td height="29" valign="top" background="Images/content-bg.gif"><div class="titlebt">添加新闻</div></td>
    <td width="22" valign="top" background="Images/mail_rightbg.gif"><img src="Images/nav-right-bg.gif" width="16" height="29" /></td>
  </tr>
  <tr>
    <td height="181" valign="middle" background="Images/mail_leftbg.gif">&nbsp;</td>
    <td valign="top" bgcolor="#F7F8F9">
    <form name="AddNews" method="post" action="AddNewsOK.php" onSubmit="return CheckForm();">
        <table width="100%"  border="1" cellspacing="0" cellpadding="0" class="colorTest">
              <tr>
                <td width="18%" height="30" align="right">新闻标题：</td>
                <td width="82%" height="30"><input name="Title" type="text" size="70" maxlength="100"></td>
                </tr>
                
                <tr>
                <td width="18%" height="30" align="right">副标题：</td>
                <td width="82%" height="30"><input name="sub_title" type="text" size="70" maxlength="100"></td>
                </tr>
                
              <tr>
                <td height="30" align="right">所属版面：</td>
                <td height="30">
				
<?php
   $New_PublishDate = $_SESSION['New_PublishDate'];
   $New_VerOrder    = $_SESSION['New_VerOrder'];
   $MySqls= "Select * From `FangBao_Paper` Order By PublishID Desc Limit 0,100";
   $Results=mysql_query($MySqls); 				 
   $oRs=mysql_fetch_object($Results);
?>
<select name="PublishDate" onChange="changelocation(document.AddNews.PublishDate.options[document.AddNews.PublishDate.selectedIndex].value)" size="1">
<?php
$selclass=$oRs->PublishDate;
?>
<option value="<?=$oRs->PublishDate?>" <? if($oRs->PublishDate==$New_PublishDate){echo "selected";}?>>总第<?=$oRs->PublishID?>期</option>
<?php
while($oRs=mysql_fetch_object($Results)){
?>
<option value="<?=$oRs->PublishDate?>" <? if($oRs->PublishDate==$New_PublishDate){echo "selected";}?>>总第<?=$oRs->PublishID?>期</option>
<?
}
?>
</select>
<select name="VerOrder">
          <option value="">请选择版面</option>
<?php
if ($_SESSION['New_PublishDate']<>''){
  $MySqlp="Select * From `FangBao_Rect` Where `PublishDate`='".$_SESSION['New_PublishDate']."' Order By ID Asc";
}else{
  $MySqlp="Select * From `FangBao_Rect` Where `PublishDate`='".$selclass."' Order By ID Asc";
	}
  $Resultp=mysql_query($MySqlp); 				 
  $pRs=mysql_fetch_object($Resultp);
?>
 <option value="<?=$pRs->VerOrder?>" <? if($pRs->VerOrder==$New_VerOrder){echo "selected";}?>><?=$pRs->VerOrder?></option>
<?php
while($pRs=mysql_fetch_object($Resultp)){
?>
 <option value="<?=$pRs->VerOrder?>" <? if($pRs->VerOrder==$New_VerOrder){echo "selected";}?>><?=$pRs->VerOrder?></option>
<?php
}
?>
        </select></td>
                </tr>
              <tr title="如果您是从PDF文件上复制过来的文章请先点击'自动分段'按钮，然后点击'自动排版'，如果有多余的空段落，请连续点击三次以上'自动排版'。程序并不能完全识别段落，如有不正确，请自行调整。（产生段落主要是在?和。间）">
                <td height="30" rowspan="2" align="right">新闻内容：
                </td>
                <td height="15">
<?php
$oFCKeditor = new FCKeditor('Content') ;
$oFCKeditor->BasePath = 'fckeditor/' ;
$oFCKeditor->Config['LinkDlgHideTarget']	= false;
$oFCKeditor->Config['LinkDlgHideAdvanced']	= false;
$oFCKeditor->Config['ImageDlgHideLink']	    = false;
$oFCKeditor->Config['ImageDlgHideAdvanced']	= false;
$oFCKeditor->Config['FlashDlgHideAdvanced']	= false;
$oFCKeditor->Config['MediaDlgHideAdvanced']	= false;
$oFCKeditor->Config['LinkUpload']  = true;
$oFCKeditor->Config['LinkBrowser'] = true;
$oFCKeditor->Config['ImageUpload'] = true;
$oFCKeditor->Config['ImageBrowser']= true;
$oFCKeditor->Config['FlashUpload'] = true;
$oFCKeditor->Config['FlashBrowser']= true;
$oFCKeditor->Config['MediaUpload'] = true;
$oFCKeditor->Config['MediaBrowser']= true;
$oFCKeditor->ToolbarSet = "Default";
$oFCKeditor->Width="620";
$oFCKeditor->Height="400";
$oFCKeditor->Value = "" ;
$oFCKeditor->Create() ;
?>
                </td>
                </tr>
              <tr>
                <td align="left" title="请先点击'自动排版'，如果有多余的空段落，请连续点击三次以上'自动排版'。"><input type="button" name="formatbrbutton" value="自动分段" onClick="FormatTextBr('Content',this)" title="如果从PDF上复制过来的文章，没有标点符号就使用此按钮，否则请勿使用！" />
              <input type="button" name="formatbutton" value="自动排版" onClick="FormatText('Content',this)" />
              <input type="button" name="formatbuttonp" value="段间空行" onClick="FormatTextP('Content',this)" />
              <input id="ifblank" name="ifblank" type="checkbox" checked />
              段前空格 </td>
              </tr>
              <tr>
                <td height="32" align="right">新闻作者： </td>
                <td height="32"><input name="User" type="text" size="30" value="肥西报"></td>
                </tr>
              <tr>
                <td height="15" align="right">新闻来源：</td>
                <td height="15"><input name="Come" type="text" value="本报讯" size="30" maxlength="30"></td>
                </tr>
                <tr>
                <td height="30" colspan="2" align="center">
                <input type="submit" name="submit" value="提交">
                <input type="reset" name="Submit2" value="重置">
                </td>
                </tr>
            </table></form>
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
</body>