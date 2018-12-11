//设置编辑器中内容
function SetContents(codeStr){
   var oEditor = FCKeditorAPI.GetInstance(content) ;
   oEditor.SetHTML(codeStr) ;
}
 
// 获取编辑器中HTML内容
function getEditorHTMLContents(EditorName) { 
    var oEditor = FCKeditorAPI.GetInstance(EditorName); 
    return(oEditor.GetXHTML(true)); 
}
// 获取编辑器中文字内容
function getEditorTextContents(EditorName) { 
    var oEditor = FCKeditorAPI.GetInstance(EditorName); 
    return(oEditor.EditorDocument.body.innerText); 
}
// 设置编辑器中内容
function SetEditorContents(EditorName, ContentStr) { 
    var oEditor = FCKeditorAPI.GetInstance(EditorName) ; 
    oEditor.SetHTML(ContentStr) ; 
}

//向编辑器插入指定代码
function insertHTMLToEditor(content,codeStr){
   var oEditor = FCKeditorAPI.GetInstance(content);
   if (oEditor.EditMode==FCK_EDITMODE_WYSIWYG){
     oEditor.InsertHtml(codeStr);
   }else{
     return false;
   }
}

//全局替换函数
function replaceAll(str,oldStr,reStr){
    return str.split(oldStr).join(reStr);
}

//自动排版
function FormatText(bodyname,obj) {
   var myeditor = FCKeditorAPI.GetInstance(bodyname);
   if (myeditor.EditMode==FCK_EDITMODE_WYSIWYG){
        var temps = new Array();

        isPart = false; //暂时无法实现局部格式化
        if (!isPart) {
            var imgs = FCKeditorAPI.GetInstance(bodyname).EditorDocument.images;
            if (imgs != null && imgs.length > 0) {
                for (j = 0; j < imgs.length; j++) {
                    var t = document.createElement("IMG");
                    t.alt = imgs[j].alt;
                    t.src = imgs[j].src;
                    t.width = imgs[j].width;
                    t.height = imgs[j].height;
                    t.align = imgs[j].align;
                    temps[temps.length] = t;
                }
                var formatImgCount = 0;
                for (j = 0; j < imgs.length;) {
                    imgs[j].outerHTML = "#FormatImgID_" + formatImgCount + "#";
                    formatImgCount++;
                }
            }
			var strongarray	= new Array();
			var strongcount = 0;
			for(var i=0;i<myeditor.EditorDocument.body.getElementsByTagName('b').length;i++){
				strongarray[strongcount]	= myeditor.EditorDocument.body.getElementsByTagName('b')[i].innerText.trim();
				myeditor.EditorDocument.body.getElementsByTagName('b')[i].innerHTML	= "#FormatStrongID_" + strongcount + "#";
				strongcount++;
			}

			for(var i=0;i<myeditor.EditorDocument.body.getElementsByTagName('strong').length;i++){
				strongarray[strongcount]	= myeditor.EditorDocument.body.getElementsByTagName('strong')[i].innerText.trim();
				myeditor.EditorDocument.body.getElementsByTagName('strong')[i].innerHTML	= "#FormatStrongID_" + strongcount + "#";
				strongcount++;
			}

            var html = processFormatText(myeditor.EditorDocument.body.innerText);
            if (temps != null && temps.length > 0) {
                for (j = 0; j < temps.length; j++) {
					if (temps[j].width >= 400 ){
						var imghtml = "<p align=\"center\"><a href=\"" + temps[j].src + "\" rel=\"lightbox[plants]\" title=\"" + temps[j].alt + "\" ><img src=\"" + temps[j].src + "\" alt=\"" + temps[j].alt + "\" width=\"400\" align=\"" + temps[j].align + "\" border=\"0\"></a></p>";
						}else{
							var imghtml = "<p align=\"center\"><img src=\"" + temps[j].src + "\" alt=\"" + temps[j].alt + "\" width=\"" + temps[j].width + "\" align=\"" + temps[j].align + "\" border=\"0\"></p>";
							}
                    html = html.replace("#FormatImgID_" + j + "#", imghtml);
                }
            }

			for(var i=0;i<strongcount;i++){
				html = html.replace("#FormatStrongID_" + i + "#", "<strong>"+strongarray[i]+"</strong>");
			}
			html=replaceAll(html,"</p></p>","</p>");
			while(html.indexOf('<p><p align="center">')!=-1)	html=html.replace('<p><p align="center">','<p align="center">');
			html=replaceAll(html,"<br />\n<br />","");
			html=replaceAll(html,"　　<p","<p");
			html=replaceAll(html,"<br />\n<p","<p");
			html=replaceAll(html,"<p>　　</p>","");
			html=replaceAll(html,"<p>&nbsp;</p>","");
			obj.disabled =true;
			SetEditorContents(bodyname, html);
        } else {
			alert('错误的操作！');
        }
   }else{
		alert('必须在设计模式下操作！');
   }
}

