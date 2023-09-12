@extends('theme.app')

@section('header')
    <div class="ss_breadcrumb text-center">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h1>{{$page->title}}</h1>
                    <ul>
                        <li><a href="index.html">Anasayfa</a><span> / Hakkımızda</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <section class="ss_about_main"> <!--===== Section Two Start =====-->
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6">
                    <div class="ss_about_img">
                        <img class="img-fluid ss_about1" src="{{makeCustomCover($page->content->gorsel2->id,400,516,100)}}" alt="team"/>
                        <div class="ss_video_img">
                            <img class="img-fluid ss_about2" src="{{makeCustomCover($page->content->gorsel->id,580,630,100)}}" alt="team"/>
                            <a class="ss_video_popup" rel="external" href="https://www.youtube.com/embed/{{$page->content->video}}">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                    <g>
                                        <path d="M477.606,128.055C443.431,68.863,388.251,26.52,322.229,8.83C256.208-8.862,187.25,0.217,128.055,34.394
									C68.861,68.57,26.52,123.75,8.83,189.772c-17.69,66.021-8.611,134.981,25.564,194.173
									C68.568,443.137,123.75,485.48,189.771,503.17c22.046,5.908,44.417,8.83,66.646,8.83c44.339,0,88.101-11.629,127.529-34.393
									c59.192-34.175,101.535-89.355,119.225-155.377C520.862,256.207,511.781,187.249,477.606,128.055z M477.429,315.333
									c-15.848,59.146-53.78,108.581-106.81,139.197c-53.028,30.617-114.806,38.749-173.952,22.903
									c-59.147-15.848-108.581-53.78-139.198-106.81c-30.616-53.028-38.749-114.807-22.9-173.954
									C50.418,137.523,88.35,88.09,141.379,57.472c35.325-20.395,74.524-30.812,114.249-30.812c19.91,0,39.959,2.618,59.702,7.909
									c59.146,15.848,108.581,53.78,139.197,106.81C485.144,194.408,493.278,256.186,477.429,315.333z"/>
                                    </g>
                                    <g>
                                        <path d="M378.778,231.852l-164.526-94.99c-8.731-5.041-19.155-5.039-27.886-0.001c-8.731,5.04-13.944,14.069-13.944,24.15v189.98
									c0,10.081,5.212,19.109,13.944,24.15c4.365,2.521,9.152,3.78,13.941,3.78c4.79,0,9.579-1.262,13.944-3.781l164.528-94.989
									c8.73-5.042,13.941-14.07,13.941-24.151C392.72,245.92,387.508,236.892,378.778,231.852z M365.452,257.074l-164.527,94.989
									c-0.201,0.117-0.62,0.358-1.236,0c-0.618-0.357-0.618-0.839-0.618-1.071v-189.98c0-0.232,0-0.714,0.618-1.071
									c0.242-0.14,0.453-0.188,0.633-0.188c0.28,0,0.482,0.117,0.605,0.188l164.526,94.99c0.201,0.116,0.618,0.357,0.618,1.071
									C366.071,256.716,365.652,256.958,365.452,257.074z"/>
                                    </g>
                                    <g>
                                        <path d="M413.303,134.44c-31.689-40.938-79.326-68.442-130.698-75.461c-7.283-0.997-14.009,4.106-15.006,11.399
									c-0.995,7.291,4.108,14.009,11.399,15.006c44.512,6.081,85.783,29.909,113.232,65.369c2.626,3.392,6.565,5.168,10.546,5.168
									c2.849,0,5.72-0.909,8.146-2.789C416.741,148.628,417.807,140.259,413.303,134.44z"/>
                                    </g>
                                </svg></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 align-self-center">
                    <div class="ss_ab_right wow fadeIn" data-wow-delay="0.2s" data-wow-duration="1s">
                        <h3>{{$page->content->ust_baslik}}</h3>
                        <h1>{{$page->content->baslik}}</h1>
                        {!! $page->content->metin !!}
                    </div>
                </div>
            </div>
        </div>
    </section>



    <section class="ss_about_sec_five ss_section_sec_bg spacer_top spacer_bottom ss_testimonial">
        <div class="container-fluid">
            <h3 class="ss_h3_center text-center">{{$page->content->misyonustbsalik}}</h3>
            <h1 class="text-center mb-4">{{$page->content->misyonbaslik}}</h1>
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    @foreach($page->content->altyazilar as $item)
                        <div class="swiper-slide">
                            <div class="row">
                                <div class="col-xl-2 mt-4 offset-xl-3 col-lg-3 offset-lg-2 col-md-4 offset-md-0">
                                    <div class="ss_testimonial_left wow fadeIn" data-wow-delay="0.1s" data-wow-duration="1s">
                                        <p><img class="img-fluid" src="{{makeCustomCover($item->gorsel->id,200,200)}}" alt="image" /></p>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-5 mt-4 col-md-8">
                                    <div class="ss_testimonial_right wow fadeIn" data-wow-delay="0.1s" data-wow-duration="1s">
                                        {!! $item->metin !!}
                                        <h1>{{$item->baslik}}</h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
                <div class="testimonial_nav">
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
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
    </section> <!--===== Section Newsletter End =====-->

@endsection

@section('customjs')

@endsection
