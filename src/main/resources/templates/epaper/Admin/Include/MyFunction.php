<?php 
// 文件目录不存在则创建
function create_dir($dir) {
    if (!file_exists ($dir)) {
        mkdir ($dir, 0777);
    } 
}

// 非法字符过滤函数
function sql_filter($sql) {
    $Check = preg_match("/^(select|insert|update|delete|\'|\/\*|\*|\.\.\/|\.\/|union|into|load_file|outfile)(.*)*/i", $sql); // 进行过滤
    if ($Check) {
        MessageBox("请勿输入非法内容！", "");
        exit();
    } else {
        return $sql;
    } 
}

// 获取配置文件 
function get_setting() {
    $MySql = "Select * From `FangBao_Info`";
    $Query = mysql_query($MySql);
    $setting = mysql_fetch_array($Query);
    return $setting; 
    // Array ( [0] => 1 [ID] => 1 [1] => 电子报管理系统 [WebSiteName] => 电子报管理系统 [2] => [WebSiteUrl] => [3] => 黔ICP备00000000号 [WebSiteTCP] => 黔ICP备00000000号 [4] => [WebTongJi] => [5] => 最简单最实用的电子报管理系统 [WebSiteKeyword] => 最简单最实用的电子报管理系统 [6] => 电子报管理系统，我们将竭诚为您服务！ [WebSiteIntr] => 电子报管理系统，我们将竭诚为您服务！ [7] => CopyRight 2014-2018 ? All Rights Reserved [WebSiteCopyInfo] => CopyRight 2014-2018 ? All Rights Reserved [8] => 1 [Message] => 1 [9] => 购买源码或二次开发服务QQ22042106 [Powered] => 购买源码或二次开发服务QQ22042106 )
}

// 获取新闻数据
function get_news_list($PublishDate, $VerOrder, $ID, $TopN) {
    $html = '';
    $MySql = "Select * From `FangBao_News` Where `PublishDate` = '" . $PublishDate . "' And `VerOrder` = '" . $VerOrder . "' Order By ID Asc";
    $Result = mysql_query($MySql);
    $j = 1;
    while ($Rs = mysql_fetch_array($Result)) {
        $Css = '';
        if (($j % 2) == 0) {
            $Css = 'h';
        } 
        $news_title = news_title($Rs['ID'], $Rs[Title], $TopN, 0);
        $news_url = news_url($Rs['ID']);
        $html = $html . '<a href="' . $news_url . '">' . $news_title . '</a>';
        $j = $j + 1;
    } 
    echo $html;
} 
// 获取报刊版面的列表新闻
function fetch_news_list($PublishDate, $VerOrder, $ID, $TopN) {
    global $db;
    $where = "`PublishDate` = '" . $PublishDate . "' And VerOrder = '" . $VerOrder . "'";
    $news_list = $db->row_select('news', $where, '*', 0, 'ID ASC');
    foreach($news_list as $key => $value) {
        $news_list[$key]['short_title'] = news_title($value['ID'], $value['Title'], $TopN, 0);
        $news_list[$key]['url'] = news_url($value['ID']);
    } 
    return $news_list;
}

// 报刊新闻详情页-上一篇新闻
function news_prev($ID, $PublishDate, $VerOrder) {
    global $db;
    $where = "`ID` < '" . $ID . "' And `PublishDate`='" . $PublishDate . "' And `VerOrder`='" . $VerOrder . "'";
    $news_data = $data = $db->row_select_one('news', $where,'*','ID DESC');
    if($news_data && $news_data['ID']>0){
        return format_title_url($news_data['ID'], "上一篇", 100, 1);
    }else{
        return "<span>上一篇</span>";
    }
} 

// 报刊新闻详情页-下一篇新闻
function news_next($ID, $PublishDate, $VerOrder) {
    global $db;
    $where = "`ID` > '" . $ID . "' And `PublishDate`='" . $PublishDate . "' And `VerOrder`='" . $VerOrder . "'";
    $news_data = $data = $db->row_select_one('news', $where,'*','ID ASC');
    if($news_data && $news_data['ID']>0){
        return format_title_url($news_data['ID'], "下一篇", 100, 1);
    }else{
        return "<span>下一篇</span>";
    }
}

