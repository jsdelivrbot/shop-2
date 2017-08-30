<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>暇步士拍党俱乐部</title>
    <meta name="viewport" content="width=640,user-scalable=no">
    <link rel="stylesheet" type="text/css" href="{{ asset('vip/css/reset.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vip/css/index.css') }}">
</head>
<body>
<!-- nav start -->
<img src="{{asset('vip/images/audio/audio2.png')}}" alt="" class="audioMusic">
<audio id="audio" src="{{asset('vip/m.mp3')}}" preload="auto" loop="loop" autoplay="autoplay"></audio>
<nav>
    <ul>
        <li><a href="{{ url('shop/user') }}"><img src="{{ asset('vip/images/index/my_info.png') }}"></a></li>
        <li><a href="{{ url('shop/ticket') }}"><img src="{{ asset('vip/images/index/my_coupon.png') }}"></a></li>
        <li><a href="{{ url('shop/coin') }}"><img src="{{ asset('vip/images/index/my_gold.png') }}"></a></li>
    </ul>
</nav>
<!-- nav end -->

<!-- index start -->
<section class="index">
    <img src="{{asset('vip/images/index/index_bg.jpg')}}">

    {{--爱犬大步走--}}
    <a href="{{ url('shop/dog') }}"><img src="{{asset('vip/images/index/dog1.png')}}" class="dog1"></a>
    {{--闪耀星派对--}}
    <a href="" onclick="alert('即将上线！')"><img src="{{asset('vip/images/index/dog2.png')}}" class="dog2"></a>
    {{--礼品店--}}
    <a href="{{ url('shop/draw') }}"><img src="{{asset('vip/images/index/gift.png')}}" class="gift"></a>
    {{--秋冬新鞋--}}
    <a href="http://mp.weixin.qq.com/s/-mbpYIvpFN4oQvsKGSU4kw"><img src="{{asset('vip/images/index/shoes.png')}}" class="shoes"></a>
    {{--每日签到--}}
    <a href="{{ url('shop/coin/day') }}" class="sign"><img src="{{asset('vip/images/index/sign.png')}}"></a>
</section>
<!-- index end -->

@if(session('sign'))
<!-- mask start -->
<div class="mask mask_sign"></div>
<!-- mask end -->
@endif

<!-- script -->
<script type="text/javascript" src="{{asset('vip/js/jquery.min.js')}}"></script>
{{--引入分享设置--}}
@include('shop.share')

<script type="text/javascript">
    @if (session('sign_error'))
        alert('已经签到过啦！');
    @endif
    $(function () {
        //点击签到
        //https://weixin.touchworld-sh.com/shop/coin/day
        // $('.sign').click(function(){
        // 	$('.mask_sign').show();
        // })

        //点击弹窗消失
        $('.mask').click(function () {
            $(this).hide();
        });
    })
</script>
<script>
    //解决ios上不能自动播放声音
    bgm_init();
    function bgm_init(){
        var audio = document.getElementById('audio');
        document.addEventListener("WeixinJSBridgeReady", function () {
            audio.play();
        }, false);
//        window.addEventListener('touchstart', function firstTouch(){
//            audio.play();
//            this.removeEventListener('touchstart', firstTouch);
//        });

        var audioMusic = document.getElementsByClassName('audioMusic')[0];

        audioMusic.addEventListener('touchstart', function (){
            if(audio.paused){
                audio.play();
                audioMusic.src = '{{asset('vip/images/audio/audio2.png')}}'
            }else{
                audio.pause();
                audioMusic.src = '{{asset('vip/images/audio/audio1.png')}}'

            }


        });
    }
</script>
</body>
</html>