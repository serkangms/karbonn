@extends('admin.app')

@section('content')

    <div class="content-inner" id="app">

        <div class="page-header">
            <div class="page-header-content d-lg-flex">
                <div class="d-flex">
                    <h4 class="page-title mb-0">
                        Bileşenler
                    </h4>
                    <a href="#page_header" class="btn btn-light align-self-center collapsed d-lg-none border-transparent rounded-pill p-0 ms-auto" data-bs-toggle="collapse">
                        <i class="ph-caret-down collapsible-indicator ph-sm m-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="content pt-0">
            <div class="row">
                @foreach($components as $item)
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body p-2 d-flex justify-content-between">
                                <div class="my-auto">
                                    <span class="fs-lg fw-medium">{{ $item->title }}</span>
                                </div>
                                <div>
                                    <a href="{{route('admin.page.edit',$item)}}" class="btn btn-sm btn-primary">Düzenle</a>
                                    @if($item->type != 'component')
                                        <a href="{{route('admin.page.index',$item)}}" class="btn btn-sm btn-primary">İçerikler</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>



@endsection