// 获取报刊版面的导航
function fetch_rect_list($PublishDate) {
    global $db;
    $where = "`PublishDate` ='" . $PublishDate . "'";
    $rect_list = $db->row_select('rect', $where, '*', 0, 'ID ASC');
    foreach($rect_list as $key => $value) {
        if ($value['IsFrist'] == '1') {
            $rect_list[$key]['url'] = "qpaper.html";
        } else {
            $rect_list[$key]['url'] = "qpaper_" . $value['ID'] . ".html";
        } 
        $rect_list[$key]['title'] = $value['VerOrder'] . "：" . $value['BanMian'];
    } 
    return $rect_list;
} 
// 上一版
function rect_prev($ID, $PublishDate) {
    $MySql = "Select * From `FangBao_Rect` Where ID < " . $ID . " And `PublishDate` = '" . $PublishDate . "' Order By ID Desc Limit 0,1";
    $Result = mysql_query($MySql);
    $Rs = mysql_fetch_array($Result);
    if ($Rs['ID'] == '') {
        return '<span>上一版</span>';
    } else {
        return format_paper_url($Rs['ID'], '上一版', 5);
    } 
} 
// 下一版
function rect_next($ID, $PublishDate) {
    $MySql = "Select * From `FangBao_Rect` where ID > " . $ID . " And `PublishDate` = '" . $PublishDate . "' Order By ID Asc limit 0,1";
    $Result = mysql_query($MySql);
    $Rs = mysql_fetch_array($Result);
    if ($Rs['ID'] == '') {
        return '<span>下一版</span>';
    } else {
        return format_paper_url($Rs['ID'], '下一版', 5);
    } 
} 
// 获取新闻标题
function news_title($ID, $Title, $LeftN, $flag) {
    if ($flag == 0) {
        return sub_title($Title, $LeftN);
    } else {
        return $Title;
    } 
} 
// 获取新闻的链接
function news_url($ID) {
    return $ID . ".html";
} 
// 截断长标题函数
function sub_title($Title, $Length) {
    if (strlen($Title) > $Length) {
        $Temp = 0;
        for($i = 0; $i < $Length; $i++)
        if (ord($Title[$i]) > 128)
            $Temp++;
        if ($Temp % 2 == 0)
            $Title = substr($Title, 0, $Length) . "…";
        else
            $Title = substr($Title, 0, $Length + 1) . "…";
    } 
    return $Title;
} 
// 格式化日期函数
function format_datetime($flag = 0, $timestr = null) {
    // 获取星期
    $warr = array("0" => 星期日,
        "1" => 星期一,
        "2" => 星期二,
        "3" => 星期三,
        "4" => 星期四,
        "5" => 星期五,
        "6" => 星期六
        ); 
    // 设置北京时间并获取时间戳
    date_default_timezone_set('PRC');
    $timeStamp = null;
    if ($timestr)
        $timeStamp = strtotime($timestr);
    else
        $timeStamp = time();
    $i = date("w", $timeStamp); 
    // 设置时间显示格式
    switch ($flag) {
        Case 0:
            $Format_Time = date("Y年m月d日 H:m:s", $timeStamp) . " " . $warr[$i]; //格式为：2011年01月01日 12:12:12 星期几
            break;
        Case 1:
            $Format_Time = date("Y年m月d日", $timeStamp) . " " . $warr[$i]; //格式为：2011年01月01日 星期几
            break;
        Case 2:
            $Format_Time = date("Y年m月d日", $timeStamp); //格式为：2011年01月01日
            break;
        Case 3:
            $Format_Time = date("Y-m-d", $timeStamp); //格式为：2011-01-01
            break;
        Case 4:
            $Format_Time = date("Y/m/d", $timeStamp); //格式为：2011/01/01
            break;
        Case 5:
            $Format_Time = date("Y-n-j", $timeStamp); //格式为：2011-1-1
            break;
    } 
    return $Format_Time;
} 
// =======================上一期 下一期 文字效果============================================
function paper_prev($PublishDate) {
    $sql = "Select PublishDate From FangBao_Paper Where PublishDate < '" . $PublishDate . "' Order By PublishDate Desc,PublishID Desc Limit 0,1";
    $Result = mysql_query($sql);
    $Rs = mysql_fetch_array($Result);
    if ($Rs[0] == '') {
        return "<span>上一期</span>";
    } else {
        $PreRs = mysql_fetch_array(mysql_query("Select PublishDate From FangBao_Rect Where `IsFrist` = '1' And PublishDate = '" . $Rs[PublishDate] . "'"));
        return "<a href=\"../" . $PreRs[0] . "/qpaper.html\" target=\"_parent\">上一期</a>";
    } 
} 
function paper_next($PublishDate) {
    $sql = "Select PublishDate From FangBao_Paper Where PublishDate > '" . $PublishDate . "' Order By PublishDate Asc,PublishID Asc Limit 0,1";
    $Result = mysql_query($sql);
    $oRs = mysql_fetch_array($Result);
    if ($oRs[0] == '') {
        return "<span>下一期</span>";
    } else {
        $NextRs = mysql_fetch_array(mysql_query("Select PublishDate From FangBao_Rect Where `IsFrist` = '1' And PublishDate = '" . $oRs[PublishDate] . "'"));
        return "<a href=\"../" . $NextRs['PublishDate'] . "/qpaper.html\" target=\"_parent\">下一期</a>";
    } 
} 
// =========================期刊版面页 期数 版数============================
function paper_nav($ID, $PublishDate) {
    $MySql = "Select * From `FangBao_Paper` Where `PublishDate` = '" . $PublishDate . "'";
    $Result = mysql_query($MySql);
    $Rs = mysql_fetch_array($Result);
    return format_paper_url($ID, $Rs[PublishID], 2);
}


