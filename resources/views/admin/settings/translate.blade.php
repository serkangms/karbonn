@extends('admin.app')

@section('content')
    <div class="content-inner">
        <div class="page-header">
            <div class="page-header-content d-lg-flex">
                <div class="d-flex">
                    <h4 class="page-title mb-0">
                        Ayarlar - <span class="fw-normal">Dil Ayarları</span>
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
        <div class="content pt-0">

            <div class="card">
                <table class="table table-xxs table-bordered">
                    <tr>
                        <td>
                            <input type="text" name="key" class="form-control form-control-sm" placeholder="Key">
                        </td>
                        @foreach(config('translatable.locales') as $locale)
                            <td>
                                <input type="text" name="{{$locale}}" class="form-control form-control-sm" placeholder="{{$locale}}">
                            </td>
                        @endforeach
                        <td style="width: 1%;">
                            <button type="button" class="btn btn-sm saveLang btn-success">Ekle</button>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="card">
                <table class="table table-xxs table-bordered">
                    <tr>
                        <th>
                            Key
                        </th>
                        @foreach(config('translatable.locales') as $locale)
                            <th>
                                {{$locale}}
                            </th>
                        @endforeach
                        <th></th>
                    </tr>
                    @foreach($langData as $key => $item)
                        <tr>
                            <td>
                                <input type="text" value="{{$key}}" class="form-control form-control-sm" name="key">
                            </td>
                            @foreach($item as $key2 => $item2)
                                <td>
                                    <input type="text" value="{{$item2}}" class="form-control form-control-sm" name="{{$key2}}">
                                </td>
                            @endforeach
                            <td style="width: 1%;">
                                <button type="button" class="btn btn-sm saveLang btn-primary">Kaydet</button>
                            </td>
                        </tr>
                    @endforeach
                </table>

            </div>
        </div>
    </div>

    <script>
        //.saveLang click
        $('.saveLang').click(function () {
            var data = $(this).parents('tr').find('input').serialize();
            var url = '{{route('admin.setting.language.update')}}';
            $.ajax({
                type: 'POST',
                url: url,
                data: data,
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    if (data.status == 'success') {
                        Swal.fire({
                            icon: 'success',
                            text: data.message,
                            showConfirmButton: false,
                            timer: 800,
                            toast: true,
                            position: 'top-end',
                        })
                    }
                    if (data.status == 'error') {
                        Swal.fire({
                            icon: 'error',
                            text: data.message,
                            showConfirmButton: false,
                            timer: 800,
                            toast: true,
                            position: 'top-end',
                        })
                    }
                }
            });
        });
    </script>

@endsection
