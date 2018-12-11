<?php session_start();?>
<html>
<title>电子报管理系统-后台登陆</title>
<meta http-equiv="Content-Type" content="text/html; chaRset=gb2312">
<link href="Images/skin.css" rel="stylesheet" type="text/css" />
<script language="JavaScript">
function FrontPage(theForm){
  if (theForm.Admin.value == "")
  {
    alert("请输入管理员账户！");
    theForm.Admin.focus();
    return (false);
  }

  if (theForm.PassWord.value == "")
  {
    alert("请输入管理员密码！");
    theForm.PassWord.focus();
    return (false);
  }
  
    if (theForm.Yzm.value == "")
  {
    alert("请输入验证码！");
    theForm.Yzm.focus();
    return (false);
  }
  
  return (true);
}
function correctPNG()
{
    var arVersion = navigator.appVersion.split("MSIE")
    var version = parseFloat(arVersion[1])
    if ((version >= 5.5) && (document.body.filters)) 
    {
       for(var j=0; j<document.images.length; j++)
       {
          var img = document.images[j]
          var imgName = img.src.toUpperCase()
          if (imgName.substring(imgName.length-3, imgName.length) == "PNG")
          {
             var imgID = (img.id) ? "id='" + img.id + "' " : ""
             var imgClass = (img.className) ? "class='" + img.className + "' " : ""
             var imgTitle = (img.title) ? "title='" + img.title + "' " : "title='" + img.alt + "' "
             var imgStyle = "display:inline-block;" + img.style.cssText 
             if (img.align == "left") imgStyle = "float:left;" + imgStyle
             if (img.align == "right") imgStyle = "float:right;" + imgStyle
             if (img.parentElement.href) imgStyle = "cursor:hand;" + imgStyle
             var strNewHTML = "<span " + imgID + imgClass + imgTitle
             + " style=\"" + "width:" + img.width + "px; height:" + img.height + "px;" + imgStyle + ";"
             + "filter:progid:DXImageTransform.Microsoft.AlphaImageLoader"
             + "(src=\'" + img.src + "\', sizingMethod='scale');\"></span>" 
             img.outerHTML = strNewHTML
             j = j-1
          }
       }
    }    
}
window.attachEvent("onload", correctPNG);//PNG放到网页上透明底不变灰
</script>
<script language=javascript><!-- 
  if (top.location != self.location)top.location=self.location;
// 前页面被放在某个frame里面，则脱去frame-->
</script>
<link href="Images/skin.css" rel="stylesheet" type="text/css">
<body>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#274253">
  <tr>
    <td height="42" valign="top">
	<table width="100%" height="42" border="0" cellpadding="0" cellspacing="0" class="login_top_bg">
      <tr>
        <td width="1%" height="21">&nbsp;</td>
        <td height="42">&nbsp;</td>
        <td width="17%">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td valign="top"><table width="100%" height="532" border="0" cellpadding="0" cellspacing="0" class="login_bg">
      <tr>
        <td width="49%" align="right"><table width="91%" height="532" border="0" cellpadding="0" cellspacing="0" class="login_bg2">
            <tr>
              <td height="138" valign="top"><table width="97%" height="427" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td height="149">&nbsp;</td>
                </tr>
                <tr>
                  <td height="80" align="right" valign="top"><img src="Images/logo.png" width="279" height="68"></td>
                </tr>
                <tr>
                  <td height="198" align="right" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr class="login_txt">
                      <td width="13%" align="right" valign="top"></td>
                      <td height="25" colspan="2" valign="top"></td>
                    </tr>
                    <tr class="login_txt">
                      <td align="right" valign="top"></td>
                      <td height="25" colspan="2"></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td height="25" colspan="2"><p>&nbsp;</p></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td width="52%" height="40">&nbsp;</td>
                      <td width="35%">&nbsp;</td>
                    </tr>
                  </table></td>
                </tr>
              </table></td>
            </tr>
            
        </table></td>
        <td width="1%" >&nbsp;</td>
        <td width="50%" valign="bottom"><table width="100%" height="59" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td width="4%">&nbsp;</td>
              <td width="16%" height="38" align="left">&nbsp;</td>
              <td width="80%" align="left"><span class="login_txt_bt">电子报管理系统后台管理</span></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td height="21" colspan="2">
              <table cellSpacing="0" cellPadding="0" width="100%" border="0" height="328">
                  <tr>
                    <td height="164" colspan="2" align="middle">
					<form method="post" action="AdminCheck.php" onSubmit="return FrontPage(this)">
                        <table cellSpacing="0" cellPadding="0" width="100%" border="0" height="143">
                          <tr>
                            <td width="16%" height="38" align="right"><span class="login_txt">管理员：</span></td>
                            <td height="38" colspan="2"><input name="Admin" size="20"></td>
                          </tr>
                          <tr>
                            <td width="16%" height="35" align="right"><span class="login_txt"> 密　码：</span></td>
                            <td height="35" colspan="2"><input type="password" size="20" name="PassWord">
                              <img src="Images/luck.gif" width="19" height="18"> </td>
                          </tr>
                          <tr>
                            <td width="16%" height="35" align="right"><span class="login_txt">验证码：</span></td>
                            <td height="35" colspan="2"><input name="Yzm" type="text" maxlength="5" size="10" />
<img src="../Include/validcode.php" alt="看不清？点击换一个" name="validcode" width="60" height="20" border="0" id="validcode" onClick="this.src='../Include/validcode.php?rnd='+Math.random();" style="cursor:pointer;" />
							</td>
                          </tr>
                          <tr>
                            <td height="35" >&nbsp;</td>
                            <td width="17%" height="35" ><input name="submit" type="submit" value="登 陆"> </td>
                            <td width="67%"><input name="cs" type="reset" value="取 消" ></td>
                          </tr>
                        </table>
                        <br>
                    </form></td>
                  </tr>
                  <tr>
                    <td width="433" height="164" align="right" valign="bottom"><img src="Images/login-wel.gif" width="242" height="138"></td>
                    <td width="57" align="right" valign="bottom">&nbsp;</td>
                  </tr>
              </table></td>
            </tr>
          </table>
          </td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="20"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="login-buttom-bg">
      <tr>
        <td align="center" class="login-buttom-txt">技术支持: <a href="http://www.pifei.net/" target="_blank" style="color:#ABCAD3;">匹飞科技</a></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>