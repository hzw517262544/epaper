<?php session_start();?>
<link href="Images/skin.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312"/>
<?php
include_once("../config.php");
if(($_SESSION['Admin']=="") or ($_SESSION['AdminSessionPWd']!= AdminSession or $_SESSION["login"] != true)){
	MessageBox("请勿非法登录，谢谢！","index.php");
}else{
?>
<table width="100%" border="0" cellpAdding="0" cellspacing="0">
  <tr>
    <td width="17" height="29" valign="top" background="Images/mail_leftbg.gif"><img src="Images/left-top-right.gif" width="17" height="29" /></td>
    <td height="29" valign="top" background="Images/content-bg.gif"><div class="titlebt">热点管理</div></td>
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
                <td width="39%" height="23" align="center">发行期刊</td>
                <td width="34%"></td>
                <td width="27%" align="center">操作选项</td>
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
                  &nbsp;(第
                  <?=$cRs[PublishID]?>
                  期)</td>
                <td width="27%" height="30" align="center" ><a href="AddPaper.php?PublishDate=<?=$cRs[PublishDate]?>">添加所属期刊版面</a> | <a href="ModifyNewsPaper.php?PublishID=<?=$cRs[PublishID]?>&PublishDate=<?=$cRs[PublishDate]?>">修改</a> | <a href="DelNewsPaper.php?PublishDate=<?=$cRs[PublishDate]?>" onclick='{if(confirm("确定要删除吗？删除此期刊同时将删除\n所包含的版面和新闻，并且不能恢复！")){return true;}return false;}'>删除</a> | <a href="HtmlSave.php?action=All_Html&PublishDate=<?=$cRs[PublishDate]?>">生成Html</a></td>
              </tr>
              <?php
$sMySql="select * from `FangBao_Rect` Where `PublishDate`='".$cRs[PublishDate]."' Order By ID Asc";
$sQuery=mysql_query($sMySql);
while($sRs=mysql_fetch_array($sQuery)){
?>
              <tr onmouseover="this.style.backgroundColor='#ffffcc'" onmouseout="this.style.backgroundColor=''">
                <td width="73%" height="30" align="left">　　<?=$sRs[VerOrder]?>（<?=$sRs[BanMian]?>）</td>
                <td height="30" align="center" >　　<a href="ModifyPaper.php?ID=<?=$sRs[ID]?>">添加/修改热图</a>
                  <?php
				  if ($sRs[IsFrist]=='1'){ 
				     $BanMianID="";
				  }else{
					 $BanMianID="_".$sRs[ID]."";
				  }
				  ?>
                  | <a href="../html/<?=$sRs[PublishDate]?>/qpaper<?=$BanMianID?>.html" target="_blank">预览</a> | <a href="DelPaper.php?ID=<?=$sRs[ID]?>&PublishDate=<?=$sRs[PublishDate]?>" onclick='{if(confirm("确定要删除吗？删除此版面同时将删除\n该版面下的所有新闻，并且不能恢复！")){return true;}return false;}'>删除</a> | <a href="HtmlSave.php?action=List_Html&PublishDate=<?=$sRs[PublishDate]?>&VerOrder=<?=$sRs[VerOrder]?>&RectID=<?=$sRs[ID]?>">生成Html</a></td>
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
              <a href="HotManage.php?Page=0">首页</a> <a href="HotManage.php?Page=<?=$Up?>">上一页</a> <a href="HotManage.php?Page=<?=$Next?>">下一页</a> <a href="HotManage.php?Page=<?=$Over?>">末页</a> </div></td>
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
