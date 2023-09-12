@if(0)
    <div class="dropdown-header">
        Contacts
        <a href="#" class="float-end">
            See all
            <i class="ph-arrow-circle-right ms-1"></i>
        </a>
    </div>

    <div class="dropdown-item cursor-pointer">
        <div class="me-3">
            <img src="{{asset('assets/admin/')}}/images/demo/users/face3.jpg" class="w-32px h-32px rounded-pill" alt="">
        </div>

        <div class="d-flex flex-column flex-grow-1">
            <div class="fw-semibold">Christ<mark>in</mark>e Johnson</div>
            <span class="fs-sm text-muted">c.johnson@awesomecorp.com</span>
        </div>

        <div class="d-inline-flex">
            <a href="#" class="text-body ms-2">
                <i class="ph-user-circle"></i>
            </a>
        </div>
    </div>


    <div class="dropdown-divider"></div>
@endif


    @if($reslut['pages'])
    @if(count($reslut['pages']) > 0)
        <div class="dropdown-header">
            Sayfalar
            <a href="{{route('admin.page.index')}}" class="float-end">
                Tümünü Gör
                <i class="ph-arrow-circle-right ms-1"></i>
            </a>
        </div>
        @foreach($reslut['pages'] as $page)
            <div data-href="{{$page->AdminEditUrl}}" class="dropdown-item cursor-pointer" onclick="window.location.href='{{$page->AdminEditUrl}}'">
                <div class="me-3">
                    <img src="{{$page->ImageCover}}" class="w-32px h-32px rounded-pill" alt="">
                </div>

                <div class="d-flex flex-column flex-grow-1">
                    <div class="fw-semibold">{{$page->title}}</div>
                    <span class="fs-sm text-muted">{{$page->deep_slug}}</span>
                </div>

                <div class="d-inline-flex">
                    <a href="{{$page->AdminEditUrl}}" class="text-body ms-2">
                        <i class="ph-briefcase"></i>
                    </a>
                </div>
            </div>
        @endforeach
    @endif

@endif


