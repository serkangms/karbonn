@extends('admin.app')

@section('content')
    <div class="content-inner">

        <div class="page-header">
            <div class="page-header-content d-lg-flex">
                <div class="d-flex">
                    <h4 class="page-title mb-0">
                        Home - <span class="fw-normal">Dashboard</span>
                    </h4>
                    <a href="#page_header" class="btn btn-light align-self-center collapsed d-lg-none border-transparent rounded-pill p-0 ms-auto" data-bs-toggle="collapse">
                        <i class="ph-caret-down collapsible-indicator ph-sm m-1"></i>
                    </a>
                </div>
                <div class="collapse d-lg-block my-lg-auto ms-lg-auto" id="page_header">
                    <div class="d-sm-flex align-items-center mb-3 mb-lg-0 ms-lg-3">
                        <div class="d-inline-flex align-items-center">

                            <a href="#" class="btn btn-primary  h-32px rounded-pill">
                                <i class="ph-plus me-1"></i>
                                Yeni Öğe Ekle
                            </a>

                            <div class="dropdown ms-2">
                                <a href="#" class="btn btn-light btn-icon w-32px h-32px rounded-pill" data-bs-toggle="dropdown">
                                    <i class="ph-dots-three-vertical"></i>
                                </a>

                                <div class="dropdown-menu dropdown-menu-end">
                                    <button type="button" class="dropdown-item">
                                        <i class="ph-briefcase me-2"></i>
                                        Customer details
                                    </button>
                                    <button type="button" class="dropdown-item">
                                        <i class="ph-folder-user me-2"></i>
                                        User directory
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content pt-0">

           <div class="mb-3">
               <button class="btn btn-sm btn-pink selectImage">File</button>
               <a data-href="#" class="badge bg-danger text-white cursor-pointer p-2 rounded swc ">Sil</a>
           </div>

            <?php $lastFile = \App\Models\Files::orderBy('id','desc')->first(); ?>
            {{$lastFile->id}}
            <img src="{{makeCustomCover(58349,1920,989,95)}}" alt="">


        </div>
    </div>

@endsection



