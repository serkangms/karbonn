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
        .container_centering {
            display: flex;
            justify-content: center;
            align-items: center;
            max-width: 80%;
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
                <div class="col-md-12 col-lg-6 text-center text-lg-left"> <!-- Değişiklik burada -->
                    <div class="main_title_1">
                        <h4 class="" style="color: #f0f0f0; font-size: 28px;"><img src="{{makeCustomCover($page->content->gorsel->id, 90, 90)}}" alt="{{$page->title}}">{{$page->content->ustbaslik}}</h4>

                        <div class="mt-5">
                            <a type="button" href="{{url('bireysel')}}" style=" color: #0b0b0b;" class="btn btn-warning btn-lg">
                                <img src="{{asset('assets/img/user.svg')}}" alt="" width="40" height="40"> Bireysel
                            </a>


                            <a type="button" href="{{url('kurumsal')}}" style=" color: #0b0b0b;" class="btn btn-warning btn-lg">
                                <img src="{{asset('assets/img/bag.svg')}}" alt="" width="40" height="40"> Kurumsal
                            </a>
                        </div>
                    </div>
                </div>
                <!-- /col -->
                <div class="col-md-12 col-lg-6 text-center text-lg-left"> <!-- Değişiklik burada -->
                    <div id="wizard_container">
                        <div id="top-wizard">
                            <div id="progressbar"></div>
                        </div>
                        <!-- /top-wizard -->
                        <form action="{{route('SubmitForm')}}" id="survey_form" method="post" >
                            @csrf


                            <div style="opacity: 0.7">

                                <img src="{{makeCustomCover($page->content->ustgorsel->id,500,500)}}" alt="{{$page->title}}">
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

</body>
</html>
