@extends('admin.app')

@section('content')
    <div class="content-inner">

        <div class="page-header">
            <div class="page-header-content d-lg-flex">
                <div class="d-flex">
                    <h4 class="page-title mb-0">
                        Kullanıcılar
                    </h4>
                    <a href="#page_header" class="btn btn-light align-self-center collapsed d-lg-none border-transparent rounded-pill p-0 ms-auto" data-bs-toggle="collapse">
                        <i class="ph-caret-down collapsible-indicator ph-sm m-1"></i>
                    </a>
                </div>

                <div class="collapse d-lg-block my-lg-auto ms-lg-auto" id="page_header">
                    <div></div>
                    <div class="d-sm-flex align-items-center mb-3 mb-lg-0 ms-lg-3">
                        <div class="d-inline-flex align-items-center">

                            <a href="{{route('admin.user.create')}}"
                               class="btn btn-primary  h-32px ">
                                <i class="ph-plus me-1"></i>
                                Yeni Kullanıcı Oluştur
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content pt-0">
            <div class="card">
                @foreach($users as $item)
                    <div class="card-body d-flex justify-content-between border-bottom p-2">
                        <div class="d-flex align-items-center">
                            <div class="">
                                {{$item->name}}
                            </div>
                            <span class="badge cursor-pointer me-2 bg-success bg-opacity-75 ms-4">{{$item->role}}</span>
                        </div>
                        <div>
                            <a href="{{route('admin.user.edit',$item->id)}}" class="badge cursor-pointer me-2 bg-primary bg-opacity-20 text-primary">Düzenle</a>
                            <a href="{{route('admin.user.delete',$item->id)}}"  onclick="confirmDelete(event)" class="badge cursor-pointer me-2 bg-danger bg-opacity-20 text-danger">Sil</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

@endsection

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script>

<script>
    function confirmDelete(event) {
        event.preventDefault();

        Swal.fire({
            title: 'Emin misiniz?',
            text: "Bu işlemi geri alamayacaksınız!",
            icon: '',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Evet, sil!',
            cancelButtonText: 'İptal',
            reverseButtons: true
        }).then(result => {
            if (result.isConfirmed) {
                window.location.href = event.target.getAttribute('href');
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                Swal.fire(
                    "Cancelled",
                    "Your imaginary file is safe :)",
                    "error"
                )
            }
        });
    }

</script>
