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
@php
    $userForm = \App\Models\UserForm::all()->last(); // Son formun kendisini alıyoruz

       if ($userForm) {
           $carbon = \App\Models\CarbonSubmit::where('user_form_id', $userForm->id)->first(); // İlgili kaydı alıyoruz

           if ($carbon) {
               $total = $carbon->total; // Kullanıcının total değeri
                $totalday=number_format($total/365, 2);
           } else {
               $total = 0;
           }
       } else {
           $total = 0;
       }
@endphp
<div id="preloader">
    <div data-loader="circle-side"></div>
</div>

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
                <div class="col-md-12 col-lg-6 text-center text-lg-left">
                    <div class="main_title_1 ">
                        @if($total<=6000)
                            <span style="font-size: 19px; color: #f2cb44;">Tebrik ediyoruz! Dünya Ortalamasının Altındasınız</span>
                        @elseif($total>6000)
                            <span style="font-size: 19px; color: #f2cb44;">Dünya Ortalamasının Üzerindesiniz Bunu Azaltabilirsiniz</span>
                        @endif
                        <h3 style="font-size: 40px;">
                            <img src="{{ asset('assets/img/carbon.svg') }}" width="80" height="80" alt="">
                            {{$total}} KG
                            <span style="margin-left: 5px; font-size: 14px;">/ Yıllık</span>
                        </h3>
                        <h3 style="font-size: 40px;">
                            <img src="{{ asset('assets/img/carbon.svg') }}" width="80" height="80" alt="">
                            {{$totalday}} KG
                            <span style="margin-left: 5px; font-size: 14px;">/ Günlük</span>
                        </h3>
                       <b><p>{{$page->content->ustbaslik}}</p></b>
                        <p >

                   <img src="{{makeCustomCover($page->content->gorsel->id, 80, 80)}}" alt="" width="80" height="80">
                            <span style="border-left: 2px solid #f2cb44; padding-left: 10px;">{{$page->content->baslik}}</span>
                        </p>
                        <p class="pl-3" >
                            <img src="{{makeCustomCover($page->content->gorsel1->id, 80, 80)}}" alt="" width="80" height="80">
                            <span style="border-left: 2px solid #f2cb44; padding-left: 10px;">{{$page->content->baslik1}} </span>
                        </p>
                    </div>
                </div>


                <div class="col-md-12 col-lg-6 text-center text-lg-left">
                    <div id="wizard_container">

                        <!-- /top-wizard -->
                        <form action="{{route('SubmitForm')}}" id="survey_form" method="post" >
                            @csrf


                            <div id="middle-wizard">


                                <div  >
                                        <h1 style="color: #f0f0f0"  >Karbon Ayak İziniz</h1>
                                </div>


                            </div>
                            <div style="opacity: 0.7">

                         <img src="{{asset('assets/img/favpng.png')}}" width="450" height="450" alt="">
                            </div>
                            <div >
                                <button type="button" name="forward" class="forward">KARBON AYAK İZİ SERTİFİKASI </button>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    var raporButonu = document.querySelector('.forward');

    // Butona tıklanıldığında tetiklenen işlem
    raporButonu.addEventListener('click', function() {
        // Rapor sayfasını bir AJAX isteği ile alın
        var xhr = new XMLHttpRequest();
        xhr.open('GET', '/CertificatePdf', true);
        xhr.responseType = 'blob';

        xhr.onload = function() {
            if (xhr.status === 200) {
                // Dosyayı blob olarak alın ve indirme bağlantısı oluşturun
                var blob = xhr.response;
                var link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = 'rapor.pdf';
                link.click();
            }
        };

        xhr.send();
    });
</script>
</body>
</html>
