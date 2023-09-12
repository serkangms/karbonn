@extends('admin.app')

@section('content')
    <div class="content-inner">

        <div class="page-header">
            <div class="page-header-content d-lg-flex">
                <div class="d-flex">
                    <h4 class="page-title mb-0">
                        Ayarlar
                    </h4>
                    <a href="#page_header" class="btn btn-light align-self-center collapsed d-lg-none border-transparent rounded-pill p-0 ms-auto" data-bs-toggle="collapse">
                        <i class="ph-caret-down collapsible-indicator ph-sm m-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="content pt-0">
            <div class="row">
                <div class="col-md-4">
                    <div class="d-flex flex-column">
                        <div class="mb-2">
                            <span class="fw-medium fs-lg">Genel</span>
                        </div>
                        <a href="{{route('admin.setting.edit','site')}}" class="card mb-2">
                            <div class="card-body text-dark p-2">
                                Site Ayarları
                            </div>
                        </a>
                        <a href="{{route('admin.setting.edit','social')}}" class="card mb-2">
                            <div class="card-body text-dark p-2">
                                Sosyal Medya
                            </div>
                        </a>
                        <a href="{{route('admin.setting.edit','smtp')}}" class="card mb-2">
                            <div class="card-body text-dark p-2">
                                Email SMTP
                            </div>
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection



