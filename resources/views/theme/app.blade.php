<!DOCTYPE html>
<!--
Template Name: Solar Supplier - Responsive HTML Template
Version: 1.0.0
Author: Kamleshyadav
Website:
Purchase:
-->
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- Begin Head -->

<head>
    @include('theme.partials.head')
</head>
<body>
<section class="s_header_main"> <!--===== Section One Start =====-->
    <div class="s_header">
        <div class="container-fluid">
            <div class="ss_header"> <!--===== Top Menu =====-->
                <div class="row">
                    <div class="col-lg-3 col-md-7 col-sm-12 col-12 align-self-center">
                        <div class="ss_logo" style="margin-top: -30px;">
                            <a href="{{route('home')}}">
                                <img src="{{asset('assets/img/logo3.png')}}" width="150" height="150" alt="Site Logo" class="logo_sticky">

                            </a>
                        </div>
                    </div>
                    <div class="col-lg-9 col-md-5 col-sm-12 col-12 align-self-center">
                        <div class="ss_menu">
                            <ul>
                                <li class="">
                                    <a href="{{route('home')}}">Anasayfa</a>
                                </li>
                                <li><a href="{{url('about')}}">Hakkımızda</a></li>
                                <li><a href="{{url('blog')}}">Blog</a></li>
                                <li class="ss_menuP">Belediye
                                    <ul class="ss_subMenu">
                                        <li><a href="https://e-belediye.cigli.bel.tr/#/home" target="_blank">E-Belediye</a></li>
                                        <li><a href="https://kbs.cigli.bel.tr/imardurumu/index.aspx" target="_blank">E-İmar</a></li>
                                        <li><a href="https://kbs.cigli.bel.tr/BELNET/LoginFW/Login.aspx?ReturnUrl=https%3A%2F%2Fkbs.cigli.bel.tr%2FBELNET%2FGenericClass%2Fquerypage.aspx%3Fquerygroup%3Druhsat_yapi.RuhsatMuellifEkrani%26autoquery%3D1%26ts%3DcnVoc2F0X3lhcGkuc3VyZWNfdHVydV9pZHx8VEVYVF8xOjt%252bcnVoc
                                        2F0X3lhcGkuaXNpbV9kZWdpc2lrbGlrX2tvbnVfaWR8fFRFWFRfMTo7fnJ1aHNhdF95YXBpLmdlb19kdXJ1bXx8VkFMVUVfMToxO34%253d%26tc%3D.html" target="_blank" >E-Ruhsat</a></li>

                                    </ul>
                                </li>
                                <li><a href="https://www.cigli.bel.tr/mudurlukler.html" target="_blank">Müdürlükler</a></li>
                                <li class="ss_menuP">Karbon Ayak İzi
                                    <ul class="ss_subMenu">
                                        <li><a href="{{url('karbon-ayak-izi-nedir')}}" > Nedir ?</a></li>
                                        <li><a href="{{url('karbon-ayak-izi-nasil-calisir')}}" >Nasıl Çalışır ?</a></li>
                                        <li><a href="{{url('karbon-hesapla')}}" >Hesapla</a></li>

                                    </ul>
                                </li>
                                <li><a href="{{url('iletisim')}}">İletişim</a></li>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @yield('header')
    </div>
</section>

@yield('content')

@include('theme.partials.footer')



<script src="{{asset('plugins')}}/js/jquery.min.js"></script>
<script src="{{asset('plugins')}}/js/bootstrap.min.js"></script>
<script src="{{asset('plugins')}}/js/jquery.magnific-popup.min.js"></script>
<script src="{{asset('plugins')}}/js/isotope.pkgd.min.js"></script>
<script src="{{asset('plugins')}}/js/swiper.min.js"></script>
<script src="{{asset('plugins')}}/js/wow.min.js"></script>
<script src="{{asset('plugins')}}/js/jquery.flot.min.js"></script>
<script src="{{asset('plugins')}}/js/script.js"></script>
@yield('csutomjs')

</body>
</html>