//自动排版，段间空行
function FormatTextP(bodyname,obj) {
   var myeditor = FCKeditorAPI.GetInstance(bodyname);
   if (myeditor.EditMode==FCK_EDITMODE_WYSIWYG){
        var temps = new Array();

        isPart = false; //暂时无法实现局部格式化
        if (!isPart) {
            var imgs = FCKeditorAPI.GetInstance(bodyname).EditorDocument.images;
            if (imgs != null && imgs.length > 0) {
                for (j = 0; j < imgs.length; j++) {
                    var t = document.createElement("IMG");
                    t.alt = imgs[j].alt;
                    t.src = imgs[j].src;
                    t.width = imgs[j].width;
                    t.height = imgs[j].height;
                    t.align = imgs[j].align;
                    temps[temps.length] = t;
                }
                var formatImgCount = 0;
                for (j = 0; j < imgs.length;) {
                    imgs[j].outerHTML = "#FormatImgID_" + formatImgCount + "#";
                    formatImgCount++;
                }
            }
			var strongarray	= new Array();
			var strongcount = 0;
			for(var i=0;i<myeditor.EditorDocument.body.getElementsByTagName('b').length;i++){
				strongarray[strongcount]	= myeditor.EditorDocument.body.getElementsByTagName('b')[i].innerText.trim();
				myeditor.EditorDocument.body.getElementsByTagName('b')[i].innerHTML	= "#FormatStrongID_" + strongcount + "#";
				strongcount++;
			}

			for(var i=0;i<myeditor.EditorDocument.body.getElementsByTagName('strong').length;i++){
				strongarray[strongcount]	= myeditor.EditorDocument.body.getElementsByTagName('strong')[i].innerText.trim();
				myeditor.EditorDocument.body.getElementsByTagName('strong')[i].innerHTML	= "#FormatStrongID_" + strongcount + "#";
				strongcount++;
			}

            var html = processFormatTextP(myeditor.EditorDocument.body.innerText);
            if (temps != null && temps.length > 0) {
                for (j = 0; j < temps.length; j++) {
					if (temps[j].width >= 400 ){
						var imghtml = "<p align=\"center\"><a href=\"" + temps[j].src + "\" rel=\"lightbox[plants]\" title=\"" + temps[j].alt + "\" ><img src=\"" + temps[j].src + "\" alt=\"" + temps[j].alt + "\" width=\"400\" align=\"" + temps[j].align + "\" border=\"0\"></a></p>";
						}else{
							var imghtml = "<p align=\"center\"><img src=\"" + temps[j].src + "\" alt=\"" + temps[j].alt + "\" width=\"" + temps[j].width + "\" align=\"" + temps[j].align + "\" border=\"0\"></p>";
							}
                    html = html.replace("#FormatImgID_" + j + "#", imghtml);
                }
            }

			for(var i=0;i<strongcount;i++){
				html = html.replace("#FormatStrongID_" + i + "#", "<strong>"+strongarray[i]+"</strong>");
			}
			html=replaceAll(html,"</p></p>","</p>");
			while(html.indexOf('<p><p align="center">')!=-1)	html=html.replace('<p><p align="center">','<p align="center">');
			html=replaceAll(html,"<br />\n<br />","");
			html=replaceAll(html,"　　<p","<p");
			html=replaceAll(html,"<br />\n<p","<p");
			html=replaceAll(html,"<p>　　</p>","");
			html=replaceAll(html,"<p>&nbsp;</p>\n","");
			obj.disabled =true;
			SetEditorContents(bodyname, html);
        } else {
			alert('错误的操作！');
        }
   }else{
		alert('必须在设计模式下操作！');
   }
}


