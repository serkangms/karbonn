<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta http-equiv="Content-Language" content="tr">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Mutfak Yapım İçerik Yönetim Sistemi</title>
<link href="{{asset('assets/admin/')}}/fonts/inter/inter.css" rel="stylesheet" type="text/css">
<link href="{{asset('assets/admin/')}}/icons/phosphor/styles.min.css" rel="stylesheet" type="text/css">
<link href="{{asset('assets/admin/')}}/css/ltr/all.min.css" id="stylesheet" rel="stylesheet" type="text/css">
<link href="{{asset('assets/admin/')}}/css/custom.css" id="stylesheet" rel="stylesheet" type="text/css">
<link rel="icon" type="image/png" href="{{asset('assets/admin/')}}/images/layers.png">

<link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/buttons.bootstrap4.min.css')}}">

<script src="{{asset('assets/admin/')}}/demo/demo_configurator.js"></script>
<script src="{{asset('assets/admin/')}}/js/bootstrap/bootstrap.bundle.min.js"></script>
<script src="{{asset('assets/admin/')}}/js/vendor/visualization/d3/d3.min.js"></script>
<script src="{{asset('assets/admin/')}}/js/vendor/visualization/d3/d3_tooltip.js"></script>
<script src="{{asset('assets/admin/')}}/js/app.js"></script>
<script src="{{asset('assets/admin/')}}/demo/pages/dashboard.js"></script>
<script src="{{asset('assets/admin/')}}/js/jquery/jquery.min.js"></script>
<script src="{{asset('assets/admin/')}}/js/vendor/notifications/sweet_alert.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@2.7.14/dist/vue.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js" ></script>
<script>
    $(function () {
        $("#buttons_dt").DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#buttons_dt_wrapper .col-md-6:eq(0)');

        $('#datatable').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    });

</script>
<script src="{{asset('assets/admin')}}/demo/pages/datatables_basic.js"></script>

<script src="{{asset('assets/admin')}}/js/vendor/tables/datatables/datatables.min.js"></script>

<script src="{{asset('assets/admin/')}}/js/vendor/media/glightbox.min.js"></script>
<script src="{{asset('assets/admin/')}}/demo/pages/gallery.js"></script>


