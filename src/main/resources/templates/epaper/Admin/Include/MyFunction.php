<?php 
// �ļ�Ŀ¼�������򴴽�
function create_dir($dir) {
    if (!file_exists ($dir)) {
        mkdir ($dir, 0777);
    } 
}

// �Ƿ��ַ����˺���
function sql_filter($sql) {
    $Check = preg_match("/^(select|insert|update|delete|\'|\/\*|\*|\.\.\/|\.\/|union|into|load_file|outfile)(.*)*/i", $sql); // ���й���
    if ($Check) {
        MessageBox("��������Ƿ����ݣ�", "");
        exit();
    } else {
        return $sql;
    } 
}

// ��ȡ�����ļ� 
function get_setting() {
    $MySql = "Select * From `FangBao_Info`";
    $Query = mysql_query($MySql);
    $setting = mysql_fetch_array($Query);
    return $setting; 
    // Array ( [0] => 1 [ID] => 1 [1] => ���ӱ�����ϵͳ [WebSiteName] => ���ӱ�����ϵͳ [2] => [WebSiteUrl] => [3] => ǭICP��00000000�� [WebSiteTCP] => ǭICP��00000000�� [4] => [WebTongJi] => [5] => �����ʵ�õĵ��ӱ�����ϵͳ [WebSiteKeyword] => �����ʵ�õĵ��ӱ�����ϵͳ [6] => ���ӱ�����ϵͳ�����ǽ��߳�Ϊ������ [WebSiteIntr] => ���ӱ�����ϵͳ�����ǽ��߳�Ϊ������ [7] => CopyRight 2014-2018 ? All Rights Reserved [WebSiteCopyInfo] => CopyRight 2014-2018 ? All Rights Reserved [8] => 1 [Message] => 1 [9] => ����Դ�����ο�������QQ22042106 [Powered] => ����Դ�����ο�������QQ22042106 )
}

// ��ȡ��������
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
// ��ȡ����������б�����
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

// ������������ҳ-��һƪ����
function news_prev($ID, $PublishDate, $VerOrder) {
    global $db;
    $where = "`ID` < '" . $ID . "' And `PublishDate`='" . $PublishDate . "' And `VerOrder`='" . $VerOrder . "'";
    $news_data = $data = $db->row_select_one('news', $where,'*','ID DESC');
    if($news_data && $news_data['ID']>0){
        return format_title_url($news_data['ID'], "��һƪ", 100, 1);
    }else{
        return "<span>��һƪ</span>";
    }
} 

// ������������ҳ-��һƪ����
function news_next($ID, $PublishDate, $VerOrder) {
    global $db;
    $where = "`ID` > '" . $ID . "' And `PublishDate`='" . $PublishDate . "' And `VerOrder`='" . $VerOrder . "'";
    $news_data = $data = $db->row_select_one('news', $where,'*','ID ASC');
    if($news_data && $news_data['ID']>0){
        return format_title_url($news_data['ID'], "��һƪ", 100, 1);
    }else{
        return "<span>��һƪ</span>";
    }
}

