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
    <section class="ss_blog spacer_bottom spacer_top"> <!--===== Section One Start =====-->
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8">
                    <div class="ss_blog_left">
                        <div class="ss_blog_img">
                            <img class="img-fluid  bg-light rounded" style="opacity: 0.8" src="{{makeCustomCover($page->image_id,1100,550)}}" width="1100" height="550" alt="Image">
                        </div>
                <div class="mt-3">
                        <h2>{{$page->title}}</h2>
                    <p>{!! ($page->description) !!}</p>

                </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="ss_blog_sidebar">

                        <div class="post_widget widget">
                            <h2>Diğer Bloglar</h2>
                            @foreach($page->siblings->where('status',1)->where('id','!=',$page->id)->take(12)->sortByDesc('publish_date') as $item)

                            <div class="ss_blog_box">
                                <div class="post_wid_img">
                                    <a href="{{url($item->deep_slug)}}">
                                        <img src="{{ makeCustomCover($item->image_id, 75, 75) }}" alt="{{ $item->title }}">
                                    </a>
                                </div>
                                <div class="post_wid_text">
                                    <a href="{{url($item->deep_slug)}}">{{$item->title}}</a>
                                    <a href="{{url($item->deep_slug)}}"><span>{{\Carbon\Carbon::parse($page->created_at)->format('d.m.Y')}}</span></a>
                                </div>
                            </div>
                            @endforeach

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
                    <div class="col-md-3 align-self-center">
                        <div class="ss_foot_news_one">
                            <a href="{{url('iletisim')}}" class="ss_btn">İletişime Geçin</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> <!--===== Section Newsletter End =====-->
@endsection

@section('customjs')

@endsection
