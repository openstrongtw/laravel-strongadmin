var indexLoadingST;
var Util = {};
Util.init = function () {
    this.iframeIndex = parent.layer.getFrameIndex ? parent.layer.getFrameIndex(window.name || null) : null; //獲取父視窗索引
    if (this.iframeIndex) {
        $('form div.st-form-submit-btn').addClass('layui-hide');//隱藏提交按鈕
    }
    //表單提示
    $('form.layui-form i.st-form-tip-help').click(function () {
        var tip = $(this).parent().next().find('input').attr('data-tips');
        var obj = $(this).parent().next().find('.st-form-tip');
        //console.log(obj.length);
        if (obj.length <= 0) {
            obj = $(this).parent().next().append('<div class="layui-word-aux st-form-tip"></div>')
            var obj = $(this).parent().next().find('.st-form-tip');
        }
        obj.text(tip);
        if (obj.hasClass('st-form-tip-error')) {
            obj.removeClass('st-form-tip-error').addClass('layui-show');
            return;
        }
        //obj.toggle();
        if (obj.hasClass('layui-hide')) {
            obj.removeClass('layui-hide').addClass('layui-show');
        } else if (obj.hasClass('layui-show')) {
            obj.removeClass('layui-show').addClass('layui-hide');
        } else {
            obj.addClass('layui-show');
        }
    });
    $.ajaxSetup({
        timeout: 30000,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
                    //, "Content-Type": "application/json;charset=utf-8"
        },
        dataType: 'json'
    });
    //全域性監聽提交
    layui.form.on('submit(ST-SUBMIT)', function (data) {
        //console.log(data)
        Util.postForm('form.layui-form', data.field, true);
        //layer.alert(JSON.stringify(data.field), {
        //    title: '最終的提交資訊'
        //});
        return false;
    });
    //批發設定
    $('.st-wholesale-create').click(function () {
        if ($('.st-form-wholesale tbody tr').length >= 10) {
            layer.msg('最多設定10個', function () {});
            return;
        }
        $('.st-form-wholesale tbody tr:first').clone(true).removeClass('layui-hide').appendTo($('.st-form-wholesale tbody'));
    });
    $('.st-wholesale-remove').click(function () {
        $(this).parent().parent().remove();
    });
};
Util.postForm = function (formId, data, reload = true, contentType = 'application/x-www-form-urlencoded') {
    if (formId instanceof  Object) {
        var formObj = formId;
    } else {
        var formObj = $(formId);
    }
    var url = $(formObj).attr('action');
    if (!url) {
        url = window.location.pathname;
    }
    $.ajaxSetup({
        beforeSend: function () {
            indexLoadingST = layer.load();
        },
        error: function (xhr, status, error) {
            console.log(error);
        },
        complete: function (xhr, status) {
            layer.close(indexLoadingST);
        }
    });
    //注意：parent 是 JS 自帶的全域性對象，可用於操作父頁面
    var iframeIndex = this.iframeIndex; //獲取視窗索引
    $.ajax({
        url: url,
        type: 'post',
        dataType: 'json',
        data: data,
        contentType: contentType,
        success: function (response, status, xhr) {
            console.log(response);
            $(formObj).find(":input").siblings('div.st-form-tip-error').text('');
            if (response.code === 200) {
                layer.msg(response.message, {
                    time: 1500
                });
                setTimeout(function () {
                    if (iframeIndex) {
                        parent.layer.close(iframeIndex);
                    }
                    if (reload) {
                        if (iframeIndex) {
                            //parent.window.location.reload();
                            parent.layui.table.reload("ST-TABLE-LIST");
                        } else {
                            window.location.reload();
                        }
                        return;
                    }
                    if (response.toUrl) {
                        window.location.href = response.toUrl;
                        return;
                    }
                }, 1600);

                return;
            }
            layer.msg(response.message, {
                //offset: 'b',
                anim: 6
            });
            let errors = response.data || [];
            for (let errorKey of Object.keys(errors)) {
                let errorVal = errors[errorKey][0];
                console.log(errorKey, errorVal);
//            var obj = $(formObj).find(":input[name=" + errorKey + "]").siblings('div.st-form-tip');
//            if (obj.length <= 0) {
//                $(formObj).find(":input[name=" + errorKey + "]").parent().append('<div class="layui-word-aux st-form-tip"></div>');
//            }
                var pos = errorKey.indexOf('.');
                console.log(pos);
                if (pos >= 0) {
                    errorKey = errorKey.substr(0, pos);
                }
                $(formObj).find(":input[name=" + errorKey + "]").siblings('div.st-form-tip').addClass('st-form-tip-error').text(errorVal).show();
                $(formObj).find("div[data-field=" + errorKey + "]").find('div.st-form-tip').addClass('st-form-tip-error').text(errorVal).show();
            }
            return false;
        }
    });
};
/**
 * 渲染錯誤資訊
 * @param {type} formObj 表單對像
 * @param {type} response 錯誤訊息對像
 * @returns {undefined}
 */
