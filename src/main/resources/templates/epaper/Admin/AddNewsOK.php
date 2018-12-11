<?php
session_start();
include_once("../config.php");
header("Content-type: text/html; charset=gb2312");
if(($_SESSION['Admin']=="") or ($_SESSION['AdminSessionPWd']!= AdminSession or $_SESSION["login"] != true)){
	MessageBox("请勿非法登录，谢谢！","index.php");
}else{
  if(Inject_Check($_POST['submit'])){
    $Come            = Inject_Check($_POST['Come']);
    $User            = Inject_Check($_POST['User']);
    $Title           = Inject_Check($_POST['Title']);
    $sub_title       = Inject_Check($_POST['sub_title']);
    $Content         = Inject_Check($_POST['Content']);
    $VerOrder        = Inject_Check($_POST['VerOrder']);
    $PublishDate     = Inject_Check($_POST['PublishDate']);
    $_SESSION['New_PublishDate'] = $PublishDate;
    $_SESSION['New_VerOrder']    = $VerOrder;
    $oMySql="Select * From `FangBao_Rect` Where `PublishDate`='".$PublishDate."' And `VerOrder`='".$VerOrder."' Order By ID Desc";
    $oQuery=mysql_query($oMySql);
    $oRs=mysql_fetch_array($oQuery);
    $VerOrderID = $oRs[ID];
    $Mysql="Insert Into `FangBao_News` (`Title`,`sub_title`,`Content`,`PublishDate`,`VerOrder`,`VerOrderID`,`Come`,`User`,`InfoTime`)" .
          "values ('".$Title."','".$sub_title."','".RegUrl($Content)."','".$PublishDate."','".$VerOrder."','".$VerOrderID."','".$Come."','".$User."',now())";
    mysql_query($Mysql);
    AdminLog("用户为".$_SESSION['Admin']."添加了一条标题为《".$_POST[Title]."》的新闻",0);	
    MessageBox("新闻提交成功，点击继续添加本版新闻，否则请选择版面！","AddNews.php");
  }else{
    if($_POST['ModifyNews']){
      $ID              = Inject_Check($_POST['ID']);
      $Come            = Inject_Check($_POST['Come']);
      $User            = Inject_Check($_POST['User']);
      $Title           = Inject_Check($_POST['Title']);
      $sub_title       = Inject_Check($_POST['sub_title']);
      $Content         = Inject_Check($_POST['Content']);
      $VerOrder        = Inject_Check($_POST['VerOrder']);
      $PublishDate     = Inject_Check($_POST['PublishDate']);
      $oMySql="Select * From `FangBao_Rect` Where `PublishDate`='".$PublishDate."' And `VerOrder`='".$VerOrder."' Order By ID Desc";
      $oQuery=mysql_query($oMySql);
      $oRs=mysql_fetch_array($oQuery);
      $VerOrderID = $oRs[ID];
      $MyNsql="Update `FangBao_News` Set `PublishDate`='".$PublishDate."',`VerOrder`='".$VerOrder."',`VerOrderID`='".$VerOrderID."',`Come`='".$Come."',`User`='".$User."',`Title`='".$Title."',`sub_title`='".$sub_title."',`Content`='".RegUrl($Content)."' Where `ID`='".$ID."'";
      mysql_query($MyNsql);
      AdminLog("用户为".$_SESSION['Admin']."修改了标题为《".$Title."》的新闻",0);
      MessageBox("新闻修改成功！","NewsManage.php");
    }
  }
}
?>