@extends('strongadmin::layouts.app')

@push('styles')
<style></style>
@endpush

@push('scripts')
<script></script>
@endpush

@section('content')
<div class="st-h15"></div>
<form class="layui-form" action="" lay-filter="ST-FORM" id="ST-FORM">
    <input type="hidden" name="id" value="{{$model->id}}">
    <div id="ST-TREE"></div>
    <div class="layui-form-item st-form-submit-btn">
        <div class="layui-input-block">
            <button type="submit" class="layui-btn" lay-submit="" lay-filter="ST-SUBMIT">立即提交</button>
        </div>
    </div>
</form>
@endsection

@push('scripts_bottom')
<script>
    !function () {
        //模擬數據
        var data = {!!$menus!!}
        ;
        //基本演示
        layui.tree.render({
            elem: '#ST-TREE'
            , data: data
            , showCheckbox: true  //是否顯示覆選框
            , id: 'ST-TREE'
                    //, isJump: true //是否允許點選節點時彈出新視窗跳轉
            , click: function (obj) {
                //var data = obj.data;  //獲取目前點選的節點數據
                //layer.msg('狀態：' + obj.state + '<br>節點數據：' + JSON.stringify(data));
            }
        });
        //監聽提交
        layui.form.on('submit(ST-SUBMIT)', function (data) {
            var checkedData = layui.tree.getChecked('ST-TREE'); //獲取選中節點的數據
            data.field.checkedData = checkedData;
            Util.postForm('#ST-FORM', data.field, false);
            return false;
        });
    }();
</script>
@endpush
