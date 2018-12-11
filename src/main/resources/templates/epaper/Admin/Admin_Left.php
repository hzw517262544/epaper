    <link href="Images/skin.css" rel="stylesheet" type="text/css" />
    <meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<?php
include_once("../config.php");
$userip=get_client_ip();
if(($_SESSION['Admin']=="") or ($_SESSION['AdminSessionPWd']!= AdminSession or $_SESSION["login"] != true)){
    MessageBox("请勿非法登录，谢谢！","index.php");
}
else{
    ?>
    <body>
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td width="17" valign="top" background="Images/mail_leftbg.gif"><img src="Images/left-top-right.gif" width="17" height="29" /></td>
            <td valign="top" background="Images/content-bg.gif"><div class="titlebt">欢迎界面</div></td>
            <td width="16" valign="top" background="Images/mail_rightbg.gif"><img src="Images/nav-right-bg.gif" width="16" height="29" /></td>
        </tr>
        <tr>
            <td valign="middle" background="Images/mail_leftbg.gif">&nbsp;</td>
            <td valign="top" bgcolor="#F7F8F9">
                <table width="100%" border="1" cellpAdding="0" cellspacing="0" class="colorTest">
                    <tr>
                        <td>
                            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="colorTest">
                                <tbody>
                                <tr>
                                    <td height="28" colspan="2">服务器信息： </td>
                                </tr>
                                <tr>
                                    <td height="25"><span>服务器名：</span> <span class="left_ts"><?php echo $_SERVER['SERVER_NAME']; ?></span></td>
                                    <td width="54%" height="25"><span>服务器IP：</span> <span class="left_ts"> <?php echo $_SERVER['REMOTE_ADDR']; ?></span></td>
                                </tr>
                                <tr>
                                    <td height="25"><span>服务器端口：</span><span class="left_ts"><?php echo $_SERVER['SERVER_PORT']; ?></span></td>
                                    <td height="25"><span>服务器操作系统：</span><span class="left_ts"><?php echo PHP_OS."&nbsp;(".php_uname().")"; ?></span></td>
                                </tr>
                                <tr>
                                    <td height="25"><span>客户端IP：</span><span class="left_ts"><?php echo $userip;?></span></td>
                                    <td height="25"><span>服务器类型/版本：</span><span class="left_ts"><?php echo $_SERVER['SERVER_SOFTWARE']; ?></span></td>
                                </tr>
                                <tr>
                                    <td height="25"><span>处理器(CPU)信息：</span><span class="left_ts"><?php echo getenv('PROCESSOR_IDENTIFIER')?getenv('PROCESSOR_IDENTIFIER'):"<font color=red>获取失败！</font>"; ?></span></td>
                                    <td height="25"><span><span class="STYLE2">处理器(CPU)个数：</span></span> <span class="left_ts"> <?php echo getenv('NUMBER_OF_PROCESSORS')?getenv('NUMBER_OF_PROCESSORS'):"获取失败！"; ?></span></td>
                                </tr>
                                <tr>
                                    <td height="25"><span>当前文件位置：</span><span class="left_ts"><?php echo $_SERVER['SCRIPT_FILENAME']; ?></span></td>
                                    <td height="25"><span>网站根目录：</span><span class="left_ts"><?php echo $_SERVER['DOCUMENT_ROOT']; ?></span></td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td><img src="Images/icon-mail2.gif" width="16" height="11"> 客户服务邮箱：22042106@qq.com</td>
                    </tr>
                </table>
            </td>
            <td background="Images/mail_rightbg.gif">&nbsp;</td>
        </tr>
        <tr>
            <td valign="bottom" background="Images/mail_leftbg.gif"><img src="Images/buttom_left2.gif" width="17" height="17" /></td>
            <td background="Images/buttom_bgs.gif"><img src="Images/buttom_bgs.gif" width="17" height="17"></td>
            <td valign="bottom" background="Images/mail_rightbg.gif"><img src="Images/buttom_right2.gif" width="16" height="17" /></td>
        </tr>
    </table>
    </body>
    <?php
}
?>