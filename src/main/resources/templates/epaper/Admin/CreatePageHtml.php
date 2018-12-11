<?php
session_start();
header("Content-type: text/html; charset=gb2312");

include_once("../config.php");
include_once "../pfcms/includes/tpl.inc.php";
include_once("Include/MyFunction.php");

if (($_SESSION['Admin'] == "") or ($_SESSION['AdminSessionPWd'] != AdminSession or $_SESSION["login"] != true)) {
    MessageBox("请勿非法登录，谢谢！", "index.php");
    return;
} 
// 生成报纸日历控件
function create_date_html() {
    $MySql = "Select * From FangBao_Paper Order By PublishID Asc";
    $Result = mysql_query($MySql);
    $PublishDates = '';
    while ($Rs = mysql_fetch_array($Result)) {
        $PublishDates .= $Rs[PublishDate] . "|";
    } 

    $tpl = Tpl();
    $tpl->assign('PublishDates', $PublishDates);

    $html_dir = "../html/date/";
    create_dir($html_dir);

    $htmlPath = $html_dir . "date.html"; 
    // $tpl->display( 'content/date.tpl' );
    $html = $tpl->fetch('content/date.tpl');
    $fp = fopen($htmlPath, "w");
    fwrite($fp, $html);
    fclose($fp);
    return true;
} 
// 生成往期回顾
function create_review_html() {
    global $db;
    include('../' . INC_DIR . 'Page.class.php');
    $pageSize = 30;
    $setting = get_setting();

    $where = "`IsFrist`='1'";

    $Page = new Page($db->tb_prefix . 'rect', $where, '*', $pageSize, 'ID DESC');
    $total_page = $Page->total_page;

    for($i = 1;$i <= $total_page;$i++) {
        $_GET['page'] = $i;
        $Page = new Page($db->tb_prefix . 'rect', $where, '*', $pageSize, 'ID DESC');
        $paper_list = $Page->get_data();
        $paper_list_pager = $Page->button_basic_num_html('index-{page}.html');

        foreach ($paper_list as $key => $value) {
            $paper_list[$key]['url'] = '../' . $value['PublishDate'] . '/qpaper.html';
            $paper_list[$key]['PicFile'] = '../../' . $value['PicFile'];
        } 
        $tpl = Tpl();
        $tpl->assign('setting', $setting);
        $tpl->assign('paper_list', $paper_list);

        $tpl->assign('paper_list_pager', $paper_list_pager);

        $html_dir = "../html/paper/";
        create_dir($html_dir);

        $htmlPath = $html_dir . "index-" . $i . ".html"; 
        // $tpl->display('content/paper_list.tpl');
        $html = $tpl->fetch('content/paper_list.tpl');
        $fp = fopen($htmlPath, "w");
        fwrite($fp, $html);
        fclose($fp);
    } 
} 
// 生成报纸版面列表，单版面生成
function create_qpaper_html($RectID) {
    global $db;
    $rectdata = $db->row_select_one('rect', 'ID=' . $RectID);

    $PublishDate = $rectdata['PublishDate'];

    $pdf_url = '';
    if ($rectdata['PdfFile'] != '') {
        $pdf_url = '../../' . $rectdata['PdfFile'];
    } 
    $rectinfo = PaperColor($rectdata['Rect']);
    $rectinfo = str_replace(array('height="550"', 'width="378"', '&nbsp;<img'), array('', 'width="100%"', ' <img'), $rectinfo);

    $setting = get_setting(); 
    // 第几版
    $paper_nav = paper_nav($RectID, $PublishDate); 
    // echo $paper_nav2;exit;
    // print_r($paper_nav);exit;
    // 新闻列表
    $news_list = fetch_news_list($PublishDate, $rectdata['VerOrder'], $RectID, 40); 
    // 版面目录
    $rect_list = fetch_rect_list($PublishDate); 
    // 上一版
    $rect_prev = rect_prev($RectID, $PublishDate); 
    // 下一版
    $rect_next = rect_next($RectID, $PublishDate); 
    // 上一期
    $paper_prev = paper_prev($PublishDate); 
    // 下一期
    $paper_next = paper_next($PublishDate); 
    // 发刊日期
    $fk_date = format_datetime(2, $PublishDate);

    $tpl = Tpl();
    $tpl->assign('setting', $setting);
    $tpl->assign('paper_nav', $paper_nav);
    $tpl->assign('rectdata', $rectdata);
    $tpl->assign('pdf_url', $pdf_url);
    $tpl->assign('news_list', $news_list);
    $tpl->assign('rect_list', $rect_list);
    $tpl->assign('rect_prev', $rect_prev);
    $tpl->assign('rect_next', $rect_next);
    $tpl->assign('paper_prev', $paper_prev);
    $tpl->assign('paper_next', $paper_next);
    $tpl->assign('fk_date', $fk_date);

    if (true) { // PC
        $tpl->assign('rectinfo', $rectinfo);

        $pcFilePath = '';
        $html_dir = "../html/" . $PublishDate;
        create_dir($html_dir);

        if ($rectdata['IsFrist'] == '1') {
            $pcFilePath = $html_dir . "/qpaper.html";
        } else {
            $pcFilePath = $html_dir . "/qpaper_" . $RectID . ".html";
        } 
        // $tpl->display('content/paper.tpl');
        $html = $tpl->fetch('content/paper.tpl');
        $fp = fopen($pcFilePath, "w");
        fwrite($fp, $html);
        fclose($fp);
    } 
    if (true) { // 手机版
        $rectinfo = str_replace(array('onmouseover="cvi_tip._show(event);" onmouseout="cvi_tip._hide(event);" onmousemove="cvi_tip._move(event);"'), array(''), $rectinfo);
        $tpl->assign('rectinfo', $rectinfo);

        $mobileFilePath = '';
        $html_dir = "../mobile/" . $PublishDate;
        create_dir($html_dir);

        if ($rectdata['IsFrist'] == '1') {
            $mobileFilePath = $html_dir . "/qpaper.html";
        } else {
            $mobileFilePath = $html_dir . "/qpaper_" . $RectID . ".html";
        } 
        // $tpl->display('mobile/paper.tpl');
        $html = $tpl->fetch('mobile/paper.tpl');
        $fp = fopen($mobileFilePath, "w");
        fwrite($fp, $html);
        fclose($fp);
    } 
    return true;
} 
// 生成该期刊的所有报刊页面
function create_qpaper_all_html($PublishDate) {
    global $db;
    $rectdata = $db->row_select('rect', "`PublishDate`='" . $PublishDate . "'", 'PublishDate,PicFile,ID,IsFrist', 0, 'ID DESC');
    foreach($rectdata as $key => $value) {
        create_qpaper_html($value['ID']);
    } 
} 
// 生成新闻静态页
function create_news_html($ID) {
    global $db;
    $newsdata = $db->row_select_one('news', 'ID=' . $ID);
    $newsdata['news_public_date'] = format_datetime(2, $newsdata['PublishDate']);

    $news_prev = news_prev($ID, $newsdata['PublishDate'], $newsdata['VerOrder']);
    $news_next = news_next($ID, $newsdata['PublishDate'], $newsdata['VerOrder']);

    $RectID = $newsdata['VerOrderID'];
    $rectdata = $db->row_select_one('rect', 'ID=' . $RectID);
    $PublishDate = $rectdata['PublishDate'];

    $pdf_url = '';
    if ($rectdata['PdfFile'] != '') {
        $pdf_url = '../../' . $rectdata['PdfFile'];
    } 
    $rectinfo = PaperColor($rectdata['Rect']);
    $rectinfo = str_replace(array('height="550"', 'width="378"', '&nbsp;<img'), array('', 'width="100%"', ' <img'), $rectinfo);

    $setting = get_setting(); 
    // 第几版
    $paper_nav = paper_nav($RectID, $PublishDate); 
    // 上一版
    $rect_prev = rect_prev($RectID, $PublishDate); 
    // 下一版
    $rect_next = rect_next($RectID, $PublishDate); 
    // 上一期
    $paper_prev = paper_prev($PublishDate); 
    // 下一期
    $paper_next = paper_next($RectID, $PublishDate); 
    // 发刊日期
    $fk_date = format_datetime(2, $PublishDate);

    $tpl = Tpl();
    $tpl->assign('setting', $setting);
    $tpl->assign('paper_nav', $paper_nav);
    $tpl->assign('rectdata', $rectdata);
    $tpl->assign('pdf_url', $pdf_url);

    $tpl->assign('newsdata', $newsdata);
    $tpl->assign('news_prev', $news_prev);
    $tpl->assign('news_next', $news_next);
    $tpl->assign('rect_prev', $rect_prev);
    $tpl->assign('rect_next', $rect_next);
    $tpl->assign('paper_prev', $paper_prev);
    $tpl->assign('paper_next', $paper_next);
    $tpl->assign('fk_date', $fk_date);

    if (true) { // PC
        $tpl->assign('rectinfo', $rectinfo);

        $pcFilePath = '';
        $html_dir = "../html/" . $PublishDate;
        create_dir($html_dir);

        $pcFilePath = $html_dir . "/" . $ID . ".html"; 
        // $tpl->display('content/news_show.tpl');
        $html = $tpl->fetch('content/news_show.tpl');
        $fp = fopen($pcFilePath, "w");
        fwrite($fp, $html);
        fclose($fp);
    } 

    if (true) { // 手机版
        $rectinfo = str_replace(array('onmouseover="cvi_tip._show(event);" onmouseout="cvi_tip._hide(event);" onmousemove="cvi_tip._move(event);"'), array(''), $rectinfo);
        $tpl->assign('rectinfo', $rectinfo);

        $mobileFilePath = '';
        $html_dir = "../mobile/" . $PublishDate;
        create_dir($html_dir);

        $mobileFilePath = $html_dir . "/" . $ID . ".html"; 
        // $tpl->display('mobile/news_show.tpl');
        $html = $tpl->fetch('mobile/news_show.tpl');
        $fp = fopen($mobileFilePath, "w");
        fwrite($fp, $html);
        fclose($fp);
    } 
    return true;
} 
// 生成报纸某版面的所有新闻
function create_news_html_rect($PublishDate, $VerOrder) {
    global $db;
    $where = "`PublishDate`='" . $PublishDate . "' And `VerOrder`='" . $VerOrder . "'";
    $newsdata = $db->row_select('news', $where, 'ID', 0, 'ID DESC');
    foreach($newsdata as $key => $value) {
        create_news_html($value['ID']);
    } 
} 
// 生成报纸该期刊的所有新闻
function create_news_html_rectall($PublishDate) {
    global $db;
    $where = "`PublishDate`='" . $PublishDate . "'";
    $newsdata = $db->row_select('news', $where, 'ID', 0, 'ID DESC');
    foreach($newsdata as $key => $value) {
        create_news_html($value['ID']);
    } 
} 

?>