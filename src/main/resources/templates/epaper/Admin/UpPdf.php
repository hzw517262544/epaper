<?php
session_start();
include_once("../config.php");
header("Content-Type:text/html;charset=gb2312");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
<!--        "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd"-->
        >
<html> 
<head> 
<title>ͼƬ�ϴ�</title> 
<meta http-equiv="content-type" content="text/html; charset=gb2312" />
<style type="text/css"> 
<!--
body{ margin:0; font-size:12px; background-color:#F7F8F9;}
input{border-width:1px;border:1px solid #bdbcbd;padding:3px 0 3px 5px;} 
.inputbut {padding-left:3px;padding-right:2px;border:1px solid #bdbcbd;font-size:12px;height:22px;} 
--> 
</style> 
</head> 
<body> 
<?php
$ID=$_GET["ID"];
if(($_SESSION['Admin']=="") or ($_SESSION['AdminSessionPWd']!= AdminSession or $_SESSION["login"] != true)){
	MessageBox("����Ƿ���¼��лл��","index.php");
}
switch($_GET["action"]) 
{ 
	case "up": 
		UpMovie($ID); 
		break; 
	default: 
		UpInput($ID); 
		break; 
} 

function UpInput($ID){ 
?> 
<script language="javascript"> 
function check()  
{ 
	var strFileName=document.form.strPhoto.value; 
	if (strFileName=="") 
	{ 
		 alert("��ѡ��Ҫ�ϴ����ļ���"); 
		 document.form.strPhoto.focus(); 
		 return false; 
	} 
	return true; 
} 
</script> 
<form action="UpPdf.php?action=up&ID=<?=$ID?>" enctype="multipart/form-data" name="form" method="post" onSubmit="if (!check()) return false;"> 
<input name="strPhoto" type="file" id="strPhoto" size="1" class="inputbut" /> 
<input type="submit" name="Submit" value="�� ��" class="inputbut" /> 
</form>
<?php
}
function UpMovie($ID){
	$web_picdir="../uploads/pdf/";
	$savePath=dirname(__FILE__)."/".$web_picdir;
	$str = date('YmdHis');
	if($_FILES['strPhoto']['name']!=''){
		$tmp_file=$_FILES['strPhoto']['tmp_name'];
		$file_types=explode(".",$_FILES['strPhoto']['name']);
		$file_type=$file_types[count($file_types)-1];
		if(strtolower($file_type)!="jpg"&strtolower($file_type)!="pdf"&strtolower($file_type)!="rar"&strtolower($file_type)!="doc"){
			echo "<span style=\"color:red;line-height: 25px;\">��ʽ�����������ϴ�<a href=\"#\" onclick=history.go(-1);>[����]</a></span>";
			exit;
		}
		$file_name=$str.".".$file_type; 
		if(!copy($tmp_file,$savePath.$file_name)){
			echo "<span style=\"color:red;line-height: 25px;\">�ϴ����������ԣ���<a href=\"#\" onclick=history.go(-1);>[����]</a></span>"; 
		}else{
			echo "<span style=\"color:red;line-height: 25px;\">�ϴ��ɹ�,</span><script>parent.document.getElementById(\"{$ID}\").value=\"uploads/pdf/".$file_name."\"</script>"; 
			echo "<a href=# onclick=history.go(-1);>����Ҫ�޸�,�������ϴ�</a>";
		}
	}else{
		echo "<span style=\"color:red;line-height: 25px;\">��ѡ����Ҫ�ϴ����ļ�<a href=\"#\" onclick=history.go(-1);>[����]</a></span>";
	}
}
?>
</body>
</html>