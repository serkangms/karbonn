<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="{{asset('plugins')}}/css/bootstrap.min.css" />

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
</div>

<div id="loader_form">
    <div data-loader="circle-side-2"></div>
</div>

<header>
    <div class="container-fluid">
        <div class="row">
            <div class="col-5">
                @if($page->content->logo)
                <a href="{{route('home')}}"><img src="{{makeCustomCover($page->content->logo->id, 50, 55)}}" alt="" width="50" height="55"></a>
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
                <!-- /col -->
            </div>
            <div class="row d-flex justify-content-center align-items-center ">

                <div class="col-md-12">
                    <div id="wizard_container">
                        <div id="top-wizard">
                            <div id="progressbar"></div>
                        </div>
                        <!-- /top-wizard -->
                        <form action="{{route('SubmitForm')}}" id="survey_form" method="post" >
                            @csrf


                            <div id="middle-wizard">

                                @php
                                    //get first 12 questions
                                    $questionsInner = \App\Models\Question::where('id', '<=', 12)->where('status', 1)->get();
                                    $questionsOuter = \App\Models\Question::where('id', '>=', 13)->where('id', '<=', 17)->where('status', 1)->get();

                                @endphp


                                <div id="inner">

                                    <div class="step quest" id="step0">
                                        <div class="error" id="errorMessage" style="color: red; font-size: 14px;"></div>

                                        <h3 class="main_question">FİRMA HAKKINDA BİLGİ</h3>
                                        <div class="form-group">
                                            <label for="firstname">FİRMA TİCARİ UNVANINIZ</label>
                                            <input type="text" name="user_name" id="user_name" class="form-control" >
                                        </div>
                                        <div class="form-group">
                                            <label for="email">E-Posta</label>
                                            <input type="email" name="user_email" id="user_email" class="form-control" >
                                        </div>
                                            <div class="form-group">
                                                <select class="form-control" name="state" id="state">
                                                    <option  value="">Ülke</option>
                                                    <option  value="Türkiye">Türkiye</option>
                                                    <option  value="Almanya">Almanya</option>
                                                    <option  value="İngiltere">İngiltere</option>
                                                    <option  value="Fransa">Fransa</option>
                                                    <option  value="İtalya">İtalya</option>
                                                    <option  value="İspanya">İspanya</option>
                                                    <option  value="Rusya">Rusya</option>
                                                    <option  value="Çin">Çin</option>
                                                    <option  value="Japonya">Japonya</option>
                                                    <option  value="Hindistan">Hindistan</option>
                                                    <option  value="Kanada">Kanada</option>
                                                    <option  value="ABD">ABD</option>
                                                    <option  value="Meksika">Meksika</option>
                                                    <option  value="Brezilya">Brezilya</option>
                                                    <option  value="Arjantin">Arjantin</option>
                                                    <option  value="Avustralya">Avustralya</option>
                                                    <option  value="Yeni Zelanda">Yeni Zelanda</option>
                                                    <option  value="Diğer">Diğer</option>
                                                </select>
                                            </div>

                                            <!-- /row -->
                                        </div>

                                    @foreach($questionsInner as $index => $question)

                                    <div class="step quest" id="step{{$index + 1}}" style="display: none">
                                            <h3 class="main_question mb-4"><strong>Karbon Tüketimi {{$index + 1}} / {{$questionsInner->count()}}</strong>{{ $question->title }}</h3>

                                            <h3 class="main_question mb-4">{{ $question->name }} </h3>

                                            <div class="review_block">
                                                <ul>
                                                    @foreach($question->Questioninput as $input)
                                                        <li>
                                                            <div class="">
                                                                <label for="fuel_{{$input->id}}" class="wrapper">{{$input->name}}</label>
                                                                <input type="text" id="fuel_{{$input->id}}" name="inputs[{{$input->id}}]" class="" value="" >
                                                            </div>
                                                            <div id="total_display_{{$input->id}}"></div>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    @endforeach

                                        <div class="step quest p-2" id="step{{$questionsInner->count() + 1}}" style="display: none">
                                            <div class="card mb-3">
                                          <img src="{{asset('assets')}}/img/leaves.svg" alt="" width="40" height="40" class="icon pl-2" >

                                                <div class="card-body">
                                                    <div class="row">
                                                  <b><p class="card-title" style="font-size: 17px; color: #333;">Karbon Miktarınızı azaltıcı Faliyet Bölümü</p></b>
                                                        <img src="{{asset('assets')}}/img/down-arrow.svg" alt="" width="40" height="40" class="icon " >

                                               </div>
                                                    <p class="card-text"><small class="text-muted">Bölüm 2</small></p>

                                                </div>
                                            </div>
                                        </div>

                                        @foreach($questionsOuter as $index => $question)
                                            <div class="step quest" id="step{{$loop->iteration + 1 + $questionsInner->count()}}" style="display: none">
                                                <h3 class="main_question mb-4"><strong>Karbon Azaltımı {{$loop->iteration }} / {{$questionsOuter->count()}}</strong>{{ $question->title }}</h3>

                                                <h3 class="main_question mb-4">{{ $question->name }} </h3>

                                                <div class="review_block">
                                                    <ul>
                                                        @foreach($question->Questioninput as $input)
                                                            <li>
                                                                <div class="">
                                                                    <label for="fuel_{{$input->id}}" class="wrapper">{{$input->name}}</label>
                                                                    <input type="text" id="fuel_{{$input->id}}" name="inputs[{{$input->id}}]" class="" value="">
                                                                </div>
                                                                <div id="total_display_{{$input->id}}"></div>

                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        @endforeach
                                </div>


                            </div>



                            <div id="bottom-wizard">
                                <button style="display: none" type="button" name="backward" class="backward">Geri</button>
                                <button type="button" name="forward" class="forward" >İleri</button>
                                <button style="display: none"  type="submit" name="process" class="submit">Hesapla</button>
                            </div>
                            <div style="height: 30px;"></div> <!-- Altta 30 piksel yüksekliğinde boşluk -->

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

    var currentTab = 0;
    var totalCount = '{{$questionsInner->count() + $questionsOuter->count() + 1}}';

    $('.forward').click(function () {
        if(checkRequired() == false){
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
        if(currentTab == 0){
            $('.backward').hide();
        }else{
            $('.backward').show();
        }

        if(currentTab == totalCount){
            $('.submit').show();
            $('.forward').hide();
        }
        else{
            $('.submit').hide();
            $('.forward').show();
        }
    }

    function checkRequired(){
        var required = true;

        if(currentTab == 0){
            var name = $('#user_name').val();
            var mail = $('#user_email').val();
            var job = $('#state').val();

            //is a email
            var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
            if(!emailReg.test(mail)){
                return false;
            }

            if(name == '' || job == ''){
                return false;
            }
        }

        $('#step' + currentTab + ' input').each(function () {
            //min one input is filled
            if($(this).val() != ''){
                required = true;
                return false;
            }else{
                required = false;
            }
        });

        return required;
    }


</script>

</body>
</html>
