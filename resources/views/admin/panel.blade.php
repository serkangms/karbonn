@extends('admin.app')

@section('content')
    <div class="content-inner">

        <div class="content ">
            <div class="mb-3">
                <span style="font-size: 2em;" class="fw-bold">Mutfak Yapım İçerik Yönetim Sistemi</span>
            </div>

            <div class="row">
                <div class="col-sm-6 col-xl-3">
                    <div class="card card-body">
                        <div class="d-flex align-items-center">
                            <i class="ph-hand-pointing ph-2x text-success me-3"></i>

                            <div class="flex-fill text-end">
                                <h4 class="mb-0">{{\App\Models\CarbonSubmit::count()}}</h4>

                                <span class="text-muted">Karbon Ayak İzi Hesap Formu</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-xl-3">
                    <div class="card card-body">
                        <div class="d-flex align-items-center">
                            <i class="ph-codesandbox-logo ph-2x text-indigo me-3"></i>

                            <div class="flex-fill text-end">
                                <h4 class="mb-0">{{\App\Models\User::count()}}</h4>
                                <span class="text-muted">Kullanıcılar</span>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="col-sm-6 col-xl-3">
                    <div class="card card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-fill">
                                <h4 class="mb-0">{{\App\Models\Contact::count()}}</h4>
                                <span class="text-muted">İletişim</span>
                            </div>

                            <i class="ph-package ph-2x text-danger ms-3"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">Hızlı Bağlantılar</h6>
                        </div>

                        <div class="card-body" style="min-height: 300px;">
                            <a href="{{route('admin.page.index')}}" class="card text-primary fw-medium fs-lg p-2 shadow-lg">
                                İçerikler
                            </a>

                            <a href="{{route('admin.component.index')}}" class="card text-primary fw-medium fs-lg p-2 shadow-lg">
                                Bileşenler
                            </a>
                            <a href="{{route('admin.setting.index')}}" class="card text-primary fw-medium fs-lg p-2 shadow-lg">
                                Site Ayarları
                            </a>
                            @foreach(\App\Models\Page::where('sidebar_text','!=',null)->get() as $item)
                                <a href="{{route('admin.page.index',$item)}}" class="card text-primary fw-medium fs-lg p-2 shadow-lg">
                                    {{$item->sidebar_text}}
                                </a>
                            @endforeach

                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex justify-content-center align-item11s-center" style="min-height: 300px;">

                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection



