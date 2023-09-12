@extends('admin.app')

@section('content')
    <div class="content-inner">

        <div class="page-header">
            <div class="page-header-content d-lg-flex">
                <div class="d-flex">
                    <h4 class="page-title mb-0">
                        Başvuru Detayları
                    </h4>
                    <a href="#page_header" class="btn btn-light align-self-center collapsed d-lg-none border-transparent rounded-pill p-0 ms-auto" data-bs-toggle="collapse">
                        <i class="ph-caret-down collapsible-indicator ph-sm m-1"></i>
                    </a>
                </div>

                <div class="collapse d-lg-block my-lg-auto ms-lg-auto" id="page_header">
                    <div></div>
                    <div class="d-sm-flex align-items-center mb-3 mb-lg-0 ms-lg-3">
                        <div class="d-inline-flex align-items-center">

                            <a href="{{route('admin.form.submissions',$submission->form_id)}}"
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
               <div class="card-header">
                   <h6 class="mb-0">Başvuru Detayları</h6>
               </div>

               @foreach($submission->AnswersFormat as $key => $item)
                   <div class="card-body border-bottom p-2 d-flex flex-row">
                       <div class="w-25">
                           {{$key}}
                       </div>
                       <div>
                           @if($item['type'] == 'file')
                               <a target="_blank" href="{{url('storage/form_submits/'.$item['val'])}}">{{$item['orginalName']}}</a>
                               @else
                               {{$item['val']}}
                           @endif
                       </div>
                   </div>
               @endforeach
               <div class="card-body p-2 d-flex flex-row">
                   <div class="w-25">
                       Başvuru Tarihi
                   </div>
                   <div>
                          {{$submission->created_at}}
                   </div>
               </div>

           </div>
            <a  class="text-danger cursor-pointer swc" data-href="{{route('admin.form.submissionDelete',$submission->id)}}">Başvuruyu Sil</a>
        </div>
    </div>

@endsection



