<?php
include_once("../../config.php");
include_once("../Include/Function.php");
include_once("../Include/MyFunction.php");
$ID= Inject_Check(intval($_GET['ID']));
if(($ID%1)!=0)
  MessageBox("请不要非法提交字符！","index.php");
else
$oMySql="Select * From `FangBao_Rect` Where `ID`='".$ID."' Order By ID Desc";
$oQuery=mysql_query($oMySql);
if ($oQuery) $oRs=mysql_fetch_array($oQuery);
$PublishDate     = $oRs[PublishDate];
$VerOrder        = $oRs[VerOrder];
$PdfFile         = $oRs[PdfFile];
$BanMian         = $oRs[BanMian];
$Rect            = PaperColor($oRs[Rect]);
$Rect = str_replace(array('height="550"','width="378"','&nbsp;<img'),array('','width="100%"',' <img'),$Rect);
$Rect = str_replace(array('onmouseover="cvi_tip._show(event);" onmouseout="cvi_tip._hide(event);" onmousemove="cvi_tip._move(event);"'),array(''),$Rect);
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="gb2312">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>电子报</title>
    <link type="text/css" rel="stylesheet" href="../../content/css/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="../../content/css/bootstrap-sidemenu.css">
	
    <link rel="stylesheet" href="../../content/css/bootstrap-datetimepicker.min.css">

    <link type="text/css" rel="stylesheet" href="../../content/css/style.css" />
    <!--[if lt IE 9]>
    <script src="../../content/js/html5shiv-printshiv.min.js"></script>
    <script src="../../content/js/respond.min.js"></script>
    <![endif]-->
	
    <script type="text/javascript" src="../../content/js/jquery.min.js"></script>
    <script type="text/javascript" src="../../content/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../../content/js/bootstrap-sidemenu.js"></script>
	
	<script type="text/javascript" src="../../content/js/bootstrap-datetimepicker.min.js"></script>
	<script type="text/javascript" src="../../content/js/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8"></script>

    <script type="text/javascript" src="../../content/js/index.js"></script>
</head>
<body>

    <div id="catalog">
        <div class="list-group list-group-h">
            <a href="#" class="list-group-item"><?php echo $VerOrder;?>：<strong><?php echo $BanMian;?></strong></a>
        </div>
        <div class="list-group">
            <?php get_news_list($PublishDate,$VerOrder,$ID,40);?>
        </div>
    </div>
	
    <div id="cat-menu">
        <div class="list-group">
			<?php get_news_nav($PublishDate);?>
        </div>
    </div>

	<div>
		<input type="text" class="form_date"/>
	</div>
	
    <div id="mask"></div>

    <div id="maps">
		<?php echo $Rect;?>
    </div>

    <div class="clearfix h40"></div>

    <footer>
        <ul>
            <li><a id="page-btn" href="javascript:;">第A01版</a></li>
            <li><a id="catalog-btn" href="javascript:;">目录</a></li>
            <li><a id="date-btn" href="javascript:;">往期</a></li>
        </ul>
    </footer>
</body>
</html>