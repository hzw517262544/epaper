<?php
session_start();
header("Content-type: text/html; charset=gb2312");

include_once("../config.php");
include_once "../pfcms/includes/tpl.inc.php";

if(($_SESSION['Admin']=="") or ($_SESSION['AdminSessionPWd']!= AdminSession or $_SESSION["login"] != true)){
	MessageBox("����Ƿ���¼��лл��","index.php");
}else{
	function ToHtml($FromURL,$PublishDate,$FilePath){
		//$Html_URL=file_get_contents($FromURL);
		$Html_URL=vita_get_url_content($FromURL);
		$Folder="../html/".$PublishDate."";
		if(file_exists ($Folder)):
		else:
		mkdir ($Folder, 0777);
		endif;
		$Handle = fopen ($FilePath,"w"); //���ļ�ָ�룬�����ļ�
		//����ļ��Ƿ񱻴����ҿ�д
		if (!is_writable ($FilePath)){
		echo "<script language=\"javascript\">alert('�ļ���".$FilePath."����д�����������Ժ����ԣ�');javascript:history.go(-1);</script>";
	} 
	if (!fwrite ($Handle,$Html_URL)){   //����Ϣд���ļ�
		echo "<script language=\"javascript\">alert('�����ļ�".$FilePath."ʧ�ܣ�');javascript:history.go(-1);</script>";
	}  
	fclose ($Handle); //�ر�ָ��
		echo "<script language=\"javascript\">alert('��̬ҳ�����ɳɹ���');javascript:history.go(-1);</script>";
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
	
	//=======================���ɱ�ֽ�����б�����������==============================
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
	
	//=======================���ɱ�ֽ�����б�����������==============================
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
	
	//=======================���ɱ�ֽ�����б��ڿ������а���==============================
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
	
	//=======================��һ��������==============================
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
	
	//=======================����ֽ�������ɴ˰������������==============================
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
	//=======================���ɴ��ڿ��ŵ���������==============================
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