$().ready(function() {
    validateRule();
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
                        html += "<option value='"+v.id+"' >"+v.verorder+":"+v.banmian+"</option>";
                    });
                }
                $("#verorder").html(html);
            }
        });
    })
});

$.validator.setDefaults({
    submitHandler : function() {
        save();
    }
});
function save() {
    $.ajax({
        cache : true,
        type : "POST",
        url : "/epaper/rect/save",
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
            verorder : {
                required : true
            },
            banmian : {
                required : true
            }
        },
        messages : {
            verorder : {
                required : icon + "所属版面名称不能为空！"
            },
            banmian : {
                required : icon + "版面名称不能为空！"
            }
        }
    })
}