function FormatPic(bodyname,obj) {
   var myeditor = FCKeditorAPI.GetInstance(bodyname);
   if (myeditor.EditMode==FCK_EDITMODE_WYSIWYG){
        var temps = new Array();

        isPart = false; //暂时无法实现局部格式化
        if (!isPart) {
            var imgs = FCKeditorAPI.GetInstance(bodyname).EditorDocument.images;
            if (imgs != null && imgs.length > 0) {
                for (j = 0; j < imgs.length; j++) {
                    var t = document.createElement("IMG");
                    t.alt = imgs[j].alt;
                    t.src = imgs[j].src;
                    t.width = imgs[j].width;
                    t.height = imgs[j].height;
                    t.align = imgs[j].align;
                    temps[temps.length] = t;
                }
                var formatImgCount = 0;
                for (j = 0; j < imgs.length;) {
                    imgs[j].outerHTML = "#FormatImgID_" + formatImgCount + "#";
                    formatImgCount++;
                }
            }
			var strongarray	= new Array();
			var strongcount = 0;
			for(var i=0;i<myeditor.EditorDocument.body.getElementsByTagName('b').length;i++){
				strongarray[strongcount]	= myeditor.EditorDocument.body.getElementsByTagName('b')[i].innerText.trim();
				myeditor.EditorDocument.body.getElementsByTagName('b')[i].innerHTML	= "#FormatStrongID_" + strongcount + "#";
				strongcount++;
			}

			for(var i=0;i<myeditor.EditorDocument.body.getElementsByTagName('strong').length;i++){
				strongarray[strongcount]	= myeditor.EditorDocument.body.getElementsByTagName('strong')[i].innerText.trim();
				myeditor.EditorDocument.body.getElementsByTagName('strong')[i].innerHTML	= "#FormatStrongID_" + strongcount + "#";
				strongcount++;
			}

            var html = myeditor.EditorDocument.body.innerHTML;
            if (temps != null && temps.length > 0) {
                for (j = 0; j < temps.length; j++) {
					if (temps[j].width >= 400 ){
						var imghtml = "<p align=\"center\"><a href=\"" + temps[j].src + "\" rel=\"lightbox[plants]\" title=\"" + temps[j].alt + "\" ><img src=\"" + temps[j].src + "\" alt=\"" + temps[j].alt + "\" width=\"400\" align=\"" + temps[j].align + "\" border=\"0\"></a></p>";
						}else{
							var imghtml = "<p align=\"center\"><img src=\"" + temps[j].src + "\" alt=\"" + temps[j].alt + "\" width=\"" + temps[j].width + "\" align=\"" + temps[j].align + "\" border=\"0\"></p>";
							}
                    html = html.replace("#FormatImgID_" + j + "#", imghtml);
                }
            }

			for(var i=0;i<strongcount;i++){
				html = html.replace("#FormatStrongID_" + i + "#", "<strong>"+strongarray[i]+"</strong>");
			}
			html=replaceAll(html,"<p>　　</p>","");
			html=replaceAll(html,"<p>&nbsp;</p>","");
			obj.disabled =true;
			SetEditorContents(bodyname, html);
        } else {
			alert('错误的操作！');
        }
   }else{
		alert('必须在设计模式下操作！');
   }
}

//去掉换行符号，如<br /><br>
function FormatTextBr(bodyname,obj) {
   var myeditor = FCKeditorAPI.GetInstance(bodyname);
   if (myeditor.EditMode==FCK_EDITMODE_WYSIWYG){
        var temps = new Array();

        isPart = false; //暂时无法实现局部格式化
        if (!isPart) {
            var imgs = FCKeditorAPI.GetInstance(bodyname).EditorDocument.images;
            if (imgs != null && imgs.length > 0) {
                for (j = 0; j < imgs.length; j++) {
                    var t = document.createElement("IMG");
                    t.alt = imgs[j].alt;
                    t.src = imgs[j].src;
                    t.width = imgs[j].width;
                    t.height = imgs[j].height;
                    t.align = imgs[j].align;
                    temps[temps.length] = t;
                }
                var formatImgCount = 0;
                for (j = 0; j < imgs.length;) {
                    imgs[j].outerHTML = "#FormatImgID_" + formatImgCount + "#";
                    formatImgCount++;
                }
            }
			
			var html = FormatText_Br(myeditor.EditorDocument.body.innerHTML);
            if (temps != null && temps.length > 0) {
                for (j = 0; j < temps.length; j++) {
					if (temps[j].width >= 400 ){
						var imghtml = "<p align=\"center\"><a href=\"" + temps[j].src + "\" rel=\"lightbox[plants]\" title=\"" + temps[j].alt + "\" ><img src=\"" + temps[j].src + "\" alt=\"" + temps[j].alt + "\" width=\"400\" align=\"" + temps[j].align + "\" border=\"0\"></a></p>";
						}else{
							var imghtml = "<p align=\"center\"><img src=\"" + temps[j].src + "\" alt=\"" + temps[j].alt + "\" width=\"" + temps[j].width + "\" align=\"" + temps[j].align + "\" border=\"0\"></p>";
							}
                    html = html.replace("#FormatImgID_" + j + "#", imghtml);
                }
            }
			html=replaceAll(html,"<p>　　</p>","");
			html=replaceAll(html,"</p></p>","</p>");
			html=replaceAll(html,"<p>&nbsp;</p>","");
			while(html.indexOf('<p><p align="center">')!=-1)	html=html.replace('<p><p align="center">','<p align="center">');
			obj.disabled =true;
			SetEditorContents(bodyname, html);
        } else {
			alert('错误的操作！');
        }
   }else{
		alert('必须在设计模式下操作！');
   }
}

