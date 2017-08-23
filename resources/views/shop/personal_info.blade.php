<!DOCTYPE html>
<html>
<head>
    <title>会员商城</title>
    <meta name="viewport" content="width=640,user-scalable=no">
    <link rel="stylesheet" type="text/css" href="{{ asset('vip/css/reset.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vip/css/date.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vip/css/personal_info.css') }}">
</head>
<body>
<img src="{{ asset('vip/images/personal_info/personal_info_bg.jpg') }}">
<div class="nickName">微信昵称：<span>{{ session('wechat.oauth_user')->nickname }}</span></div>
<div class="info">
    <p>姓名:
        <input type="text" name="username" id="username" value="{{ isset($user->name) ? $user->name : '' }}">
    </p>
    <p>TEL:
        <input type="number" name="tel" id="tel" value="{{ isset($user->mobile) ? $user->mobile : '' }}">
    </p>
    <p>地址:
        <input type="text" name="address" id="address" value="{{ isset($user->location) ? $user->location : '' }}">
    </p>
    <p>生日:
        <input type="text" name="birthday" id="dateinput" value="{{ isset($user->birthday) ? $user->birthday : '' }}">
    </p>
    <div id="datePlugin"></div>
</div>

<!-- btn start-->
<a href="{{ url('shop/index') }}" class="home"><img src="{{ asset('vip/images/personal_info/home.png') }}"></a>
<a href="javascript:void(0)" class="btn"><img src="{{ asset('vip/images/personal_info/getGold.png') }}"></a>
<a href="javascript:void(0)" class="btnDown hidden"><img src="{{ asset('vip/images/personal_info/btnDown.png') }}"></a>
<a href="javascript:void(0)" class="ok"><img src="{{ asset('vip/images/personal_info/ok.png') }}"></a>
<!-- btn end-->

<!-- mask start-->
<div class="mask mask_ok hidden"></div>
<div class="mask mask_gold hidden">
    <div class="text">
        <p>恭喜你获得<span>5</span>金币</p>
        <p>前往 "我的金币" 查看</p>
    </div>
</div>
<div class="mask mask_confirm hidden"></div>
<!-- mask end -->

<!-- script -->
<script type="text/javascript" src="{{ asset('vip/js/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vip/js/date.js') }}"></script>
<script type="text/javascript" src="{{ asset('vip/js/iscroll_date.js') }}"></script>
<script type="text/javascript">
    $(function () {
        var openid = "{{ session('wechat.oauth_user')->id }}";
        //初始化日期插件
        $('#dateinput').date();

        //点击勾按钮
        $('.ok').click(function () {
            //提交用户信息
            submitInfo("mask_ok");
        })

        //点击领取金币按钮
        $('.btn').click(function () {
            //显示领取金币弹窗
            submitInfo("mask_gold");
        })

        //点击弹窗消失
        $('.mask').click(function () {
            $(this).hide();
        });

        //获取页面输入信息提交后台
        function submitInfo(target) {
            var username = $('#username').val();
            var tel = $('#tel').val();
            var address = $('#address').val();
            var birthday = $('#dateinput').val();
            //将日期yy.mm.dd转换成yy-mm-dd
            birthday = birthday.replace(/\./g, '-');

            //表单验证
            if (tel === '' || birthday === '') {
                $('.mask_confirm').show();
                // alert('必填项必须填写')
            } else if (tel.length !== 11) {
                $('.mask_confirm').show();
                // alert('请填写正确的手机号')
            } else {
                if (target === 'mask_ok') {
                    //$('.mask_ok').show();
                    //提交用户信息
                    $.ajax({
                        type: 'POST',
                        url: 'https://weixin.touchworld-sh.com/api/user/info',
                        dataType: 'json',
                        data: {
                            openid: openid,
                            username: username,
                            mobile: tel,
                            location: address,
                            birthday: birthday
                        },
                        success: function (data) {
                            //提交成功
                            if (data.is_new == 1) {
                                $('.mask_ok').show();
                            } else if (data.is_new == 0) {
                                if (data.type == 2) {
                                    $('.text span').text('10');
                                    $('.mask_gold').show();
                                } else if (data.type == 1) {
                                    $('.text span').text('5');
                                    $('.mask_gold').show();
                                } else if (data.type == 0) {
                                    window.location.href = "{{ url('shop/index') }}";
                                }
                            }
                        },
                        error: function (data) {
                            //提交失败
                        }
                    })
                } else if (target === 'mask_gold') {
                    $.ajax({
                        type: 'POST',
                        url: 'https://weixin.touchworld-sh.com/api/user/info',
                        dataType: 'json',
                        data: {
                            openid: openid,
                            username: username,
                            mobile: tel,
                            location: address,
                            birthday: birthday
                        },
                        success: function (data) {
                            //提交成功
                            if (data.type == 2) {
                                $('.text span').text('10');
                                $('.mask_gold').show();
                            } else if (data.type == 1) {
                                $('.text span').text('5');
                                $('.mask_gold').show();
                            } else if (data.type == 0) {
                                window.location.href = "{{ url('shop/index') }}";
                            }
                        },
                        error: function (data) {
                            //提交失败
                        }
                    })
                }

            }
        }
    })


</script>
</body>
</html>