<?php session_start();?>
<link href="Images/skin.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<?php
include_once("../config.php");
$OperatorTime=date("Y年m月d日",time());
error_reporting(E_ALL & ~E_NOTICE);
global $mysqlhost, $mysqluser, $mysqlpwd, $mysqldb;
include("MyData.php");
$d=new db($mysqlhost,$mysqluser,$mysqlpwd,$mysqldb);
mysql_query("set names GBK");

/*-------------界面结束-------------*//*---------------------------------*/
/*----*、/*--------------主程序-----------------------------------------*/
if($_POST['weizhi']=="localpc"&&$_POST['fenjuan']=='yes')
{$msgs[]="只有选择备份到服务器，才能使用分卷备份功能";
show_msg($msgs); pageend();}
if($_POST['fenjuan']=="yes"&&!$_POST['filesize'])
{$msgs[]="您选择了分卷备份功能，但未填写分卷文件大小";
show_msg($msgs); pageend();}
if($_POST['weizhi']=="server"&&!writeable("BackUp"))
{$msgs[]="备份文件存放目录'BackUp'不可写，请修改目录属性";
show_msg($msgs); pageend();}

/*----------备份全部表-------------*/if($_POST['bfzl']=="quanbubiao"){/*----*/
/*----不分卷*/if(!$_POST['fenjuan']){/*--------------------------------*/
if(!$tables=$d->query("show table status from $mysqldb"))
{$msgs[]="读数据库结构错误"; show_msg($msgs); pageend();}
$sql="";
while($d->nextrecord($tables))
{
$table=$d->f("Name");
$sql.=make_header($table);
$d->query("select * from $table");
$num_fields=$d->nf();
while($d->nextrecord())
{$sql.=make_record($table,$num_fields);}
}
$filename=date("Ymd",time())."_all.sql";
if($_POST['weizhi']=="localpc") down_file($sql,$filename);
elseif($_POST['weizhi']=="server")
{
	if(write_file($sql,$filename))
	{
   $msgs[]="全部数据表数据备份完成,生成备份文件'BackUp/$filename'";
   AdminLog("用户为".$_SESSION['Admin']."于".$OperatorTime."备份了数据库",0);
	}
else
{
	$msgs[]="备份全部数据表失败";
    AdminLog("用户为".$_SESSION['Admin']."于".$OperatorTime."备份了数据库时失败",0);
}
show_msg($msgs);
pageend();
}
/*-----------------不要卷结束*/}/*-----------------------*/
/*-----------------分卷*/else{/*-------------------------*/
if(!$_POST['filesize'])
{$msgs[]="请填写备份文件分卷大小"; show_msg($msgs);pageend();}
if(!$tables=$d->query("show table status from $mysqldb"))
{$msgs[]="读数据库结构错误"; show_msg($msgs); pageend();}
$sql=""; $p=1;
$filename=date("Ymd",time())."_all";
while($d->nextrecord($tables))
{
$table=$d->f("Name");
$sql.=make_header($table);
$d->query("select * from $table");
$num_fields=$d->nf();
while($d->nextrecord())
{$sql.=make_record($table,$num_fields);
if(strlen($sql)>=$_POST['filesize']*1000){
     $filename.=("_v".$p.".sql");
     if(write_file($sql,$filename))
     $msgs[]="全部数据表-卷-".$p."-数据备份完成,生成备份文件'BackUp/$filename'";
     else $msgs[]="备份表-".$_POST['tablename']."-失败";
     $p++;
     $filename=date("Ymd",time())."_all";
     $sql="";}
}
}
if($sql!=""){$filename.=("_v".$p.".sql");  
if(write_file($sql,$filename))
$msgs[]="全部数据表-卷-".$p."-数据备份完成,生成备份文件'BackUp/$filename'";}
AdminLog("用户为".$_SESSION['Admin']."于".$OperatorTime."成功备份了数据库",0);
show_msg($msgs);
/*---------------------分卷结束*/}/*--------------------------------------*/
/*--------备份全部表结束*/}/*---------------------------------------------*/

/*--------备份单表------*/elseif($_POST['bfzl']=="danbiao"){/*------------*/
if(!$_POST['tablename'])
{$msgs[]="请选择要备份的数据表"; show_msg($msgs); pageend();}
/*--------不分卷*/if(!$_POST['fenjuan']){/*-------------------------------*/
$sql=make_header($_POST['tablename']);
$d->query("select * from ".$_POST['tablename']);
$num_fields=$d->nf();
while($d->nextrecord())
{$sql.=make_record($_POST['tablename'],$num_fields);}
$filename=date("Ymd",time())."_".$_POST['tablename'].".sql";
if($_POST['weizhi']=="localpc") down_file($sql,$filename);
elseif($_POST['weizhi']=="server")
{if(write_file($sql,$filename))
$msgs[]="表-".$_POST['tablename']."-数据备份完成,生成备份文件'BackUp/$filename'";
else $msgs[]="备份表-".$_POST['tablename']."-失败";
show_msg($msgs);
pageend();
}
/*----------------不要卷结束*/}/*------------------------------------*/
/*----------------分卷*/else{/*--------------------------------------*/
if(!$_POST['filesize'])
{$msgs[]="请填写备份文件分卷大小"; show_msg($msgs);pageend();}
$sql=make_header($_POST['tablename']); $p=1; 
$filename=date("Ymd",time())."_".$_POST['tablename'];
$d->query("select * from ".$_POST['tablename']);
$num_fields=$d->nf();
while ($d->nextrecord()) 
{ 
    $sql.=make_record($_POST['tablename'],$num_fields);
      if(strlen($sql)>=$_POST['filesize']*1000){
     $filename.=("_v".$p.".sql");
     if(write_file($sql,$filename))
     $msgs[]="表-".$_POST['tablename']."-卷-".$p."-数据备份完成,生成备份文件'BackUp/$filename'";
     else $msgs[]="备份表-".$_POST['tablename']."-失败";
     $p++;
     $filename=date("Ymd",time())."_".$_POST['tablename'];
     $sql="";}
}
if($sql!=""){$filename.=("_v".$p.".sql");  
if(write_file($sql,$filename))
$msgs[]="表-".$_POST['tablename']."-卷-".$p."-数据备份完成,生成备份文件'BackUp/$filename'";}
show_msg($msgs);
/*----------分卷结束*/}/*--------------------------------------------------*/
/*----------备份单表结束*/}/*----------------------------------------------*/

