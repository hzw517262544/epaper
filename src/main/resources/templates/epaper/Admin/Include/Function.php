<?php 
// �ضϳ����⺯��
function ChgTitle($Title, $Length) {
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
// ��������
function Format_navURL($ID, $VerOrder, $BanMian) {
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
function Format_TitleURL($ID, $Title, $LeftN, $Flag) {
    $oTitle = ChgTitle($Title, $LeftN);
    $TitleURL = $ID . ".html";
    switch ($Flag) {
        Case 0:
            $Format_TitleURL = "<a href='" . $TitleURL . "'>��" . $oTitle . "</a>";
            break;
        Case 1:
            $Format_TitleURL = "<a href='" . $TitleURL . "'>" . $Title . "</a>";
            break;
    } 
    echo $Format_TitleURL;
} 
// �ڿ�����
function Format_PaperURL($ID, $txt, $Flag) {
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
            $Format_PaperURL = "�ܵ�" . $txt . "��";
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
    echo $Format_PaperURL;
} 
// ���ڻع���ʾ
function Pic_index($PageNum) {
    echo "<table width=\"100%\" align=\"center\">\n";
    echo "<tr>\n";
    $i = 1;
    $oMySql = "select count(*) from `FangBao_Rect` Where `IsFrist`='1' order by PublishDate Desc,ID Asc";
    $oQuery = mysql_query($oMySql);
    $oRs = mysql_fetch_array($oQuery);
    $Num = $oRs[0];
    $Pagenum = $PageNum;
    $AllPage = ceil($Num / $PageNum);
    if (Inject_Check(empty($_GET['Page']))) {
        $Page = 0;
    } else {
        $Page = Inject_Check($_GET['Page']);
        if ($Page < 0) $Page = 0;
        if ($Page >= $AllPage) $Page = $AllPage-1;
    } 
    $dMySql = "Select * From `FangBao_Rect` Where `IsFrist`='1' Order By ID Desc Limit " . ($Page * $Pagenum) . ",$PageNum ";
    $Resulta = mysql_query($dMySql);
    while ($cRs = mysql_fetch_array($Resulta)) {
        $QFPublishDate = $cRs[PublishDate];
        $qMySql = "Select * From `FangBao_Paper` Where `PublishDate`='" . $QFPublishDate . "' Order By PublishID Desc";
        $qResulta = mysql_query($qMySql);
        $qRs = mysql_fetch_array($qResulta);
        echo "<td height=\"198\" width=\"160\" align=\"center\"> <a class=\"img\" href=\"../" . $cRs[PublishDate] . "/qpaper.html\"><img src=\"../../" . $cRs[PicFile] . "\" title=\"�ܵ�" . $qRs[PublishID] . "��\" height=\"198\" width=\"138\" border=\"0\"></a><br><br><span class=\"red\">��������:" . $cRs[PublishDate] . "</span></td>\n";
        if (($i % 6) == 0) {
            echo "</tr>\n";
            echo "<tr>\n";
        } 
        $i = $i + 1;
    } 
    echo "</tr>\n";
    echo "<tr>\n";
    echo "<td align=\"center\" colspan=\"6\">\n";
    $sPage = $Page + 1;
    echo "��" . $Num . "��  ";
    echo "ÿҳ" . $PageNum . "��  ";
    echo "(" . "�� $sPage ҳ/";
    echo "�� $AllPage ҳ" . ") ";
    if ($Page <= 0) {
        $Up = 0;
    } else {
        $Up = $Page-1;
    } 
    if ($Page >= $AllPage-1) {
        $Next = $AllPage-1;
    } else {
        $Next = $Page + 1;
    } 
    $Over = $AllPage-1;
    echo "<a href=\"Review_0.html\">��ҳ</a> <a href=\"Review_" . $Up . ".html\">��һҳ</a> <a href=\"Review_" . $Next . ".html\">��һҳ</a> <a href=\"Review_" . $Over . ".html\">ĩҳ</a>";
    echo "</td>\n";
    echo "</tr>\n";
    echo "</table>\n";
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
// ========================���浼��=============================================
function News_nav($PublishDate) {
    echo "<table width=\"100%\">\n";
    $MySql = "Select * From `FangBao_Rect` Where `PublishDate` ='" . $PublishDate . "' Order By ID Asc";
    $Result = mysql_query($MySql);
    $i = 1;
    while ($Rs = mysql_fetch_array($Result)) {
        if (($i % 2) == 0) {
            $Css = "info1";
        } else {
            $Css = "info2";
        } 
        echo "<tr class=\"" . $Css . "\" onMouseOver=\"this.style.backgroundColor='#FFFFCC'\" onMouseOut=\"this.style.backgroundColor=''\">\n";
        echo "<td>";
        echo "��";
        Format_navURL($Rs[ID], $Rs[VerOrder], $Rs[BanMian]);
        echo "</td>";
        echo "</tr>\n";
        $i = $i + 1;
    } 
    echo"</table>\n";
} 
// ========================�����б�=============================================
function News_List($PublishDate, $VerOrder, $ID, $TopN) {
    $MySql = "Select * From `FangBao_News` Where `PublishDate` = '" . $PublishDate . "' And `VerOrder` = '" . $VerOrder . "' Order By ID Asc";
    $Result = mysql_query($MySql);
    $j = 1;
    echo "<table width=\"100%\">\n";
    while ($Rs = mysql_fetch_array($Result)) {
        if (($j % 2) == 0) {
            $Css = "info1";
        } else {
            $Css = "info2";
        } 
        echo "<tr class=\"" . $Css . "\" onmouseover=\"this.style.backgroundColor='#FFFFCC'\" onmouseout=\"this.style.backgroundColor=''\">\n";
        echo "<td>";
        Format_TitleURL($Rs[ID], $Rs[Title], $TopN, 0);
        echo "</td>";
        echo "</tr>\n";
        $j = $j + 1;
    } 
    echo "</table>\n";
} 
// ========================���ŵ�����а��б�=============================================
function Top_News_List($Nub, $TopN) {
    $MySql = "Select * From `FangBao_News` Order By Hits Desc Limit 0," . $Nub . "";
    $Result = mysql_query($MySql);
    echo "<table width=\"100%\">\n";
    while ($Rs = mysql_fetch_array($Result)) {
        echo "<tr onmouseover=\"this.style.backgroundColor='#FFFFCC'\" onmouseout=\"this.style.backgroundColor=''\">\n";
        echo "<td align=\"left\" width=\"80%\">";
        Format_TitleURL($Rs[ID], $Rs[Title], $TopN, 0);
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
    if ($Rs[ID] == '') {
        echo $b;
    } else {
        Format_PaperURL($Rs[ID], $a, 5);
    } 
    echo"</td>\n";
    echo"<tr>\n";
    $MySql = "Select * From `FangBao_Rect` where ID > " . $ID . " And `PublishDate` = '" . $PublishDate . "' Order By ID Asc limit 0,1";
    $Result = mysql_query($MySql);
    $Rs = mysql_fetch_array($Result);
    echo "<td>";
    if ($Rs[ID] == '') {
        echo $d;
    } else {
        Format_PaperURL($Rs[ID], $c, 5);
    } 
    echo "</td>\n";
    echo "</tr>\n";
    echo "</table>\n";
} 
// =======================��һ�� ��һ�� ����Ч��============================================
function Paper_Next($ID, $PublishDate) {
    $MySql = "Select * From `FangBao_Rect` Where `ID` < '" . $ID . "' And `IsFrist` = '1' And PublishDate <> '" . $PublishDate . "' Order By ID Desc Limit 0,1";
    $Result = mysql_query($MySql);
    $Rs = mysql_fetch_array($Result);
    echo "<table width=\"65%\" cellpadding=\"0\" cellspacing=\"0\">\n";
    echo "<tr>\n";
    echo "<td>";
    if ($Rs[ID] == '') {
        Format_PaperURL("", "��һ��", 4);
        echo "<img border=\"0\" src=\"../Images/d1.gif\" align=\"absmiddle\" />";
    } else {
        Format_PaperURL($Rs[ID], "��һ�� ", 0);
        echo "<img border=\"0\" src=\"../Images/d1.gif\" align=\"absmiddle\" />";
    } 
    echo "</td>\n";
    $MySql = "Select * From `FangBao_Rect` Where `ID` > '" . $ID . "' And `IsFrist` = '1' And PublishDate <> '" . $PublishDate . "' Order By ID Asc Limit 0,1";
    $Result = mysql_query($MySql);
    $Rs = mysql_fetch_array($Result);
    echo "<td>";
    if ($Rs[ID] == '') {
        echo "<img border=\"0\" src=\"../Images/d.gif\" align=\"absmiddle\" />";
        Format_PaperURL("", "��һ��", 4);
    } else {
        echo "<img border=\"0\" src=\"../Images/d.gif\" align=\"absmiddle\">";
        Format_PaperURL($Rs[ID], "��һ�� ", 0);
    } 
    echo "</td>\n";
    echo "</tr>\n";
    echo "</table>\n";
} 
// =========================�ڿ�����ҳ ���� ����============================
function GhostPhp_Nav($ID, $PublishDate) {
    $MySql = "Select * From `FangBao_Paper` Where `PublishDate` = '" . $PublishDate . "'";
    $Result = mysql_query($MySql);
    $Rs = mysql_fetch_array($Result);
    Format_PaperURL($ID, $Rs[PublishID], 2);
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
    Format_PaperURL("", $Rs[PublishID], 2);
} 

function Show_Hits($ID) {
    echo "<span id=\"News_Hits\"><script language=\"javascript\" src=\"../../Include/Hits.php?ID=" . $ID . "\"></script></span>";
} 
// ========================�����Ķ�ҳ ��һƪ ��һƪ=============================================
function Show_Next_show($ID, $PublishDate, $VerOrder) {
    $MySql = "Select * From `FangBao_News` Where `ID` < '" . $ID . "' And `PublishDate`='" . $PublishDate . "' And `VerOrder`='" . $VerOrder . "' Order By ID Desc";
    $Result = mysql_query($MySql);
    $Rs = mysql_fetch_array($Result);
    echo "<table width=\"100\" cellpadding=\"0\" cellspacing=\"0\">\n";
    echo "<tr>\n";
    echo "<td>";
    if ($Rs[ID] == '') {
        echo "��һƪ";
        echo "<img border=\"0\" src=\"../../Images/d1.gif\" align=\"absmiddle\" />";
    } else {
        Format_TitleURL($Rs[ID], "��һƪ", 10, 1);
        echo "<img border=\"0\" src=\"../../Images/d1.gif\" align=\"absmiddle\" />";
    } 
    echo "</td>\n";
    $MySql = "Select * From `FangBao_News` Where `ID` > '" . $ID . "' And `PublishDate`='" . $PublishDate . "' And `VerOrder`='" . $VerOrder . "' Order By ID Asc";
    $Result = mysql_query($MySql);
    $Rs = mysql_fetch_array($Result);
    echo "<td>";
    if ($Rs[ID] == '') {
        echo "<img border=\"0\" src=\"../../Images/d.gif\" align=\"absmiddle\" />";
        echo "��һƪ";
    } else {
        echo "<img border=\"0\" src=\"../../Images/d.gif\" align=\"absmiddle\" />";
        Format_TitleURL($Rs[ID], "��һƪ", 10, 1);
    } 
    echo "</td>\n";
    echo "</tr>\n";
    echo "</table>\n";
} 

?>