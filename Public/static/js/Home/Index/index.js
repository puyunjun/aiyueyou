//获取图片列表对象
var fileObj = $('#uploaderFiles');

//定义图片base64地址数组

//定义上传图片url地址数组

var userPhoto = [];

var imgBase = [];
layui.use(['upload','element'], function(){
    var upload = layui.upload;
    var element = layui.element;

   /* var uploadInst = upload.render({
        elem: '#uploadFile'
        ,url: 'http://'+window.location.host+'/Home/Index/uploadFile'
        ,auto: false //选择文件后不自动上传
        ,bindAction: '#submitBt' //指向一个按钮触发上传
        ,multiple:true      //允许多图片上传
        ,number:0           //上传图片个数
        ,accept:'file'
        ,before:function(obj){

        }
        ,choose: function(obj){
            //将每次选择的文件追加到文件队列
            var files = obj.pushFile();

            //预读本地文件，如果是多文件，则会遍历。(不支持ie8/9)
            obj.preview(function(index, file, result){

                //添加base64地址入数组
                imgBase.push(result);
                //创建列表节点对象
                var liObj = '<li onclick="imgPrivew()" name="filePrivew" class="weui-uploader__file" style="background-image:url('+result+')">' +
                    '</li>';
                /!*  console.log(index); //得到文件索引
                  console.log(file); //得到文件对象
                  console.log(result); //得到文件base64编码，比如图片
                  console.log(fileObj);*!/
                fileObj.append(liObj)
                //这里还可以做一些 append 文件列表 DOM 的操作
                //obj.upload(index, file); //对上传失败的单个文件重新上传，一般在某个事件中使用
                //delete files[index]; //删除列表中对应的文件，一般在某个事件中使用
            });
        }
        ,
        done:function(res, index, upload){
           console.log(res)
        }
    });*/



    //多图片上传
    upload.render({
        elem: '#uploadFile'
        ,url: 'http://'+window.location.host+'/Home/Index/uploadFile'
        ,multiple:true      //允许多图片上传
        ,before: function(obj){

            console.log(obj);
            var n = 0, timer = setInterval(function(){
                n = n + Math.random()*20|0;
                if(n>70){
                    n = 70;
                    clearInterval(timer);
                }
                element.progress('demo', n+'%');
            }, 100+Math.random()*10);
            //预读本地文件示例，不支持ie8
            obj.preview(function(index, file, result){

                imgBase.push(result);
                var liObj = '<img onclick="imgPrivew()" style="width:50px;height: 50px;" src="'+ result +'" alt="'+ file.name +'" class="layui-upload-img">';
               // $('#imgView').append('<li onclick="imgPrivew()" class="weui-uploader__file" src="'+ result +'" alt="'+ file.name +'" class="layui-upload-img">')
                $('#imgView').append(liObj);
            });
        }
        ,done: function(res){
            element.progress('demo', '70%');
            var n = 70, timer = setInterval(function(){
                n = n + Math.random()*10|0;
                if(n>100){
                    n = 100;
                    clearInterval(timer);
                }
                element.progress('demo', n+'%');
            }, 100+Math.random()*10);
            console.log(res)
            console.log(res.info.info.url)
            //保存上传的图片进入数组
            userPhoto.push(res.info.info.url);
            userUpload();

            console.log(userPhoto)
        }
    });

});


function imgPrivew(){
    //console.log(imgBase)
    var pb1 = $.photoBrowser({
        items: imgBase
    });
    pb1.open();
}


//为上传图片赋值


function userUpload(){

    $('#userPhoto').val(userPhoto)

}


//表单提交

//做出简单验证

//定义需要验证的输入框数组,值为name值

var validateArr = [
    'qq','stature','weight','nickname','userPhoto','remarks'
];

$('#myForm').submit(function() {
    for(var i=0;i<validateArr.length;i++){
        var inputObj = document.getElementsByName(validateArr[i])
        if($(inputObj[0]).val() == ''){
            layer.msg('请将信息填写完毕');
            return false;
        }
    }
    $(this).ajaxSubmit(options);

    return false;
    //非常重要，如果是false，则表明是不跳转
    //在本页上处理，也就是ajax，如果是非false，则传统的form跳转。
});

//表单 提交

var options = {
    //target: '#myForm',          //把服务器返回的内容放入id为output的元素中
    dataType: 'JSON',
    clearForm: true,
    // beforeSubmit: showRequest,  //提交前的回调函数
    success: function(res){
        layer.msg(res.info);
        $('#imgView').empty();
    }      //提交后的回调函数
    //url: url,                 //默认是form的action， 如果申明，则会覆盖
    //type: type,               //默认是form的method（get or post），如果申明，则会覆盖
    //dataType: null,           //html(默认), xml, script, json...接受服务端返回的类型
    //clearForm: true,          //成功提交后，清除所有表单元素的值
    //resetForm: true,          //成功提交后，重置所有表单元素的值
}
