@extends('admin.app')

@section('content')
    <div class="content-inner">
        <div class="page-header">
            <div class="page-header-content d-lg-flex">
                <div class="d-flex">
                    <h4 class="page-title mb-0">
                        Ayarlar - <span class="fw-normal">Cache Keyleri</span>
                    </h4>

                    <a href="#page_header" class="btn btn-light align-self-center collapsed d-lg-none border-transparent rounded-pill p-0 ms-auto" data-bs-toggle="collapse">
                        <i class="ph-caret-down collapsible-indicator ph-sm m-1"></i>
                    </a>
                </div>

                <div class="collapse d-lg-block my-lg-auto ms-lg-auto" id="page_header">
                    <div class="hstack gap-3 mb-3 mb-lg-0">



                        <a href="{{route('admin.setting.index')}}" class="btn btn-light">
                            <i class="ph-arrow-left me-1"></i>
                            Geri Dön
                        </a>
                    </div>
                </div>

            </div>
        </div>
        <div  class="content pt-0" >
            <div class="card">
                <table class="table table-xxs">
                    @foreach($keys as $item)
                        <tr>
                            <td>
                                {{$item}}
                            </td>
                            <td>
                                <a href="" class="badge bg-warning ml-2 bg-opacity-20 text-warning">Flush</a>
                                <a href="" class="badge bg-danger ml-2 bg-opacity-20 text-danger">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>



@endsection
