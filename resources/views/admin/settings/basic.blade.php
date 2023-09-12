@extends('admin.app')

@section('content')
    <div class="content-inner">
        <div class="page-header">
            <div class="page-header-content d-lg-flex">
                <div class="d-flex">
                    <h4 class="page-title mb-0">
                        Ayarlar - <span class="fw-normal">Site Ayarları</span>
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
        <form method="post" class="content pt-0" action="{{route('admin.setting.update')}}">
            @csrf
            <div class="card p-0 tab-content">
                <div class="card-header d-sm-flex pt-0 ">
                    <ul class="nav nav-tabs nav-tabs-underline card-header-tabs ">
                        <li class="nav-item my-auto fs-lg fw-bold me-1 ps-2">
                            <div class="p-2">
                                Parametreler
                            </div>
                        </li>
                        @if(isset($setting->global))
                            @else
                            @foreach($setting as $locale => $vals)
                                <li class="nav-item">
                                    <a href="#tab{{ $locale }}" class="nav-link {{ $loop->first ? 'active' : '' }}" data-bs-toggle="tab">
                                        <img src="{{asset('assets/media/flags/'.getLang($locale)->flag.'.png')}}" class="h-16px me-2" alt=""> {{getLang($locale)->native}}
                                    </a>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>

                @if(isset($setting->global))
                    @foreach($setting->global as $key => $value)
                         @php $settingItem = DB::table('site_configs')->where('code', $code)->where('key', $key)->first(); @endphp
                        @if($settingItem->enum)
                                <?php $options = json_decode($settingItem->enum); ?>
                            <div class="card-body p-2">
                                <label class="fw-medium">{{$settingItem->name ?? $key}}</label>
                                <select class="form-select" name="{{$code}}|{{$key}}">
                                    @foreach($options as $option)
                                        <option value="{{$option}}" @if($option == $value) selected @endif>{{$option}}</option>
                                    @endforeach
                                </select>
                            </div>
                        @else
                            @if($settingItem->is_file)
                                <div class="p-2 d-flex flex-column">
                                    <label class="fw-medium fs-lg">{{$settingItem->name ?? $key}}</label>
                                    <input type="hidden" name="{{$code}}|{{$key}}" id="imgval{{ $loop->index }}" value="{{$value}}">
                                    <img
                                        style="max-height: 200px; max-width: 25%; object-fit: contain;min-height: 200px";
                                        class="img-fluid p-1 bg-light rounded cursor-pointer selectImage w-100" id="coverimg{{ $loop->index }}"
                                        data-thumbnail="full" data-target-value="imgval{{ $loop->index }}" data-target-show="coverimg{{ $loop->index }}"
                                        @if($value)
                                            src="{{ getFilesUrl($value)  }}"
                                        @else
                                            src="{{asset('assets/images/noimage.jpg')}}"
                                        @endif
                                    >
                                </div>
                            @else
                                @if($settingItem->is_textarea)
                                    <div class="card-body p-2">
                                        <label class="fw-medium">{{$settingItem->name ?? $key}}</label>
                                        <textarea class="form-control" style="height: 180px;" name="{{$code}}|{{$key}}">{{$value}}</textarea>
                                    </div>
                                @else
                                    <div class="card-body p-2">
                                        <label class="fw-medium">{{$settingItem->name ?? $key}}</label>
                                        <input type="text" class="form-control" name="{{$code}}|{{$key}}" value="{{$value}}">
                                    </div>
                                @endif
                            @endif
                        @endif
                    @endforeach
                @endif

                @foreach(activeLangs() as $locale)
                    @if(isset($setting->{$locale}))
                        <div class="tab-pane fade  {{ $loop->first ? 'show active' : '' }} " id="tab{{ $locale }}">
                            @foreach($setting->{$locale} as $key => $value)
                                    <?php $settingItem = DB::table('site_configs')->where('code', $code)->where('key', $key)->first(); ?>
                                @if($settingItem->enum)
                                        <?php $options = json_decode($settingItem->enum); ?>
                                    <div class="card-body p-2">
                                        <label class="fw-medium">{{$locale}} {{$settingItem->name ?? $key}}</label>
                                        <select class="form-select" name="{{$code}}|{{$key}}|{{$locale}}">
                                            @foreach($options as $option)
                                                <option value="{{$option}}" @if($option == $value) selected @endif>{{$option}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @else
                                    @if($settingItem->is_file)
                                        <div class="p-2 d-flex flex-column">
                                            <label class="fw-medium fs-lg">{{$locale}} {{$settingItem->name ?? $key}}</label>
                                            <input type="hidden" name="{{$code}}|{{$key}}|{{$locale}}" id="imgval{{ $loop->index.$locale }}" value="{{$value}}">
                                            <img
                                                style="max-height: 200px; max-width: 25%; object-fit: contain;min-height: 200px";
                                                class="img-fluid p-1 bg-light rounded cursor-pointer selectImage w-100" id="coverimg{{ $loop->index.$locale }}"
                                                data-thumbnail="full" data-target-value="imgval{{ $loop->index.$locale }}" data-target-show="coverimg{{ $loop->index.$locale }}"
                                                @if($value)
                                                    src="{{ getFilesUrl($value)  }}"
                                                @else
                                                    src="{{asset('assets/images/noimage.jpg')}}"
                                                @endif
                                            >
                                        </div>
                                    @else
                                        @if($settingItem->is_textarea)
                                            <div class="card-body p-2">
                                                <label class="fw-medium">{{$locale}}  {{$settingItem->name ?? $key}}</label>
                                                <textarea class="form-control" style="height: 180px;" name="{{$code}}|{{$key}}|{{$locale}}">{{$value}}</textarea>
                                            </div>
                                        @else
                                            <div class="card-body p-2">
                                                <label class="fw-medium">{{$locale}}  {{$settingItem->name ?? $key}}</label>
                                                <input type="text" class="form-control" name="{{$code}}|{{$key}}|{{$locale}}" value="{{$value}}">
                                            </div>
                                        @endif
                                    @endif
                                @endif
                            @endforeach
                        </div>
                    @endif
                @endforeach

            </div>

            <div>
                <button class="btn btn-primary">Kaydet</button>
            </div>


        </form>
    </div>


@endsection
