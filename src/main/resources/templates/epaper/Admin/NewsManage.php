<?php session_start();?>
<link href="Images/skin.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<?php
include_once("../config.php");
if(($_SESSION['Admin']=="") or ($_SESSION['AdminSessionPWd']!= AdminSession or $_SESSION["login"] != true)){
	MessageBox("请勿非法登录，谢谢！","index.php");
}else{
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="17" height="29" valign="top" background="Images/mail_leftbg.gif"><img src="Images/left-top-right.gif" width="17" height="29" /></td>
    <td height="29" valign="top" background="Images/content-bg.gif"><div class="titlebt">新闻管理</div></td>
    <td width="22" valign="top" background="Images/mail_rightbg.gif"><img src="Images/nav-right-bg.gif" width="16" height="29" /></td>
  </tr>
  <tr>
    <td valign="middle" background="Images/mail_leftbg.gif"></td>
    <td valign="top" bgcolor="#F7F8F9"><table width="100%"  border="1" cellspacing="0" cellpadding="0" class="colorTest">
        <tr>
          <td height="30"><form id="form" name="form" method="post" action="DelNews.php">
              <table width="100%"  border="1" cellspacing="0" cellpadding="0" class="colorTest">
                <tr class="sec1">
                  <td width="62%" align="center">新闻标题</td>
                  <td width="12%" align="center">新闻作者</td>
                  <td width="12%" align="center">发布日期</td>
                  <td width="11%" align="center">操作选项</td>
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
                  <td width="11%" height="30" align="center"><a href="ModifyNews.php?ID=<?=$cRs[ID]?>">修改</a> ‖ <a href="DelNews.php?ID=<?=$cRs[ID]?>" onclick='{if(confirm("您确定删除吗?此操作将不能恢复!")){return true;}return false;}'>删除</a> ‖ <a href="HtmlSave.php?action=Page_Html&ID=<?=$cRs[ID]?>">生成</a></td>
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
echo "总" . $Num."条  ";
echo "每页".$PageNum."条  ";
echo "("."第 $sPage 页/";
echo "共 $AllPage 页".") ";
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
              <a href="NewsManage.php?Page=0">首页</a> <a href="NewsManage.php?Page=<?=$Up?>">上一页</a> <?php
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
			  	   echo "<a".$c." href=\"NewsManage.php?Page=".$i."\">第".($i+1)."页</a> ";
			    }
			  ?> <a href="NewsManage.php?Page=<?=$Next?>">下一页</a> <a href="NewsManage.php?Page=<?=$Over?>">末页</a></div></td>
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