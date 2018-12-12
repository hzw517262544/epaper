
var prefix = "/epaper/paper"
$(function() {
    load();
});

function load() {
    $('#exampleTable')
        .bootstrapTable(
            {
                method : 'get', // 服务器数据的请求方式 get or post
                url : prefix + "/list", // 服务器数据的加载地址
                //	showRefresh : true,
                //	showToggle : true,
                //	showColumns : true,
                iconSize : 'outline',
                toolbar : '#exampleToolbar',
                striped : true, // 设置为true会有隔行变色效果
                dataType : "json", // 服务器返回的数据类型
                pagination : true, // 设置为true会在底部显示分页条
                // queryParamsType : "limit",
                // //设置为limit则会发送符合RESTFull格式的参数
                singleSelect : false, // 设置为true将禁止多选
                // contentType : "application/x-www-form-urlencoded",
                // //发送到服务器的数据编码类型
                pageSize : 10, // 如果设置了分页，每页数据条数
                pageNumber : 1, // 如果设置了分布，首页页码
                //search : true, // 是否显示搜索框
                showColumns : false, // 是否显示内容下拉框（选择显示的列）
                sidePagination : "server", // 设置在哪里进行分页，可选值为"client" 或者 "server"
                queryParams : function(params) {
                    return {
                        //说明：传入后台的参数包括offset开始索引，limit步长，sort排序列，order：desc或者,以及所有列的键值对
                        limit: params.limit,
                        offset:params.offset
                        // name:$('#searchName').val(),
                        // username:$('#searchName').val()
                    };
                },
                // //请求服务器数据时，你可以通过重写参数的方式添加一些额外的参数，例如 toolbar 中的参数 如果
                // queryParamsType = 'limit' ,返回参数必须包含
                // limit, offset, search, sort, order 否则, 需要包含:
                // pageSize, pageNumber, searchText, sortName,
                // sortOrder.
                // 返回false将会终止请求
                columns : [
                    {
                        field: 'no',
                        title: '序号',
                        sortable: true,
                        align: "center",
                        width: 40,
                        formatter: function (value, row, index) {
                            //获取每页显示的数量
                            var pageSize=$('#exampleTable').bootstrapTable('getOptions').pageSize;
                            //获取当前是第几页
                            var pageNumber=$('#exampleTable').bootstrapTable('getOptions').pageNumber;
                            //返回序号，注意index是从0开始的，所以要加上1
                            return pageSize * (pageNumber - 1) + index + 1;
                        }
                    },{
                        checkbox : true
                    },
                    {
                        field : 'publishid',
                        title : 'publishid',
                        align:'center',
                        width:50,
                        visible:false
                    },
                    {
                        field : 'publishdate',
                        title : '发行期刊',
                        width:500,
                        align:'center',
                        formatter:function(value, row, index){
                            return value+"&nbsp;(第"+row.publishid+"期)";
                        }
                    },
                    {
                        title : '操作选项',
                        field : 'id',
                        align : 'center',
                        formatter : function(value, row, index) {
                            var e = '<a  href="#" title="添加所属期刊版面" onclick="edit(\''
                                + row.id
                                + '\')">添加所属期刊版面</a> ';
                            var d = '<a  href="#" title="修改" onclick="remove(\''
                                + row.id
                                + '\')">修改</a> ';
                            var f = '<a  href="#" title="删除" onclick="resetPwd(\''
                                + row.id
                                + '\')">删除</a> ';
                            var g = '<a  href="#" title="生成Html" onclick="resetPwd(\''
                                + row.id
                                + '\')">生成Html</a> ';
                            return e+"|"+d+"|"+f+"|"+g;
                        }
                    } ],
                detailView: true,  //是否显示父子表
                onExpandRow: function(index, row, $detail) {
                    //这一步就是相当于在当前点击列下新创建一个table
                    var cur_table = $detail.html('<table></table>').find('table');
                    var html = "";
                    html += "<table class='table'>";
                    $.ajax({
                        type: "get",
                        url: "/epaper/rect/listByPublishId",       //子表请求的地址
                        data: {publishid:row.publishid},//我这里是点击父表后，传递父表列id和nama到后台查询子表数据
                        async: false,           //很重要，这里要使用同步请求
                        success: function(data) {
                            //遍历子表数据
                            $.each(data,
                                function(n, value) {
                                    var e = '<a  href="#" title="添加/修改热图" onclick="edit(\''
                                        + row.id
                                        + '\')">添加/修改热图</a> ';
                                    var d = '<a  href="#" title="预览" onclick="remove(\''
                                        + row.id
                                        + '\')">预览</a> ';
                                    var f = '<a  href="#" title="删除" onclick="resetPwd(\''
                                        + row.id
                                        + '\')">删除</a> ';
                                    var g = '<a  href="#" title="生成Html" onclick="resetPwd(\''
                                        + row.id
                                        + '\')">生成Html</a> ';

                                    html += "<tr  align='center'>"
                                        + "<td width='620'>" + value.verorder+":"+value.banmian + "</td>"
                                        + "<td>" + e+"|"+d+"|"+f+"|"+g + "</td>"
                                        + "</tr>";
                                });
                            html += '</table>';
                            $detail.html(html); // 关键地方
                        }
                    });
                }
            });
}
function reLoad() {
    $('#exampleTable').bootstrapTable('refresh');
}
function add() {
    layer.open({
        type : 2,
        title : '期数添加',
        maxmin : true,
        shadeClose : false, // 点击遮罩关闭层
        area : [ '800px', '500px' ],
        content : prefix + '/add' // iframe的url
    });
}
function edit(id) {
    layer.open({
        type : 2,
        title : '编辑',
        maxmin : true,
        shadeClose : false, // 点击遮罩关闭层
        area : [ '800px', '520px' ],
        content : prefix + '/edit/' + id // iframe的url
    });
}
function remove(id) {
    layer.confirm('确定要删除选中的记录？', {
        btn : [ '确定', '取消' ]
    }, function() {
        $.ajax({
            url : prefix+"/remove",
            type : "post",
            data : {
                'id' : id
            },
            success : function(r) {
                if (r.code==0) {
                    layer.msg(r.msg);
                    reLoad();
                }else{
                    layer.msg(r.msg);
                }
            }
        });
    })
}

function resetPwd(id) {
}
function batchRemove() {
    var rows = $('#exampleTable').bootstrapTable('getSelections'); // 返回所有选择的行，当没有选择的记录时，返回一个空数组
    if (rows.length == 0) {
        layer.msg("请选择要删除的数据");
        return;
    }
    layer.confirm("确认要删除选中的'" + rows.length + "'条数据吗?", {
        btn : [ '确定', '取消' ]
        // 按钮
    }, function() {
        var ids = new Array();
        // 遍历所有选择的行数据，取每条数据对应的ID
        $.each(rows, function(i, row) {
            ids[i] = row['id'];
        });
        $.ajax({
            type : 'POST',
            data : {
                "ids" : ids
            },
            url : prefix + '/batchRemove',
            success : function(r) {
                if (r.code == 0) {
                    layer.msg(r.msg);
                    reLoad();
                } else {
                    layer.msg(r.msg);
                }
            }
        });
    }, function() {

    });
}