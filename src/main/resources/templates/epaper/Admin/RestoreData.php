<?php session_start();?>
<link href="Images/skin.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<?php
include_once("../config.php");
$OperatorTime=date("Y��m��d��",time());
global $mysqlhost, $mysqluser, $mysqlpwd, $mysqldb;
include("MyData.php");
$d=new db($mysqlhost,$mysqluser,$mysqlpwd,$mysqldb);
mysql_query("set names GBK");
/******����*/if(!$_POST['act']&&!$_SESSION['data_file']){/**********************/
$msgs[]="�������ڻָ��������ݵ�ͬʱ����ȫ������ԭ�����ݣ���ȷ���Ƿ���Ҫ�ָ����������������ʧ";
$msgs[]="���ݻָ�����ֻ�ָܻ���dShop�����������ļ����������������ʽ�����޷�ʶ��";
$msgs[]="�ӱ��ػָ�������Ҫ������֧���ļ��ϴ�����֤���ݳߴ�С�������ϴ������ޣ�����ֻ��ʹ�ôӷ������ָ�";
$msgs[]="�����ʹ���˷־��ݣ�ֻ���ֹ������ļ���1�����������ļ�����ϵͳ�Զ�����";

/**************************�������*/}/*************************************/
/****************************������*/if($_POST['act']=="�ָ�����"){/**************/
/***************�������ָ�*/if($_POST['restorefrom']=="server"){/**************/
if(!$_POST['serverfile']){
	$msgs[]="��ѡ��ӷ������ļ��ָ����ݣ���û��ָ�������ļ�";
    show_msg($msgs); pageend(); 
}
if(!preg_match("/^(_v[0-9]+)$/i",$_POST['serverfile'])){
	$filename="BackUp/".$_POST['serverfile'];
	if(import($filename)){
		$msgs[]="�����ļ�".$_POST['serverfile']."�ɹ��������ݿ�";
		AdminLog("�û�Ϊ".$_SESSION['Admin']."��".$OperatorTime."�ɹ��������ݿ�",0);
	}else{
		$msgs[]="�����ļ�".$_POST['serverfile']."����ʧ��";
   		AdminLog("�û�Ϊ".$_SESSION['Admin']."��".$OperatorTime."�ڵ������ݿ�û�гɹ�",0);
	}
    show_msg($msgs);
	pageend();  
}else{
	$filename="BackUp/".$_POST['serverfile'];
	if(import($filename)){
		$msgs[]="�����ļ�".$_POST['serverfile']."�ɹ��������ݿ�";
   		AdminLog("�û�Ϊ".$_SESSION['Admin']."��".$OperatorTime."�ɹ��������ݿ�",0);
	}else{
		$msgs[]="�����ļ�".$_POST['serverfile']."����ʧ��";
   		AdminLog("�û�Ϊ".$_SESSION['Admin']."��".$OperatorTime."�ڵ������ݿ�û�гɹ�",0);
	}
	show_msg($msgs);
	pageend();
	$voltmp=explode("_v",$_POST['serverfile']);
	$volname=$voltmp[0];
	$volnum=explode(".sq",$voltmp[1]);
	$volnum=intval($volnum[0])+1;
	$tmpfile=$volname."_v".$volnum.".sql";
	if(file_exists("BackUp/".$tmpfile)){
		$msgs[]="������3���Ӻ��Զ���ʼ����˷־��ݵ���һ���ݣ��ļ�".$tmpfile."�������ֶ���ֹ��������У��������ݿ�ṹ����";
		$_SESSION['data_file']=$tmpfile;
		show_msg($msgs);
		sleep(3);
		echo "<script language='javascript'>"; 
		echo "location='RestoreData.php';"; 
		echo "</script>"; 
    }else{
    	$msgs[]="�˷־���ȫ������ɹ�";
    	show_msg($msgs);
    }
}
/**************�������ָ�����*/
}
/********************************************/
/*****************���ػָ�*/if($_POST['restorefrom']=="localpc"){/**************/
switch ($_FILES['myfile']['error'])
{
	case 1:
	case 2:
		$msgs[]="���ϴ����ļ����ڷ������޶�ֵ���ϴ�δ�ɹ�";
		break;
	case 3:
		$msgs[]="δ�ܴӱ��������ϴ������ļ�";
		break;
	case 4:
		$msgs[]="�ӱ����ϴ������ļ�ʧ��";
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
	$msgs[]="���ر����ļ��ϴ��ɹ�";
	if(import("BackUp/".$fname)) {$msgs[]="���ر����ļ��ɹ��������ݿ�"; unlink("./backup/".$fname);
}else{
	$msgs[]="���ر����ļ��������ݿ�ʧ��";
}
}else{
	($msgs[]="�ӱ����ϴ������ļ�ʧ��");
}
show_msg($msgs);
/****���ػָ�����*****/}/****************************************************/
/****************************���������*/}/**********************************/
/*************************ʣ��־��ݻָ�**********************************/
if(!$_POST['act']&&$_SESSION['data_file'])
{
$filename="BackUp/".$_SESSION['data_file'];
if(import($filename)) $msgs[]="�����ļ�".$_SESSION['data_file']."�ɹ��������ݿ�";
else {$msgs[]="�����ļ�".$_SESSION['data_file']."����ʧ��";show_msg($msgs);pageend();}
$voltmp=explode("_v",$_SESSION['data_file']);
$volname=$voltmp[0];
$volnum=explode(".sq",$voltmp[1]);
$volnum=intval($volnum[0])+1;
$tmpfile=$volname."_v".$volnum.".sql";
if(file_exists("BackUp/".$tmpfile))
    {
    $msgs[]="������3���Ӻ��Զ���ʼ����˷־��ݵ���һ���ݣ��ļ�".$tmpfile."�������ֶ���ֹ��������У��������ݿ�ṹ����";
    $_SESSION['data_file']=$tmpfile;
    show_msg($msgs);
    sleep(3);
    echo "<script language='javascript'>"; 
    echo "location='RestoreData.php';"; 
    echo "</script>"; 
    }
else
    {
    $msgs[]="�˷־���ȫ������ɹ�";
    unset($_SESSION['data_file']);
    show_msg($msgs);
    }
}
/**********************ʣ��־��ݻָ�����*******************************/
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
$title="����ʾ��";
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
	MessageBox("����Ƿ���¼��лл��","index.php");
}
else{
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="17" height="29" valign="top" background="Images/mail_leftbg.gif"><img src="Images/left-top-right.gif" width="17" height="29" /></td>
    <td height="29" valign="top" background="Images/content-bg.gif"><div class="titlebt">�ָ�����</div></td>
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
            <td width="33%"><input type="radio" name="restorefrom" value="server" checked />�ӷ������ļ��ָ� </td>
            <td width="67%"><select name="serverfile">
                <option value="">-��ѡ��-</option>
                <?php
					$handle=opendir('BackUp');
					while ($file = readdir($handle)) {
						  if(preg_match("/^[0-9]{8,8}([0-9a-z_]+)(\.sql)$/i",$file)) echo "<option value='$file'>$file</option>";}
					closedir($handle); 
				?>
              </select></td>
          </tr>
          <tr>
            <td><input type="radio" name="restorefrom" value="localpc" />�ӱ����ļ��ָ�</td>
            <td><input type="hidden" name="MAX_FILE_SIZE" value="1500000" />
              <input type="file" name="myfile" /></td>
          </tr>
          <tr>
            <td colspan="2" align="center"><?php show_msg($msgs);?></td>
          </tr>
          <tr>
            <td colspan="2" align="center"><input type="submit" name="act" value="�ָ�����" /></td>
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
