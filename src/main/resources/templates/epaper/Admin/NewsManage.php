<?php session_start();?>
<link href="Images/skin.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<?php
include_once("../config.php");
if(($_SESSION['Admin']=="") or ($_SESSION['AdminSessionPWd']!= AdminSession or $_SESSION["login"] != true)){
	MessageBox("����Ƿ���¼��лл��","index.php");
}else{
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="17" height="29" valign="top" background="Images/mail_leftbg.gif"><img src="Images/left-top-right.gif" width="17" height="29" /></td>
    <td height="29" valign="top" background="Images/content-bg.gif"><div class="titlebt">���Ź���</div></td>
    <td width="22" valign="top" background="Images/mail_rightbg.gif"><img src="Images/nav-right-bg.gif" width="16" height="29" /></td>
  </tr>
  <tr>
    <td valign="middle" background="Images/mail_leftbg.gif"></td>
    <td valign="top" bgcolor="#F7F8F9"><table width="100%"  border="1" cellspacing="0" cellpadding="0" class="colorTest">
        <tr>
          <td height="30"><form id="form" name="form" method="post" action="DelNews.php">
              <table width="100%"  border="1" cellspacing="0" cellpadding="0" class="colorTest">
                <tr class="sec1">
                  <td width="62%" align="center">���ű���</td>
                  <td width="12%" align="center">��������</td>
                  <td width="12%" align="center">��������</td>
                  <td width="11%" align="center">����ѡ��</td>
                </tr>
                <?php
	$oMySql="Select count(*) From FangBao_News Order By ID Desc";
	$oQuery=mysql_query($oMySql);
	$oRs=mysql_fetch_array($oQuery); 
	$Num=$oRs[0];
	$PageNum=20;
	$AllPage=ceil($Num/$PageNum);
   if(Inject_Check(empty($_GET['Page']))){
		$Page=0;
   }else{
    $Page=Inject_Check($_GET['Page']);
    if ($Page<0) $Page=0;
    if($Page>=ceil($Num/$PageNum)) $Page=ceil($Num/$PageNum)-1;   
    }
		$dMySql="Select * From `FangBao_News` Order By ID Desc Limit ".($Page*$PageNum).",$PageNum ";
		$Resulta=mysql_query($dMySql);
		while ($cRs=mysql_fetch_array($Resulta)){
?>
                <tr onmouseover="this.style.backgroundColor='#ffffcc'" onmouseout="this.style.backgroundColor=''">
                  <td width="62%" align="left">[
                    <? Format_Time(2,$cRs[PublishDate]);?>
                    <?=$cRs[VerOrder]?>
                    ]
                    <?=$cRs[Title]?>
                    </span></td>
                  <td width="12%" align="center"><?=$cRs[User]?></td>
                  <td width="12%" align="center"><?=$cRs[InfoTime]?></td>
                  <td width="11%" height="30" align="center"><a href="ModifyNews.php?ID=<?=$cRs[ID]?>">�޸�</a> �� <a href="DelNews.php?ID=<?=$cRs[ID]?>" onclick='{if(confirm("��ȷ��ɾ����?�˲��������ָܻ�!")){return true;}return false;}'>ɾ��</a> �� <a href="HtmlSave.php?action=Page_Html&ID=<?=$cRs[ID]?>">����</a></td>
                </tr>
                <?php
}
?>
              </table>
            </form></td>
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
              <a href="NewsManage.php?Page=0">��ҳ</a> <a href="NewsManage.php?Page=<?=$Up?>">��һҳ</a> <?php
			  $a=(int)($_GET['Page']-3);
			  $b=(int)($_GET['Page']+3);
			  if($a<1) $a=0;
			  if(($b-$AllPage)>0) $b=$AllPage-1;
                for ($i = $a; $i <= $b; $i++) {
				   if($i==$_GET['Page']){
					   $c=" style=\"font-weight:bold; color:#FF0000;\"";
				   }else{
					   $c="";
				   }
			  	   echo "<a".$c." href=\"NewsManage.php?Page=".$i."\">��".($i+1)."ҳ</a> ";
			    }
			  ?> <a href="NewsManage.php?Page=<?=$Next?>">��һҳ</a> <a href="NewsManage.php?Page=<?=$Over?>">ĩҳ</a></div></td>
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