Util.showErrors = function (formObj, response) {
    layer.msg(response.message, {
        //offset: 'b',
        anim: 6
    });
    let errors = response.data || [];
    for (let errorKey of Object.keys(errors)) {
        let errorVal = errors[errorKey][0];
        console.log(errorKey, errorVal);
        var pos = errorKey.indexOf('.');
        console.log(pos);
        if (pos >= 0) {
            errorKey = errorKey.substr(0, pos);
        }
        $(formObj).find(":input[name=" + errorKey + "]").siblings('div.st-form-tip').addClass('st-form-tip-error').text(errorVal).show();
        $(formObj).find("div[data-field=" + errorKey + "]").find('div.st-form-tip').addClass('st-form-tip-error').text(errorVal).show();
    }
};
Util.destroy = function (url, data = {}, reload = true) {
    $.ajaxSetup({
        beforeSend: function () {
            indexLoadingST = layer.load();
        },
        error: function (xhr, status, error) {
            console.log(error);
        },
        complete: function (xhr, status) {
            layer.close(indexLoadingST);
        }
    });
    layer.confirm('確定刪除? 刪除后無法恢復', {icon: 3, title: '提示'}, function (index) {
        //do something
        $.post(url, data).then(response => {
            console.log(response);
            if (response.code === 200) {
                layer.msg(response.message, {
                    time: 1500
                });
                setTimeout(function () {
                    if (reload) {
                        window.location.reload();
                        return;
                    }
                    if (response.toUrl) {
                        window.location.href = response.toUrl;
                        return;
                    }
                }, 1600);
                return;
            }
            layer.msg(response.message, {
                //offset: 'b',
                anim: 6
            });
            return false;
        })
                .catch(function (error) {
                    console.log(error);
                });
        layer.close(index);
    });

};
Util.batchDelete = function (url, datas, field = 'id') {
    var arr = $.map(datas, function (n, i) {
        console.log(n);
        return n[field];
    });
    this.destroy(url, {id: arr});
};
Util.exportFile = function (tableIns, whereData) {
    console.log(tableIns);
    whereData.export = 1;
    $.ajaxSetup({
        beforeSend: function () {
            indexLoadingST = layer.msg('正在導出', {
                icon: 16
                , shade: 0.01
            });
        },
        error: function (xhr, status, error) {
            console.log(error);
        },
        complete: function (xhr, status) {
            layer.close(indexLoadingST);
        }
    });
    $.get(tableIns.config.url, whereData, function (res) {
        //導出任意數據
        layui.table.exportFile(tableIns.config.id, res.data); //data 為該實例中的任意數量的數據
        layer.msg('導出成功');
    })
};
/**
 * 建立表單視窗
 * @param {type} url 提交url
 * @param {type} title 視窗標題
 * @param {type} area 視窗寬高
 * @param {type} narrowTitle 是否縮低視窗標題高度
 * @param {type} btn 操作按鈕文案
 * @returns {undefined}
 */
