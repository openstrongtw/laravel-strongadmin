@extends('strongadmin::layouts.app')

@push('styles')
<style>
    body{
        background:#eee;
    }
    .layadmin-backlog .layadmin-backlog-body {
        display: block;
        padding: 10px 15px;
        background-color: #f8f8f8;
        color: #999;
        border-radius: 2px;
        transition: all .3s;
        -webkit-transition: all .3s;
    }
    .layadmin-backlog-body h3 {
        padding-bottom: 10px;
        font-size: 12px;
    }
    .layadmin-backlog-body p cite {
        font-style: normal;
        font-size: 30px;
        font-weight: 300;
        color: #009688;
    }
</style>
@endpush

@push('scripts')
<script></script>
@endpush

@section('content')
<div class="st-h20"></div>
<div class="layui-fluid">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md4">
            <div class="layui-card">
                <div class="layui-card-header">提醒事項</div>
                <div class="layui-card-body">
                    <div class="layui-carousel layadmin-carousel layadmin-backlog" lay-anim="" lay-indicator="inside" lay-arrow="none" style="width: 100%; height: 180px;">
                        <div carousel-item="">
                            <ul class="layui-row layui-col-space10 layui-this">
                                <li class="layui-col-xs4">
                                    <a href="/admin/order/index?order_status=12" class="layadmin-backlog-body" target="mainBody">
                                        <h3>待發貨</h3>
                                        <p><cite>323</cite></p>
                                    </a>
                                </li>
                                <li class="layui-col-xs4">
                                    <a href="/admin/order/index?order_status=10" class="layadmin-backlog-body" target="mainBody">
                                        <h3>待付款</h3>
                                        <p><cite>42</cite></p>
                                    </a>
                                </li>
                                <li class="layui-col-xs4">
                                    <a href="/admin/order/index" class="layadmin-backlog-body" target="mainBody">
                                        <h3>今日&昨日 訂單</h3>
                                        <p><cite>222</cite></p>
                                    </a>
                                </li>
                                <li class="layui-col-xs4">
                                    <a href="/admin/user/feedback/index?status=1" class="layadmin-backlog-body" target="mainBody">
                                        <h3>待回覆反饋</h3>
                                        <p><cite>88</cite></p>
                                    </a>
                                </li>
                                <li class="layui-col-xs4">
                                    <a href="/admin/product/index" class="layadmin-backlog-body" target="mainBody">
                                        <h3>庫存警告</h3>
                                        <p><cite>7</cite></p>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection

    @push('scripts_bottom')

    @endpush
