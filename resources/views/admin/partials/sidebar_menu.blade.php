<div class="sidebar-content">

    <div class="sidebar-section">
        <ul class="nav nav-sidebar" data-nav-type="accordion">

            <!-- Main -->
            <li class="nav-item-header">
                <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">Main</div>
                <i class="ph-dots-three sidebar-resize-show"></i>
            </li>


            <li class="nav-item">
                <a href="{{route('admin.panel')}}" class="nav-link">
                    <i class="ph-house"></i>
                    <span>Panel</span>
                </a>
            </li>



            @foreach(\App\Models\Page::where('sidebar_text','!=',null)->get() as $item)
                <li class="nav-item">
                    <a href="{{route('admin.page.index',$item)}}" class="nav-link">
                        <i class="ph-circle"></i>
                        <span>{{$item->sidebar_text}}</span>
                    </a>
                </li>
            @endforeach




                <li class="nav-item">
                    <a href="{{ route('admin.Contact.index') }}" class="nav-link">
                        <i class="ph-clipboard-text"></i>
                        <span>İletişim</span>
                    </a>
                </li>
            <li class="nav-item">
                <a href="{{route('admin.ContactCarbon')}}" class="nav-link">
                    <i class="ph-house"></i>
                    <span>Karbon Formu</span>
                </a>
            </li>

                <li class="nav-item">
                <a href="{{route('admin.page.index')}}" class="nav-link">
                    <i class="ph-clipboard-text"></i>
                    <span>İçerikler</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{route('admin.component.index')}}" class="nav-link">
                    <i class="ph-codesandbox-logo"></i>
                    <span>Bileşenler</span>
                </a>
            </li>



            <li class="nav-item">
                <a href="{{route('admin.filemanager.index')}}" class="nav-link">
                    <i class="ph-folder"></i>
                    <span>Dosyalar</span>
                </a>
            </li>


            <li class="nav-item">
                <a href="{{route('admin.user.index')}}" class="nav-link">
                    <i class="ph-user"></i>
                    <span>Kullanıcılar</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{route('admin.setting.index')}}" class="nav-link">
                    <i class="ph-gear"></i>
                    <span>Ayarlar</span>
                </a>
            </li>

            <li class="nav-item d-none">
                <a href="{{route('admin.blank')}}" class="nav-link">
                    <i class="ph-list-numbers"></i>
                    <span>Blank</span>
                    <span class="badge bg-primary align-self-center rounded-pill ms-auto">4.0</span>
                </a>
            </li>
        </ul>
    </div>

</div>