Util.createFormWindow = function (url, title = '資訊', area = ['45%', '60%'], narrowTitle = false, btn = ['儲存', '取消']) {
    var titleStyle = '';
    if (narrowTitle) {
        titleStyle = 'height:25px;line-height:25px;font-size:14px;';
        $('span.layui-layer-setwin').css('top', '7px');
    }
    layer.open({
        type: 2,
        content: url,
        title: [title, titleStyle],
        //area: 'auto',
        area: area,
        fixed: false, //不固定
        maxmin: true,
        resize: true
        , btn: btn
        , yes: function (index, layero) {
            //按鈕【按鈕一】的回撥
            /*
             var childIframeFormObj = layer.getChildFrame('form#ST-FORM', index);
             var childIframeframeWin = window[layero.find('iframe')[0]['name']];
             data = childIframeframeWin.layui.form.val('ST-FORM');
             Util.postForm(childIframeFormObj, data, true);
             */

            layer.getChildFrame('form.layui-form :submit', index).click();

            return false;//開啟該程式碼可禁止點選該按鈕關閉
        }
        , btn2: function (index, layero) {
            //按鈕【按鈕二】的回撥
            //return false;
        }
        , cancel: function () {
            //右上角關閉回撥
        }
    });
    if (narrowTitle) {
        $('span.layui-layer-setwin').css('top', '7px');
    }
    ;
};
/**
 * 建立檢視視窗
 * @param {type} url 提交url
 * @param {type} title 視窗標題
 * @param {type} area 視窗寬高
 * @param {type} narrowTitle 是否縮低視窗標題高度
 * @returns {undefined}
 */
Util.createWindow = function (url, title = '資訊', area = ['100%', '100%'], narrowTitle = false) {
    var titleStyle = '';
    if (narrowTitle) {
        titleStyle = 'height:25px;line-height:25px;font-size:14px;';
        $('span.layui-layer-setwin').css('top', '7px');
    }
    layer.open({
        type: 2,
        content: url,
        title: [title, titleStyle],
        //area: 'auto',
        area: area,
        fixed: true, //層是否固定在可視區域
        maxmin: true,
        resize: false,
        maxmin: false
    });
    if (narrowTitle) {
        $('span.layui-layer-setwin').css('top', '7px');
    }
    ;
};
Util.treeTable = function (id) {
    var _this = this;
    $(id + ' .st-tree-table').click(function () {
        var parentObj = $(this).parent().parent();
        var parentOpen = $(parentObj).attr('data-open');
        if (parentOpen == -1) {
            return;
        }
        if (parentOpen == 0) {
            _this.openTreeTable(parentObj, true);
        } else {
            _this.closeTreeTable(parentObj);
        }
    });
    var down = this.getUrlParam('down');
    if (down == 1) {
        $(id + " tbody tr").removeClass('layui-hide').find('.st-tree-table').children('i.layui-icon-add-circle').removeClass('layui-icon-add-circle').addClass('layui-icon-reduce-circle').parent().parent().parent().attr('data-open', 1);
    }
};
Util.openTreeTable = function (parentObj, isFirstLevel) {
    var _this = this;
    if (!isFirstLevel) {
        var parentOpen = $(parentObj).attr('data-open');
        parentOpen = $.trim(parentOpen);
        if (parentOpen == -1) {
            return;
        }
        if (parentOpen == 0) {
            return;
        }
    }
    var parenLevel = $(parentObj).attr('data-level');
    var parentIndent = $(parentObj).attr('data-indent');
    var childIndent = parseInt(parentIndent) + 1;
    var parentIconObj = $(parentObj).find('.st-tree-table').children('i');
    $(parentObj).attr('data-open', 1);
    $(parentIconObj).removeClass('layui-icon-add-circle').addClass('layui-icon-reduce-circle');
    var parentSiblingsElements = $(parentObj).siblings("[data-level^='" + parenLevel + "'][data-indent='" + childIndent + "']");
    $(parentSiblingsElements).removeClass('layui-hide');
    parentSiblingsElements.each(function () {
        _this.openTreeTable(this, false);
    });
};
Util.closeTreeTable = function (parentObj) {
    var parenLevel = $(parentObj).attr('data-level');
    var parentIconObj = $(parentObj).find('.st-tree-table').children('i');
    $(parentObj).attr('data-open', 0);
    $(parentIconObj).removeClass('layui-icon-reduce-circle').addClass('layui-icon-add-circle');
    var parentSiblingsElements = $(parentObj).siblings("[data-level^='" + parenLevel + "']");
    $(parentSiblingsElements).addClass('layui-hide');
};
Util.sortImage = function (id) {
    var _this = this;
    $(id).sortable({
        start: function () {
        },
        drag: function () {
        },
        stop: function () {
            //layer.msg('sortImage');
            //_this.sortImageCover(id);
        }
    }).disableSelection();
    $(id + " i.layui-icon-delete").click(function () {
        $(this).parentsUntil('table').parent().parent().fadeOut(function () {
            $(this).remove();
            _this.sortImageCover(id);
        });
    });
};
Util.sortImageCover = function (id) {
    $(id + ">li:eq(1)").find('input[name=isImgCover],input[name=isImgSpec]').attr('checked', 'true');
};
Util.getUrlParam = function (name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)"); //構造一個含有目標參數的正規表示式對像
    var r = window.location.search.substr(1).match(reg);  //匹配目標參數
    if (r) {
        return unescape(r[2]);
    }
    return null; //返回參數值
};
/**
 * 建立下拉框
 * @param {type} datas 渲染的數據
 * @param {type} selected 選中的數據
 * @param {type} map 
 * @param {type} name
 * @returns {undefined}
 */