// ///////////////////////////////////////////////////////////////////////////////////////////////////////////
// ///////////////////////////////////////////////////////////////////////////////////////////////////////////
// ///////////////////////////////////////////////////////////////////////////////////////////////////////////
// ///////////////////////////////////////////////////////////////////////////////////////////////////////////
// ========================版面导航=============================================
function get_news_nav($PublishDate) {
    $html = '';
    $MySql = "Select * From `FangBao_Rect` Where `PublishDate` ='" . $PublishDate . "' Order By ID Asc";
    $Result = mysql_query($MySql);
    $i = 1;
    while ($Rs = mysql_fetch_array($Result)) {
        $Css = '';
        if (($i % 2) == 0) {
            $Css = 'h';
        } 
        $nav_url = get_news_nav_url($Rs['ID'], $Rs[VerOrder], $Rs[BanMian]);
        $html = $html . $nav_url;
        $i = $i + 1;
    } 
    echo $html;
} 
// 版面链接
function get_news_nav_url($ID, $VerOrder, $BanMian) {
    $MySql = "Select * From `FangBao_Rect` Where ID = " . $ID . "";
    $Rs = mysql_fetch_array(mysql_query($MySql));
    $IsFrist = $Rs[IsFrist];
    if ($IsFrist == '1') {
        $TitleURL = "qpaper.html";
    } else {
        $TitleURL = "qpaper_" . $ID . ".html";
    } 
    echo "<a href='" . $TitleURL . "'>" . $VerOrder . "：" . $BanMian . "</a>";
} 
// 版面链接
function format_nav_url($ID, $VerOrder, $BanMian) {
    $MySql = "Select * From `FangBao_Rect` Where ID = " . $ID . "";
    $Rs = mysql_fetch_array(mysql_query($MySql));
    $IsFrist = $Rs[IsFrist];
    if ($IsFrist == '1') {
        $TitleURL = "qpaper.html";
    } else {
        $TitleURL = "qpaper_" . $ID . ".html";
    } 
    echo "<a href='" . $TitleURL . "'>" . $VerOrder . "：" . $BanMian . "</a>";
} 
// 标题链接
function format_title_url($ID, $Title, $LeftN, $Flag) {
    $oTitle = sub_title($Title, $LeftN);
    $TitleURL = $ID . ".html";
    switch ($Flag) {
        Case 0:
            $format_title_url = "<a href='" . $TitleURL . "'>·" . $oTitle . "</a>";
            break;
        Case 1:
            $format_title_url = "<a href='" . $TitleURL . "'>" . $Title . "</a>";
            break;
    } 
    return $format_title_url;
} 
// 期刊链接
function format_paper_url($ID, $txt, $Flag) {
    $MySql = "Select * From `FangBao_Rect` where ID = " . $ID . "";
    $Result = mysql_query($MySql);
    if ($Result) $Rs = mysql_fetch_array($Result);
    $IsFrist = $Rs[IsFrist];
    $PublishDate = $Rs[PublishDate];
    if ($IsFrist == '1') {
        $TitleURL = "qpaper.html";
    } else {
        $TitleURL = "qpaper_" . $ID . ".html";
    } 

    switch ($Flag) {
        Case 0:
            $Format_PaperURL = "<a href=\"../html/" . $PublishDate . "/" . $TitleURL . "\" target=\"_parent\">" . $txt . "</a>";
            break;
        Case 1:
            $Format_PaperURL = "<a href=\"" . $TitleURL . "\"><img src=\"" . $txt . "\" width=\"24\" height=\"99\" border=\"0\"></a>";
            break;
        Case 2:
            $Format_PaperURL = "第" . $txt . "期";
            break;
        Case 3:
            $Format_PaperURL = "value=" . $TitleURL . "";
            break;
        Case 4:
            $Format_PaperURL = "<a href=\"Alert.php\" target=\"_parent\">" . $txt . "</a>";
            break;
        Case 5:
            $Format_PaperURL = "<a href=\"" . $TitleURL . "\">" . $txt . "</a>";
            break;
    } 
    return $Format_PaperURL;
}
// ========================把日期写入JS中============================
function GhostPhp_JS() {
    $MySql = "Select * From `FangBao_Paper` Order By PublishID Asc";
    $Result = mysql_query($MySql);
    while ($Rs = mysql_fetch_array($Result)) {
        echo Format_Time(5, $Rs[PublishDate]);
        echo ",";
    } 
} 
// ========================新闻点击排行榜列表=============================================
function Top_News_List($Nub, $TopN) {
    $MySql = "Select * From `FangBao_News` Order By Hits Desc Limit 0," . $Nub . "";
    $Result = mysql_query($MySql);
    echo "<table width=\"100%\">\n";
    while ($Rs = mysql_fetch_array($Result)) {
        echo "<tr onmouseover=\"this.style.backgroundColor='#FFFFCC'\" onmouseout=\"this.style.backgroundColor=''\">\n";
        echo "<td align=\"left\" width=\"80%\">";
        format_title_url($Rs['ID'], $Rs[Title], $TopN, 0);
        echo "</td>\n";
        echo "<td width=\"20%\">";
        echo "[" . $Rs[Hits] . "]";
        echo "</td>\n";
        echo "</tr>\n";
    } 
    echo "</table>\n";
} 
// =========================上一版 下一版 图片效果=============================================
function New_Next_Pic($ID, $PublishDate) {
    $a = "<img src=\"../../Images/Btn_Next.gif\" width=\"24\" height=\"99\" border=\"0\" />";
    $b = "<img src=\"../../Images/Btn_Next3.gif\" width=\"24\" height=\"99\" border=\"0\" />";
    $c = "<img src=\"../../Images/Btn_Next1.gif\" width=\"24\" height=\"99\" border=\"0\" />";
    $d = "<img src=\"../../Images/Btn_Next2.gif\" width=\"24\" height=\"99\" border=\"0\" />";
    $MySql = "Select * From `FangBao_Rect` Where ID < " . $ID . " And `PublishDate` = '" . $PublishDate . "' Order By ID Desc Limit 0,1";
    $Result = mysql_query($MySql);
    $Rs = mysql_fetch_array($Result);
    echo "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\">\n";
    echo "<tr>\n";
    echo "<td>";
    if ($Rs['ID'] == '') {
        echo $b;
    } else {
        format_paper_url($Rs['ID'], $a, 5);
    } 
    echo"</td>\n";
    echo"<tr>\n";
    $MySql = "Select * From `FangBao_Rect` where ID > " . $ID . " And `PublishDate` = '" . $PublishDate . "' Order By ID Asc limit 0,1";
    $Result = mysql_query($MySql);
    $Rs = mysql_fetch_array($Result);
    echo "<td>";
    if ($Rs['ID'] == '') {
        echo $d;
    } else {
        format_paper_url($Rs['ID'], $c, 5);
    } 
    echo "</td>\n";
    echo "</tr>\n";
    echo "</table>\n";
} 
// ========================文章阅读页图片热点=============================================
function Show_Rect($VerOrder, $PublishDate) {
    $MySql = "Select * From `FangBao_Rect` Where `PublishDate` = '" . $PublishDate . "' And `VerOrder` = '" . $VerOrder . "' Order By ID Asc";
    $Result = mysql_query($MySql);
    $Rs = mysql_fetch_array($Result);
    echo PaperColor($Rs[Rect]);
} 
// ========================文章阅读页PDF下载=============================================
function Show_PDF($PublishDate, $VerOrder) {
    $oMySql = "Select * From `FangBao_Rect` Where `PublishDate` = '" . $PublishDate . "' And `VerOrder` = '" . $VerOrder . "'";
    $oResult = mysql_query($oMySql);
    $oRs = mysql_fetch_array($oResult);
    echo "PDF版<a href=\"../../" . $oRs[pdfFile] . "\"><img border=\"0\" src=\"../../Images/pdf.gif\" width=\"16\" height=\"16\" /></a>";
} 
// =========================期刊版面页 期数 版数============================
function Show_Nav($PublishDate) {
    $MySql = "Select * From `FangBao_Paper` Where `PublishDate` = '" . $PublishDate . "'";
    $Result = mysql_query($MySql);
    $Rs = mysql_fetch_array($Result);
    format_paper_url("", $Rs[PublishID], 2);
} 

function Show_Hits($ID) {
    echo "<span id=\"News_Hits\"><script language=\"javascript\" src=\"../../Include/Hits.php?ID=" . $ID . "\"></script></span>";
} 
// ========================文章阅读页 上一篇 下一篇=============================================


?>