<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">

<head>
    @include('theme.partials.head')

</head>
<body>
@php
$homeslider = getcomponent('homeslider');
$homecarbon = getcomponent('homecarbon');
$homecigli= getcomponent('homecigli');
$homesite= getcomponent('homesite');
$homemedia= getcomponent('homemedia');
@endphp
<section class="ss_index_one"> <!--===== Section One Start =====-->
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
                            <li class="ss_menuP">
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
        <div class="ss_banner_main"> <!--===== Banner =====-->
            <div class="row">
                <div class="col-lg-5">
                    <div class="ss_banner_left">
                        <h2>{{$homeslider->content->ustbaslik}}</h2>
                        <h1>{{$homeslider->content->baslik}}</h1>
                        <a href="{{url('karbon-hesapla')}}" class="white_btn">Karbon Ayak İzini Hesapla</a>

                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="ss_banner_right">
                        <img style="opacity: 0.9; border-radius: 20px" class="img-fluid" src="{{makeCustomCover($homeslider->content->gorsel->id,980,650)}}" alt="Image">
                        <img class="img-fluid ss_cloud" src="{{asset('assets/img/cloud.png')}}" alt="image"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="ss_section_two spacer_top">
    <div class="container-fluid">
        <div class="ss_two">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="ss_two_sec wow fadeIn" data-wow-delay="0.1s">
                        <div class="pb-2">
                            <img  class="img-fluid" src="{{makeCustomCover($homecarbon->content->gorsel->id,80,80)}}" alt="Image">
                        </div>
                        <div class="mt-2">
                        <p>{!! removefirstandlastp($homecarbon->content->ustbaslik) !!}</p>
                        </div>

                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="ss_two_sec wow fadeIn" data-wow-delay="0.2s">
                        <div class="pb-2">
                            <img  class="img-fluid" src="{{makeCustomCover($homecarbon->content->gorsel1->id,80,80)}}" alt="Image">
                        </div>
                        <div class="mt-2">
                            <p>{!! removefirstandlastp($homecarbon->content->baslik) !!}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="ss_two_sec wow fadeIn" data-wow-delay="0.3s">
                        <div class="pb-2">
                            <img  class="img-fluid" src="{{makeCustomCover($homecarbon->content->gorsel2->id,80,80)}}" alt="Image">
                        </div>
                        <div class="mt-2">
                            <p>{!! removefirstandlastp($homecarbon->content->baslik1) !!}</p>
                        </div>
                    </div>

                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="ss_two_sec wow fadeIn" data-wow-delay="0.4s">
                        <div class="pb-2">
                            <img  class="img-fluid" src="{{makeCustomCover($homecarbon->content->gorsel3->id,80,80)}}" alt="Image">
                        </div>
                        <div class="mt-2">
                            <p>{!! removefirstandlastp($homecarbon->content->baslik2) !!}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> <!--===== Section Two End =====-->


<section class="ss_section_five ss_section_sec_bg spacer_top spacer_bottom"> <!--===== Section Five Start =====-->
    <div class="container-fluid">
        <h3 class="ss_h3_center text-center">{{$homesite->content->ustbaslik}}</h3>
        <h1 class="text-center mb-5">{{$homesite->content->baslik}}</h1>
        <div class="row">
            <div class="col-xl-4 col-lg-6">
                <div class="ss_four_left">
                    <div class="ss_box_bg wow fadeIn" data-wow-delay="0.1s" data-wow-duration="1s">
                        <div class="row">
                            <div class="col-3">
                                <div class="ss_four_one">
                                    <img  class="img-fluid" src="{{makeCustomCover($homesite->content->gorsel1->id,80,80)}}" alt="Image">
                                </div>
                            </div>
                            <div class="col-9">
                                <div class="ss_four_two">
                                    <h2>{{$homesite->content->baslik1}}</h2>
                                    <p>{!! removefirstandlastp($homesite->content->metin1) !!}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ss_box_bg mt-4 wow fadeIn" data-wow-delay="0.1s" data-wow-duration="1s">
                        <div class="row">
                            <div class="col-3">
                                <div class="ss_four_one">
                                    <img  class="img-fluid" src="{{makeCustomCover($homesite->content->gorsel2->id,80,80)}}" alt="Image">
                                </div>
                            </div>
                            <div class="col-9">
                                <div class="ss_four_two">
                                    <h2>{{$homesite->content->baslik2}}</h2>
                                    <p>{!! removefirstandlastp($homesite->content->metin2) !!}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ss_box_bg mt-4 wow fadeIn" data-wow-delay="0.1s" data-wow-duration="1s">
                        <div class="row">
                            <div class="col-3">
                                <div class="ss_four_one">
                                    <img  class="img-fluid" src="{{makeCustomCover($homesite->content->gorsel3->id,80,80)}}" alt="Image">
                                </div>
                            </div>
                            <div class="col-9">
                                <div class="ss_four_two">
                                    <h2>{{$homesite->content->baslik3}}</h2>
                                    <p>{!! removefirstandlastp($homesite->content->metin3) !!}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-6 order-xl-last mt-lg-0 mt-md-4">
                <div class="ss_four_left">
                    <div class="ss_box_bg wow fadeIn" data-wow-delay="0.3s" data-wow-duration="1s">
                        <div class="row">
                            <div class="col-3">
                                <div class="ss_four_one">
                                    <img  class="img-fluid"src="{{makeCustomCover($homesite->content->gorsel4->id,80,80)}}" alt="Image">
                                </div>
                            </div>
                            <div class="col-9">
                                <div class="ss_four_two">
                                    <h2>{{$homesite->content->baslik4}}</h2>
                                    <p>{!! removefirstandlastp($homesite->content->metin4) !!}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ss_box_bg mt-4 wow fadeIn" data-wow-delay="0.3s" data-wow-duration="1s">
                        <div class="row">
                            <div class="col-3">
                                <div class="ss_four_one">
                                    <img  class="img-fluid" src="{{makeCustomCover($homesite->content->gorsel5->id,80,80)}}" alt="Image">
                                </div>
                            </div>
                            <div class="col-9">
                                <div class="ss_four_two">
                                    <h2>{{$homesite->content->baslik5}}</h2>
                                    <p>{!! removefirstandlastp($homesite->content->metin5) !!}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ss_box_bg mt-4 wow fadeIn" data-wow-delay="0.3s" data-wow-duration="1s">
                        <div class="row">
                            <div class="col-3">
                                <div class="ss_four_one">
                                    <img  class="img-fluid" src="{{makeCustomCover($homesite->content->gorsel6->id,80,80)}}" alt="Image">
                                </div>
                            </div>
                            <div class="col-9">
                                <div class="ss_four_two">
                                    <h2>{{$homesite->content->baslik6}}</h2>
                                    <p>{!! removefirstandlastp($homesite->content->metin6) !!}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 offset-xl-0 col-lg-6 offset-lg-3">
                <div class="ss_easy_use wow zoomIn" data-wow-delay="0.2s" data-wow-duration="1s">
                    <img style="opacity: 0.9; border-radius: 20px" class="img-fluid" src="{{makeCustomCover($homesite->content->ustgorsel->id,440,500)}}" alt="Image">

                </div>
            </div>
        </div>
    </div>
