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
            @foreach($navigations as $item)
                <div class="card">
                    <div class="card-body p-2">
                        <a href="{{route('admin.navigation.edit',$item)}}">
                            {{$item->name}}
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection



