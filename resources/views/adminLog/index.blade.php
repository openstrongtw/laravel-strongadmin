@extends('strongadmin::layouts.app')
@push('styles')
<style></style>
@endpush
@push('scripts')
<script></script>
@endpush
@section('content')
<div class="st-h15"></div>
<form class="layui-form st-form-search" lay-filter="ST-FORM-SEARCH">
    <div class="layui-form-item"><div class="layui-inline">
            <label class="layui-form-label">{{$model->getAttributeLabel('route_url')}}</label>
            <div class="layui-input-inline">
                <input type="text" name="route_url" autocomplete="off" placeholder="" class="layui-input">
            </div>
        </div><div class="layui-inline">
            <label class="layui-form-label">{{$model->getAttributeLabel('desc')}}</label>
            <div class="layui-input-inline">
                <input type="text" name="desc" autocomplete="off" placeholder="" class="layui-input">
            </div>
        </div>
         <div class="layui-inline">
            <label class="layui-form-label">{{$model->getAttributeLabel('admin_user_id')}}</label>
            <div class="layui-input-inline">
                <input type="text" name="admin_user_id" autocomplete="off" placeholder="" class="layui-input">
            </div>
        </div> 
        <div class="layui-inline">
            <label class="layui-form-label">{{$model->getAttributeLabel('created_at')}}</label>
            <div class="layui-input-inline">
                <input type="text" name="created_at_begin" id="date" placeholder="年-月-日" autocomplete="off" class="layui-input">
            </div>
            <div class="layui-input-inline">
                <input type="text" name="created_at_end" id="date2" placeholder="年-月-日" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-inline">
            <a class="layui-btn layui-btn-xs st-search-button">開始搜索</a>
        </div>
    </div>
</form>
<table class="layui-hide" id="ST-TABLE-LIST" lay-filter="ST-TABLE-LIST"></table>
<script type="text/html" id="ST-TOOL-BAR">
    <div class="layui-btn-container st-tool-bar">
        <a class="layui-btn layui-btn-xs" lay-event="batchDelete" data-href="/admin/adminLog/destroy">刪除選中</a>
    </div>
</script>
<script type="text/html" id="ST-OP-BUTTON">
    @verbatim
    <a class="layui-btn layui-btn-xs" onclick="Util.createFormWindow('/strongadmin/adminLog/update?id={{d.id}}', this.innerText);">更新</a>
    <a class="layui-btn layui-btn-danger layui-btn-xs" onclick="Util.destroy('/strongadmin/adminLog/destroy?id={{d.id}}');">刪除</a>
    @endverbatim
</script>
@endsection
@push('scripts_bottom')        
<script>
!function () {
    //日期
    layui.laydate.render({
        elem: '#date'
    });
    layui.laydate.render({
        elem: '#date2'
    });
    //表格欄位
    var cols = [
                {type: 'checkbox'}
                , {field: 'id', title: 'id', width: 80,  unresize: true, totalRowText: '合計', sort: true}
                , {field: 'route_url', title: '{{$model->getAttributeLabel("route_url")}}'}
                , {field: 'desc', title: '{{$model->getAttributeLabel("desc")}}'}
                , {field: 'log_original', title: '{{$model->getAttributeLabel("log_original")}}', templet: function(res){
                        return res.log_original ? JSON.stringify(res.log_original) : '/';
                }}
                , {field: 'log_dirty', title: '{{$model->getAttributeLabel("log_dirty")}}', templet: function(res){
                        return res.log_dirty ? JSON.stringify(res.log_dirty) : '/';
                }}
                , {field: 'created_at', title: '{{$model->getAttributeLabel("created_at")}}'}
                , {field: 'admin_user_id', title: '{{$model->getAttributeLabel("admin_user_id")}}', templet: function (res) {
                                        return  res.admin_user  ? '<em>' + (res.admin_user.name || res.admin_user.user_name) + '</em>' : '--';
                    }}
            ];
    var tableConfig = {
        elem: '#ST-TABLE-LIST'//table 容器唯一 id
        ,searchFormId: 'ST-FORM-SEARCH'//查詢搜索表單id(自定義欄位值)
        ,url: window.location.pathname
        ,cols: [cols]
        ,defaultToolbar:[]
    };
    Util.renderTable(tableConfig);
}();
</script>
@endpush