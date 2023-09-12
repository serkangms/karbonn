@extends('admin.app')

@section('content')
    <div class="content-inner">

        <div class="page-header">
            <div class="page-header-content d-lg-flex">
                <div class="d-flex">
                    <h4 class="page-title mb-0">
                        Dosyalar
                    </h4>
                    <a href="#page_header" class="btn btn-light align-self-center collapsed d-lg-none border-transparent rounded-pill p-0 ms-auto" data-bs-toggle="collapse">
                        <i class="ph-caret-down collapsible-indicator ph-sm m-1"></i>
                    </a>
                </div>

                <div  class="collapse d-lg-block my-lg-auto ms-lg-auto" id="page_header" >
                    <input type="file" name="file" id="file" class="d-none">
                    <div></div>
                    <div class="d-sm-flex align-items-center mb-3 mb-lg-0 ms-lg-3">
                        <div class="d-inline-flex align-items-center">

                            <span
                                onclick="document.getElementById('file').click()"
                                href="{{route('admin.form.create')}}"
                               class="btn btn-primary  h-32px ">
                                <i class="ph-upload me-1"></i>
                                Yeni Dosya Yükle
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content pt-0">
           <div class="card">
               @foreach($files as $item)
                   <div class="card-body p-2 d-flex justify-content-between border-bottom item">
                       <div class="d-flex flex-row">
                           <div class="me-2">
                               @if($item->is_image)
                                   <img src="{{$item->Resize200}}" class="rounded bg-light" width="72">
                                   @else
                                   <div style="width: 72px;height: 72px" class="bg-light rounded d-flex justify-content-center align-items-center">
                                       <span>{{$item->extension}}</span>
                                   </div>
                               @endif
                           </div>
                           <div class="d-flex flex-column my-auto">
                               <div class="m-0 p-0">
                                   <span class="m-0 p-0 filename fw-medium">{{$item->orginal_name}}</span>
                               </div>
                               <div class="m-0 p-0">
                                   <a href="{{url($item->path)}}" class="m-0 p-0 text-muted">{{$item->path}}</a>
                               </div>
                               <div style="display: none" class="actions mt-1">
                                   <div class="d-flex flex-row" >
                                       <a href="{{downloadfile($item->id)}}" class="badge cursor-pointer me-2 bg-primary bg-opacity-20 text-primary">İndir</a>
                                       <span data-href="{{downloadfile($item->id)}}" class="badge cursor-pointer copyitem me-2  bg-success bg-opacity-20 text-success">İndirme Adresi Kopyala</span>
                                       <span data-href="{{url($item->path)}}" class="badge cursor-pointer copyitem  bg-success me-2 bg-opacity-20 text-success">Bağlantı Adresi Kopyala</span>
                                       <span data-name="{{$item->orginal_name}}" data-id="{{$item->id}}" class="badge cursor-pointer editname  bg-warning bg-opacity-20 text-warning">Dosya Adını Değiştir</span>
                                   </div>
                               </div>
                           </div>
                       </div>
                       <div class="pe-2 my-auto d-flex flex-column text-end">
                           <div>
                               Boyut: {{number_format($item->size,2)}} KB
                           </div>
                           <div>
                                 Yükleme Tarihi: {{$item->created_at->format('d.m.Y H:i')}}
                           </div>
                       </div>
                   </div>
               @endforeach


           </div>
            <div>
                <?php $paginator = $files; ?>
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center">
                        @if ($paginator->onFirstPage())
                            <li class="page-item disabled">
                                <a class="page-link"  style="font-weight: 600;"  tabindex="-1">Geri</a>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" style="font-weight: 600;"  href="{{ $paginator->previousPageUrl() }}">Geri</a>
                            </li>
                        @endif

                        {{-- Display links to specific pages --}}
                        @php
                            $maxPagesToShow = 4;
                            if ($paginator->lastPage() < $maxPagesToShow) {
                                $maxPagesToShow = $paginator->lastPage();
                            }
                            $middlePage = ceil($maxPagesToShow / 2);
                            $startPage = $paginator->currentPage() - $middlePage + 1;
                            $endPage = $startPage + $maxPagesToShow - 1;

                            if ($startPage < 1) {
                                $startPage = 1;
                                $endPage = $startPage + $maxPagesToShow - 1;
                            }

                            if ($endPage > $paginator->lastPage()) {
                                $endPage = $paginator->lastPage();
                                $startPage = $endPage - $maxPagesToShow + 1;
                            }

                            if ($startPage > 1) {
                                echo '<li class="page-item"><a class="page-link" style="font-weight: 600;"  href="' . $paginator->url(1) . '">1</a></li>';
                                if ($startPage > 2) {
                                    echo '<li class="page-item disabled"><a style="font-weight: 600;"  class="page-link" >...</a></li>';
                                }
                            }

                            for ($page = $startPage; $page <= $endPage; $page++) {
                                if ($page == $paginator->currentPage()) {
                                    echo '<li class="page-item active"><a class="page-link " style="font-weight: 600;" >' . $page . '</a></li>';
                                } else {
                                    echo '<li class="page-item"><a style="font-weight: 600;" class="page-link" href="' . $paginator->url($page) . '">' . $page . '</a></li>';
                                }
                            }

                            if ($endPage < $paginator->lastPage()) {
                                if ($endPage < $paginator->lastPage() - 1) {
                                    echo '<li class="page-item disabled"><a style="font-weight: 600;"  class="page-link" href="#">...</a></li>';
                                }
                                echo '<li class="page-item"><a class="page-link" style="font-weight: 600;"  href="' . $paginator->url($paginator->lastPage()) . '">' . $paginator->lastPage() . '</a></li>';
                            }
                        @endphp

                        @if ($paginator->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" style="font-weight: 600;"  href="{{ $paginator->nextPageUrl() }}" rel="next">İleri</a>
                            </li>
                        @endif
                    </ul>
                </nav>

            </div>
        </div>
    </div>

    <script>
        var element;

        $(document).ready(function () {
            $('.item').hover(function () {
                $(this).find('.actions').show();
            },function () {
                $(this).find('.actions').hide();
            })

            $('.copyitem').click(function () {
                var $temp = $("<input>");
                $("body").append($temp);
                $temp.val($(this).data('href')).select();
                document.execCommand("copy");
                $temp.remove();
                Swal.fire({
                    icon: 'success',
                    title: 'Bağlantı Kopyalandı',
                    showConfirmButton: false,
                    toast: true,
                    timer: 1500
                })
            })

            $('.editname').click(function (){
                var name = $(this).data('name');
                var id = $(this).data('id');
                element = $(this).parent('.item').find('.filename');


                Swal.fire({
                    title: 'Dosya Adını Değiştir',
                    html: `<input id="swal-input1" name="name" class="form-control" value="${name}"><span class="text-muted">Dosya Uzantısını Değiştirmeyin</span>`,
                    showCancelButton: true,
                    customClass: {
                        confirmButton: 'btn btn-primary',
                        cancelButton: 'btn btn-outline-danger ms-1'
                    },
                    confirmButtonText: 'Kaydet',
                    cancelButtonText: 'İptal',
                    showLoaderOnConfirm: true,
                    preConfirm: (name) => {
                        return fetch(`{{route('admin.filemanager.update')}}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{csrf_token()}}'
                            },
                            body: JSON.stringify({
                                name: $('#swal-input1').val(),
                                id: id
                            })
                        })
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error(response.statusText)
                                }
                                return response.json()
                            })
                            .catch(error => {
                                Swal.showValidationMessage(
                                    `İşlem Başarısız: ${error}`
                                )
                            })
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Dosya Adı Değiştirildi',
                            showConfirmButton: false,
                            toast: true,
                            timer: 1500
                        }).then(function () {
                            element.text($('#swal-input1').val());
                        })

                    }
                })


            })

            $('#file').change(function (){
                var url = '{{route('uploadfile')}}';
                var file = $(this)[0].files[0];
                var formData = new FormData();
                formData.append('file',file);
                formData.append('_token','{{csrf_token()}}');
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (data){
                        Swal.fire({
                            icon: 'success',
                            title: 'Dosya Yüklendi',
                            showConfirmButton: false,
                            toast: true,
                            timer: 1500
                        }).then(function () {
                            location.reload();
                        })
                    },
                    error: function (data){
                        Swal.fire({
                            icon: 'error',
                            title: 'Dosya Yüklenemedi',
                            showConfirmButton: false,
                            toast: true,
                            timer: 1500
                        })
                    }
                })
            })
        })
    </script>

@endsection