Util.htmlSelect = function (id, rows, selected, map = ["id", "name"]) {
    var url = rows;
    $.get(url).then(response => {
        console.log(response);
        if (response.code !== 200) {
            return;
        }
        let htmlStr = '';
        let datas = response.data || [];
        for (let dataKey of Object.keys(datas)) {
            let value = datas[dataKey][map[0]];
            let name = datas[dataKey][map[1]];
            htmlStr += '<option value="' + value + '">' + name + '</option>';
        }
        console.log(htmlStr);
        $(id).append(htmlStr);
        return false;
    })
            .catch(function (error) {
                console.log(error);
            });

};
/*
 * 數據表格列表 預設配置
 * @type type
 */
Util.tableConfigDefault = {
    elem: '#ST-TABLE-LIST'//table 容器唯一 id
    , searchFormId: 'ST-FORM-SEARCH'//查詢搜索表單id(自定義欄位值)
    , url: window.location.pathname//請求url，預設目前url
    , title: '數據列表'
    , escape: true //是否開啟 xss 字元過濾
    , autoSort: false //禁止前端自動排序
    , totalRow: false //統計
    , toolbar: '#ST-TOOL-BAR' // 工具欄
    , defaultToolbar: [
        'filter', //欄位過濾
        'print', //列印
        'exports', //導出
        //自定義按鈕
        {
            title: '導出(目前搜索條件下全部數據)' //標題
            , layEvent: 'ST-EXPORT-EXCEL' //事件名，用於 toolbar 事件中使用
            , icon: 'layui-icon-export' //圖示類名
        }]
    , initSort: {
        field: 'id' //排序欄位，對應 cols 設定的各欄位名
        , type: 'desc' //排序方式  asc: 升序、desc: 降序、null: 預設排序
    }
    , page: true
    , height: 'full-100'//高度最大適應化
    , parseData: function (res) { //res 即為原始返回的數據
        return {
            code: res.code == 200 ? 0 : res.code, //解析介面狀態
            msg: res.message, //解析提示文字
            count: res.data.total, //解析數據長度
            data: res.data.data //解析數據列表
        };
    }
    , done: function (res, curr, count) {//數據渲染完的回撥
        //如果是非同步請求數據方式，res即為你介面返回的資訊。
        //如果是直接賦值的方式，res即為：{data: [], count: 99} data為目前頁數據、count為數據總長度
        console.log(res);
        //得到目前頁碼
        console.log(curr);
        //得到數據總量
        console.log(count);
        //圖片放大
        $(".st-img-zoom").click(function () {
            var src = $(this).attr('src');
            var html = "<img src='" + src + "' style='max-width:500px;height:auto;' />";
            layer.open({
                type: 1,
                title: false,
                closeBtn: 1,
                area: ['auto'],
                area: ['500px', '500px'],
                skin: 'layui-layer-nobg', //沒有背景色
                shadeClose: true,
                content: html
            });
        });
    }
    , cols: []
    , size: "sm"
};
//渲染數據表格列表
Util.renderTable = function (tableConfig) {
    var tableIns = layui.table.render(Object.assign(this.tableConfigDefault, tableConfig));
    //console.log(tableIns);
    var tableId = tableIns.config.id;
    var searchFormId = tableIns.config.searchFormId;
    //條件搜索
    layui.$('form[lay-filter="ST-FORM-SEARCH"] .st-search-button').on('click', function () {
        var data = layui.form.val(searchFormId);
        console.log(data);
        tableIns.reload({
            where: data
            , page: {
                curr: 1 //重新從第 1 頁開始
            }
        }, true);
    });
    //監聽排序事件 
    layui.table.on('sort(' + tableId + ')', function (obj) { //註：sort 是工具條事件名，test 是 table 原始容器的屬性 lay-filter="對應的值"
        tableIns.reload({
            initSort: obj //記錄初始排序，如果不設的話，將無法標記表頭的排序狀態。
            , where: {//請求參數（注意：這裡面的參數可任意定義，並非下面固定的格式）
                field: obj.field //排序欄位
                , order: obj.type //排序方式
            }
            , page: {
                curr: 1 //重新從第 1 頁開始
            }
        }, true);
        //layer.msg('服務端排序。order by ' + obj.field + ' ' + obj.type);
    });
    //工具欄事件
    layui.table.on('toolbar(' + tableId + ')', function (obj) {
        var checkStatus = layui.table.checkStatus(obj.config.id);
        switch (obj.event) {
            case 'batchDelete':
                Util.batchDelete($(this).attr('data-href'), checkStatus.data);
                break;
            case 'ST-EXPORT-EXCEL':
                var data = layui.form.val(searchFormId);
                Util.exportFile(tableIns, data);
                break;
        }
        return;
    });
    return tableIns;
};
/**
 * 獲取批發設定的數據
 * @returns {Util.getWholesaleSet.utilAnonym$20|Boolean}
 */