//-------------主程序结束------------------------------------------*/

function write_file($sql,$filename)
{
$re=true;
if(!@$fp=fopen("./BackUp/".$filename,"w+")) {$re=false; echo "BackUp文件夹打开失败，请确认是否有读写权限！";}
if(!@fwrite($fp,$sql)) {$re=false; echo "BackUp文件夹没有写入权限！";}
if(!@fclose($fp)) {$re=false; echo "BackUp文件夹无法操作！";}
return $re;
}
function down_file($sql,$filename)
{
ob_end_clean();
header("Content-Encoding: none");
header("Content-Type: ".(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') ? 'application/octetstream' : 'application/octet-stream'));
   
header("Content-Disposition: ".(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') ? 'inline; ' : 'attachment; ')."filename=".$filename);
   
header("Content-Length: ".strlen($sql));
header("Pragma: no-cache");
   
header("Expires: 0");
echo $sql;
$e=ob_get_contents();
ob_end_clean();
}
function writeable($dir)
{
if(!is_dir($dir)) {
@mkdir($dir, 0777);
}
if(is_dir($dir)) 
{
if($fp = @fopen("$dir/test.test", 'w'))
    {
@fclose($fp);
@unlink("$dir/test.test");
$writeable = 1;
} 
else {
$writeable = 0;
}
}
return $writeable;
}
function make_header($table)
{global $d;
$sql="DROP TABLE IF EXISTS ".$table."\n";
$d->query("show create table ".$table);
$d->nextrecord();
$tmp=preg_replace("/\n/","",$d->f("Create Table"));
$sql.=$tmp."\n";
return $sql;
}
function make_record($table,$num_fields)
{
global $d;
$comma="";
$sql .= "Insert Into ".$table." VALUES(";
for($i = 0; $i < $num_fields; $i++) 
{$sql .= ($comma."'".mysql_escape_string($d->record[$i])."'"); $comma = ",";}
$sql .= ")\n";
return $sql;
}
function show_msg($msgs)
{
$title="提示：";
echo "<table width=\"100%\"  border=\"1\" cellspacing=\"0\" cellpadding=\"0\" class=\"colorTest\">";
echo "<tr><td>".$title."</td></tr>";
echo "<tr><td><ul>";
while (list($k,$v)=each($msgs))
{
echo "<li>".$v."</li>";
}
echo "</ul></td></tr></table>";
}
function pageend()
{
exit();
}
if(($_SESSION['Admin']=="") or ($_SESSION['AdminSessionPWd']!= AdminSession or $_SESSION["login"] != true)){
	MessageBox("请勿非法登录，谢谢！","index.php");
}
else{
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="17" height="29" valign="top" background="Images/mail_leftbg.gif"><img src="Images/left-top-right.gif" width="17" height="29" /></td>
    <td height="29" valign="top" background="Images/content-bg.gif"><div class="titlebt">备份数据</div></td>
    <td width="22" valign="top" background="Images/mail_rightbg.gif"><img src="Images/nav-right-bg.gif" width="16" height="29" /></td>
  </tr>
  <tr>
    <td height="83" valign="middle" background="Images/mail_leftbg.gif">&nbsp;</td>
    <td valign="top" bgcolor="#F7F8F9">
<form name="form1" method="post" action="BackUpData.php">
	 <table width="100%"  border="1" cellspacing="0" cellpadding="0" class="colorTest">
      <tr>
        <td> 　 
          <input type="radio" name="bfzl" value="quanbubiao" checked>备份全部数据</td>
	  <td>　备份全部数据表中的数据到一个备份文件</td>
      </tr>
      <tr>
        <td>　
          <input type="radio" name="bfzl" value="danbiao">备份单张表数据 
          <select name="tablename"><option value="">请选择</option>
    <?php
    $d->query("show table status from $mysqldb");
    while($d->nextrecord()){
    echo "<option value='".$d->f('Name')."'>".$d->f('Name')."</option>";}
    ?>
          </select></td>
        <td>　备份选中数据表中的数据到单独的备份文件</td>
      </tr>
      <tr>
        <td colspan="2">　使用分卷备份</td>
      </tr>
      <tr>
        <td colspan="2">　
          <input type="checkbox" name="fenjuan" value="yes">
          分卷备份 <input name="filesize" type="text" size="10">
          KB</td>
      </tr>
      <tr>
        <td colspan="2">　选择目标位置</td>
      </tr>
      <tr>
        <td colspan="2">　
          <input type="radio" name="weizhi" value="server" checked>备份到服务器</td></tr><tr class="cells">
            <td colspan='2'> 　 
              <input type="radio" name="weizhi" value="localpc">备份到本地</td></tr>
      <tr>
        <td colspan="2" align='left'>
	  　注意：服务器备份目录为后台BackUp，对于较大的数据表，强烈建议使用分卷备份，只有选择备份到服务器，才能使用分卷备份功能！
	  </td>
      </tr>
      <tr>
        <td colspan="2" align='center'><input type="submit" name="act" value="备份数据"></td>
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
<?php
}
?>
