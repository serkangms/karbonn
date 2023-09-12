<div class="container-fluid">
    <div class="d-flex d-lg-none me-2">
        <button type="button" class="navbar-toggler sidebar-mobile-main-toggle rounded-pill">
            <i class="ph-list"></i>
        </button>
    </div>

    <div class="navbar-collapse flex-lg-1 order-2 order-lg-1 collapse" id="navbar_search">
        <div class="navbar-search flex-fill dropdown mt-2 mt-lg-0">
            <div class="form-control-feedback form-control-feedback-start flex-grow-1">
                <input type="text" id="search_input" class="form-control form-control-lg bg-light border-0 shadow-sm fw-medium" placeholder="İçerik Ara..." data-bs-toggle="dropdown">
                <div class="form-control-feedback-icon">
                    <i class="ph-magnifying-glass"></i>
                </div>
                <div class="dropdown-menu " style="width: 100%;  max-height: 400px; overflow-y: auto; overflow-x: hidden;min-height: 100px" >
                    <div class="dropdown-menu-scrollable-lg" >
                        <div id="search_result" style="display: none">

                        </div>

                    </div>
                </div>
            </div>


        </div>
    </div>

    <ul class="nav hstack gap-sm-1 flex-row justify-content-end order-1 order-lg-2">

        <li class="nav-item me-2">
            <a class="text-dark" href="{{url('/')}}">
                Siteyi Aç
            </a>
        </li>

        <li class="nav-item d-lg-none">
            <a href="#navbar_search" class="navbar-nav-link navbar-nav-link-icon rounded-pill" data-bs-toggle="collapse">
                <i class="ph-magnifying-glass"></i>
            </a>
        </li>


        <li class="nav-item d-none">
            <a href="#" class="navbar-nav-link navbar-nav-link-icon rounded-pill" data-bs-toggle="offcanvas" data-bs-target="#notifications">
                <i class="ph-bell"></i>
                <span class="badge bg-yellow text-black position-absolute top-0 end-0 translate-middle-top zindex-1 rounded-pill mt-1 me-1">2</span>
            </a>
        </li>

        <li class="nav-item nav-item-dropdown-lg dropdown">
            <a href="#" class="navbar-nav-link align-items-center bg-light rounded-pill p-1" data-bs-toggle="dropdown">
                <div class="status-indicator-container">
                    <img
                        src="{{makeCustomCover((Auth::user()->image_id),32,32,100)}}"
                         class="w-32px h-32px rounded-pill" alt="">
                    <span class="status-indicator bg-success"></span>
                </div>
                <span class="d-none d-lg-inline-block mx-lg-2">
                    {{Auth::user()->name}}
                </span>
            </a>

            <div class="dropdown-menu dropdown-menu-end">
                <a href="{{route('admin.user.edit',auth()->user()->id)}}" class="dropdown-item">
                    <i class="ph-gear me-2"></i>
                    Ayarlar
                </a>
                <a href="{{url('logout')}}" class="dropdown-item">
                    <i class="ph-sign-out me-2"></i>
                    Çıkış Yap
                </a>
            </div>
        </li>
    </ul>
</div>

<script>
    $('#search_input').on('keyup paste', function(){
        searchItems();
    });


    function searchItems(){
        var val = $('#search_input').val();
        $('#loading_search_result').show();
        $('#search_result').hide();
        if(val.length > 2){
            $.ajax({
                type: "POST",
                url: "{{route('admin.search')}}",
                data: {
                    _token: "{{csrf_token()}}",
                    val: val
                },
                success: function (response) {
                    $('#search_result').html(response);
                    $('#loading_search_result').hide();
                    $('#search_result').show();
                }
            });
        }
    }
</script>
