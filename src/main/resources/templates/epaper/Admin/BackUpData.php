<?php session_start();?>
<link href="Images/skin.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<?php
include_once("../config.php");
$OperatorTime=date("Y��m��d��",time());
error_reporting(E_ALL & ~E_NOTICE);
global $mysqlhost, $mysqluser, $mysqlpwd, $mysqldb;
include("MyData.php");
$d=new db($mysqlhost,$mysqluser,$mysqlpwd,$mysqldb);
mysql_query("set names GBK");

/*-------------�������-------------*//*---------------------------------*/
/*----*��/*--------------������-----------------------------------------*/
if($_POST['weizhi']=="localpc"&&$_POST['fenjuan']=='yes')
{$msgs[]="ֻ��ѡ�񱸷ݵ�������������ʹ�÷־��ݹ���";
show_msg($msgs); pageend();}
if($_POST['fenjuan']=="yes"&&!$_POST['filesize'])
{$msgs[]="��ѡ���˷־��ݹ��ܣ���δ��д�־��ļ���С";
show_msg($msgs); pageend();}
if($_POST['weizhi']=="server"&&!writeable("BackUp"))
{$msgs[]="�����ļ����Ŀ¼'BackUp'����д�����޸�Ŀ¼����";
show_msg($msgs); pageend();}

/*----------����ȫ����-------------*/if($_POST['bfzl']=="quanbubiao"){/*----*/
/*----���־�*/if(!$_POST['fenjuan']){/*--------------------------------*/
if(!$tables=$d->query("show table status from $mysqldb"))
{$msgs[]="�����ݿ�ṹ����"; show_msg($msgs); pageend();}
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
   $msgs[]="ȫ�����ݱ����ݱ������,���ɱ����ļ�'BackUp/$filename'";
   AdminLog("�û�Ϊ".$_SESSION['Admin']."��".$OperatorTime."���������ݿ�",0);
	}
else
{
	$msgs[]="����ȫ�����ݱ�ʧ��";
    AdminLog("�û�Ϊ".$_SESSION['Admin']."��".$OperatorTime."���������ݿ�ʱʧ��",0);
}
show_msg($msgs);
pageend();
}
/*-----------------��Ҫ�����*/}/*-----------------------*/
/*-----------------�־�*/else{/*-------------------------*/
if(!$_POST['filesize'])
{$msgs[]="����д�����ļ��־��С"; show_msg($msgs);pageend();}
if(!$tables=$d->query("show table status from $mysqldb"))
{$msgs[]="�����ݿ�ṹ����"; show_msg($msgs); pageend();}
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
     $msgs[]="ȫ�����ݱ�-��-".$p."-���ݱ������,���ɱ����ļ�'BackUp/$filename'";
     else $msgs[]="���ݱ�-".$_POST['tablename']."-ʧ��";
     $p++;
     $filename=date("Ymd",time())."_all";
     $sql="";}
}
}
if($sql!=""){$filename.=("_v".$p.".sql");  
if(write_file($sql,$filename))
$msgs[]="ȫ�����ݱ�-��-".$p."-���ݱ������,���ɱ����ļ�'BackUp/$filename'";}
AdminLog("�û�Ϊ".$_SESSION['Admin']."��".$OperatorTime."�ɹ����������ݿ�",0);
show_msg($msgs);
/*---------------------�־����*/}/*--------------------------------------*/
/*--------����ȫ�������*/}/*---------------------------------------------*/

