<?php
session_start();
include_once("../../../../../config.php");
?><html>
<head>
<title>Image Map Editor</title>
<!--[if gte IE 6]>
<script type="text/javascript" src="jscripts/excanvas.js"></script>
<![endif]-->
<script type="text/javascript" src="jscripts/imgmap.js?"></script>
<script type="text/javascript" src="jscripts/functions.js?"></script>
<link rel="stylesheet" href="css/imgmap.css" type="text/css"/>
<meta http-equiv="imagetoolbar" content="no"/>
<META content="text/html; charset=gb2312" http-equiv=Content-Type>
<script language="javascript">
function getText() {
    var myindex=document.myform.PaperTitle.selectedIndex;
    document.myform.txtAttTitle.value=document.myform.PaperTitle.options[myindex].text;
    document.myform.txtUrl.value=document.myform.PaperTitle.options[myindex].value;     
}
</script>
</HEAD>
<body>
<form id="img_area_form" name="myform">
  <fieldset>
    <legend> <a onClick="toggleFieldset(this.parentNode.parentNode)" fckLang="imgmapMapAreas">Image Map Areas</a> </legend>
    <div>
      <?php include_once("imgmap.php");?>
      <div style="float: right; display:none;">
        <label for="MapName" fckLang="imgmapMapName">Map name:</label>
        <input type="text" id="MapName" value="" size="30" onChange="myimgmap.mapname = this.value"/>
      </div>
    </div>
    <div id="properties" style="visibility:hidden;">
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td colspan="2">文章标题：
            <?php
				if(($_SESSION['Admin']=="") or ($_SESSION['AdminSessionPWd']!= AdminSession or $_SESSION["login"] != true)){
					MessageBox("请误非法登录，谢谢！","../../../../index.php");
				}else{
					echo "<select id=\"PaperTitle\" name=\"PaperTitle\" style=\"width:280px\" onChange=\"getText();\" />";
					echo "<option value=\"\">请选择文章标题</option>";
				    $PublishDate=$_SESSION['PublishDate'];
				    $VerOrder=$_SESSION['VerOrder'];
				    $SQL="Select * From `FangBao_News` Where `VerOrder` ='".$VerOrder."' And  `PublishDate` ='".$PublishDate."' Order By ID Desc";
				    $Query=mysql_query($SQL);
				    while($Rs=mysql_fetch_array($Query)){
				        echo "<option value=\"".$Rs[ID].".html\">".$Rs[Title]."</option>";
				    }
				    echo "</select>";
				}
		    ?>
          </td>
        </tr>
        <tr>
          <td><input id="txtAlt" onChange="SetAlt(this.value)" type="hidden"/>
            热点标题：
            <input type="text" id="txtAttTitle" value="" onFocus="this.value=''" onBlur="if (value ==''){value=' '}" onChange="SetTitle(this.value)" size="50" /></td>
        </tr>
        <tr>
          <td colspan="2"> 链接地址：
            <input type="text" id="txtUrl" value="" onFocus="this.value=''" onBlur="if (value ==''){value=' '}" onChange="SetUrl(this.value)" size="50" />
            <input id="cmbTarget" onChange="SetTarget(this.value);" type="hidden" /></td>
        </tr>
      </table>
    </div>
  </fieldset>
  <fieldset>
    <legend> <a onClick="toggleFieldset(this.parentNode.parentNode)" fckLang="DlgImgPreview">Preview</a> </legend>
    <div id="pic_container"></div>
  </fieldset>
</form>
</BODY>
</HTML>