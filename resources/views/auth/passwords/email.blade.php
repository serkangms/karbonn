<!DOCTYPE html>
<html lang="tr">


<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="{{asset('assets')}}/css/iziModal.min.css">


    <link rel="stylesheet" href="{{asset('assets/theme')}}/css/style.css">
    <link href="{{asset('assets/theme')}}/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{asset('assets/theme')}}/css/custom.css" rel="stylesheet">



</head>

<body>
<div class="preloader-it">
    <div class="loader-pendulums"></div>
</div>

<div id="login" class="hk-wrapper">

    <div class="hk-pg-wrapper hk-auth-wrapper">
        <header class="d-flex justify-content-between align-items-center">
            <a class="d-flex auth-brand" href="{{route('home')}}">
                <picture>
                    <img class="brand-img img-fluid" src="{{makeCustomThumb(siteconfigLocaled('site.logo_dark'),280,70,100)}}" alt="Mutfak Yapım" />
                </picture>
            </a>
            <div class="btn-group btn-group-sm">
                <a href="https://mutfakyapim.com/iletisim" class="btn btn-sm btn-outline-secondary rounded-0">İletişim</a>
                <a href="https://mutfakyapim.com/biz-kimiz" class="btn btn-sm btn-outline-secondary rounded-0">Hakkımızda</a>
            </div>
        </header>
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-5 pa-0">
                    <div id="owl_demo_1" class="owl-carousel dots-on-item owl-theme">
                        <div class="fadeOut item auth-cover-img overlay-wrap" style="background-image:url({{makeCustomCover(siteconfigLocaled('site.login_image'),500,400,100)}});">
                            <div class="auth-cover-info py-xl-0 pt-100 pb-50">
                                <div class="auth-cover-content text-center w-xxl-75 w-sm-90 w-xs-100">
                                    <h1 class="display-4 text-white mb-20" style="font-weight: 400;">Websitenizi Daha İyi Yönetin.</h1>
                                    <p class="text-white" style="font-weight: 500;">Yönetim panelinize hoşgeldiniz. Websitenizin ihtiyacını karşılayabileceğiniz tüm özellikleri sunuyoruz...</p>
                                </div>
                            </div>
                            <div class="bg-overlay bg-trans-dark-75"></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-7 pa-0">
                    <div class="auth-form-wrap py-xl-0 py-50">
                        <div class="auth-form w-xxl-55 w-xl-75 w-sm-90 w-xs-100">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                        {{ 'Şifrenizi sıfırlamak için e-posta gönderdik!' }}
                                </div>
                            @endif

                            <form method="POST" action="{{ route('password.email') }}">

                                @csrf
                                <h1 class="mb-10" style="opacity: 0.9;">Şifrenizi mi unuttunuz ?</h1>
                                <p class="mb-30" style="opacity: 0.9;">Bilgilerinizle şifrenizi sıfırlayın.</p>
                                <div class="form-group">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="E-Posta Adresi">

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ 'Bu e-posta adresine sahip bir kullanıcı bulamıyoruz.' }}</strong>
                                    </span>
                                    @enderror

                                </div>
                                <button class="btn btn-sm btn-pink rounded-0 btn-block login-btn" type="submit">Şifremi Sıfırla</button>
                                <div>
                                    <p class="font-14 text-center mt-15" style="opacity: 0.7;" >Şifrenizi Hatırladınız Mı?</p>
                                <p class="text-center" style="position: relative; top: -15px;"><a href="{{route('login')}}">Giriş Yapın</a></p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>        </div>
    <!-- /Main Content -->

</div>

<script src="{{asset('assets')}}/js/custom.js"></script>
<script src="{{asset('assets')}}/js/jquery.min.js"></script>
<script src="{{asset('assets')}}/js/iziModal.min.js"></script>
<script src="{{asset('assets')}}/js/init.js"></script>

<script>
    $(document).ready(function() {
        $(document).on("click", ".updateUserBtnNav", function(e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            $('#navUserModal').iziModal('destroy');
            let url = $(this).data("url");
            createModal("#navUserModal", "Kullanıcı Düzenle", "Kullanıcı Düzenle", 600, true, "20px", 0, "#e20e17", "#fff", 1040, function() {
                $.post(url, {}, function(response) {
                    $("#navUserModal .iziModal-content").html(response);
                    if ($("button.btnUpdate").hasClass('btnUpdate')) {
                        if (!$("button.btnUpdate").hasClass('btnUpdateNav')) {
                            $("button.btnUpdate").addClass("btnUpdateNav");
                        }
                        $("button.btnUpdate").removeClass("btnUpdate");
                    }
                });
            });
            openModal("#navUserModal");
            $("#navUserModal").iziModal("setFullscreen", false);
        });
        $(document).on("click", ".btnUpdateNav", function(e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            let url = $(this).data("url");
            let formData = new FormData(document.getElementById("updateUser"));
            createAjax(url, formData, function() {
                closeModal("#navUserModal");
                $("#navUserModal").iziModal("setFullscreen", false);
                reloadTable("userTable");
            });
        });
    });
</script>

<!-- Mirrored from izmirmobilya.com.tr/panel/login by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 04 Aug 2023 17:06:02 GMT -->
</body>
</html>

