<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">

    <meta name="description" content="爱约游">
    <title>爱约游</title>
    <!-- head 中 -->
    <link rel="stylesheet" href="/Public/static/jqurey-weui/lib/weui.min.css">
    <link rel="stylesheet" href="/Public/static/jqurey-weui/css/jquery-weui.min.css">
    <!-- body 最后 -->
    <link rel="stylesheet" href="/Public/static//layui/css/layui.css">
</head>
<body>

<div class="weui-panel weui-panel_access">
    <div class="weui-panel__hd">报名说明</div>
    <div class="weui-cell">
        <div class="weui-cell__ft">
            <p>请如实填写您的真实信息，特别是照片</p>
        </div>
    </div>
    <div class="weui-cells">
        <a class="weui-cell weui-cell_access" href="javascript:;">
            <div class="weui-cell__hd"><img style="height: 18px;width: 18px" src="/Public/static/Image/yuehui.jpg"></div>
            <div class="weui-cell__bd">
                <p>地址：加州协信中心</p>
            </div>
            <div class="weui-cell__ft">
            </div>
        </a>
        <a class="weui-cell weui-cell_access" href="javascript:;">
            <div class="weui-cell__hd"><img style="height: 18px;width: 18px" src="/Public/static/Image/yuehui.jpg"></div>
            <div class="weui-cell__bd">
                <p>报名电话</p>
            </div>
            <div class="weui-cell__ft">
            </div>
        </a>
    </div>
</div>
<form class="layui-form" id="myForm" action="/index.php/Home/Index/index" method="post" enctype="multipart/form-data">
<div class="weui-cells weui-cells_form">
    <div class="weui-cell">
        <div class="weui-cell__hd"><label class="weui-label">qq</label></div>
        <div class="weui-cell__bd">
            <input class="weui-input" name="qq" type="number" pattern="[0-9]*" placeholder="请输入qq号">
        </div>
    </div>

    <div class="weui-cell">
        <div class="weui-cell__hd"><label for="" class="weui-label">身高</label></div>
        <div class="weui-cell__bd">
            <input class="weui-input" name="stature" type="number" pattern="[0-9]*"  placeholder="请输入身高,单位cm">
        </div>
    </div>

    <div class="weui-cell">
        <div class="weui-cell__hd"><label class="weui-label">体重</label></div>
        <div class="weui-cell__bd">
            <input class="weui-input" name="weight" type="number" pattern="[0-9]*" placeholder="请输入体重">
        </div>
    </div>

    <div class="weui-cell">
        <div class="weui-cell__hd"><label class="weui-label">昵称</label></div>
        <div class="weui-cell__bd">
            <input class="weui-input" name="nickname" type="text"  placeholder="请输入昵称">
        </div>
    </div>
</div>
    <div class="layui-upload">
        <button type="button" class="layui-btn" id="uploadFile">上传图片（可上传多张）</button>
        <blockquote class="layui-elem-quote layui-quote-nm" style="margin-top: 10px;">
            预览图：
            <div class="layui-upload-list" id="imgView"></div>
            <input type="hidden" name="userPhoto" id="userPhoto" value=""/>
        </blockquote>
    </div>

<div class="weui-cells__title">备注</div>
<div class="weui-cells weui-cells_form">
    <div class="weui-cell">
        <div class="weui-cell__bd">
            <textarea class="weui-textarea" name="remarks" placeholder="请输入备注信息" rows="3"></textarea>
            <div class="weui-textarea-counter"><span>0</span>/200</div>
        </div>
    </div>
    <button type="submit"  id="submitBt" style="width: 80%" data-type="loading" class="weui-btn weui-btn_primary site-demo-active">上传信息</button>
</div>

<div class="layui-progress layui-progress-big" lay-showpercent="true" lay-filter="demo">
    <div class="layui-progress-bar layui-bg-red" lay-percent="0%"></div>
</div>
</form>
</body>

<script src="/Public/static/jqurey-weui/lib/jquery-2.1.4.js"></script>
<script src="/Public/static/jqurey-weui/js/jquery-weui.min.js"></script>

<!-- 如果使用了某些拓展插件还需要额外的JS -->

<script src="/Public/static/jqurey-weui/js/swiper.min.js"></script>
<script src="/Public/static/jqurey-weui/js/city-picker.min.js"></script>

<script src="/Public/static/layui/layui.js"></script>
<script src="/Public/static/jquery-form/jquery.form.min.js"></script>
<script src="/Public/static/js/Home/Index/index.js"></script>

<!--提示：如果是采用非模块化方式（最下面有讲解），此处可换成：./layui/layui.all.js-->

<!--<script>
    layui.use('element', function(){
        var $ = layui.jquery
            ,element = layui.element; //Tab的切换功能，切换事件监听等，需要依赖element模块

        //触发事件
        var active = {
            setPercent: function(){
                //设置50%进度
                element.progress('demo', '50%')
            }
            ,loading: function(othis){
                var DISABLED = 'layui-btn-disabled';
                if(othis.hasClass(DISABLED)) return;

                //模拟loading
                var n = 0, timer = setInterval(function(){
                    n = n + Math.random()*10|0;
                    if(n>100){
                        n = 100;
                        clearInterval(timer);
                        othis.removeClass(DISABLED);
                    }
                    element.progress('demo', n+'%');
                }, 300+Math.random()*1000);

                othis.addClass(DISABLED);
            }
        };

        $('.site-demo-active').on('click', function(){
            var othis = $(this), type = $(this).data('type');
            active[type] ? active[type].call(this, othis) : '';
        });
    });
</script>-->


</html>