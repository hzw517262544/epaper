<?php session_start();?>
<link href="Images/skin.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<?php
include_once("../config.php");
$OperatorTime=date("Y年m月d日",time());
global $mysqlhost, $mysqluser, $mysqlpwd, $mysqldb;
include("MyData.php");
$d=new db($mysqlhost,$mysqluser,$mysqlpwd,$mysqldb);
mysql_query("set names GBK");
/******界面*/if(!$_POST['act']&&!$_SESSION['data_file']){/**********************/
$msgs[]="本功能在恢复备份数据的同时，将全部覆盖原有数据，请确定是否需要恢复，以免造成数据损失";
$msgs[]="数据恢复功能只能恢复由dShop导出的数据文件，其他软件导出格式可能无法识别";
$msgs[]="从本地恢复数据需要服务器支持文件上传并保证数据尺寸小于允许上传的上限，否则只能使用从服务器恢复";
$msgs[]="如果您使用了分卷备份，只需手工导入文件卷1，其他数据文件会由系统自动导入";

/**************************界面结束*/}/*************************************/
/****************************主程序*/if($_POST['act']=="恢复数据"){/**************/
/***************服务器恢复*/if($_POST['restorefrom']=="server"){/**************/
if(!$_POST['serverfile']){
	$msgs[]="您选择从服务器文件恢复备份，但没有指定备份文件";
    show_msg($msgs); pageend(); 
}
if(!preg_match("/^(_v[0-9]+)$/i",$_POST['serverfile'])){
	$filename="BackUp/".$_POST['serverfile'];
	if(import($filename)){
		$msgs[]="备份文件".$_POST['serverfile']."成功导入数据库";
		AdminLog("用户为".$_SESSION['Admin']."于".$OperatorTime."成功导入数据库",0);
	}else{
		$msgs[]="备份文件".$_POST['serverfile']."导入失败";
   		AdminLog("用户为".$_SESSION['Admin']."于".$OperatorTime."在导入数据库没有成功",0);
	}
    show_msg($msgs);
	pageend();  
}else{
	$filename="BackUp/".$_POST['serverfile'];
	if(import($filename)){
		$msgs[]="备份文件".$_POST['serverfile']."成功导入数据库";
   		AdminLog("用户为".$_SESSION['Admin']."于".$OperatorTime."成功导入数据库",0);
	}else{
		$msgs[]="备份文件".$_POST['serverfile']."导入失败";
   		AdminLog("用户为".$_SESSION['Admin']."于".$OperatorTime."在导入数据库没有成功",0);
	}
	show_msg($msgs);
	pageend();
	$voltmp=explode("_v",$_POST['serverfile']);
	$volname=$voltmp[0];
	$volnum=explode(".sq",$voltmp[1]);
	$volnum=intval($volnum[0])+1;
	$tmpfile=$volname."_v".$volnum.".sql";
	if(file_exists("BackUp/".$tmpfile)){
		$msgs[]="程序将在3秒钟后自动开始导入此分卷备份的下一部份：文件".$tmpfile."，请勿手动中止程序的运行，以免数据库结构受损";
		$_SESSION['data_file']=$tmpfile;
		show_msg($msgs);
		sleep(3);
		echo "<script language='javascript'>"; 
		echo "location='RestoreData.php';"; 
		echo "</script>"; 
    }else{
    	$msgs[]="此分卷备份全部导入成功";
    	show_msg($msgs);
    }
}
/**************服务器恢复结束*/
}
/********************************************/
/*****************本地恢复*/if($_POST['restorefrom']=="localpc"){/**************/
switch ($_FILES['myfile']['error'])
{
	case 1:
	case 2:
		$msgs[]="您上传的文件大于服务器限定值，上传未成功";
		break;
	case 3:
		$msgs[]="未能从本地完整上传备份文件";
		break;
	case 4:
		$msgs[]="从本地上传备份文件失败";
		break;
	case 0:
		break;
}
if($msgs){show_msg($msgs);pageend();}
$fname=date("Ymd",time())."_".sjs(5).".sql";
if (is_uploaded_file($_FILES['myfile']['tmp_name'])) {
	copy($_FILES['myfile']['tmp_name'], "./backup/".$fname);
}
if (file_exists("BackUp/".$fname)) {
	$msgs[]="本地备份文件上传成功";
	if(import("BackUp/".$fname)) {$msgs[]="本地备份文件成功导入数据库"; unlink("./backup/".$fname);
}else{
	$msgs[]="本地备份文件导入数据库失败";
}
}else{
	($msgs[]="从本地上传备份文件失败");
}
show_msg($msgs);
/****本地恢复结束*****/}/****************************************************/
/****************************主程序结束*/}/**********************************/
/*************************剩余分卷备份恢复**********************************/
if(!$_POST['act']&&$_SESSION['data_file'])
{
$filename="BackUp/".$_SESSION['data_file'];
if(import($filename)) $msgs[]="备份文件".$_SESSION['data_file']."成功导入数据库";
else {$msgs[]="备份文件".$_SESSION['data_file']."导入失败";show_msg($msgs);pageend();}
$voltmp=explode("_v",$_SESSION['data_file']);
$volname=$voltmp[0];
$volnum=explode(".sq",$voltmp[1]);
$volnum=intval($volnum[0])+1;
$tmpfile=$volname."_v".$volnum.".sql";
if(file_exists("BackUp/".$tmpfile))
    {
    $msgs[]="程序将在3秒钟后自动开始导入此分卷备份的下一部份：文件".$tmpfile."，请勿手动中止程序的运行，以免数据库结构受损";
    $_SESSION['data_file']=$tmpfile;
    show_msg($msgs);
    sleep(3);
    echo "<script language='javascript'>"; 
    echo "location='RestoreData.php';"; 
    echo "</script>"; 
    }
else
    {
    $msgs[]="此分卷备份全部导入成功";
    unset($_SESSION['data_file']);
    show_msg($msgs);
    }
}
/**********************剩余分卷备份恢复结束*******************************/
function import($fname)
{global $d;
$sqls=file($fname);
foreach($sqls as $sql)
{
str_replace("\r","",$sql);
str_replace("\n","",$sql);
if(!$d->query(trim($sql))) return false;
}
return true;
}
function show_msg($msgs)
{
$title="　提示：";
echo "<table width='100%' border='0' cellspacing='0' cellpadding='0' class='colorTest'>";
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
    <td height="29" valign="top" background="Images/content-bg.gif"><div class="titlebt">恢复数据</div></td>
    <td width="22" valign="top" background="Images/mail_rightbg.gif"><img src="Images/nav-right-bg.gif" width="16" height="29" /></td>
  </tr>
  <tr>
    <td height="83" valign="middle" background="Images/mail_leftbg.gif">&nbsp;</td>
    <td valign="top" bgcolor="#F7F8F9"><form action="" method="post" enctype="multipart/form-data" name="RestoreData.php">
        <table width="100%"  border="0" cellspacing="0" cellpadding="0" class="colorTest">
          <tr align="center">
            <td colspan="2" align="center"></td>
          </tr>
          <tr>
            <td width="33%"><input type="radio" name="restorefrom" value="server" checked />从服务器文件恢复 </td>
            <td width="67%"><select name="serverfile">
                <option value="">-请选择-</option>
                <?php
					$handle=opendir('BackUp');
					while ($file = readdir($handle)) {
						  if(preg_match("/^[0-9]{8,8}([0-9a-z_]+)(\.sql)$/i",$file)) echo "<option value='$file'>$file</option>";}
					closedir($handle); 
				?>
              </select></td>
          </tr>
          <tr>
            <td><input type="radio" name="restorefrom" value="localpc" />从本地文件恢复</td>
            <td><input type="hidden" name="MAX_FILE_SIZE" value="1500000" />
              <input type="file" name="myfile" /></td>
          </tr>
          <tr>
            <td colspan="2" align="center"><?php show_msg($msgs);?></td>
          </tr>
          <tr>
            <td colspan="2" align="center"><input type="submit" name="act" value="恢复数据" /></td>
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
<?php
}
?>
