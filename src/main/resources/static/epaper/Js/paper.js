function ChkIsPic()
{
	obj = document.getElementById("DisIsPic");
	obj.style.display = obj.style.display == "none" ? "" : "none";
}

if(document.getElementById("isfrist").checked)
	document.getElementById("DisIsPic").style.display = "";
	
function Get_FCKeditor_Img()
{	
var contents = FCKeditorAPI.GetInstance('Rect').GetXHTML();
var imggz= /<img[^>]+src="[^"]+"[^>]*>/g;
var imgs=contents.match(imggz);
var imgstr=""
for(var i=0;i<imgs.length; i++){
imgstr += imgs[i];
}
re=/src/g;
imgstr = imgstr.replace(re,"onclick='Set_Img(this.src)' src")
	eImg.innerHTML = imgstr;
	eImg.style.display = "block";
}
function Set_Img(src)
{
	var sPath = location.host + location.pathname;
	sPath = sPath.substr(0, sPath.length-16);
	var tmp = sPath.split("/");
	var url = "http://";
	for(var i=0;i<tmp.length-1;i++)
		url = url + tmp[i] + "/";
	ModifyPaper.PicFile.value = src.replace(url,"");
	eImg.style.display = "none";
}