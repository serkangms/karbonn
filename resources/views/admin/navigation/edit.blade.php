@extends('admin.app')

@section('content')


    <?php

    function getCategories($parent_id = 0, $user_tree_array = '', $depth = 0)
    {
        if (!is_array($user_tree_array))
            $user_tree_array = array();

        $categories = \App\Models\NavigationItem::where('parent_id', $parent_id)->orderBy('sort_order', 'asc')->get();

        if ($categories) {
            $depth++;
            foreach ($categories as $category) {
                $user_tree_array[] = array(
                    "id" => $category->id,
                    "name" => $category->name,
                    "page_id" => $category->page_id,
                    "depth" => $depth,
                    "sort_order" => $category->sort_order,
                    "parent_id" => $category->parent_id,
                    "url" => $category->url,
                    "childrenCnt" => \App\Models\NavigationItem::where('parent_id', $category->id)->count(),
                );
                $user_tree_array = getCategories($category->id, $user_tree_array, $depth);
            }
        }
        return $user_tree_array;
    }

    ?>

    <script src="{{asset('assets/admin/')}}/js/vendor/forms/selects/select2.min.js"></script>


    <div class="content-inner">

        <div class="page-header">
            <div class="page-header-content d-lg-flex">
                <div class="d-flex">
                    <h4 class="page-title mb-0">
                        Ayarlar
                    </h4>
                    <a href="#page_header" class="btn btn-light align-self-center collapsed d-lg-none border-transparent rounded-pill p-0 ms-auto" data-bs-toggle="collapse">
                        <i class="ph-caret-down collapsible-indicator ph-sm m-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="content pt-0">
            <div class="row">
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">Menü öğeleri ekle</h6>
                        </div>

                        <form method="post" class="card-body p-2" action="{{route('admin.navigation.store')}}">
                            @csrf
                            <input type="hidden" name="navigation_id" value="{{$navigation->id}}">
                            <div>
                                <span>Üst Menü</span>
                                <select class="form-select" name="parent_id">
                                    <option value="">Üst Menü</option>
                                    @foreach($navigation->itemsAll->where('locale',$locale) as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mt-2">
                                <span>Sayfa</span>
                                <select id="pageseact" class="form-control "
                                        data-placeholder="Sayfa seçiniz"
                                        name="page_id" data-minimum-input-length="2" data-minimum-results-for-search="Infinity"></select>
                            </div>
                            <div class="mt-2">
                                <span>URL</span>
                                <input  type="text" class="form-control mt-1" name="url" placeholder="Url">
                            </div>
                            <div class="mt-2">
                                <span>Metin</span>
                                <input type="text" class="form-control mt-1" name="text" placeholder="Metin">
                            </div>
                            <div class="mt-2">
                                <span>Sıra</span>
                                <input type="number" class="form-control mt-1" name="sort_order" placeholder="Sıra">
                            </div>
                            <div class="d-grid gap-2 mt-1">
                                <button class="btn btn-primary mt-2">Ekle</button>
                                <input type="hidden" name="locale" value="{{$locale}}">
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="d-flex justify-content-between mb-2">
                        <div class="mb-2 my-auto">
                            <span class="fw-bold fs-lg">Menü yapısı</span>
                        </div>
                        <div>
                            @foreach(activeLangs() as $lang)
                                <a href="{{route('admin.navigation.edit',[$navigation->id,$lang])}}"
                                   class="btn btn-sm btn-outline-secondary @if($locale == $lang) active @endif">
                                    {{$lang}} Menü</a>
                            @endforeach
                        </div>
                    </div>
                    @foreach($map as $item)
                        <div class="card mb-2">
                            <div class="card-body p-1 d-flex flex-row justify-content-between align-items-center">
                                <div>
                                    <span>{{$item->name}} <span  class="text-muted sortorder fs-sm">{{$item->sort_order}}</span></span>
                                </div>
                                <div  class="d-flex" data-id="{{$item->id}}">

                                    <a data-href="{{route('admin.navigation.delete',$item->id)}}" class="badge cursor-pointer me-2 swc bg-danger bg-opacity-20 text-danger">Sil</a>
                                    <a
                                        data-id="{{$item->id}}"
                                        data-parentid="{{$item->parent_id}}"
                                        data-name="{{$item->name}}"
                                        data-url="{{$item->url}}"
                                        data-pageid="{{$item->page_id}}"
                                        data-text="{{$item->text}}"
                                        data-sortorder="{{$item->sort_order}}"
                                        class="badge cursor-pointer edititem bg-success bg-opacity-20 text-success">Düzenle</a>
                                </div>
                            </div>
                        </div>
                            <?php $subCategories = getCategories($item->id); ?>
                        <div class="parentor" data-parentid="{{$item->id}}">
                            @foreach($subCategories as $subCategory)
                                <div class="card items sortdepth_{{$subCategory['depth']}} mb-2" data-depth="{{$subCategory['depth']}}" style="margin-left: {{$subCategory['depth']*25}}px">
                                    <div class="card-body p-1 d-flex flex-row justify-content-between align-items-center">
                                        <div>
                                            <span>-> {{$subCategory['name']}} <span  class="text-muted sortorder fs-sm">{{$subCategory['sort_order']}}</span></span>
                                        </div>
                                        <div  class="d-flex" data-id="{{$subCategory['id']}}">

                                            <a data-href="{{route('admin.navigation.delete',$subCategory['id'])}}" class="badge cursor-pointer me-2 swc bg-danger bg-opacity-20 text-danger">Sil</a>
                                            <a
                                                data-id="{{$subCategory['id']}}"
                                                data-parentid="{{$subCategory['parent_id']}}"
                                                data-name="{{$subCategory['name']}}"
                                                data-pageid="{{$subCategory['page_id']}}"
                                                data-url="{{$subCategory['url']}}"
                                                data-sortorder="{{$subCategory['sort_order']}}"
                                                class="badge cursor-pointer edititem  bg-success bg-opacity-20 text-success">Düzenle</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>


    <div id="edit_modal" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-sm">
            <form method="post" action="{{route('admin.navigation.update')}}" class="modal-content">
                @csrf
                <input type="hidden" name="id" id="edit_id">
                <div class="modal-header">
                    <h5 class="modal-title">Düzenle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div>
                        <span>Üst Menü</span>
                        <select class="form-select" name="parent_id">
                            <option value="">Üst Menü</option>
                            @foreach($navigation->itemsAll->where('locale',$locale) as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mt-2">
                        <span>Sayfa</span>
                        <select id="pageseact2" class="form-control "
                                data-placeholder="Sayfa seçiniz"
                                data-allow-clear="true"
                                data-dropdown-parent="#edit_modal"
                                name="page_id" data-minimum-input-length="2" data-minimum-results-for-search="Infinity"></select>
                    </div>
                    <div class="mt-2">
                        <span>URL</span>
                        <input  type="text" class="form-control mt-1" name="url" placeholder="Url">
                    </div>
                    <div class="mt-2">
                        <span>Metin</span>
                        <input type="text" class="form-control mt-1" name="text" placeholder="Metin">
                    </div>
                    <div class="mt-2">
                        <span>Sıra</span>
                        <input type="number" class="form-control sort_order mt-1" name="sort_order" placeholder="Sıra">
                    </div>
                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">İptal</button>
                    <button type="submit" class="btn btn-primary">Kaydet</button>
                </div>
            </form>
        </div>
    </div>




    <script>
        $(document).ready(function(){
            $("#pageseact").select2({
                ajax: {
                    url: "{{route('admin.navigation.getPageList')}}",
                    type: "get",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            searchTerm: params.term // search term
                        };
                    },
                    processResults: function (response) {
                        return {
                            results: response
                        };
                    },
                    cache: true
                }
            });
            $("#pageseact2").select2({
                ajax: {
                    url: "{{route('admin.navigation.getPageList')}}",
                    type: "get",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            searchTerm: params.term // search term
                        };
                    },
                    processResults: function (response) {
                        return {
                            results: response
                        };
                    },
                    cache: true
                }
            });

            $('.edititem').click(function (){
                let id = $(this).data('id');
                let parent_id = $(this).data('parentid');
                let name = $(this).data('name');
                let page_id = $(this).data('pageid');
                let url = $(this).data('url');
                let text = $(this).data('text');
                let sort_order = $(this).data('sortorder');
                $('#edit_modal').modal('show');
                $('#edit_modal').find('select[name="parent_id"]').val(parent_id);
                $("#pageseact2").append(new Option(name, page_id, true, true)).trigger('change');
                $('#edit_modal').find('input[name="url"]').val(url);
                $('#edit_modal').find('input[name="text"]').val(text);
                $('#edit_modal').find('button.btn-primary').attr('data-id',id);
                $('#edit_modal').find('#edit_id').val(id);
                $('#edit_modal').find('input[name="sort_order"]').val(sort_order);
            });
        });
    </script>





@endsection

