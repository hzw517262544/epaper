<?php
session_start();
header("Content-type: text/html; charset=gb2312");

include_once("../config.php");
include_once "../pfcms/includes/tpl.inc.php";

if(($_SESSION['Admin']=="") or ($_SESSION['AdminSessionPWd']!= AdminSession or $_SESSION["login"] != true)){
	MessageBox("请勿非法登录，谢谢！","index.php");
}else{
	function ToHtml($FromURL,$PublishDate,$FilePath){
		//$Html_URL=file_get_contents($FromURL);
		$Html_URL=vita_get_url_content($FromURL);
		$Folder="../html/".$PublishDate."";
		if(file_exists ($Folder)):
		else:
		mkdir ($Folder, 0777);
		endif;
		$Handle = fopen ($FilePath,"w"); //打开文件指针，创建文件
		//检查文件是否被创建且可写
		if (!is_writable ($FilePath)){
		echo "<script language=\"javascript\">alert('文件：".$FilePath."不可写，请检查其属性后重试！');javascript:history.go(-1);</script>";
	} 
	if (!fwrite ($Handle,$Html_URL)){   //将信息写入文件
		echo "<script language=\"javascript\">alert('生成文件".$FilePath."失败！');javascript:history.go(-1);</script>";
	}  
	fclose ($Handle); //关闭指针
		echo "<script language=\"javascript\">alert('静态页面生成成功！');javascript:history.go(-1);</script>";
	}
	
	function vita_get_url_content($url) {
		if(function_exists('file_get_contents')){
			$file_contents = file_get_contents($url);
		}else{
			$ch = curl_init();
			$timeout = 300; 
			curl_setopt ($ch, CURLOPT_URL, $url);
			curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1); 
			curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
			$file_contents = curl_exec($ch);
			curl_close($ch);
		}
		return $file_contents;
	}
	
	//=======================生成报纸版面列表，单版面生成==============================
	function Index_Html(){
		ToHtml(GetPageUrlPath()."/Date.php","Date","../html/date/date.html");
		$oMySql="Select count(*) From `FangBao_Rect` Where `IsFrist`='1' Order By ID Desc";
		$oQuery=mysql_query($oMySql);
		$oRs=mysql_fetch_array($oQuery); 
		$Num=$oRs[0];
		$PageNum=24;
		$AllPage=ceil($Num/$PageNum)-1;
		$Page=0;
		while ($Page<=$AllPage){
			$FilePath = "../html/Review/Review_".$Page.".html";
			$FromURL = GetPageUrlPath()."/Review.php?Page=".$Page;
		 	ToHtml($FromURL,"Review",$FilePath);
		 	$Page=$Page+1;
		}
	}
	
	//=======================生成报纸版面列表，单版面生成==============================
	function List_Html($RectID){
		$MySql="Select * From `FangBao_Rect` Where `ID`='".$RectID."' Order by ID Desc";
		$Result=mysql_query($MySql);
		$oRs=mysql_fetch_array($Result);
		$PublishDate = $oRs[PublishDate];
		$IsFrist = $oRs[IsFrist];
		if ($IsFrist=='1'){
			 $FilePath = "../html/".$PublishDate."/qpaper.html";
		}else{
			 $FilePath = "../html/".$PublishDate."/qpaper_".$RectID.".html";
		}
		$FromURL = GetPageUrlPath()."/qpaper.php?ID=".$RectID."";
		ToHtml($FromURL,$PublishDate,$FilePath);
	}
	
	//=======================生成报纸版面列表，期刊号所有版面==============================
	function All_Html($PublishDate){
		$MySql="Select `PublishDate`,`PicFile`,`ID`,`IsFrist` From `FangBao_Rect` Where `PublishDate`='".$PublishDate."' Order By ID Desc";
		$Result=mysql_query($MySql);
		while ($oRs=mysql_fetch_array($Result)){
		$IsFrist = $oRs[IsFrist];
		$ID = $oRs[ID];
		if ($IsFrist=='1'){
			 $FilePath = "../html/".$PublishDate."/qpaper.html";
		}else{
			 $FilePath = "../html/".$PublishDate."/qpaper_".$ID.".html";
		}
		$FromURL = GetPageUrlPath()."/qpaper.php?ID=".$ID."";
		ToHtml($FromURL,$PublishDate,$FilePath);
		}
	}
	
	//=======================单一新闻生成==============================
	function Page_Html($ID){
		$MySql="Select `ID`,`PublishDate` From `FangBao_News` Where ID=".$ID." Order By ID Desc";
		$Result=mysql_query($MySql);
		$oRs=mysql_fetch_array($Result);
		$PublishDate = $oRs[PublishDate];
		$ID = $oRs[ID];
		$FilePath = "../html/".$PublishDate."/".$ID.".html";
		$FromURL = GetPageUrlPath()."/Qnews.php?ID=".$ID."";
		ToHtml($FromURL,$PublishDate,$FilePath);
	}
	
	//=======================按报纸版面生成此版面的所有文章==============================
	function BanMian_Html($PublishDate,$VerOrder){
		$MySql="Select `ID`,`PublishDate` From `FangBao_News` Where `PublishDate`='".$PublishDate."' And `VerOrder`='".$VerOrder."' Order By ID Desc";
		$Result=mysql_query($MySql);
		while ($oRs=mysql_fetch_array($Result)){
			$ID = $oRs[ID];
			$FilePath = "../html/".$PublishDate."/".$ID.".html";
			$FromURL = GetPageUrlPath()."/Qnews.php?ID=".$ID."";
		 	ToHtml($FromURL,$PublishDate,$FilePath);
		}
	}
	//=======================生成此期刊号的所有文章==============================
	function Pages_Html($PublishDate){
		$MySql="Select `ID`,`PublishDate` From `FangBao_News` Where `PublishDate`='".$PublishDate."' Order By ID Desc";
		$Result=mysql_query($MySql);
		while ($oRs=mysql_fetch_array($Result)){
			$ID = $oRs[ID];
			$FilePath = "../html/".$PublishDate."/".$ID.".html";
			$FromURL = GetPageUrlPath()."/Qnews.php?ID=".$ID."";
		 	ToHtml($FromURL,$PublishDate,$FilePath);
		}
	}
}
?>