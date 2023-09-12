<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    @include('admin.partials.head')
</head>

<body class="">

<!-- Page content -->
<div class="page-content">

    <!-- Main sidebar -->
    <div class="sidebar sidebar-dark sidebar-main sidebar-expand-lg">
        @include('admin.partials.sidebar_top')
        @include('admin.partials.sidebar_menu')
    </div>
    <!-- /main sidebar -->


    <!-- Main content -->
    <div class="content-wrapper">

        <!-- Main navbar -->
        <div class="navbar navbar-expand-lg navbar-static shadow ">
            @include('admin.partials.navbar')
        </div>
        <!-- /main navbar -->


        @yield('content')


    </div>
    <!-- /main content -->

</div>



@include('admin.partials.fileSelector')
<script>
    $('.swc').click(function () {
        var url = $(this).attr('data-href');
        Swal.fire({
            html: 'Bu kaydı silmek istediğinizden emin misiniz?',
            icon: "warning",
            buttonsStyling: false,
            showCancelButton: true,
            confirmButtonText: "Evet, sil!",
            cancelButtonText: 'Hayır, iptal et!',
            customClass: {
                confirmButton: "btn btn-primary",
                cancelButton: 'btn btn-danger'
            },
        }).then(function (result) {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    });
</script>

@if(session('success'))
    <script>
        Swal.fire({
            text: '{{session('success')}}',
            icon: 'success',
            toast: true,
            showConfirmButton: false,
            position: 'top-end'
        });
    </script>
@endif

@if(session('error'))
    <script>
        Swal.fire({
            text: '{{session('error')}}',
            icon: 'error',
            toast: true,
            showConfirmButton: false,
            position: 'top-end'
        });
    </script>
@endif
</body>
</html>
