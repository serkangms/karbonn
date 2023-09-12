@extends('theme.app')

@section('header')
    <div class="ss_breadcrumb text-center">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h1>{{$page->title}}</h1>
                    <ul>
                        <li><a href="index.html">Anasayfa</a><span> / Karbon Ayak İzi Nedir</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')


    <section class="ss_wchoose_us spacer_top"> <!--===== Section Three Start =====-->
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 col-md-10 offset-md-0">
                    <div class="ss_box_bg">
                        <div class="row">
                            <div class="col-lg-5">
                                <div class="ss_wchoose_one">
                                    <h1 style="font-size: 35px;">{{$page->content->ustbaslik}}</h1>
                                    <p>{!! removefirstandlastp($page->content->ustmetin) !!}</p>
                                </div>
                            </div>

                            <div class="col-lg-7">
                                <div class="ss_wchoose_two wow fadeIn" data-wow-delay="0.1s" data-wow-duration="2s">
                                    <img class="img-fluid" src="{{makeCustomCover($page->content->gorsel->id,540,400,100)}}"  alt="image"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 offset-lg-2 col-md-10 offset-md-0">
                    <div class="ss_box_bg">
                        <div class="row">
                            <div class="col-lg-7">
                                <div class="ss_wchoose_three wow fadeIn" data-wow-delay="0.1s" data-wow-duration="2s">
                                    <img class="img-fluid" src="{{makeCustomCover($page->content->ustgorsel->id,540,400,100)}}" alt="image"/>
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="ss_wchoose_one">
                                    <h1 style="font-size: 35px;">{{$page->content->baslik}}</h1>
                                    <p>{!! removefirstandlastp($page->content->metin) !!}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
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
    </section>
@endsection

@section('customjs')

@endsection
