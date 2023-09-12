@extends('admin.app')

@section('content')
    <div class="content-inner">

        <div class="page-header">
            <div class="page-header-content d-lg-flex">
                <div class="d-flex">
                    <h4 class="page-title mb-0">
                        Başvurular
                    </h4>
                    <a href="#page_header" class="btn btn-light align-self-center collapsed d-lg-none border-transparent rounded-pill p-0 ms-auto" data-bs-toggle="collapse">
                        <i class="ph-caret-down collapsible-indicator ph-sm m-1"></i>
                    </a>
                </div>

                <div class="collapse d-lg-block my-lg-auto ms-lg-auto" id="page_header">
                    <div></div>
                    <div class="d-sm-flex align-items-center mb-3 mb-lg-0 ms-lg-3">
                        <div class="d-inline-flex align-items-center">

                            <a href="{{route('admin.form.index')}}"
                               class="btn btn-light  h-32px ">
                                <i class="ph-arrow-left me-1"></i>
                                Geri Dön
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content pt-0">
            <div class="card">
                <table class="table table-sm">
                    <thead>
                    <tr>
                        <td>
                            ID
                        </td>
                        <td>
                            Başvuru Tarihi
                        </td>
                        <td>
                            IP Adresi
                        </td>
                        <td>
                            İşlemler
                        </td>
                    </tr>
                    </thead>
                    @foreach($sumissions as $item)
                        <tr>
                            <td>
                                {{$item->id}}
                            </td>
                            <td>
                                {{$item->created_at}}
                            </td>
                            <td>
                                {{$item->ip_address}}
                            </td>
                            <td>
                                <a href="{{route('admin.form.submission',$item->id)}}"
                                   class="badge cursor-pointer copyitem me-2  bg-primary bg-opacity-20 text-primary">
                                   Detay
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </table>

            </div>

        </div>
    </div>

@endsection