/*--------���ݵ���------*/elseif($_POST['bfzl']=="danbiao"){/*------------*/
if(!$_POST['tablename'])
{$msgs[]="��ѡ��Ҫ���ݵ����ݱ�"; show_msg($msgs); pageend();}
/*--------���־�*/if(!$_POST['fenjuan']){/*-------------------------------*/
$sql=make_header($_POST['tablename']);
$d->query("select * from ".$_POST['tablename']);
$num_fields=$d->nf();
while($d->nextrecord())
{$sql.=make_record($_POST['tablename'],$num_fields);}
$filename=date("Ymd",time())."_".$_POST['tablename'].".sql";
if($_POST['weizhi']=="localpc") down_file($sql,$filename);
elseif($_POST['weizhi']=="server")
{if(write_file($sql,$filename))
$msgs[]="��-".$_POST['tablename']."-���ݱ������,���ɱ����ļ�'BackUp/$filename'";
else $msgs[]="���ݱ�-".$_POST['tablename']."-ʧ��";
show_msg($msgs);
pageend();
}
/*----------------��Ҫ�����*/}/*------------------------------------*/
/*----------------�־�*/else{/*--------------------------------------*/
if(!$_POST['filesize'])
{$msgs[]="����д�����ļ��־��С"; show_msg($msgs);pageend();}
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
     $msgs[]="��-".$_POST['tablename']."-��-".$p."-���ݱ������,���ɱ����ļ�'BackUp/$filename'";
     else $msgs[]="���ݱ�-".$_POST['tablename']."-ʧ��";
     $p++;
     $filename=date("Ymd",time())."_".$_POST['tablename'];
     $sql="";}
}
if($sql!=""){$filename.=("_v".$p.".sql");  
if(write_file($sql,$filename))
$msgs[]="��-".$_POST['tablename']."-��-".$p."-���ݱ������,���ɱ����ļ�'BackUp/$filename'";}
show_msg($msgs);
/*----------�־����*/}/*--------------------------------------------------*/
/*----------���ݵ������*/}/*----------------------------------------------*/

//-------------���������------------------------------------------*/

function write_file($sql,$filename)
{
$re=true;
if(!@$fp=fopen("./BackUp/".$filename,"w+")) {$re=false; echo "BackUp�ļ��д�ʧ�ܣ���ȷ���Ƿ��ж�дȨ�ޣ�";}
if(!@fwrite($fp,$sql)) {$re=false; echo "BackUp�ļ���û��д��Ȩ�ޣ�";}
if(!@fclose($fp)) {$re=false; echo "BackUp�ļ����޷�������";}
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
$title="��ʾ��";
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
	MessageBox("����Ƿ���¼��лл��","index.php");
}
else{
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="17" height="29" valign="top" background="Images/mail_leftbg.gif"><img src="Images/left-top-right.gif" width="17" height="29" /></td>
    <td height="29" valign="top" background="Images/content-bg.gif"><div class="titlebt">��������</div></td>
    <td width="22" valign="top" background="Images/mail_rightbg.gif"><img src="Images/nav-right-bg.gif" width="16" height="29" /></td>
  </tr>
  <tr>
    <td height="83" valign="middle" background="Images/mail_leftbg.gif">&nbsp;</td>
    <td valign="top" bgcolor="#F7F8F9">
<form name="form1" method="post" action="BackUpData.php">
	 <table width="100%"  border="1" cellspacing="0" cellpadding="0" class="colorTest">
      <tr>
        <td> �� 
          <input type="radio" name="bfzl" value="quanbubiao" checked>����ȫ������</td>
	  <td>������ȫ�����ݱ��е����ݵ�һ�������ļ�</td>
      </tr>
      <tr>
        <td>��
          <input type="radio" name="bfzl" value="danbiao">���ݵ��ű����� 
          <select name="tablename"><option value="">��ѡ��</option>
    <?php
    $d->query("show table status from $mysqldb");
    while($d->nextrecord()){
    echo "<option value='".$d->f('Name')."'>".$d->f('Name')."</option>";}
    ?>
          </select></td>
        <td>������ѡ�����ݱ��е����ݵ������ı����ļ�</td>
      </tr>
      <tr>
        <td colspan="2">��ʹ�÷־���</td>
      </tr>
      <tr>
        <td colspan="2">��
          <input type="checkbox" name="fenjuan" value="yes">
          �־��� <input name="filesize" type="text" size="10">
          KB</td>
      </tr>
      <tr>
        <td colspan="2">��ѡ��Ŀ��λ��</td>
      </tr>
      <tr>
        <td colspan="2">��
          <input type="radio" name="weizhi" value="server" checked>���ݵ�������</td></tr><tr class="cells">
            <td colspan='2'> �� 
              <input type="radio" name="weizhi" value="localpc">���ݵ�����</td></tr>
      <tr>
        <td colspan="2" align='left'>
	  ��ע�⣺����������Ŀ¼Ϊ��̨BackUp�����ڽϴ�����ݱ�ǿ�ҽ���ʹ�÷־��ݣ�ֻ��ѡ�񱸷ݵ�������������ʹ�÷־��ݹ��ܣ�
	  </td>
      </tr>
      <tr>
        <td colspan="2" align='center'><input type="submit" name="act" value="��������"></td>
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
