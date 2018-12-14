$().ready(function() {
    $('.summernote').summernote({
        height : '300px',
        lang : 'zh-CN',
        callbacks: {
            onImageUpload: function(files, editor, $editable) {
                sendFile(files);
            }
        }
    });

    $('#publishdate').change(function(){
        var publishdate=$(this).children('option:selected').val();//这就是selected的值
        $.ajax({
            cache : true,
            type : "get",
            url : "/epaper/rect/list",
            data : {
                "publishdate":publishdate
            },// 你的formid
            async : false,
            error : function(request) {
                parent.layer.alert("Connection error");
            },
            success : function(data) {
                var html = "";
                if(data.total>0){
                    var rows = data.rows;
                    $.each(rows,function(k,v){
                        html += "<option value='"+v.id+"' >"+v.verorder+"</option>";
                    });
                }
                $("#verorderid").html(html);
            }
        });
    })
    validateRule();
});

$.validator.setDefaults({
    submitHandler : function() {
        save();
    }
});
function save() {
    var content_sn = $("#content_sn").summernote('code');
    $("#content").val(content_sn);
    $("#verorder").val($("#verorderid").children('option:selected').text());
    $.ajax({
        cache : true,
        type : "POST",
        url : "/epaper/news/save",
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
            title : {
                required : true
            },
            publishdate : {
                required : true
            },
            verorder : {
                required : true
            },
            user : {
                required : true
            },
            come : {
                required : true
            }
        },
        messages : {
            title : {
                required : icon + "新闻标题不能为空！"
            },
            publishdate : {
                required : icon + "所属版面不能为空！"
            },
            verorder : {
                required : icon + "所属版面不能为空！"
            },
            user : {
                required : icon + "新闻作者不能为空！"
            },
            come : {
                required : icon + "新闻来源不能为空！"
            }
        }
    })
}

function resetForm() {
    $('#signupForm')[0].reset;
    $("#content_sn").summernote('reset');
}
