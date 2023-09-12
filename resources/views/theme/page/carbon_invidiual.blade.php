
@php
    $questions = \App\Models\Question::where('type', 'invidual')->where('status', 1)->get();
    //splice 3 and 4 index
    $info =  array();
    $info['type'] = 'info';
    $info = json_decode(json_encode($info));
    $questions->splice(6, 0, [$info]);
    $questions->splice(10, 0, [$info]);
    $questions->splice(15, 0, [$info]);
    //splice first
    $questions->splice(0, 0, [$info]);
    $questions->splice(0, 0, [$info]);
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="{{asset('assets')}}/css/bootstrap.min.css" />
    <link rel="stylesheet" href="{{asset('plugins')}}/css/vendors.css" />
    <link rel="stylesheet" href="{{asset('assets')}}/css/style.css" />
    <link href="https://fonts.googleapis.com/css?family=Caveat|Poppins:300,400,500,600,700&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" type="image/x-icon" href="{{asset('assets')}}/img/apple-touch-icon-57x57-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="72x72" href="{{asset('assets')}}/img/apple-touch-icon-72x72-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="114x114" href="{{asset('assets')}}/img/apple-touch-icon-114x114-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="144x144" href="{{asset('assets')}}/img/apple-touch-icon-144x144-precomposed.png">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        .main_title_1 img {
            display: inline; /* Veya diğer uygun stil */
        }
    </style>
</head>


<body class="style_3">

<div id="preloader">
    <div data-loader="circle-side"></div>
</div><!-- /Preload -->

<div id="loader_form">
    <div data-loader="circle-side-2"></div>
</div><!-- /loader_form -->

<header>
    <div class="container-fluid">
        <div class="row">
            <div class="col-5">
                @if($page->content->logo)
                    <img src="{{makeCustomCover($page->content->logo->id, 50, 55)}}" alt="" width="50" height="55">
                @endif
            </div>
            <div class="col-7">
                <div id="social">

                </div>
            </div>
        </div>

    </div>

</header>


<div class="wrapper_centering">
    <div class="container_centering">
        <div class="container">
            <div class="row d-flex justify-content-center align-items-center">
                <div class="col-md-12">
                    <div class="main_title_1">
                        <h2 class="" style="color: #f0f0f0"><img src="{{makeCustomThumb($page->content->gorsel->id,80,80)}}" width="80" height="80" alt="">{{$page->content->baslik}}</h2>
                        <p>{!! $page->content->metin !!}</p>
                    </div>
                </div>
            </div>
            <div class="row d-flex justify-content-center align-items-center ">
                    <div class="col-md-12">
                    <div id="wizard_container">
                        <div id="top-wizard">
                            <div id="progressbar"></div>
                        </div>

                        <form action="{{route('CarbonSubmit')}}" id="survey_form" method="post" >
                            @csrf

                            <div id="middle-wizard">


                                <div id="inner">


                                    @foreach($questions as $index => $question)
                                        @if($question->type == 'info')
                                            <div class="step quest" id="step{{$index + 1}}" style="display: {{$loop->first ? 'block' : 'none'}}">
                                                @if($index == 0)
                                                    <div class="">
                                                        <h3 class="main_question">Kİşisel Bilgiler</h3>
                                                        <div class="form-group">
                                                            <label for="firstname">ADINIZ SOYADINIZ</label>
                                                            <input type="text" name="user_name" id="user_name" class="form-control" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="email">E-Posta</label>
                                                            <input type="email" name="user_mail" id="user_mail" class="form-control" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="telephone">Meslek</label>
                                                            <input type="text" name="user_job" id="job" class  ="form-control">
                                                        </div>
                                                        <div class="form-group">

                                                        </div>


                                                    </div>

                                                @elseif($index == 1)

                                                        <div class="card mb-3" style="opacity: 0.9;">

                                                            <div class="card-body  ">
                                                                <div class="row d-flex justify-content-center ">
                                                                    <b><p class="card-title" style="font-size: 25px; color: #333;">TÜKETİM MİKTARLARI</p></b>
                                                                    <div class="col-md-4">
                                                                        <img  src="{{ asset('assets/img/footprints.svg') }}" alt="" width="40" height="40" class="icon">
                                                                    </div>
                                                                </div>

                                                                <p class="card-text"><small class="text-muted">Bölüm 1</small></p>

                                                            </div>
                                                        </div>

                                                @elseif($index == 8)
                                                    <div class="card mb-3" style="opacity: 0.9;">

                                                        <div class="card-body">
                                                            <div class="row pl-1  ">

                                                                <b><p class="card-title" style="font-size: 25px; color: #333;">HANE BİLGİLERİ</p></b>
                                                                <div class="col-md-4 pl-4">
                                                                    <img  src="{{ asset('assets/img/home.svg') }}" alt="" width="40" height="40" class="icon">
                                                                </div>
                                                            </div>

                                                            <p class="card-text"><small class="text-muted">Bölüm 2</small></p>

                                                        </div>
                                                    </div>
                                                @elseif($index  == 12)
                                                    <div class="card mb-3" style="opacity: 0.9;">

                                                        <div class="card-body">
                                                            <div class="row pl-1  ">

                                                                <b><p class="card-title" style="font-size: 25px; color: #333;">ULAŞIM BİLGİLERİ</p></b>
                                                                <div class="col-md-4 pl-4">
                                                                    <img  src="{{ asset('assets/img/fly.svg') }}" alt="" width="40" height="40" class="icon">
                                                                </div>
                                                            </div>
                                                            <p class="card-text"><small class="text-muted">Bölüm 3</small></p>
                                                        </div>
                                                    </div>
                                                @elseif($index  == 17)
                                                    <div class="card mb-3" style="opacity: 0.9;">

                                                        <div class="card-body">
                                                            <div class="row pl-1  ">

                                                                <b><p class="card-title" style="font-size: 25px; color: #333;">ALIŞKANLIKLAR</p></b>
                                                                <div class="col-md-4 pl-4">
                                                                    <img  src="{{ asset('assets/img/leaves.svg') }}" alt="" width="40" height="40" class="icon">
                                                                </div>
                                                            </div>
                                                            <p class="card-text"><small class="text-muted">Bölüm 4</small></p>
                                                        </div>
                                                    </div>

                                                @endif

                                            </div>
                                            @else
                                            <div class="step quest reqarea" data-mode="{{$question->extend ? 'extend' : 'normal'}}"   id="step{{$index + 1}}" style="display: none">
                                                <h3 class="main_question mb-4"><strong>Karbon Tüketimi {{$index + 1}} / {{$questions->count()}}</strong>{{ $question->title }}</h3>

                                                <h3 class="main_question mb-4">{{ $question->name }} </h3>

                                                <div class="review_block">

                                                    @if($question->extend)
                                                        <div class="review_block_numbers mb-2">
                                                            <ul class="clearfix">
                                                                <li>
                                                                    <div class="container_numbers">
                                                                        <input type="radio" id="very_bad_{{$input->id}}" name="question_{{$input->id}}" class="required extend"  data-toggle="show" data-target="#question_{{$question->id}}">
                                                                        <label class="radio good" for="very_bad_{{$input->id}}">Evet</label>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="container_numbers">
                                                                        <input type="radio" id="bad_{{$input->id}}" name="question_{{$input->id}}" class="required extend"  data-toggle="hide" data-target="#question_{{$question->id}}">
                                                                        <label class="radio bad" for="bad_{{$input->id}}">Hayır</label>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    @endif

                                                    <ul style="display: {{$question->extend ? 'none' : 'block'}}" id="question_{{$question->id}}" class="qarea" data-order="{{$index+1}}">
                                                        @foreach($question->Questioninput->sortByDesc('sort_order') as $input)
                                                            @if($question->input_type == 'radio')
                                                                <li>
                                                                    <div class="checkbox_radio_container">
                                                                        <input type="radio" id="fuel_{{$input->id}}" name="input[{{$question->id}}]" class="required inp{{$index+1}}" value="{{$input->id}}" data-order="{{$index+1}}" data-qid="{{$question->id}}">
                                                                        <label class="radio" for="fuel_{{$input->id}}"></label>
                                                                        <label for="fuel_{{$input->id}}" class="wrapper">{{$input->name}}</label>
                                                                    </div>
                                                                </li>
                                                            @else
                                                                <li>
                                                                    <div class="">
                                                                        <label for="fuel_{{$input->id}}" class="wrapper">{{$input->name}}</label>
                                                                        <input type="text" id="fuel_{{$input->id}}" name="inputs[{{$input->id}}]" class="" value=""  >
                                                                    </div>
                                                                    <div id="total_display_{{$input->id}}"></div>
                                                                </li>
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach



                                </div>


                            </div>



                            <div id="bottom-wizard">
                                <button style="display: none" type="button" name="backward" class="backward">Geri</button>
                                <button type="button" name="forward" class="forward">İleri</button>
                                <button style="display: none"  type="submit" name="process" class="submit">Hesapla</button>
                            </div>

                        </form>
                    </div>
                </div>
                </div>

        </div>
    </div>
