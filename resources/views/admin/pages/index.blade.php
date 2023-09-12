@extends('admin.app')

@section('content')

    <script src="//cdn.jsdelivr.net/npm/sortablejs@1.8.4/Sortable.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/Vue.Draggable/2.20.0/vuedraggable.umd.min.js"></script>

    <div class="content-inner" id="app">

        <div class="page-header">
            <div class="page-header-content d-lg-flex">
                <div class="d-flex">
                    <h4 class="page-title mb-0">
                        İçerikler
                    </h4>
                    <a href="#page_header" class="btn btn-light align-self-center collapsed d-lg-none border-transparent rounded-pill p-0 ms-auto" data-bs-toggle="collapse">
                        <i class="ph-caret-down collapsible-indicator ph-sm m-1"></i>
                    </a>
                </div>



                <div class="collapse d-lg-block my-lg-auto ms-lg-auto" id="page_header">
                    <div></div>
                    <div class="d-sm-flex align-items-center mb-3 mb-lg-0 ms-lg-3">
                        <div class="d-inline-flex align-items-center">

                            <a :href="'{{route('admin.page.create')}}/' + parent_id"
                               class="btn btn-primary  h-32px ">
                                <i class="ph-plus me-1"></i>
                                Yeni Öğe Ekle
                            </a>

                            <div class="dropdown ms-2">
                                <a href="#" class="btn btn-light btn-icon w-32px h-32px " data-bs-toggle="dropdown">
                                    <i class="ph-dots-three-vertical"></i>
                                </a>

                                <div class="dropdown-menu dropdown-menu-end">
                                    <button type="button" class="dropdown-item">
                                        <i class="ph-briefcase me-2"></i>
                                        Customer details
                                    </button>
                                    <button type="button" class="dropdown-item">
                                        <i class="ph-folder-user me-2"></i>
                                        User directory
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content pt-0">
            <div class="mb-2 d-flex justify-content-between">
                <div class="my-auto">
                    <div class="breadcrumb">
                        <a  @click="parent_id = 0"  class="breadcrumb-item cursor-pointer py-2">Tüm Sayfalar</a>
                        <a v-for="item in parent_map" @click="parent_id = item.id" :class="item.id == parent_id ? 'text-muted ' : 'text-primary' " class="breadcrumb-item cursor-pointer py-2">@{{item.title}}</a>
                    </div>
                </div>
                <div class="d-flex flex-row">
                    <div class="my-auto me-2">
                        <select v-model="per_page" class="form-select fs-sm h-32px">
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                            <option value="500">500</option>
                        </select>
                    </div>
                    <div class="my-auto">
                        <input type="text" class="form-control h-32px" placeholder="Ara.." v-model="search">
                    </div>
                </div>
            </div>
            <div v-if="!onload" >
                <div v-if="pages.length">
                    <draggable     handle=".handle" @end="onDragEnd" v-model="pages" :options="{group:'pages'}">
                        <div v-for="page in pages" :key="page.id"  class="card  mb-2">
                            <div class="card-body p-1 pe-2">
                                <div class="row">
                                    <div class="d-flex col-md-6 flex-row">
                                        <div>
                                            <img :src="page.image_url"  style="height: 50px; width: 50px;" class="me-2 rounded">
                                        </div>
                                        <div class="d-flex my-auto flex-column">
                                            <span class="fs-lg-5 fw-medium text-wrap">@{{page.title}}</span>
                                            <a :href="page.SiteUrl" target="_blank" class="text-primary text-decoration-none">
                                                <span class="text-muted">@{{page.deep_slug}}</span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-2 my-auto">
                                        <div class="d-flex flex-row  ">
                                            <div v-for="translation in page.translations" :key="translation.id"
                                                 :class="translation.status == 1 ? 'bg-success text-success' : 'bg-danger text-danger' "
                                                 class="badge  bg-opacity-20 fw-bold p-1 me-2">
                                                <span>@{{translation.locale}}</span>
                                                <div class="form-check cursor-pointer form-switch ms-2 form-check-custom form-check-solid">
                                                    <input
                                                        :checked="translation.status == 1 ? true : false"
                                                        @change="updateStatus(translation, $event)"
                                                        class="form-check-input cursor-pointer " type="checkbox" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 my-auto d-flex justify-content-end">
                                        <div class="d-flex flex-row">

                                            <div class="my-auto me-2 handle">
                                                @{{ page.sort_order }}
                                                <i class="ph-arrows-vertical fs-2 text-muted cursor-move"></i>
                                            </div>

                                            <a  v-if="page.parent_id" @click="parent_id = page.parent.parent_id" class="btn btn-sm  btn-icon me-2 btn-primary ">
                                                <i class="ph ph-arrow-fat-line-left fs-2 "></i>
                                            </a>


                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                    İşlemler
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                    <li><a class="dropdown-item" :href="page.AdminEditUrl">Düzenle</a></li>
                                                    <li><a @click="copyItem(page.id)" class="dropdown-item" >Kopyala</a></li>
                                                    <li><a @click="deleteItem(page.AdminDeleteUrl)" class="dropdown-item swalConfirmUrl cursor-pointer" >Sil</a></li>
                                                </ul>
                                            </div>

                                            <a v-show="!parent_page || parent_page.only_one_child != 1"
                                               @click="parent_id = page.id" class="btn btn-sm  btn-icon ms-2 btn-primary ">
                                                <i class="ph-arrow-fat-line-right fs-2 "></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </draggable>

                    <div class="mt-3 d-flex justify-content-between align-items-center flex-wrap" v-if="total > per_page">
                        <ul class="pagination pagination-outline" >
                            <li class="page-item cursor-pointer" v-if="current_page != 1">
                                <a @click="current_page = 1" class="page-link">1</a>
                            </li>
                            <li v-if="current_page > 2 && current_page <= last_page - 2" class="page-item disabled" >
                                <a class="page-link">...</a>
                            </li>

                            <li class="page-item cursor-pointer"
                                :class="{'active': current_page === page}"
                                v-for="page in visiblePages" :key="page">
                                <a @click="current_page = page" class="page-link">@{{ page }}</a>
                            </li>

                            <li v-if="last_page > visiblePages.length && current_page != last_page" class="page-item disabled" >
                                <a class="page-link">...</a>
                            </li>

                            <li class="page-item cursor-pointer" v-if="current_page != last_page">
                                <a @click="current_page = last_page" class="page-link">@{{ last_page }}</a>
                            </li>
                        </ul>
                        <div class="d-flex flex-row pe-4">
                            <div class="me-2">
                                <select v-model="per_page" class="form-select fs-sm h-32px">
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </div>
                            <div class="my-auto">
                                <span>@{{ total }} Kayıt</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-else>
                    <div class="card">
                        <div class="card-body">
                            Hiçbir sonuç bulunamadı.
                        </div>
                    </div>
                </div>
            </div>
            <div v-else>
                <div  class="card  mb-2" v-for="index in 9">
                    <div class="card-body p-2 pe-2">
                        <div class="placeholder-glow d-flex flex-column">
                            <span class="placeholder mb-1 p-1 w-75" ></span>
                            <span class="placeholder w-25"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <script type="text/javascript">
        var app = new Vue({
            el: '#app',
            data: {
                search: '',
                per_page: 25,
                parent_id: '{{ $parent_id }}',
                pages: [],
                total: 0,
                last_page: 0,
                current_page: 0,
                parent_map: [],
                parent_page: null,
                onload: true,
                max_visible_pages: 10
            },
            computed : {
                last_page() {
                    return Math.ceil(this.total / this.per_page);
                },
                visiblePages() {
                  //set max_visible_pages
                    if (this.last_page <= this.max_visible_pages) {
                        return Array.from({ length: this.last_page }, (_, i) => i + 1);
                    }

                    const startPage = Math.max(
                        1,
                        Math.min(
                            this.current_page - Math.floor(this.max_visible_pages / 2),
                            this.last_page - this.max_visible_pages + 1
                        )
                    );
                    return Array.from({ length: this.max_visible_pages }, (_, i) => startPage + i);
                }
            },
            methods: {
                fetchPages: function() {
                    var vm = this;
                    vm.onload = true;
                    axios.post('/admin/page/fetch', {
                        search: vm.search,
                        page: vm.current_page,
                        per_page: vm.per_page,
                        parent_id: vm.parent_id,
                    })
                        .then(function(response) {
                            vm.pages = response.data.pages.data;
                            vm.total = response.data.pages.total;
                            vm.last_page = response.data.pages.last_page;
                            vm.current_page = response.data.pages.current_page;
                            vm.parent_map = response.data.parent_map;
                            vm.parent_page = response.data.parent_map[0];
                            vm.onload = false;
                        })
                        .catch(function(error) {
                            console.log(error);
                        });
                },
                updateStatus: function(translation, event) {
                    var vm = this;
                    axios.post('/admin/page/updateStatus', {
                        id: translation.id,
                        status: translation.status,
                    })
                        .then(function(response) {
                            if (response.data.status == 'success'){
                                toastr.success(response.data.message);
                            }else{
                                toastr.error(response.data.message);
                                event.target.checked = !event.target.checked;
                                return false;
                            }
                        })
                        .catch(function(error) {
                            console.log(error);
                        });

                    //change status
                    if (translation.status == 1) {
                        translation.status = 0;
                    } else {
                        translation.status = 1;
                    }
                },
                deleteItem: function(url) {
                    Swal.fire({
                        html: 'Bu kaydı silmek istediğinizden emin misiniz?',
                        icon: "warning",
                        buttonsStyling: false,
                        showCancelButton: true,
                        confirmButtonText: "Evet, sil!",
                        cancelButtonText: 'Hayır, iptal et!',
                        customClass: {
                            confirmButton: "btn btn-primary",
                            cancelButton: 'btn btn-danger'
                        },
                    }).then(function (result) {
                        if (result.isConfirmed) {
                            url = url+'?isAjax=true';
                            axios.get(url)
                                .then(function(response) {
                                    if (response.data.status == 'success'){
                                        Swal.fire({
                                            icon: 'success',
                                            html: response.data.message,
                                            toast: true,
                                            position: 'top-end',
                                            showConfirmButton: false,
                                        })
                                       // app.fetchPages();
                                    }else{
                                        toastr.error(response.data.message);
                                        return false;
                                    }
                                })
                                .catch(function(error) {
                                    console.log(error);
                                });
                        }
                    });
                },
                copyItem: function (pageid) {
                    axios.post('/admin/page/clonepage', {
                        pageid: pageid,
                    })
                        .then(function(response) {
                            if (response.data.status == 'success'){
                                toastr.success(response.data.message);
                                app.fetchPages();
                            }else{
                                toastr.error(response.data.message);
                                return false;
                            }
                        })
                        .catch(function(error) {
                            console.log(error);
                        });
                },
                onDragEnd() {
                    var vm = this;
                    var data = [];

                    vm.pages.forEach(function(page, index) {
                        vm.pages[index].sort_order = index + 1;
                        data.push({
                            id: page.id,
                            sort_order: index + 1,
                        });
                    });

                    axios.post('/admin/page/updateOrder', {
                        data: data,
                    })
                        .then(function(response) {
                            if (response.data.status == 'success'){
                                Swal.fire({
                                    icon: 'success',
                                    html: response.data.message,
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                })
                            }else{
                                Swal.fire({
                                    icon: 'error',
                                    html: response.data.message,
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                })
                                return false;
                            }
                        });
                },
            },
            mounted() {
                this.current_page = 1;
            },
            watch: {
                search: function(val) {
                    if (val.length > 2 || val.length === 0) {
                        this.fetchPages();
                    }
                },
                per_page: function(val) {
                    this.fetchPages();
                },
                parent_id: function(val) {
                    this.search = '';
                    this.fetchPages();
                },
                current_page: function(val) {
                    this.fetchPages();
                },
            },
        });


    </script>
@endsection
