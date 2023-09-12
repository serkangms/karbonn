@extends('admin.app')

@section('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <div class="content-inner">

        <div class="page-header">
            <div class="page-header-content d-lg-flex">
                <div class="d-flex">
                    <h4 class="page-title mb-0">
                        Kullanıcı Düzenle
                    </h4>
                    <a href="#page_header" class="btn btn-light align-self-center collapsed d-lg-none border-transparent rounded-pill p-0 ms-auto" data-bs-toggle="collapse">
                        <i class="ph-caret-down collapsible-indicator ph-sm m-1"></i>
                    </a>
                </div>

                <div class="collapse d-lg-block my-lg-auto ms-lg-auto" id="page_header">
                    <div></div>
                    <div class="d-sm-flex align-items-center mb-3 mb-lg-0 ms-lg-3">
                        <div class="d-inline-flex align-items-center">

                            <a href="{{route('admin.user.index')}}"
                               class="btn btn-light  h-32px ">
                                <i class="ph-arrow-left me-1"></i>
                                Tüm Kullanıcılar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="content pt-0">

            <form class="card" method="post" action="{{route('admin.user.update',$user->id)}}">
                @csrf
                <div class="card-header p-1">
                    <h6 class="mb-0">Genel Bilgiler</h6>
                </div>

                <div class="card-body p-2 border-bottom">
                    <label for="">İsim</label>
                    <input name="name" type="text" class="form-control" value="{{$user->name}}">
                </div>

                <div class="card-body p-2 border-bottom">
                    <label for="">E-Posta</label>
                    <input name="email" type="text" class="form-control" value="{{$user->email}}">
                </div>

                <div class="card-body p-2 border-bottom">
                    <label for="">Telefon</label>
                    <input name="phone" type="text" class="form-control" value="{{$user->phone}}">
                </div>

                <div class="form-group delete p-2" >
                    <label >Görsel</label>
                    <div class="d-flex flex-column p-2">

                        <input type="hidden" id="imageValue" name="image_id" value="{{ $user->image_id }}">

                        @if($user->image_id)
                            <div>
                                <img data-target-show="imageShow" data-target-value="imageValue" id="imageShow" src="{{url($user->userImage->path)}}" class="img-fluid selectImage cursor-pointer" style="height: 100px; width: 150px;">
                            </div>
                        @else
                            <div>
                                <img data-target-show="imageShow" data-target-value="imageValue" id="imageShow" class="selectImage cursor-pointer" src="">
                            </div>
                        @endif

                        <div>

                            <button type="button" id="removeButton" class="btn bg-light mt-2 fs-lg fw-medium  btn-sm " onclick="removeImage()">Görseli Kaldır</button>
                            <button type="button" data-target-show="imageShow" data-target-value="imageValue" class="btn bg-light mt-2 fs-lg fw-medium selectImage btn-sm ">Görsel Seç</button>
                        </div>
                    </div>


                </div>


                <div class="card-body p-2 ">
                    <button class="btn btn-primary">Kaydet</button>
                </div>
            </form>

            <form method="post" class="card mt-4" action="{{route('admin.user.update.password',$user->id)}}">
                @csrf
                <div class="card-header p-1">
                    <h6 class="mb-0">Şifre</h6>
                </div>
                <div class="card-body p-2 border-bottom">
                    <label for="">Şifre</label>
                    <input type="password"  name="old_password" class="form-control" >
                </div>
                <div class="card-body p-2 border-bottom">
                    <label for="">Yeni Şifre</label>
                    <input type="password"  name="password" class="form-control" >
                </div>
                <div class="card-body p-2 border-bottom">
                    <label for="">Yeni Şifre Tekrar</label>
                    <input  type="password"  name="password_confirmation" class="form-control" >
                </div>
                <div class="card-body p-2 ">
                    <button class="btn btn-primary">Kaydet</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        function removeImage() {
            document.getElementById('imageShow').src = '';
            document.getElementById('imageValue').value = '';
            saveImageToDatabase(null);


        }

        function saveImageToDatabase(imageId) {
            if (imageId) {
                $.ajax({
                    url: "{{route('admin.user.update',$user->id)}}",
                    type: "POST",
                    data: {
                        image_id: imageId,
                        _token: '{{csrf_token()}}'
                    },
                    success: function (response) {
                        console.log(response);
                    }
                })
            }

        }
    </script>


    <script>
        $(document).ready(function() {
            $('.select2').select2();

        });
    </script>
@endsection



