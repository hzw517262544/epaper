<?php session_start();?>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<link href="Images/skin.css" rel="stylesheet" type="text/css" />
<?php
include_once("../config.php");
if(($_SESSION['Admin']=="") or ($_SESSION['AdminSessionPWd']!= AdminSession or $_SESSION["login"] != true)){
	MessageBox("����Ƿ���¼��лл��","index.php");
}else{
	$LogType= Inject_Check($_GET['LogType']);
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="17" height="29" valign="top" background="Images/mail_leftbg.gif"><img src="Images/left-top-right.gif" width="17" height="29" /></td>
    <td height="29" valign="top" background="Images/content-bg.gif"><div class="titlebt">��־����</div></td>
    <td width="22" valign="top" background="Images/mail_rightbg.gif"><img src="Images/nav-right-bg.gif" width="16" height="29" /></td>
  </tr>
  <tr>
    <td valign="middle" background="Images/mail_leftbg.gif">&nbsp;</td>
    <td valign="top" bgcolor="#F7F8F9">
	<table width="100%"  border="0" cellpadding="0" cellspacing="0" class="colorTest">
	 <tr class="sec1">
       <td width="5%" align="center">ID</td>
       <td width="12%" align="center">IP</td>
       <td width="13%" align="center">ʱ��</td>
       <td width="56%" align="center">����</td>
       <td width="10%" align="center">���</td>
     </tr>
<?php
$oMySql="Select count(*) From `FangBao_Log` Where `LogType`='".$LogType."' Order By LogID Desc";
$oQuery=mysql_query($oMySql);
$oRs=mysql_fetch_array($oQuery); 
$Num=$oRs[0];
$PageNum=20;
$AllPage=ceil($Num/$PageNum);
$Page=ceil($Num/$PageNum);
   if(Inject_Check(empty($_GET['Page'])))
   {
		$Page=0;
   }else{
		$Page=Inject_Check($_GET['Page']);
		if ($Page<0) $Page=0;
		if($Page>=ceil($Num/$PageNum)) $Page=ceil($Num/$PageNum)-1;   
   }
		$dMySql="Select * From `FangBao_Log` Where `LogType`='".$LogType."' Order By LogID Desc Limit ".($Page*$PageNum).",$PageNum ";
		$Resulta=mysql_query($dMySql);
		while ($cRs=mysql_fetch_array($Resulta)){
?>
        <tr onmouseover="this.style.backgroundColor='#ffffcc'" onmouseout="this.style.backgroundColor=''">
         <td align="center"><?=$cRs[LogID]?></td>
         <td align="center"><?=$cRs[LogIP]?></td>
         <td align="center"><?=$cRs[LogTime]?></td>
         <td align="center"><?=$cRs[LogInfo]?></td>
         <td align="center"><? if($cRs[LogType]=='1'){ echo "��ȫ��־";}else{echo "������־";}?></td>
        </tr>
<?php
}
?>
		<form name="form" method="post" action="DelWebLog.php?LogType=<?=$LogType?>">
          <tr>
           <td height="12" colspan="7" align="right"><input name="<?=$LogType?>" value="ɾ��������־" type="submit"/></td>
          </tr>
		</form>
          <tr>
           <td height="13" colspan="7" align="center">
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
��<a href="WeblaborLog.php?LogType=<?=$LogType?>&Page=0">��ҳ</a> <a href="WeblaborLog.php?LogType=<?=$LogType?>&Page=<?=$Up?>">��һҳ</a> <a href="WeblaborLog.php?LogType=<?=$LogType?>&Page=<?=$Next?>">��һҳ</a> <a href="WeblaborLog.php?LogType=<?=$LogType?>&Page=<?=$Over?>">ĩҳ</a>			
</td>
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