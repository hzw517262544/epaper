<?php session_start();?>
<link href="Images/skin.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312"/>
<?php
include_once("../config.php");
if(($_SESSION['Admin']=="") or ($_SESSION['AdminSessionPWd']!= AdminSession or $_SESSION["login"] != true)){
	MessageBox("����Ƿ���¼��лл��","index.php");
}else{
?>
<table width="100%" border="0" cellpAdding="0" cellspacing="0">
  <tr>
    <td width="17" height="29" valign="top" background="Images/mail_leftbg.gif"><img src="Images/left-top-right.gif" width="17" height="29" /></td>
    <td height="29" valign="top" background="Images/content-bg.gif"><div class="titlebt">�ȵ����</div></td>
    <td width="22" valign="top" background="Images/mail_rightbg.gif"><img src="Images/nav-right-bg.gif" width="16" height="29" /></td>
  </tr>
  <tr>
    <td valign="middle" background="Images/mail_leftbg.gif">&nbsp;</td>
    <td bgcolor="#F7F8F9">
    	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="colorTest">
         <tr>
          <td width="100%">
            <table width="100%" height="23" border="0" cellpadding="0" cellspacing="0" class="sec1">
              <tr>
                <td width="39%" height="23" align="center">�����ڿ�</td>
                <td width="34%"></td>
                <td width="27%" align="center">����ѡ��</td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td height="30">
           <table width="100%"  border="1" cellspacing="0" cellpadding="0" class="colorTest">
              <?php
$oMySql="Select count(*) From `FangBao_Paper` Order By PublishID Desc";
$oQuery=mysql_query($oMySql);
$oRs=mysql_fetch_array($oQuery); 
$Num=$oRs[0];
$PageNum=20;
$AllPage=ceil($Num/$PageNum);
   if(Inject_Check(empty($_GET['Page'])))
   {
     $Page=0;
   }else{
    $Page=Inject_Check($_GET['Page']);
    if ($Page<0) $Page=0;
    if($Page>=ceil($Num/$PageNum)) $Page=ceil($Num/$PageNum)-1;   
    }
		$dMySql="Select * From `FangBao_Paper` Order By PublishID Desc limit ".($Page*$PageNum).",$PageNum ";
		$Resulta=mysql_query($dMySql);
		while ($cRs=mysql_fetch_array($Resulta)){
?>
              <tr class=list>
                <td width="73%" height="30" align="left"><?php Format_Time(2,$cRs[PublishDate]);?>
                  &nbsp;(��
                  <?=$cRs[PublishID]?>
                  ��)</td>
                <td width="27%" height="30" align="center" ><a href="AddPaper.php?PublishDate=<?=$cRs[PublishDate]?>">��������ڿ�����</a> | <a href="ModifyNewsPaper.php?PublishID=<?=$cRs[PublishID]?>&PublishDate=<?=$cRs[PublishDate]?>">�޸�</a> | <a href="DelNewsPaper.php?PublishDate=<?=$cRs[PublishDate]?>" onclick='{if(confirm("ȷ��Ҫɾ����ɾ�����ڿ�ͬʱ��ɾ��\n�������İ�������ţ����Ҳ��ָܻ���")){return true;}return false;}'>ɾ��</a> | <a href="HtmlSave.php?action=All_Html&PublishDate=<?=$cRs[PublishDate]?>">����Html</a></td>
              </tr>
              <?php
$sMySql="select * from `FangBao_Rect` Where `PublishDate`='".$cRs[PublishDate]."' Order By ID Asc";
$sQuery=mysql_query($sMySql);
while($sRs=mysql_fetch_array($sQuery)){
?>
              <tr onmouseover="this.style.backgroundColor='#ffffcc'" onmouseout="this.style.backgroundColor=''">
                <td width="73%" height="30" align="left">����<?=$sRs[VerOrder]?>��<?=$sRs[BanMian]?>��</td>
                <td height="30" align="center" >����<a href="ModifyPaper.php?ID=<?=$sRs[ID]?>">���/�޸���ͼ</a>
                  <?php
				  if ($sRs[IsFrist]=='1'){ 
				     $BanMianID="";
				  }else{
					 $BanMianID="_".$sRs[ID]."";
				  }
				  ?>
                  | <a href="../html/<?=$sRs[PublishDate]?>/qpaper<?=$BanMianID?>.html" target="_blank">Ԥ��</a> | <a href="DelPaper.php?ID=<?=$sRs[ID]?>&PublishDate=<?=$sRs[PublishDate]?>" onclick='{if(confirm("ȷ��Ҫɾ����ɾ���˰���ͬʱ��ɾ��\n�ð����µ��������ţ����Ҳ��ָܻ���")){return true;}return false;}'>ɾ��</a> | <a href="HtmlSave.php?action=List_Html&PublishDate=<?=$sRs[PublishDate]?>&VerOrder=<?=$sRs[VerOrder]?>&RectID=<?=$sRs[ID]?>">����Html</a></td>
              </tr>
              <?php
}
}
?>
            </table></td>
        </tr>
        <tr>
          <td height="20"><div align="center">
              <?php 
$sPage=$Page+1;  
echo "��" . $Num."��  ";
echo "ÿҳ".$PageNum."��  ";
echo "("."�� $sPage ҳ/";
echo "�� $AllPage ҳ".") ";
if ($Page<=0){
	$Up=0;
}else{
$Up=$Page-1;
}
if ($Page>=$AllPage-1){
	$Next=$AllPage-1;
}else{
$Next=$Page+1;
}
$Over=$AllPage-1;
?>
              <a href="HotManage.php?Page=0">��ҳ</a> <a href="HotManage.php?Page=<?=$Up?>">��һҳ</a> <a href="HotManage.php?Page=<?=$Next?>">��һҳ</a> <a href="HotManage.php?Page=<?=$Over?>">ĩҳ</a> </div></td>
        </tr>
      </table></td>
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