function processFormatText(textContext) {
    var text = DBC2SBC(textContext);
    var prefix = "　　";
    var tmps = text.split("\n");
    var html = "";
	var ifblank = document.getElementById("ifblank");
    for (i = 0; i < tmps.length; i++) {
      var tmp = tmps[i].trim();
      if (tmp.length > 0) {
	  if (ifblank)
	  {
		  if (ifblank.checked)
			html += "　　" + tmp + "<br />\n";
			else
			html += tmp + "<br />\n";
		  }
	  }else{
			html += tmp + "<br />\n";
	  }
    }
  return html;
}

function processFormatTextP(textContext) {
    var text = DBC2SBC(textContext);
    var prefix = "　　";
    var tmps = text.split("\n");
    var html = "";
	var ifblank = document.getElementById("ifblank");
    for (i = 0; i < tmps.length; i++) {
      var tmp = tmps[i].trim();
      if (tmp.length > 0) {
	  if (ifblank)
	  {
		  if (ifblank.checked)
			html += "<p>　　" + tmp + "</p>\n";
			else
			html += "<p>"+tmp + "</p>\n";
		  }
	  }else{
			html += "<p>"+tmp + "</p>\n";
	  }
    }
  return html;
}

function FormatText_Br(textContext) {
    var newcontent = textContext;
		newcontent=replaceAll(newcontent,"<p>　　</p>","");
		newcontent=replaceAll(newcontent,"<p>&nbsp;</p>","");
	    newcontent=replaceAll(newcontent," ","");
		newcontent=replaceAll(newcontent,"”<BR>","”<Paper>"); //替换认为是应该换行的标志
		newcontent=replaceAll(newcontent,"。<BR>","。<Paper>");
		newcontent=replaceAll(newcontent,"？<BR>","？<Paper>");
		newcontent=replaceAll(newcontent,".<BR>",".<Paper>");
		newcontent=replaceAll(newcontent,"。<br />","。<Paper>");
		newcontent=replaceAll(newcontent,"！<br />","！<Paper>");
		newcontent=replaceAll(newcontent,"!<br />","!<Paper>");
		newcontent=replaceAll(newcontent,".<br>",".<Paper>");
		newcontent=replaceAll(newcontent,".<br>",".<Paper>");
		newcontent=replaceAll(newcontent,"<br />","<Paper>");
		newcontent=replaceAll(newcontent,"<BR><BR>","<BR>");
		newcontent=replaceAll(newcontent,"<BR>","");   //替换所有<br>
		newcontent=replaceAll(newcontent,"<Paper>","<br />"); //把所有应当换行的换回来
  return newcontent;
}


function DBC2SBC(str) {
  var result = '';
  for (var i = 0; i < str.length; i++) {
    code = str.charCodeAt(i);
    // "65281"是"！"，"65373"是"｝"，"65292"是"，"。不转换"，"

    if (code >= 65281 && code < 65373 && code != 65292 && code != 65306){
    //  "65248"是转换码距
      result += String.fromCharCode(str.charCodeAt(i) - 65248);
    } else {
      result += str.charAt(i);
    }
  }
  return result;
}


String.prototype.trim = function()
{
  return this.replace(/(^[\s　]*)|([\s　]*$)/g, "");
};

String.prototype.leftTrim = function()
{
  return this.replace(/(^\s*)/g, "");
};

String.prototype.rightTrim = function()
{
  return this.replace(/(\s*$)/g, "");
};