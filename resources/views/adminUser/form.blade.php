@extends('strongadmin::layouts.app')

@push('styles')
<style></style>
@endpush

@push('scripts')
<script></script>
@endpush

@section('content')
<div class="st-h15"></div>
<form class="layui-form" action="">
    <input name="id" type="hidden" value="{{$model->id}}" />
    <div class="layui-row">
        <div class="layui-col-xs12">
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label st-form-input-required">{{$model->getAttributeLabel('user_name')}}</label>
                    <div class="layui-input-inline">
                        <input type="text" name="user_name" value="{{$model->user_name}}" autocomplete="off" placeholder="" class="layui-input">
                        <div class="layui-word-aux st-form-tip"></div>
                    </div>
                    <label class="layui-form-label">{{$model->getAttributeLabel('name')}}</label>
                    <div class="layui-input-inline">
                        <input type="text" name="name" value="{{$model->name}}" autocomplete="off" placeholder="" class="layui-input">
                        <div class="layui-word-aux st-form-tip"></div>
                    </div>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">{{$model->getAttributeLabel('email')}}</label>
                <div class="layui-input-inline">
                    <input type="text" name="email" value="{{$model->email}}" autocomplete="off" placeholder="" class="layui-input">
                    <div class="layui-word-aux st-form-tip"></div>
                </div>
                <label class="layui-form-label">{{$model->getAttributeLabel('phone')}}</label>
                <div class="layui-input-inline">
                    <input type="text" name="phone" value="{{$model->phone}}" autocomplete="off" placeholder="" class="layui-input">
                    <div class="layui-word-aux st-form-tip"></div>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"><i class="layui-icon layui-icon-help st-form-tip-help"></i>{{$model->getAttributeLabel('password')}}</label>
                <div class="layui-input-inline">
                    <input type="text" name="password" value="" autocomplete="off" placeholder="" class="layui-input">
                    <div class="layui-word-aux st-form-tip">不填寫則密碼保持不變，填寫后則會重置密碼</div>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">{{$model->getAttributeLabel('introduction')}}</label>
                <div class="layui-input-inline">
                    <textarea name="introduction" autocomplete="off" placeholder="" class="layui-textarea">{{$model->introduction}}</textarea>
                    <div class="layui-word-aux st-form-tip"></div>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label st-form-input-required">{{$model->getAttributeLabel('status')}}</label>
                <div class="layui-input-block">
                    <input type="radio" name="status" value="1" title="開啟" @if($model->status==1)checked @endif>
                    <input type="radio" name="status" value="2" title="禁用" @if($model->status==2)checked @endif>
                    <div class="layui-word-aux st-form-tip"></div>
                </div>
            </div>
            <hr class="layui-bg-gray"/>

            <div class="layui-form-item">
                <label class="layui-form-label st-form-input-required">{{$model->getAttributeLabel('role_id')}}</label>
                <div class="layui-input-block">
                    @foreach ($roles as $role)
                    <input type="checkbox" value="{{$role->id}}" name="role_id[]" lay-skin="primary" title="{{$role->name}}" @if($model->roles->pluck('id')->search($role->id) !== false) checked @endif>
                    @endforeach
                    <div class="layui-word-aux st-form-tip"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="layui-form-item st-form-submit-btn">
        <div class="layui-input-block">
            <button type="submit" class="layui-btn" lay-submit="" lay-filter="ST-SUBMIT">立即提交</button>
            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
        </div>
    </div>
</form>
@endsection

@push('scripts_bottom')
<script>
    !function () {
        layui.form.on('submit(ST-SUBMIT)', function (data) {
            //console.log(data)
            //layer.alert(JSON.stringify(data.field), {
            //    title: '最終的提交資訊'
            //});

            var formObj = 'form.layui-form';//表單
            var data = data.field;//表單數據對像
            var url = $(formObj).attr('action');//表單提交url
            if (!url) {
                url = window.location.pathname;
            }
            //注意：parent 是 JS 自帶的全域性對象，可用於操作父頁面
            var iframeIndex = Util.iframeIndex; //獲取視窗索引
            $.ajax({
                url: url,
                type: 'post',
                dataType: 'json',
                data: data,
                contentType: 'application/x-www-form-urlencoded',
                success: function (response, status, xhr) {
                    console.log(response);
                    $(formObj).find(":input").siblings('div.st-form-tip-error').text('');
                    if (response.code !== 200) {
                        //顯示錯誤
                        Util.showErrors(formObj, response);
                        return;
                    }
                    //success
                    layer.msg(response.message, {
                        time: 1500
                    });
                    setTimeout(function () {
                        if (iframeIndex) {
                            parent.layer.close(iframeIndex);//關閉父視窗
                            //parent.window.location.reload();//過載父頁面
                            parent.layui.table.reload("ST-TABLE-LIST");//過載layui表格列表
                            return;
                        }
                        if (response.toUrl) {
                            window.location.href = response.toUrl;
                            return;
                        }
                        window.location.reload();//過載頁面
                    }, 1600);
                    return;
                }
            });

            return false;
        });
    }();
</script>
@endpush
