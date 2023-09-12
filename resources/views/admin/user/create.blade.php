@extends('admin.app')

@section('content')

    <script src="{{asset('assets/admin/')}}/js/vendor/ui/prism.min.js"></script>
    <script src="{{asset('assets/admin/')}}/js/vendor/media/glightbox.min.js"></script>
    <script src="{{asset('/assets/')}}/cdn/build/ckeditor.js"></script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <div class="content-inner" id="app">
        <div class="page-header">
            <div class="page-header-content d-lg-flex">
                <div class="d-flex">
                    <div class="page-title">
                        <h5 class="m-0">
                            Kullanıcı Ekle
                        </h5>
                        <div class="breadcrumb m-0">
                            <a href="{{route('admin.user.index')}}" class="breadcrumb-item">
                                Kullanıcılar
                            </a>
                        </div>
                    </div>
                    <a href="#page_header" class="btn btn-light align-self-center collapsed d-lg-none border-transparent rounded-pill p-0 ms-auto" data-bs-toggle="collapse">
                        <i class="ph-caret-down collapsible-indicator ph-sm m-1"></i>
                    </a>
                </div>

                <div class="collapse d-lg-block my-lg-auto ms-lg-auto" id="page_header">
                    <div></div>
                    <div class="d-sm-flex align-items-center mb-3 mb-lg-0 ms-lg-3">
                        <div class="d-inline-flex align-items-center">

                            <a href="javascript:history.back()" class="btn btn-light  h-32px ">
                                <i class="ph-arrow-left me-2"></i>
                                Geri Dön
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="kt_app_content_container" class="app-container  container-xxl " :key="activelang">

            <div class="row">
                <div class="col-md-12">
                    <form action="{{route('admin.user.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card card-flush mb-3 ">
                            <div class="card-header p-2">

                                <div class="p-2">
                                    <h6 class="mb-0"></h6>
                                </div>

                            </div>

                            <div class="card-body p-2">

                                <div class="form-group">
                                    <div>
                                        <label style="width:35%; font-size:11pt;"><strong>Adı Soyadı</strong></label>
                                        <div class="text-left form-group p-1 ">
                                            <div>
                                                <input name="name" class="form-control mb-3" type="text" placeholder="Kullanıcı Adı">
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label style="width:35%; font-size:11pt;"><strong>E-Posta</strong></label>
                                        <div class="text-left p-1 ">
                                            <div>
                                                <input name="email" class="form-control mb-3" type="text" placeholder="E-Posta">
                                            </div>
                                        </div>
                                </div>
                                <div class="form-group">
                                    <label style="width:35%; font-size:11pt;"><strong>Şifre</strong></label>
                                    <div class="text-left p-1 ">
                                        <div>
                                            <input name="password" class="form-control mb-3" type="password" placeholder="Şifre">
                                        </div>
                                    </div>
                                </div>


                        </div>

                        <div class="mb-3 p-2">
                            <button  type="submit" class="btn btn-lg fw-bold fs-lg btn-success">Kaydet</button>
                        </div>

                        </div>
                    </form>
                </div>

            </div>

        </div>

    </div>

@endsection
