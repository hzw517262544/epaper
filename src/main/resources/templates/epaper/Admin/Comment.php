<?php session_start();?>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312"/>
<link href="Images/skin.css" rel="stylesheet" type="text/css" />
<?php
include_once("../config.php");
if(($_SESSION['Admin']=="") or ($_SESSION['AdminSessionPWd']!= AdminSession or $_SESSION["login"] != true)){
	MessageBox("����Ƿ���¼��лл��","index.php");
}else{
?>
<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="17" height="29" valign="top" background="Images/mail_leftbg.gif"><img src="Images/left-top-right.gif" width="17" height="29" /></td>
    <td height="29" valign="top" background="Images/content-bg.gif"><div class="titlebt">���۹���</div></td>
    <td width="22" valign="top" background="Images/mail_rightbg.gif"><img src="Images/nav-right-bg.gif" width="16" height="29" /></td>
  </tr>
  <tr>
    <td valign="middle" background="Images/mail_leftbg.gif">&nbsp;</td>
    <td valign="top" bgcolor="#F7F8F9">
    <table width="100%"  border="1" cellspacing="0" cellpadding="0" class="colorTest">
            <tr>
              <td height="30" class="left_ts" align="center">
			  <form id="form" name="form" method="post" action="CommentDel.php">
<?php
$tMySql="Select count(*) From `FangBao_PingLun` Order By PingLunID Desc";
$oQuery=mysql_query($tMySql);
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
		$tMySql="Select * From `FangBao_PingLun` Order By Time limit ".($Page*$PageNum).",$PageNum ";
		$Resulta=mysql_query($tMySql);
		while ($cRs=mysql_fetch_array($Resulta)){
?>
<table width="100%"  border="1" cellspacing="0" cellpadding="0" class="colorTest">
                  <tr>
                  <td width="6%" class="left_bt2">�����ˣ�</td>
                  <td width="8%" class="left_ts"><b><?=$cRs[PingLunName]?></b></td>
                  <td width="8%" class="left_bt2">���������£�</td>
                  <td width="57%" align="left" class="left_ts">
<?php
$NewsSql="Select * From `FangBao_News` Where `ID`=".$cRs[ID]."";
$sResult=mysql_query($NewsSql); 				 
$sRs=mysql_fetch_array($sResult);
$IsShow=$cRs[IsShow];
if($IsShow==0){
	$text="<span class=\"left_ts\">�ر�</span>";
	$IsShow=1;
}else{
	$text="<span class=\"left_ts\">��ʾ</span>";
	$IsShow=0;
}
?>
    <a href="../html/<?=$sRs[PublishDate]?>/<?=$cRs[ID]?>.html" target="_blank"><div class="left_ts"><?=$sRs[Title]?></div></a></td>
                  <td width="10%" align="center">
				  <a href="CommentDel.php?PingLunID=<?=$cRs[PingLunID]?>">ɾ��</a> | <a href="CommentDel.php?PingLunID=<?=$cRs[PingLunID]?>&IsShow=<?=$IsShow?>"><?=$text?></a></td>
                  </tr>
<tr class=list onMouseOver="this.style.backgroundColor='#ffffcc'" onMouseOut="this.style.backgroundColor=''">
                  <td colspan="7" align="left">����<?=$cRs[PingLunContent]?> (<?=$cRs[Time]?>)</td>
                  </tr>
              </table>
<?php
}
?>
</form></td>
            </tr>
            <tr>
              <td height="100%" colspan="6" align="center">
<?php 
$sPage=$Page+1;  
echo "��" . $Num."��  ";
echo "ÿҳ".$PageNum."��  ";
echo "("."�� $sPage ҳ/";
echo "�� $AllPage ҳ".") ";
?>
��<a href="Comment.php?Page=0">��ҳ</a> <a href="Comment.php?Page=<?php echo $Page-1?>">��һҳ</a> <a href="Comment.php?Page=<?php echo $Page+1?>">��һҳ</a> <a href="Comment.php?Page=<?php echo ceil($Num/$PageNum)-1?>">ĩҳ</a>
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
</body>
</html>
<?php
}
?>