layui.use(['jquery','element', 'form','table', 'layer','upload','laydate'],function(){
    var $ = layui.$;
    var element = layui.element;
    var form = layui.form;
    var table = layui.table;
    var layer = layui.layer;
    var upload = layui.upload;
    var laydate = layui.laydate;
    // 删除提示
    $('.btn_trash').on('click', function() {
        layer.confirm('真的要删除吗？', {title:'警告'}, function(index){
            layer.msg('删除成功！');
            layer.close(index);
        });
    });
    var nowData = new Date();
    laydate.render({
    elem: '#start_time_id'
    ,type: 'datetime' //类型
    ,value: nowData //默认值
    ,min: '2019-1-19 12:30:00' //最小时间范围
    ,max: '2025-12-31 12:30:00'//最大时间范围
    ,format: 'yyyy-MM-dd HH:mm:ss'//时间日期格式
    ,theme: '#5696f8' //主题颜色 
  });
});