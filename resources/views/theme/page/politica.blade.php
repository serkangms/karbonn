@extends('theme.app')

@section('header')
    <div class="ss_breadcrumb text-center">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h1>{{$page->title}}</h1>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')

    <section class="ss_cart spacer_top spacer_bottom">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12">
                    <div class="cart_box ss_box_wbg">
                        <div class="cart_box_one">
                            <h2>Güncelleme Tarihi</h2>
                            <p>{{$page->content->ustbaslik }}</p>
                        </div>
                        <div class="cart_box_div">
                            <p>{!! $page->content->metin !!}</p>
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