</section> <!--===== Section Five End =====-->
<div style="height: 80px;"></div>

<section class="ss_section_three spacer_bottom "> <!--===== Section Three Start =====-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6">
                <div class="ss_three_left wow fadeIn">
                    <img  class="img-fluid"  src="{{makeCustomCover($homecigli->content->gorsel->id,780,640)}}" alt="Image">
                </div>
            </div>
            <div class="col-lg-6 align-self-center">
                <div class="ss_three_right wow fadeIn">
                    <h3>{{$homecigli->content->ustbaslik}}</h3>
                    <h1>{{$homecigli->content->baslik}}</h1>
                    <p>{!! $homecigli->content->metin !!}</p>

                </div>
            </div>
        </div>
        <div class="ss_shape_one">
            <div class="ss_shape"></div>
        </div>
        <div class="ss_shape_dot"></div>
    </div>
</section> <!--===== Section Three End =====-->

<section class="ss_section_four spacer_top spacer_bottom"> <!--===== Section Four Start =====-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 align-self-center">
                <div class="ss_five_right wow fadeIn">
                    <h3>{{$homemedia->content->ustbaslik}}</h3>
                    <h1>{{$homemedia->content->baslik}}</h1>
                    <p>{!! $homemedia->content->metin !!}</p>
                </div>
            </div>
            <div class="col-lg-6 align-self-center">
                <div class="ss_four_right wow fadeIn">
                    <img style="opacity: 0.9; border-radius: 20px" class="img-fluid" src="{{makeCustomCover($homemedia->content->gorsel->id,780,640)}}" alt="Image">
                </div>
            </div>
        </div>
        <div class="ss_shape_two">
            <div class="ss_shape"></div>
        </div>
        <div class="ss_shape_three">
            <div class="ss_shape"></div>
        </div>
    </div>
</section> <!--===== Section Four End =====-->
<section class="ss_newsletter ss_section_sec_bg"> <!--===== Section Newsletter Start =====-->
    <div class="container-fluid">
        <div class="ss_footer_news ss_box_bg">
            <div class="row">
                <div class="col-md-7">
                    <div class="ss_foot_news_one">
                        <h1>Sorularınız mı var ?</h1>
                        <p>İletişim formunu doldurarak bizimle iletişime geçebilirsiniz.</p>
                    </div>
                </div>
                <div class="col-md-5 align-self-center">
                    <div class="ss_foot_news_one">
                        <a href="{{url('iletisim')}}" class="ss_btn">İletişime Geçin</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> <!--===== Section Newsletter End =====-->


@include('theme.partials.footer')
<!--===== script start =====-->
<script src="{{(asset('plugins'))}}/js/jquery.min.js"></script>
<script src="{{(asset('plugins'))}}/js/bootstrap.min.js"></script>
<script src="{{(asset('plugins'))}}/js/jquery.magnific-popup.min.js"></script>
<script src="{{(asset('plugins'))}}/js/isotope.pkgd.min.js"></script>
<script src="{{(asset('plugins'))}}/js/swiper.min.js"></script>
<script src="{{(asset('plugins'))}}/js/wow.min.js"></script>
<script src="{{(asset('plugins'))}}/js/script.js"></script>

</body>
</html>
