<?php
include_once("../../config.php");
include_once("../Include/Function.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>往期回顾-<?php echo $Ghost_WebSiteName;?>-<?php echo $Ghost_WebPowered;?></title>
<meta content="text/html; charset=gb2312" http-equiv="content-type" />
<link rel=stylesheet type=text/css href="../../Images/css.css" />
<meta content="blendTrans(duration=0.5)" http-equiv="Page-Enter" />
<meta content="blendTrans(duration=0.5)" http-equiv="Page-Exit" />
</head>
<body>
<table width="980" border="0" align="center" cellpadding="0" cellspacing="0" >
 <tr align="left" >
	<td>
		<img src="../../Images/pic_03.jpg" />
	</td>
 </tr>
 <tr>
  <td width="100%" height="32" background="../../Images/pic_02.gif"> </td>
 </tr>
</table>
<table width="980" border="0" align="center" cellpadding="0" cellspacing="0">
 <tr>
  <td bgcolor="#e0dbd5">
    <?php Pic_index(24);?>
  </td>
 </tr>
</table>
<table width="980" border="0" align="center" cellpadding="0" cellspacing="0" style="background-color:#000;">
  <tr>
    <td height="40" align="center" valign="middle" class="White_a" style="line-height:40px;">
     <?php echo $Ghost_WebSiteCopyInfo;?> | 备案号：<?php echo $Ghost_WebSiteTCP;?> <?php echo $Ghost_WebTongJi;?>
    </td>
  </tr>
</table>
</body>
</html>