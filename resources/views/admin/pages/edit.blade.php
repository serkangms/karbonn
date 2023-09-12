@extends('admin.app')

@section('content')

    <script src="{{asset('assets/admin/')}}/js/vendor/ui/prism.min.js"></script>
    <script src="{{asset('assets/admin/')}}/js/vendor/media/glightbox.min.js"></script>


    <div class="content-inner" id="app">
        <div class="page-header">
            <div class="page-header-content d-lg-flex">
                <div class="d-flex">
                    <div class="page-title">
                        <h5 class="m-0">
                            İçerik Yönetimi
                        </h5>
                        <div class="breadcrumb m-0">
                            <a href="{{route('admin.page.index')}}" class="breadcrumb-item">
                                İçerikler
                            </a>
                            @foreach($page->UpperCategories as $item)
                                <a href="{{route('admin.page.index',$item->id)}}" class="breadcrumb-item">{{tr_ucwords($item->title)}}</a>
                            @endforeach
                        </div>
                    </div>
                    <a href="#page_header" class="btn btn-light align-self-center collapsed d-lg-none border-transparent rounded-pill p-0 ms-auto" data-bs-toggle="collapse">
                        <i class="ph-caret-down collapsible-indicator ph-sm m-1"></i>
                    </a>
                </div>

                <div class="collapse d-lg-block my-lg-auto ms-lg-auto" id="page_header">
                    <div></div>
                    <div class="d-sm-flex align-items-center mb-3 mb-lg-0 ms-lg-3">
                        <div class="d-inline-flex align-items-center">

                            <a href="javascript:history.back()" class="btn btn-light  h-32px ">
                                <i class="ph-arrow-left me-2"></i>
                                Geri Dön
                            </a>

                            <div class="dropdown ms-2">
                                <a href="#" class="btn btn-light btn-icon w-32px h-32px " data-bs-toggle="dropdown">
                                    <i class="ph-dots-three-vertical"></i>
                                </a>

                                @if($page->id)
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a
                                            data-bs-toggle="modal" data-bs-target="#modal_developer_setting"
                                            type="button" class="dropdown-item">
                                            <i class="ph ph-code-simple me-2"></i>
                                            Geliştirici Seçenekleri
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="kt_app_content_container" class="app-container  container-xxl " :key="activelang">

            <div class="row">
                <div class="col-md-9">
                    <div class="card card-flush mb-3 " v-if="sections.title || sections.description || sections.summary || sections.gallery">
                        <div class="card-header p-2">
                            <h6 class="mb-0">Genel Bilgiler</h6>
                        </div>
                        <div class="card-body p-2">
                            <div class="" v-if="sections.title">
                                <label class="form-label">Sayfa Adı</label>
                                <input v-model="pageTranslations[activelang].title" class="form-control  mb-3" type="text" placeholder="Sayfa Adı" >
                            </div>

                            <div class="mb-3" v-if="sections.summary">
                                <label class="form-label">Özet</label>
                                <vue-editor v-model="pageTranslations[activelang].summary"></vue-editor>
                            </div>

                            <div class="mb-3" v-if="sections.description">
                                <label class="form-label">İçerik</label>
                                <vue-editor v-model="pageTranslations[activelang].description"></vue-editor>
                            </div>

                            <div class="mb-10" v-if="sections.gallery">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label">Galeri</label>
                                    <div>
                                        <span data-max-select-count="5" data-target-func="addGalleryItem" class="fs-lg badge bg-opacity-10 bg-success text-success fw-medium cursor-pointer addImage">
                                            <i class="ph-plus me-1"></i>
                                            Galeri Öğe Ekle
                                        </span>
                                    </div>
                                </div>

                                <div v-if="1" class="row">
                                    <div class="col-sm-6 col-xl-3" v-for="(item, filekey) in pageTranslations[activelang].gallery">
                                        <div class="card">
                                            <div class="card-img-actions mx-1 mt-1">
                                                <div v-if="item.file.is_image">
                                                    <img class="card-img img-fluid" :src="item.file.url" style="height: 150px; object-fit: cover;" alt="">
                                                </div>
                                                <div v-else>
                                                    <div v-if="item.coverfile">
                                                        <img class="card-img img-fluid" :src="item.coverfile.url" style="height: 150px; object-fit: cover;" alt="">
                                                    </div>
                                                    <div v-else class="d-flex justify-content-center align-items-center" style="height: 130px;">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <i class="ph-file-image fs-2 text-muted"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="bg-light" v-if="!item.file.is_image" >
                                                <button v-if="item.coverfile"
                                                        @click="item.coverfile = null"
                                                        class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary btn-icon-color-muted rounded-circle ms-2">
                                                    <i class="ph-trash me-2"></i>
                                                    Kapak Görselini Kaldır
                                                </button>
                                                <button v-else
                                                    :data-target-func-param="filekey"
                                                    data-max-select-count="1" data-target-func="addCoverItem" type="button" class="btn addImage btn-sm btn-icon btn-bg-light btn-active-color-primary btn-icon-color-muted rounded-circle ms-2">
                                                    <i class="ph-image me-2"></i>
                                                    Kapak Görseli Seç
                                                </button>

                                            </div>

                                            <div class="card-body p-1">
                                                <div class="d-flex align-items-start flex-nowrap">
                                                    <div>
                                                        <input type="text" class="form-control fs-sm form-control-sm" v-model="item.name" placeholder="Başlık">
                                                    </div>

                                                    <div class="d-inline-flex my-auto">
                                                        <a
                                                            @click="removeGalleryItem(key)"
                                                            class="text-body cursor-pointer ms-2 me-1"><i class="ph-trash"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="card mb-3 " v-if="meta">
                        <div class="card-header p-2">
                            <h6 class="mb-0">Sayfa Bileşenleri</h6>
                        </div>

                        <div class="card-body p-1 pt-0 tab-content" >
                            <div class="p-2 " v-for="(item, key, index) in meta" :key="index">

                                <div v-if="item.type != 'array'" class="mb-1 d-flex justify-content-between">
                                    <label class="my-auto fw-medium" >@{{item.label}}</label>
                                </div>

                                <input v-if="item.type == 'text'" type="text" class="form-control " v-model="data[activelang][key]">
                                <input v-if="item.type == 'date'" type="date" class="form-control " v-model="data[activelang][key]">

                                <div v-if="item.type == 'longtext'" >
                                    <textarea  class="form-control "  v-model="data[activelang][key]"></textarea>
                                </div>

                                <div v-if="item.type == 'richtext'" >
                                    <vue-editor v-model="data[activelang][key]"></vue-editor>
                                </div>

                                <div v-if="item.type == 'image'">
                                    <div class=" d-flex flex-column">
                                        <input type="hidden" :id="'image'+index" v-model="data[activelang][key]">
                                        <div v-if="!data[activelang][key].id">
                                            <div class="card cursor-pointer addImage w-25 p-3" style="border: 1px dashed #ccc;" data-max-select-count="1" data-target-func="setImage" :data-target-func-param="activelang + '.' + key">
                                                Dosya Seç
                                            </div>
                                        </div>
                                        <div v-else>
                                            <img
                                                v-if="data[activelang][key].is_image"
                                                :src="asseturl+data[activelang][key].path"
                                                class="img-fluid p-1 bg-light rounded cursor-pointer addImage  object-fit-cover"
                                                data-max-select-count="1" data-target-func="setImage" :data-target-func-param="activelang + '.' + key"
                                                style="height: 200px;width: 200px;object-fit: contain;"
                                            >
                                            <div v-else>
                                                <div class="p-2 bg-light rounded w-50">
                                                    <i class="ph ph-file text-muted"></i>
                                                    @{{data[activelang][key].name}}
                                                </div>
                                            </div>
                                            <div class="d-flex mt-1 flex-row">
                                                <span data-max-select-count="1" data-target-func="setImage" :data-target-func-param="activelang + '.' + key" class="addImage me-2 cursor-pointer">
                                                    <i class="ph-pencil"></i>
                                                </span>
                                                <span @click="data[activelang][key] = []" class="cursor-pointer text-danger">
                                                    <i class="ph-trash"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div v-if="item.type == 'select'">
                                    <select class="form-select" v-model="data[activelang][key]">
                                        <option value="">Seçiniz</option>
                                        <option v-for="(option, index) in item.options" :value="option.value">@{{option.label}}</option>
                                    </select>
                                </div>

                                <div v-if="item.type == 'array'" >
                                    <div class="border border-2 border-dashed rounded p-2 mb-2">
                                        <div class="mb-1 d-flex justify-content-between">
                                            <label class="my-auto fs-5 fw-bold " >@{{item.label}}</label>
                                            <span v-if="item.type == 'array'" class="badge bg-success bg-opacity-20 text-success cursor-pointer fw-medium fs-lg" @click="pushOrNew(key,metaToEmptyData(item))">Yeni Öğe Ekle</span>
                                        </div>

                                        <div class="p-3">
                                            <div v-for="(subdata,subkey,index) in data[activelang][key]" class="card border-3 mb-4 border border-dashed  " :key="index">
                                                <div class="p-2">
                                                    <div class="rounded d-flex bg-light justify-content-between p-1">
                                                        <div>
                                                            <span v-show="subkey != 0" @click="moveUp(key,subkey)" class="ph-arrow-square-up ps-1 me-2  cursor-pointer"></span>
                                                            <span v-show="subkey != data[activelang][key].length - 1" @click="moveDown(key,subkey)" class="ph-arrow-square-down  cursor-pointer"></span>
                                                        </div>
                                                        <div class="my-auto">
                                                            <span class="fs-lg fw-medium ">@{{subkey + 1}}. Öğe</span>
                                                        </div>
                                                        <span class="badge bg-danger bg-opacity-20 text-danger cursor-pointer" @click="data[activelang][key].splice(subkey,1)">Öğeyi Sil</span>
                                                    </div>
                                                </div>

                                                <div class="border-1  border-gray-300 p-2 border-bottom" v-for="(itemsub, keysub, index) in item.items" :key="data[activelang][key][subkey]">
                                                    <label >@{{itemsub.label}}  </label>
                                                    <input v-if="itemsub.type == 'text'" type="text" class="form-control" v-model="data[activelang][key][subkey][keysub]">
                                                    <textarea v-if="itemsub.type == 'longtext'" class="form-control" v-model="data[activelang][key][subkey][keysub]"></textarea>
                                                    <div v-if="itemsub.type == 'richtext'" >
                                                        <vue-editor v-model="data[activelang][key][subkey][keysub]" ></vue-editor>
                                                    </div>

                                                    <div v-if="itemsub.type == 'image'">
                                                        <div class="border-bottom d-flex flex-column">
                                                            <input type="hidden" :id="'image'+index" v-model="data[activelang][key][subkey][keysub]">
                                                            <div v-if="!data[activelang][key][subkey][keysub].id">
                                                                <div class="card cursor-pointer addImage w-25 p-3" style="border: 1px dashed #ccc;" data-max-select-count="1" data-target-func="setImage" :data-target-func-param="activelang + '.' + key + '.' + subkey + '.' + keysub">
                                                                    Dosya Seç
                                                                </div>
                                                            </div>
                                                            <div v-else>
                                                                <img
                                                                    v-if="data[activelang][key][subkey][keysub].is_image"
                                                                    :src="asseturl+data[activelang][key][subkey][keysub].path"
                                                                    class="img-fluid p-1 bg-light rounded cursor-pointer addImage  object-fit-cover"
                                                                    data-max-select-count="1" data-target-func="setImage" :data-target-func-param="activelang + '.' + key + '.' + subkey + '.' + keysub"
                                                                    style="height: 200px;width: 200px;object-fit: contain;"
                                                                >
                                                                <div v-else>
                                                                    <div class="p-2 bg-light rounded w-50 cursor-pointer addImage" data-max-select-count="1" data-target-func="setImage" :data-target-func-param="activelang + '.' + key + '.' + subkey + '.' + keysub">
                                                                        <i class="ph ph-file text-muted"></i>
                                                                        @{{data[activelang][key][subkey][keysub].name}}
                                                                    </div>
                                                                </div>
                                                                <div class="d-flex mt-1 flex-row">
                                                                    <span data-max-select-count="1" data-target-func="setImage"
                                                                          :data-target-func-param="activelang + '.' + key + '.' + subkey + '.' + keysub"
                                                                          class="addImage me-2 cursor-pointer"><i class="ph-pencil"></i></span>
                                                                    <span @click="data[activelang][key][subkey][keysub] = {}"
                                                                          class="cursor-pointer text-danger"><i class="ph-trash"></i></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-center mb-2">
                                                <span v-if="item.type == 'array'" class="badge bg-success bg-opacity-20 text-success cursor-pointer fw-medium fs-lg" @click="data[activelang][key].push(metaToEmptyData(item))">
                                                    @{{item.label}} son'a için öğe ekle
                                                </span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>


                    <div class="card" v-if="sections.seo">
                        <div class="card-header p-2">
                            <h6 class="mb-0">Meta</h6>
                        </div>

                        <div class="card-body p-2">
                           <div class="row">
                               <div class="col-md-6">
                                   <div class="mb-2">
                                       <label>Meta Tag URL</label>
                                       <div class="input-group input-group-sm">
                                           <select v-model="pageTranslations[activelang].use_custom_slug" class="form-select w-auto flex-grow-0">
                                               <option value="0">Otomatik</option>
                                               <option value="1">Özel</option>
                                           </select>
                                           <input
                                               :disabled="pageTranslations[activelang].use_custom_slug == 0"
                                               v-model="pageTranslations[activelang].deep_slug" type="text" class="form-control" >
                                       </div>
                                   </div>
                                   <div class="mb-2">
                                       <label >Meta Tag Title</label>
                                       <input type="text" class="form-control form-control-sm mb-2" v-model="pageTranslations[activelang].meta_title">
                                   </div>
                                   <div class="mb-2">
                                       <label >Meta Tag Description</label>
                                       <textarea class="form-control form-control-sm" v-model="pageTranslations[activelang].meta_description" rows="2"></textarea>
                                   </div>
                               </div>
                               <div class="col-md-6 my-auto">
                                   <div class="my-auto card p-2">
                                       <div class="d-flex flex-column my-auto">
                                           <div class="d-flex mb-1 flex-row">
                                               <div class="bg-light p-1 my-auto me-2 rounded-pill">
                                                   <img src="<?php echo getFilesUrl(siteconfigLocaled('site.favico'))?>" class="img-fluid w-32px h-32px rounded" alt="">
                                               </div>
                                               <div class="d-flex flex-column">
                                                   <span>karbonayakizihesapla.com.tr</span>
                                                   <span id="spn1" class="text-success">@{{ pageTranslations[activelang].deep_slug }}</span>
                                               </div>
                                           </div>
                                           <div>
                                               <span class="text-primary fw-bold fs-lg">@{{ pageTranslations[activelang].meta_title }}</span>
                                               <span class="text-primary fw-bold fs-lg">{{siteconfigLocaled('site.meta_title_end_tag')}}</span>
                                           </div>
                                           <span id="spn3" class="fs-sm">@{{ pageTranslations[activelang].meta_description }}</span>
                                       </div>
                                   </div>
                               </div>
                           </div>
                        </div>
                    </div>

                </div>

                <div class="col-md-3">

                    <div class="card p-2" v-if="locales.length > 1">
                        <div class="d-flex flex-row gap-2 ">
                            @foreach($locales as $locale)
                                <button class="btn w-100" @click="activelang = '{{ $locale }}'"  :class="{'btn-primary': activelang == '{{ $locale }}', 'btn-light': activelang != '{{ $locale }}'}">
                                    <img class="rounded-1 w-24px me-1" src="{{asset('')}}assets/media/flags/{{getLang($locale)->country_name}}.svg" alt="">
                                    {{getLang($locale)->native}}
                                </button>
                            @endforeach
                        </div>
                    </div>


                    <div class="card card-flush">
                        <div class="card-header p-2">
                            <h6 class="mb-0">Ayarlar</h6>
                        </div>


                        <div class="card-body p-2">
                            <div class="d-flex flex-column ">
                                <div class="mb-1">
                                    <div class="d-flex justify-content-between">
                                        <label class="form-label">Durum</label>
                                        <div class="">
                                            <div v-show="pageTranslations[activelang].status == '1'" class="rounded-circle bg-success w-15px h-15px" ></div>
                                            <div v-show="pageTranslations[activelang].status == '0'" class="rounded-circle bg-danger w-15px h-15px" ></div>
                                            <div v-show="pageTranslations[activelang].status == '2'" class="rounded-circle bg-warning w-15px h-15px" ></div>
                                        </div>
                                    </div>
                                    <select
                                        v-model="pageTranslations[activelang].status"
                                        class="form-select mb-2"  data-placeholder="Durum Seçiniz" >
                                        <option>Seçiniz</option>
                                        <option value="1">Aktif</option>
                                        <option value="0">Pasif</option>
                                        <option value="2">Planlı</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Yayın Tarihi</label>
                                    <input v-model="pageTranslations[activelang].publish_date" type="datetime-local" class="form-control" name="publish_date" placeholder="Yayın Tarihi" />
                                </div>

                                <div class="mb-2">
                                    <label class="form-label">Sayfa Düzeni</label>
                                    <select
                                        v-model="page.layout"
                                        class="form-select mb-2"  data-placeholder="Durum Seçiniz" >
                                        <option>Seçiniz</option>
                                        <option value="full">Full</option>
                                        <option value="subitems">Menü ve Altiçerik</option>
                                        <option value="menu">Tek Menü</option>
                                        <option value="fullmenu">Üst Menü</option>
                                    </select>
                                </div>

                                <div class="mb-2" v-show="page.layout == 'fullmenu'">
                                    <label class="form-label">Üst Sayfa Menü</label>
                                    <select
                                        v-model="page.parent_menu"
                                        class="form-select mb-2"  data-placeholder="Durum Seçiniz" >
                                        <option>Seçiniz</option>
                                        <option v-for="item in pageData.parents" :value="item.id" >@{{ item.title }}</option>
                                    </select>
                                </div>

                                <div class="mb-3" v-show="page.layout == 'menu'">
                                    <label class="form-label">Menü Adı</label>
                                    <input v-model="pageTranslations[activelang].menu_text" type="text" class="form-control" placeholder="Menü Adı" />
                                </div>

                                <div class="mb-0" v-if="sections.image">
                                    <label class="form-label">Sayfa Görseli</label>
                                    <div class="mb-3 d-flex justify-content-center">
                                        <img
                                            :src="pageTranslations[activelang].image_id ? asseturl+pageTranslations[activelang].image_url : noimage"
                                            class="img-fluid p-1 bg-light rounded cursor-pointer addImage"
                                            style="object-fit: cover; width: 200px; height: 200px;object-fit: contain;"
                                            data-max-select-count="1" data-target-func="setPageImage"  >
                                    </div>
                                    <div v-if="pageTranslations[activelang].image_id" class="d-flex justify-content-center">
                                        <button @click="removePageImage" type="button" class="btn btn-sm btn-danger">Görseli Kaldır</button>
                                    </div>
                                </div>

                                <div class="mb-0" v-if="sections.image">
                                    <label class="form-label">Liste Görseli</label>
                                    <div class="mb-3 d-flex justify-content-center">
                                        <img
                                            :src="pageTranslations[activelang].list_image_id ? asseturl+pageTranslations[activelang].list_image_url : noimage"
                                            class="img-fluid p-1 bg-light rounded cursor-pointer addImage"
                                            style="object-fit: cover; width: 200px; height: 200px;object-fit: contain;"
                                            data-max-select-count="1" data-target-func="setListImage"  >
                                    </div>
                                    <div v-if="pageTranslations[activelang].list_image_id" class="d-flex justify-content-center">
                                        <button @click="removeListImage" type="button" class="btn btn-sm btn-danger">Görseli Kaldır</button>
                                    </div>
                                </div>

                                <div class="mb-2">
                                    <label class="form-label">Form</label>
                                    <select
                                        v-model="pageTranslations[activelang].form_id"
                                        class="form-select mb-2" >
                                        <option>Seçiniz</option>
                                        @foreach(\App\Models\Form::all() as $form)
                                            <option value="{{$form->id}}">{{$form->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <button @click="save" type="button" class="btn btn-lg fw-bold fs-lg btn-success">Kaydet</button>
                    </div>
                </div>
            </div>

        </div>


        <div id="modal_developer_setting" class="modal fade" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Geliştirici Seçenekleri</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="alert alert-warning">
                            <div class="d-flex flex-row gap-2">
                                <div class="flex-shrink-0">
                                    <div class="rounded-circle bg-warning w-15px h-15px"></div>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="fw-bold">Geliştirici Seçenekleri</div>
                                    <div class="fs-sm">Dikkat ! Bu seçenekler sadece geliştirici tarafından kullanılmalıdır.</div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="row mb-2">
                                <div class="col-md-4">
                                    <div class="mb-2">
                                        <label class="mb-1">Custom View</label>
                                        <input type="text" class="form-control" v-model="page.template" placeholder="Custom View" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-2">
                                        <label class="mb-1">Custom Child View</label>
                                        <input type="text" class="form-control" v-model="page.child_template" placeholder="Custom View" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-2">
                                        <label class="mb-1">Sayfa Tipi</label>
                                        <select class="form-select" v-model="page.type">
                                            @foreach(config('constants.page.type') as $key => $item)
                                                <option value="{{$key}}">{{$item['title']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-2">
                                        <label class="mb-1">Sadece Bileşen Menüsünde Göster</label>
                                        <select class="form-select" v-model="page.component_only">
                                            <option value="0">Hayır</option>
                                            <option value="1">Evet</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-2">
                                        <label class="mb-1">Bileşen Adı</label>
                                        <input type="text" class="form-control" v-model="page.component_name" placeholder="Bileşen Adı" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-2">
                                        <label class="mb-1">Menü'de alt öğeleri gizle</label>
                                        <select class="form-select" v-model="page.hide_menu_sub_items">
                                            <option value="0">Hayır</option>
                                            <option value="1">Evet</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-2">
                                        <label class="mb-1">Panel Metin</label>
                                        <input type="text" class="form-control" v-model="page.sidebar_text" placeholder="Sidebar Adı" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Listeleme Başlık Yerine Göster</label>
                                    <select class="form-select" v-model="page.list_dom_replace_1">
                                        <option value="">Seç</option>
                                        <option v-for="(item,index) in child_meta" v-if="item.type != 'array' && item.type != 'image'" :value="index">@{{ item.label }}</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label>Listeleme Slug Yerine Göster</label>
                                    <select class="form-select" v-model="page.list_dom_replace_2">
                                        <option value="">Seç</option>
                                        <option v-for="(item,index) in child_meta"  v-if="item.type != 'array' && item.type != 'image'" :value="index">@{{ item.label }}</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label >Listeleme Görsel Yerine Göster</label>
                                    <select class="form-select" v-model="page.list_dom_replace_3">
                                        <option value="">Seç</option>
                                        <option v-for="(item,index) in child_meta"  v-if="item.type == 'image'" :value="index">@{{ item.label }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div>
                           <div class="row">
                               <div class="col-md-6">
                                   <label>Meta</label>
                                   <pre class="language-javascript mb-3">
										<code>
                                             @{{ page.meta }}
                                        </code>
                                   </pre>
                                   <input type="text" class="form-control" v-model="page.meta" placeholder="Meta" />
                               </div>
                               <div class="col-md-6">
                                   <label>Child Meta</label>
                                   <pre class="language-javascript mb-3">
										<code>
                                             @{{ page.child_meta }}
                                        </code>
                                   </pre>
                                   <input type="text" class="form-control" v-model="page.child_meta" placeholder="Child Meta" />
                               </div>
                           </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{asset('/assets/')}}/cdn/build/ckeditor.js"></script>
    <script>

        var CkEditor = Vue.component('vue-editor', {
            props: [
                'value',
            ],
            template: '<textarea></textarea>',
            methods: {
                updateValue: function(value) {
                    this.$emit('input', value);
                }
            },
            mounted: function() {
                var self = this;
                ClassicEditor.create(this.$el, {
                    toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'undo', 'redo' , 'sourceEditing' ],
                    allowedContent: true,
                    htmlSupport: {
                        allow: [
                            {
                                name: /h2/,
                                attributes: true,
                                classes: true,
                                styles: true,
                                comments: true,
                                elements: true,
                                other: true
                            },
                            {
                                name: /span/,
                                attributes: true,
                                classes: true,
                                styles: true,
                                comments: true,
                                elements: true,
                                other: true
                            },
                            {
                                name: /div/,
                                attributes: true,
                                classes: true,
                                styles: true,
                                comments: true,
                                elements: true,
                                other: true
                            },
                            {
                                name: /p/,
                                attributes: true,
                                classes: true,
                                styles: true,
                                comments: true,
                                elements: true,
                                other: true
                            },
                            {
                                name: /img/,
                                attributes: true,
                                classes: true,
                                styles: true,
                                comments: true,
                                elements: true,
                                other: true
                            },
                            {
                                name: /a/,
                                attributes: true,
                                classes: true,
                                styles: true,
                                comments: true,
                                elements: true,
                                other: true
                            },
                            {
                                name: /ul/,
                                attributes: true,
                                classes: true,
                                styles: true,
                                comments: true,
                                elements: true,
                                other: true
                            },
                            {
                                name: /li/,
                                attributes: true,
                                classes: true,
                                styles: true,
                                comments: true,
                                elements: true,
                                other: true
                            },
                            {
                                name: /table/,
                                attributes: true,
                                classes: true,
                                styles: true,
                                comments: true,
                                elements: true,
                                other: true
                            },
                            {
                                name: /tr/,
                                attributes: true,
                                classes: true,
                                styles: true,
                                comments: true,
                                elements: true,
                                other: true
                            },
                            {
                                name: /td/,
                                attributes: true,
                                classes: true,
                                styles: true,
                                comments: true,
                                elements: true,
                                other: true
                            },
                            {
                                name: /th/,
                                attributes: true,
                                classes: true,
                                styles: true,
                                comments: true,
                                elements: true,
                                other: true
                            },
                            {
                                name: /tbody/,
                                attributes: true,
                                classes: true,
                                styles: true,
                                comments: true,
                                elements: true,
                                other: true
                            },
                            {
                                name: /thead/,
                                attributes: true,
                                classes: true,
                                styles: true,
                                comments: true,
                                elements: true,
                                other: true
                            },
                            {
                                name: /tfoot/,
                                attributes: true,
                                classes: true,
                                styles: true
                            },
                            {
                                name: /b/,
                                attributes: true,
                                classes: true,
                                styles: true,
                                comments: true,
                                elements: true,
                                other: true
                            },
                        ]
                    },
                }).then(editor => {
                    editor.model.document.on('change:data', () => {
                        self.$emit('input', editor.getData());
                    });
                    //setData
                    editor.setData(self.value);
                }).catch(error => {
                    console.error(error);
                });
            }
        });

        var QuilEditor = Vue.component('quill-editor', {
            props: [
                'value',
            ],
            template: '<div></div>',
            methods: {
                updateValue: function(value) {
                    this.$emit('input', value);
                }
            },
            mounted: function() {
                var self = this;
                var toolbarOptions = [
                    ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
                    ['blockquote', 'code-block'],

                    [{ 'header': 1 }, { 'header': 2 }],               // custom button values
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    [{ 'script': 'sub'}, { 'script': 'super' }],      // superscript/subscript
                    [{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent
                    [{ 'direction': 'rtl' }],                         // text direction

                    [{ 'size': ['small', false, 'large', 'huge'] }],  // custom dropdown
                    [{ 'header': [1, 2, 3, 4, 5, 6, false] }],

                    [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
                    [{ 'font': [] }],
                    [{ 'align': [] }],

                    ['clean']                                         // remove formatting button
                ];
                var options = {
                    modules: {
                        toolbar: [
                            [{
                                header: [1, 2, false]
                            }],
                            ['bold', 'italic', 'underline'],
                            ['image', 'code-block']
                        ]
                    },
                    placeholder: 'Type your text here...',
                    theme: 'snow' // or 'bubble'
                };
                var editor = new Quill(this.$el, options);
                editor.on('text-change', function(delta, oldDelta, source) {
                    self.$emit('input', editor.root.innerHTML);
                });
                editor.root.innerHTML = self.value;
            },
            watch: {
                lang: function(newLang, oldLang) {
                    // Dil değiştiğinde editör içeriğini güncelle
                    var editor = ClassicEditor.editorRegistry.get(this.$el);
                    editor.setData(this.value);
                }
            }
        });

        var app = new Vue({
            el: '#app',
            components: {
                'vue-editor': CkEditor,
                'quill-editor': QuilEditor,
            },
            data: {
                page: @json($page),
                pageData: @json($pageData),
                activelang : 'tr',
                meta : {!! $meta !!},
                child_meta : {!! $page->child_meta ?? '[]' !!},
                data :  @json($page_meta_data),
                pageTranslations : @json($pageData['translations']),
                asseturl : '{{asset('')}}',
                noimage : '{{asset('')}}assets/media/svg/files/blank-image.svg',
                parentPage : @json($parentPage),
                sections : @json($sections),
                locales : @json($locales),
            },
            methods: {
                pushOrNew(key,veri){

                    if(this.data[this.activelang][key] == undefined || this.data[this.activelang][key] == null || this.data[this.activelang][key].length == 0){
                        this.data[this.activelang][key] = [];
                    }
                    this.data[this.activelang][key].unshift(veri);
                },
                metaToEmptyData(veri){
                    var donusVeri = {};
                    for (const anahtar in veri.items) {
                        donusVeri[anahtar] = "";
                    }
                    return donusVeri;
                },
                moveDown(data,index){
                    var vm = this;
                    if(index == vm.data[vm.activelang][data].length - 1){
                        return;
                    }
                    vm.data[vm.activelang][data].splice(index + 1, 0, vm.data[vm.activelang][data].splice(index, 1)[0]);
                    //veu editörü güncelle
                    VueEditor.updateValue();
                },
                moveUp(data,index) {
                    var vm = this;
                    if(index == 0){
                        return;
                    }
                    vm.data[vm.activelang][data].splice(index - 1, 0, vm.data[vm.activelang][data].splice(index, 1)[0]);
                },
                save() {
                    //swall loading
                    Swal.fire({
                        title: 'Kaydediliyor...',
                        html: 'Lütfen bekleyiniz',
                        allowOutsideClick: false,
                        confirmButton : false,
                        showConfirmButton: false,
                        onBeforeOpen: () => {
                            Swal.showLoading()
                        },
                    });

                    axios.post('{{route('admin.page.update')}}', {
                        page_id: '{{ $page->id }}',
                        data: this.data,
                        pagetranslations : this.pageTranslations,
                        page : this.page,
                        locales : this.locales,
                    })
                        .then(function (response) {
                            Swal.close();
                            // location.reload();
                            if(response.data.status == 'error'){
                                Swal.fire({
                                    icon: 'error',
                                    title: response.data.message,
                                    showConfirmButton: false,
                                    toast: true,
                                    timer: 1500,
                                    position: 'top-right',
                                })
                            }

                            if(response.data.status == 'success'){
                                Swal.fire({
                                    icon: 'success',
                                    html: response.data.message,
                                    showConfirmButton: false,
                                    toast: true,
                                    timer: 1500,
                                    position: 'top-right',
                                })

                                if(response.data.mode == 'create'){
                                    window.location.href = response.data.redirectUrl;
                                }
                            }
                        });
                },
                removeGalleryItem(key){
                    var vm = this;
                    vm.pageTranslations[vm.activelang].gallery.splice(key, 1);
                },
                removePageImage(){
                    var vm = this;
                    vm.pageTranslations[vm.activelang].image_id = null;
                    vm.pageTranslations[vm.activelang].image_url = null;
                },
                removeListImage(){
                    var vm = this;
                    vm.pageTranslations[vm.activelang].list_image_id = null;
                    vm.pageTranslations[vm.activelang].list_image_url = null;
                },
            }
        })


        function setImage(data,stack){;
            var vm = app;
            var stack = stack.split('.');
            var data = data[0];


            if(stack.length === 2){
                if(vm.data[stack[0]][stack[1]]){
                    vm.data[stack[0]][stack[1]] = data;
                }else{
                    vm.$set(vm.data[stack[0]], stack[1], data);
                }
            }
            else
                vm.data[stack[0]][stack[1]][stack[2]][stack[3]] = data;
        }

        function setPageImage(data) {
            var vm = app;
            vm.pageTranslations[vm.activelang].image_id = data[0].id;
            vm.pageTranslations[vm.activelang].image_url = data[0].path;
        }

        function setListImage(data) {
            var vm = app;
            vm.pageTranslations[vm.activelang].list_image_id = data[0].id;
            vm.pageTranslations[vm.activelang].list_image_url = data[0].path;
        }

        function addGalleryItem(data) {
            var vm = app;
            if(vm.pageTranslations[vm.activelang].gallery == null){
                vm.$set(vm.pageTranslations[vm.activelang], 'gallery', []);
            }

            for (var i = 0; i < data.length; i++){
                let newGalleryItem = {
                    name : data[i].orginal_name,
                    file : data[i],
                    coverfile : null,
                };
                vm.pageTranslations[vm.activelang].gallery.push(newGalleryItem);
            }
        }

        function addCoverItem(data,key) {
            var vm = app;
            vm.pageTranslations[vm.activelang].gallery[key].coverfile = data[0];
        }

    </script>
@endsection
