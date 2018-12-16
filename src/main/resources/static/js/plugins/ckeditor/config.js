/**
 * @license Copyright (c) 2003-2017, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
    config.height=500;
    config.image_previewText=' ';
	config.filebrowserUploadUrl="/common/sysFile/uploadCk"; //注意是配置在函数里边

    // 界面语言，默认为 'en'
    config.language = 'zh-cn';
    /*  // 编辑器样式，有三种：'kama'（默认）、'office2003'、'v2'
     config.skin = 'v2';*/
    // 工具栏（基础'Basic'、全能'Full'、自定义）plugins/toolbar/plugin.js
    //  config.toolbar = 'Basic';
     config.toolbar = 'Full';
     //工具栏是否可以被收缩
     config.toolbarCanCollapse = true;
     //工具栏的位置
     config.toolbarLocation = 'top';//可选：bottom
     //工具栏默认是否展开
     config.toolbarStartupExpanded = true;

};