</div>

<script src="{{asset('assets')}}/js/jquery-3.2.1.min.js"></script>
<script src="{{asset('assets')}}/js/common_scripts.min.js"></script>
<script src="{{asset('assets')}}/js/functions.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>

<script>

    var currentTab = 1;
    var totalCount = '{{$questions->count() }}';

    $('.forward').click(function () {

        if(checkReq() == false){
            alert('Lütfen tüm alanları doldurunuz.');
            return false;
        }

        currentTab++;
        showTab();

    });

    $('.backward').click(function () {
        currentTab--;
        showTab();
    });

    function showTab(){
        $('.quest').hide();

        $('#step' + currentTab).show();
        checkButtons();
    }

    function checkButtons(){
        if(currentTab == 1){
            $('.backward').hide();
        }else{
            $('.backward').show();
        }

        if(currentTab == totalCount){
            $('.submit').show();
            $('.forward').hide();
        }else{
            $('.submit').hide();
            $('.forward').show();
        }
    }

    $('.extend').change(function () {
        var target = $(this).data('target');
        var type = $(this).data('toggle');

        if(type == 'show'){
            $(target).show();
        }else{
            //set val to null
            $(target).find('input').val('');
            $(target).hide();
        }
    });

    function checkReq(){
        if(currentTab == 1){
            var name = $('#user_name').val();
            var mail = $('#user_mail').val();
            var job = $('#job').val();

            //is a email
            var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
            if(!emailReg.test(mail)){
                return false;
            }

            if(name == '' || job == ''){
               return false;
            }
        }


        var reqarea = $('#step' + currentTab);
        var mode = reqarea.data('mode');

        if(mode == 'normal'){
            var checked = false;
            reqarea.find('.qarea').each(function () {
                if($(this).find('input').is(':checked')){
                    checked = true;
                }
            });
        }

        if(mode == 'extend'){
            var extend = false;
            reqarea.find('.extend').each(function () {
                if($(this).is(':checked')){
                    extend = true;
                }
            });
            if(extend == false){
                return false;
            }
        }

        if(checked == false){
            return false;
        }


    }




</script>
</body>
</html>
