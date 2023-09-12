@extends('theme.app')

@section('header')
    <div class="ss_breadcrumb text-center">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h1>{{$page->title}}</h1>
                    <ul>
                        <li><a href="index.html">Anasayfa</a><span> / Blog</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    @php
        $pages = \App\Models\PageTranslation::where('status', 1)
                     ->where('locale', app()->getLocale())
                     ->whereHas('page', function ($query) use ($page) {
                         $query->where('parent_id', $page->id);
                     })->orderBy('sort_order', 'asc');

             if (request('q')){
                 $pages->where('title', 'like', '%' . request('q') . '%');
             }

             $pages = $pages->paginate(12);
             $paginator = $pages;
             $paginator->appends(request()->except('page'));
    @endphp
    <section class="ss_section_eight ss_section_sec_bg spacer_top spacer_bottom">
        <div class="container-fluid">
            <h3 class="ss_h3_center text-center">{{$page->content->baslik}}</h3>
            <h1 class="text-center mb-5">{!! $page->content->metin !!}</h1>
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    @foreach($pages as $item)

                        <div class="swiper-slide">
                            <div class="ss_eight ss_box_wbg">
                                <a href="{{url($item->deep_slug)}}">
                                    <img src="{{makeCustomThumb($item->list_image_id,550,400)}}" width="550" height="400" alt="{{$item->title}}">
                                </a>
                                <div class="ss_product_content ss_box_bg">
                                    <h2><a href="blog.html">{{$item->title}}</a> <span>{{ \Carbon\Carbon::parse($item->created_at)->setTimezone('Europe/Istanbul')->format('d.m.Y') }}</span></h2>

                                    <p>{!! removefirstandlastp($item->description) !!}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach



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