Util.pluckWholesaleSet = function () {
    var wholesale_num = [], wholesale_price = [];
    $("input[name='wholesale_num']").each(function (i) {
        if (i == 0) {
            return;
        }
        i--;
        wholesale_num[i] = $(this).val();
    });
    $("input[name='wholesale_price']").each(function (i) {
        if (i == 0) {
            return;
        }
        i--;
        wholesale_price[i] = $(this).val();
    });
    return {
        num: wholesale_num,
        price: wholesale_price
    };
};
/**
 * 獲取產品圖片數據
 * @returns {Array}
 */
Util.pluckImgPhotos = function () {
    var img_photos = [];
    $(".st-sortable-image li").each(function (i) {
        if (i === 0) {
            return;
        }
        i--;
        img_photos[i] = {
            src: $(this).find('img').attr("src"),
            title: $(this).find('img').attr("data-title"),
            isImgCover: $(this).find('input[name=isImgCover]').is(":checked"),
            isImgSpec: $(this).find('input[name=isImgSpec]').is(":checked")
        };
    });
    return img_photos;
};
/**
 * 獲取產品規格數據
 * @returns {Util.getSpecs.utilAnonym$22|Boolean}
 */
Util.pluckSpecs = function () {
    var specs = [];
    var n = 0;
    $(":input[name='productSpec']").each(function (i) {
        var spec_id = $(this).attr('data-specId');
        var spec_type = $(this).attr('data-specType');
        var spec_value = $(this).val();
        specs[n] = {
            spec_id: spec_id,
            spec_type: spec_type,
            spec_value: spec_value
        };
        n++;
    });
    return specs;
};
/**
 * 產品規格 html部分
 * @param {type} url
 * @param {type} specGroupId
 * @param {type} productId
 * @returns {undefined}
 */
Util.getSpecs = function (url, specGroupId = "", productId = "") {
    url += '?specGroupId=' + specGroupId;
    url += '&productId=' + productId;
    $.get(url, function (res) {
        $("#productSpecsList").html(res.data);
        /*
         * 動態更新渲染
         * 具體參考 https://www.layui.com/doc/modules/form.html#render
         */
        layui.form.render('select');//更新渲染
    });
};

//*** BEGIN 此初始化方法`Util.init()`必須放在末尾執行
Util.init();
//*** END `Util.init()`