// ��ȡ��������ĵ���
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
        $rect_list[$key]['title'] = $value['VerOrder'] . "��" . $value['BanMian'];
    } 
    return $rect_list;
} 
// ��һ��
function rect_prev($ID, $PublishDate) {
    $MySql = "Select * From `FangBao_Rect` Where ID < " . $ID . " And `PublishDate` = '" . $PublishDate . "' Order By ID Desc Limit 0,1";
    $Result = mysql_query($MySql);
    $Rs = mysql_fetch_array($Result);
    if ($Rs['ID'] == '') {
        return '<span>��һ��</span>';
    } else {
        return format_paper_url($Rs['ID'], '��һ��', 5);
    } 
} 
// ��һ��
function rect_next($ID, $PublishDate) {
    $MySql = "Select * From `FangBao_Rect` where ID > " . $ID . " And `PublishDate` = '" . $PublishDate . "' Order By ID Asc limit 0,1";
    $Result = mysql_query($MySql);
    $Rs = mysql_fetch_array($Result);
    if ($Rs['ID'] == '') {
        return '<span>��һ��</span>';
    } else {
        return format_paper_url($Rs['ID'], '��һ��', 5);
    } 
} 
// ��ȡ���ű���
function news_title($ID, $Title, $LeftN, $flag) {
    if ($flag == 0) {
        return sub_title($Title, $LeftN);
    } else {
        return $Title;
    } 
} 
// ��ȡ���ŵ�����
function news_url($ID) {
    return $ID . ".html";
} 
// �ضϳ����⺯��
function sub_title($Title, $Length) {
    if (strlen($Title) > $Length) {
        $Temp = 0;
        for($i = 0; $i < $Length; $i++)
        if (ord($Title[$i]) > 128)
            $Temp++;
        if ($Temp % 2 == 0)
            $Title = substr($Title, 0, $Length) . "��";
        else
            $Title = substr($Title, 0, $Length + 1) . "��";
    } 
    return $Title;
} 
// ��ʽ�����ں���
function format_datetime($flag = 0, $timestr = null) {
    // ��ȡ����
    $warr = array("0" => ������,
        "1" => ����һ,
        "2" => ���ڶ�,
        "3" => ������,
        "4" => ������,
        "5" => ������,
        "6" => ������
        ); 
    // ���ñ���ʱ�䲢��ȡʱ���
    date_default_timezone_set('PRC');
    $timeStamp = null;
    if ($timestr)
        $timeStamp = strtotime($timestr);
    else
        $timeStamp = time();
    $i = date("w", $timeStamp); 
    // ����ʱ����ʾ��ʽ
    switch ($flag) {
        Case 0:
            $Format_Time = date("Y��m��d�� H:m:s", $timeStamp) . " " . $warr[$i]; //��ʽΪ��2011��01��01�� 12:12:12 ���ڼ�
            break;
        Case 1:
            $Format_Time = date("Y��m��d��", $timeStamp) . " " . $warr[$i]; //��ʽΪ��2011��01��01�� ���ڼ�
            break;
        Case 2:
            $Format_Time = date("Y��m��d��", $timeStamp); //��ʽΪ��2011��01��01��
            break;
        Case 3:
            $Format_Time = date("Y-m-d", $timeStamp); //��ʽΪ��2011-01-01
            break;
        Case 4:
            $Format_Time = date("Y/m/d", $timeStamp); //��ʽΪ��2011/01/01
            break;
        Case 5:
            $Format_Time = date("Y-n-j", $timeStamp); //��ʽΪ��2011-1-1
            break;
    } 
    return $Format_Time;
} 
// =======================��һ�� ��һ�� ����Ч��============================================
function paper_prev($PublishDate) {
    $sql = "Select PublishDate From FangBao_Paper Where PublishDate < '" . $PublishDate . "' Order By PublishDate Desc,PublishID Desc Limit 0,1";
    $Result = mysql_query($sql);
    $Rs = mysql_fetch_array($Result);
    if ($Rs[0] == '') {
        return "<span>��һ��</span>";
    } else {
        $PreRs = mysql_fetch_array(mysql_query("Select PublishDate From FangBao_Rect Where `IsFrist` = '1' And PublishDate = '" . $Rs[PublishDate] . "'"));
        return "<a href=\"../" . $PreRs[0] . "/qpaper.html\" target=\"_parent\">��һ��</a>";
    } 
} 
function paper_next($PublishDate) {
    $sql = "Select PublishDate From FangBao_Paper Where PublishDate > '" . $PublishDate . "' Order By PublishDate Asc,PublishID Asc Limit 0,1";
    $Result = mysql_query($sql);
    $oRs = mysql_fetch_array($Result);
    if ($oRs[0] == '') {
        return "<span>��һ��</span>";
    } else {
        $NextRs = mysql_fetch_array(mysql_query("Select PublishDate From FangBao_Rect Where `IsFrist` = '1' And PublishDate = '" . $oRs[PublishDate] . "'"));
        return "<a href=\"../" . $NextRs['PublishDate'] . "/qpaper.html\" target=\"_parent\">��һ��</a>";
    } 
} 
// =========================�ڿ�����ҳ ���� ����============================
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
// ========================���浼��=============================================
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
// ��������
function get_news_nav_url($ID, $VerOrder, $BanMian) {
    $MySql = "Select * From `FangBao_Rect` Where ID = " . $ID . "";
    $Rs = mysql_fetch_array(mysql_query($MySql));
    $IsFrist = $Rs[IsFrist];
    if ($IsFrist == '1') {
        $TitleURL = "qpaper.html";
    } else {
        $TitleURL = "qpaper_" . $ID . ".html";
    } 
    echo "<a href='" . $TitleURL . "'>" . $VerOrder . "��" . $BanMian . "</a>";
} 
// ��������
function format_nav_url($ID, $VerOrder, $BanMian) {
    $MySql = "Select * From `FangBao_Rect` Where ID = " . $ID . "";
    $Rs = mysql_fetch_array(mysql_query($MySql));
    $IsFrist = $Rs[IsFrist];
    if ($IsFrist == '1') {
        $TitleURL = "qpaper.html";
    } else {
        $TitleURL = "qpaper_" . $ID . ".html";
    } 
    echo "<a href='" . $TitleURL . "'>" . $VerOrder . "��" . $BanMian . "</a>";
} 
// ��������
function format_title_url($ID, $Title, $LeftN, $Flag) {
    $oTitle = sub_title($Title, $LeftN);
    $TitleURL = $ID . ".html";
    switch ($Flag) {
        Case 0:
            $format_title_url = "<a href='" . $TitleURL . "'>��" . $oTitle . "</a>";
            break;
        Case 1:
            $format_title_url = "<a href='" . $TitleURL . "'>" . $Title . "</a>";
            break;
    } 
    return $format_title_url;
} 
// �ڿ�����
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
            $Format_PaperURL = "��" . $txt . "��";
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
// ========================������д��JS��============================
function GhostPhp_JS() {
    $MySql = "Select * From `FangBao_Paper` Order By PublishID Asc";
    $Result = mysql_query($MySql);
    while ($Rs = mysql_fetch_array($Result)) {
        echo Format_Time(5, $Rs[PublishDate]);
        echo ",";
    } 
} 
// ========================���ŵ�����а��б�=============================================
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
// =========================��һ�� ��һ�� ͼƬЧ��=============================================
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
// ========================�����Ķ�ҳͼƬ�ȵ�=============================================
function Show_Rect($VerOrder, $PublishDate) {
    $MySql = "Select * From `FangBao_Rect` Where `PublishDate` = '" . $PublishDate . "' And `VerOrder` = '" . $VerOrder . "' Order By ID Asc";
    $Result = mysql_query($MySql);
    $Rs = mysql_fetch_array($Result);
    echo PaperColor($Rs[Rect]);
} 
// ========================�����Ķ�ҳPDF����=============================================
function Show_PDF($PublishDate, $VerOrder) {
    $oMySql = "Select * From `FangBao_Rect` Where `PublishDate` = '" . $PublishDate . "' And `VerOrder` = '" . $VerOrder . "'";
    $oResult = mysql_query($oMySql);
    $oRs = mysql_fetch_array($oResult);
    echo "PDF��<a href=\"../../" . $oRs[pdfFile] . "\"><img border=\"0\" src=\"../../Images/pdf.gif\" width=\"16\" height=\"16\" /></a>";
} 
// =========================�ڿ�����ҳ ���� ����============================
function Show_Nav($PublishDate) {
    $MySql = "Select * From `FangBao_Paper` Where `PublishDate` = '" . $PublishDate . "'";
    $Result = mysql_query($MySql);
    $Rs = mysql_fetch_array($Result);
    format_paper_url("", $Rs[PublishID], 2);
} 

function Show_Hits($ID) {
    echo "<span id=\"News_Hits\"><script language=\"javascript\" src=\"../../Include/Hits.php?ID=" . $ID . "\"></script></span>";
} 
// ========================�����Ķ�ҳ ��һƪ ��һƪ=============================================


?>