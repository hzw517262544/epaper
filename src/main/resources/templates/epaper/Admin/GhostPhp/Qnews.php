<?php
include_once("../../config.php");
include_once("../Include/Function.php");
$ID= Inject_Check(intval($_GET['ID']));
if(($ID%1)!=0)
  MessageBox("请不要非法提交字符！","index.php");
else
$oMySql="select * from `fangbao_news` Where `ID`='".$ID."' Order by ID Desc";
$oQuery=mysql_query($oMySql);
$oRs=mysql_fetch_array($oQuery);
if($oRs[PublishDate]=="")
  MessageBox("没有对应的数据，将返回！","index.php");
else
$PublishDate     = $oRs[PublishDate];
$VerOrderID      = $oRs[VerOrderID];
$InfoTime        = $oRs[InfoTime];
$VerOrder        = $oRs[VerOrder];
$Content         = $oRs[Content];
$BanMian         = $oRs[BanMian];
$Title           = $oRs[Title];
$User            = $oRs[User];
$Hits            = $oRs[Hits];
?>
<!DOCTYPE html>
<html>
<head>
	<meta content="text/html; charset=gb2312" http-equiv="content-type" />
    <title><?php echo $Ghost_WebSiteName;?>-<?php echo $Title;?></title>
    <meta charset="utf-8" name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <link type="text/css" rel="stylesheet" href="../../content/css/news.css" />
</head>
<body>
    <div id="main">
        <div id="scroller">
            <div class="caption">
                <a name="top" id="top"></a>
                <font id="main-title"><?php echo $Title;?></font>
                <font id="guide">
					编辑: <?php echo $User;?>&nbsp点击：<?php Show_Hits($ID)?>
				</font>
                <font id="sub-title"></font>
                <font id="author"><?php Format_Time(2,$PublishDate)?></font>
            </div>
            <div class="content" id="content">
                <?php echo $Content;?>
            </div>
			<div class="PaperT" style="margin-top:20px;">
				<script type="text/javascript">
				document.write("<iframe scrolling=\"no\" id=\"PingLun\" name=\"PingLun\" width=\"100%\" style=\"height:300px;\" frameborder=\"0\" src=\"../../Include/PingLun.php?ID=<?php echo $ID;?>&VerOrderID=<?php echo $VerOrderID;?>\"></iframe>");
				</script>
			</div>
        </div>
		<div class="hide-scrolling"></div>
    </div>
    <div id="mask"></div>
    <a href="javascript:scroll(0,0)" id="toTop"></a>
    <div id="share">
        <ul>
            <li class="icons-yixin"><a href="javascript:share.yixin();">易信</a></li>
            <li class="icons-qzone"><a href="javascript:share.qzone();">QQ空间</a></li>
            <li class="icons-douban"><a href="javascript:share.douban();">豆瓣</a></li>
            <li class="icons-sina"><a href="javascript:share.weibo();">新浪微博</a></li>
        </ul>
    </div>
    <div id="operate">
        <ul>
            <li class="icons-back"><a href="qpaper.html"></a></li>
            <li class="icons-larger"><a href="javascript:fontLarger();"></a></li>
            <li class="icons-smaller"><a href="javascript:fontSmaller();"></a></li>
            <li class="icons-share"><a href="javascript:showShare();"></a></li>
        </ul>
    </div>
    <script src="../../content/js/jquery.min.js"></script>
    <script src="../../content/js/jquery.mobile.custom.min.js"></script>
    <script src="../../content/js/iscroll.js"></script>
    <script src="../../content/js/simple-share.min.js"></script>
    <script src="../../content/js/news.js"></script>
    <script>
        //《取消注释下行代码可以禁用文字复制》
        //document.onselectstart=new Function("event.returnValue=false");
        var share = new SimpleShare({
            url: location.href,
            title: '<?php echo $Ghost_WebSiteName;?>',
            content: '<?php echo $Title;?>'
            //pic: ''
        });
    </script>
</body>
</html>