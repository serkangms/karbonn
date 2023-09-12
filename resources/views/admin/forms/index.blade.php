@extends('admin.app')

@section('content')
    <div class="content-inner">

        <div class="page-header">
            <div class="page-header-content d-lg-flex">
                <div class="d-flex">
                    <h4 class="page-title mb-0">
                        Formlar
                    </h4>
                    <a href="#page_header" class="btn btn-light align-self-center collapsed d-lg-none border-transparent rounded-pill p-0 ms-auto" data-bs-toggle="collapse">
                        <i class="ph-caret-down collapsible-indicator ph-sm m-1"></i>
                    </a>
                </div>

                <div class="collapse d-lg-block my-lg-auto ms-lg-auto" id="page_header">
                    <div></div>
                    <div class="d-sm-flex align-items-center mb-3 mb-lg-0 ms-lg-3">
                        <div class="d-inline-flex align-items-center">

                            <a href="{{route('admin.form.create')}}"
                               class="btn btn-primary  h-32px ">
                                <i class="ph-plus me-1"></i>
                                Yeni Form Oluştur
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content pt-0">
           <div class="row">
               @foreach($forms as $item)
                   <div class="col-md-6">
                       <div class="card">
                           <div class="card-body p-2 d-flex justify-content-between">
                               <div class="my-auto">
                                   <span class="fw-medium fs-lg">{{$item->name}}</span>
                               </div>
                               <div>
                                   <a
                                       data-href="{{route('admin.form.delete',$item->id)}}"
                                       type="button" class="btn btn-flat-danger swc btn-sm">
                                       <i class="ph-trash me-2"></i>
                                       Sil
                                   </a>
                                   <a
                                        href="{{route('admin.form.submissions',$item->id)}}"
                                       type="button" class="btn btn-flat-primary btn-sm">
                                       <i class="ph-eye me-2"></i>
                                       Başvurular
                                   </a>
                                   <a
                                       href="{{route('admin.form.edit',$item->id)}}"
                                       type="button" class="btn btn-flat-success btn-sm">
                                       <i class="ph-pen me-2"></i>
                                       Düzenle
                                   </a>
                               </div>
                           </div>
                       </div>
                   </div>
               @endforeach
           </div>
        </div>
    </div>

@endsection



