$().ready(function() {
	validateRule();
	//初始化热点图片
    CKEDITOR.replace( 'rectEditor');
    CKEDITOR.instances.rectEditor.setData($("#rect").val());
    //选择文件触发事件
    $("#pdfFiles").change(function () {
        upLoadPdfFile();
    });
});

$.validator.setDefaults({
	submitHandler : function() {
		update();
	}
});
function update() {
	$("#rect").val(CKEDITOR.instances.rectEditor.getData());
	$.ajax({
		cache : true,
		type : "POST",
		url : "/epaper/rect/update",
		data : $('#signupForm').serialize(),// 你的formid
		async : false,
		error : function(request) {
			parent.layer.alert("Connection error");
		},
		success : function(data) {
			if (data.code == 0) {
				parent.layer.msg("操作成功");
				parent.reLoad();
				var index = parent.layer.getFrameIndex(window.name); // 获取窗口索引
				parent.layer.close(index);

			} else {
				parent.layer.alert(data.msg)
			}

		}
	});

}
function validateRule() {
	var icon = "<i class='fa fa-times-circle'></i> ";
	$("#signupForm").validate({
		rules : {
			name : {
				required : true
			}
		},
		messages : {
			name : {
				required : icon + "请输入名字"
			}
		}
	})
}

function upLoadPdfFile() {
    var file = document.getElementById('pdfFiles').files[0];
    var size = file.size;
    if((size / 1024 / 1024) > 10) {
        alert("文件大小不能超过10M...");
        return false;
    }
    console.log("size="+size);
    var formData = new FormData();
    formData.append("file", file);
    $.ajax({
        data : formData,
        type : "POST",
        url : "/common/sysFile/upload",    // 图片上传出来的url，返回的是图片上传后的路径，http格式
        cache : false,
        contentType : false,
        processData : false,
        dataType : "json",
        success: function(data) {//data是返回的hash,key之类的值，key是定义的文件名
            layer.msg("上传成功！");
            $("#pdffile").val(data.fileName);
        },
        error:function(){
            alert("上传失败！");
        }
    });
}