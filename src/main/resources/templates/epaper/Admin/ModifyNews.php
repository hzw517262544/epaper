<?php session_start();?>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link href="Images/skin.css" rel="stylesheet" type="text/css" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />
<script src="Js/plus_format_fck.js" type="text/javascript"></script>
<?php
include_once("../config.php");
include_once("fckeditor/fckeditor.php");
if(($_SESSION['Admin']=="") or ($_SESSION['AdminSessionPWd']!= AdminSession or $_SESSION["login"] != true)){
	MessageBox("����Ƿ���¼��лл��","index.php");
}else{
$ID=Inject_Check(intval($_GET['ID']));
$eMySql="Select * From `FangBao_Rect` Order By PublishDate Desc,ID Desc Limit 0,800";
$eResult=mysql_query($eMySql);
?>
<script language = "JavaScript">
var onecount;
subcat = new Array();//����һ������
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
    document.ModifyNews.VerOrder.length = 1; 
    var locationid=locationid;
    var i;
    for (i=0;i < onecount; i++)
        {
            if (subcat[i][1] == locationid)
            { 
                document.ModifyNews.VerOrder.options[document.ModifyNews.VerOrder.length] = new Option(subcat[i][0], subcat[i][2]);
            }        
        }
    }    

function CheckForm()
{
	if (document.ModifyNews.Title.value.length == 0) {
		alert("���ű���û����д��");
		document.ModifyNews.Title.focus();
		return false;
	}
	if (document.ModifyNews.VerOrder.value.length == 0) {
		alert("����û����д��");
		document.ModifyNews.VerOrder.focus();
		return false;
	}
	if(FCKeditorAPI.GetInstance('Content').GetXHTML()=="")
	{
		alert("���ݲ���Ϊ�գ������룡");
		FCKeditorAPI.GetInstance('Content').Focus();
		return false;
	}
	if (document.ModifyNews.User.value.length == 0) {
		alert("��������û����д��");
		document.ModifyNews.User.focus();
		return false;
	}
return true;
}
</script>
<?php
$nMySql="Select * From `FangBao_News` Where `ID`='".$ID."'";
$nQuery=mysql_query($nMySql);
$nRs=mysql_fetch_array($nQuery); 
?>
<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="17" height="29" valign="top" background="Images/mail_leftbg.gif"><img src="Images/left-top-right.gif" width="17" height="29" /></td>
    <td height="29" valign="top" background="Images/content-bg.gif"><div class="titlebt">�޸�����</div></td>
    <td width="22" valign="top" background="Images/mail_rightbg.gif"><img src="Images/nav-right-bg.gif" width="16" height="29" /></td>
  </tr>
  <tr>
    <td valign="middle" background="Images/mail_leftbg.gif">&nbsp;</td>
    <td valign="top" bgcolor="#F7F8F9">
    <form name="ModifyNews" method="post" action="AddNewsOK.php" onSubmit="return CheckForm();">
            <table width="100%"  border="1" cellspacing="0" cellpadding="0" class="colorTest">
              <tr>
                <td width="18%" height="30" align="right">���ű��⣺</td>
                <td width="82%" height="30"><input name="Title" type="text" size="70" maxlength="100" value="<?=$nRs[Title]?>"></td>
                </tr>
                
                <tr>
                <td width="18%" height="30" align="right">�����⣺</td>
                <td width="82%" height="30"><input name="sub_title" type="text" size="70" maxlength="100" value="<?=$nRs[sub_title]?>"></td>
                </tr>
              <tr>
                <td height="30" align="right">�������棺</td>
                <td height="30">
				
<?php
		$MySqls= "Select * From `FangBao_Paper` Order By PublishID Desc Limit 0,100";
		$Results=mysql_query($MySqls); 				 
        $oRs=mysql_fetch_object($Results);
?>
<select name="PublishDate" onChange="changelocation(document.ModifyNews.PublishDate.options[document.ModifyNews.PublishDate.selectedIndex].value)" size="1">
<?php
$SelClass=$nRs[PublishDate];
?>
   <option value="<?=$oRs->PublishDate?>" <? if($oRs->PublishDate==$nRs[PublishDate]) {echo "selected";}?>>�ܵ�<?=$oRs->PublishID?>��</option>
<?php
while($oRs=mysql_fetch_object($Results)){
?>
   <option value="<?=$oRs->PublishDate?>" <? if($oRs->PublishDate==$nRs[PublishDate]) {echo "selected";}?>>�ܵ�<?=$oRs->PublishID?>��</option>
<?php
}
?>
</select>
<select name="VerOrder">
  <option value="">��ѡ�����</option>
<?php
			$MySqlp="Select * From `FangBao_Rect` Where `PublishDate`='".$SelClass."' Order By ID Asc";
			$Resultp=mysql_query($MySqlp); 				 
            $pRs=mysql_fetch_object($Resultp);
?>
  <option value="<?=$pRs->VerOrder?>" <? if($pRs->VerOrder==$nRs[VerOrder]) {echo "selected";}?>><?=$pRs->VerOrder?></option>
<?php
while($pRs=mysql_fetch_object($Resultp)){
?>
  <option value="<?=$pRs->VerOrder?>" <? if($pRs->VerOrder==$nRs[VerOrder]) {echo "selected";}?>><?=$pRs->VerOrder?></option>
<?php
}
?>
</select>
</td>
                </tr>
              <tr>
                <td height="30" rowspan="2" align="right">�������ݣ�</td>
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
$oFCKeditor->Value = $nRs[Content];
$oFCKeditor->Create() ;
?>
                </td>
                </tr>
                <tr>
                 <td align="left" title="���ȵ��'�Զ��Ű�'������ж���Ŀն��䣬�����������������'�Զ��Ű�'��"><input type="button" name="formatbrbutton" value="�Զ��ֶ�" onClick="FormatTextBr('Content',this)" title="�����PDF�ϸ��ƹ��������£�û�б����ž�ʹ�ô˰�ť����������ʹ�ã�" />
              <input type="button" name="formatbutton" value="�Զ��Ű�" onClick="FormatText('Content',this)" />
              <input type="button" name="formatbuttonp" value="�μ����" onClick="FormatTextP('Content',this)" />
              <input id="ifblank" name="ifblank" type="checkbox" checked />
              ��ǰ�ո� </td>
                </tr>
              <tr>
                <td height="32" align="right">�������ߣ� </td>
                <td height="32"><input name="User" type="text" size="30" value="<?=$nRs[User]?>"></td>
                </tr>
              <tr>
                <td height="15" align="right">������Դ��</td>
                <td height="15"><input name="Come" type="text" size="30" maxlength="30" value="<?=$nRs[Come]?>"></td>
                </tr>
                <tr>
                <td height="15" colspan="2" align="center">
			    <input type="hidden" name="ID" value="<?=$nRs[ID]?>">
                <input type="submit" name="ModifyNews" value="�ύ">
                <input type="reset" name="Submit2" value="����"></td>
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
</body>
<?php
}
?>