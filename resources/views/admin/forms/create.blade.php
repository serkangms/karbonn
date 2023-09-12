@extends('admin.app')

@section('content')
    <div class="content-inner" id="app">
        <div class="page-header">
            <div class="page-header-content d-lg-flex">
                <div class="d-flex">
                    <h4 class="page-title mb-0">
                        Form Oluştur
                    </h4>
                    <a href="#page_header" class="btn btn-light align-self-center collapsed d-lg-none border-transparent rounded-pill p-0 ms-auto" data-bs-toggle="collapse">
                        <i class="ph-caret-down collapsible-indicator ph-sm m-1"></i>
                    </a>
                </div>

                <div class="collapse d-lg-block my-lg-auto ms-lg-auto" id="page_header">
                    <div></div>
                    <div class="d-sm-flex align-items-center mb-3 mb-lg-0 ms-lg-3">
                        <div class="d-inline-flex align-items-center">

                            <a href="{{route('admin.form.index')}}"
                               class="btn btn-light  h-32px ">
                                <i class="ph-arrow-left me-1"></i>
                                Geri Dön
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content pt-0">
            <div class="row">
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">Form Bilgileri</h6>
                        </div>

                        <div class="card-body p-2">
                            <span>Form Adı</span>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Form Adı" v-model="form.name">
                        </div>
                        <div class="card-body border-top p-2">
                            <span>Dil</span>
                            <select class="form-select" name="language" id="language" v-model="form.locale">
                                <option value="tr">Türkçe</option>
                                <option value="en">İngilizce</option>
                            </select>
                        </div>
                        <div class="card-body border-top p-2">
                            <span>Açıklama</span>
                            <textarea v-model="form.description" class="form-control" rows="3" name="description" id="description" placeholder="Açıklama"></textarea>
                        </div>
                        <div class="card-body border-top p-2">
                            <span>Max. Kayıt Sayısı</span>
                            <input v-model="form.max_submit" type="number" class="form-control" name="max_submit" id="max_submit" placeholder="Max. Kayıt Sayısı">
                            <span class="text-muted fs-sm">
                                0 girilirse veya boş bırakılırsa sınırsız kayıt oluşturulabilir.
                            </span>
                        </div>
                        <div class="card-body border-top p-2">
                            <span>Form Kodu</span>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Form Kodu" v-model="form.code">
                        </div>
                    </div>
                    <div>
                        <button @click="saveForm" class="btn btn-lg fw-medium btn-success">Kaydet</button>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="d-flex flex-row gap-2">
                        <div>
                            <button @click="addField('text')" class="btn btn-sm btn-light">Metin</button>
                        </div>
                        <div>
                            <button @click="addField('textarea')" class="btn btn-sm btn-light">Metin Alanı</button>
                        </div>
                        <div>
                            <button @click="addField('select')" class="btn btn-sm btn-light">Açılır Liste</button>
                        </div>
                        <div>
                            <button @click="addField('checkbox')" class="btn btn-sm btn-light">Onay Kutuları</button>
                        </div>
                        <div>
                            <button @click="addField('radio')" class="btn btn-sm btn-light">Radyo Butonları</button>
                        </div>
                        <div>
                            <button @click="addField('date')"  class="btn btn-sm btn-light">Tarih</button>
                        </div>
                        <div>
                            <button @click="addField('time')" class="btn btn-sm btn-light">Saat</button>
                        </div>
                        <div>
                            <button @click="addField('file')" class="btn btn-sm btn-light">Dosya</button>
                        </div>
                    </div>

                    <div class="mt-2">
                        <div class="card" v-for="(field, index) in fields" :key="index">
                            <div class="card-body d-none  border-bottom p-2">
                                <span class="fw-medium">Tipi : xxx</span>
                            </div>
                            <div class="card-body border-bottom p-2">
                                <div class="row">
                                    <label class="col-lg-2 col-form-label">Adı</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control form-control-sm" v-model="field.name">
                                    </div>
                                </div>
                            </div>
                            <div class="card-body border-bottom p-2">
                                <div class="row">
                                    <label class="col-lg-2 col-form-label">Boş Metni</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control form-control-sm" v-model="field.placeholder">
                                    </div>
                                </div>
                            </div>
                            <div class="card-body border-bottom p-2">
                                <div class="row">
                                    <label class="col-lg-2 col-form-label">Zorunlu</label>
                                    <div class="col-lg-9">
                                        <select class="form-select form-select-sm" v-model="field.required">
                                            <option value="1">Evet</option>
                                            <option value="0">Hayır</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body border-bottom p-2" v-if="field.type == 'select' || field.type == 'checkbox' || field.type == 'radio'">
                                <div class="row">
                                    <label class="col-lg-2 col-form-label">Değerler</label>
                                    <div class="col-lg-7">
                                        <input
                                            v-model="field.addval"
                                            type="text" class="form-control form-control-sm" >
                                    </div>
                                    <div class="col-lg-2">
                                        <button
                                            @click="addFieldValue(index)"
                                            class="btn d-grid d-block w-100 btn-sm btn-light">Değer Ekle</button>
                                    </div>
                                </div>
                                <div>
                                    <div class="row" v-for="(value, vlindx) in field.values" :key="vlindx">
                                        <label class="col-lg-2 col-form-label">x. Değer</label>
                                        <div class="col-lg-7">
                                            <input type="text" class="form-control form-control-sm" v-model="value">
                                        </div>
                                        <div class="col-lg-2">
                                            <button
                                                @click="removeFieldValue(vlindx, index)"
                                                class="btn d-grid d-block w-100 btn-sm btn-light">Sil</button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="card-body border-bottom p-2" v-if="field.type == 'text'">
                                <div class="row">
                                    <label class="col-lg-2 col-form-label">Tipi</label>
                                    <div class="col-lg-9">
                                        <select class="form-select form-select-sm" v-model="field.inputtype">
                                            <option value="text">Düz Metin</option>
                                            <option value="email">E-Posta</option>
                                            <option value="url">URL</option>
                                            <option value="tel">Telefon</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body border-bottom p-2" v-if="field.type == 'file'">
                                <div class="row">
                                    <label class="col-lg-2 col-form-label">Dosya Türü</label>
                                    <div class="col-lg-9">
                                        <select class="form-select form-select-sm" v-model="field.filetype">
                                            <option value="images">Resim</option>
                                            <option value="docs">Belge</option>
                                            <option value="all">Tüm Dosyalar</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body border-bottom p-2" v-if="field.type == 'file'">
                                <div class="row">
                                    <label class="col-lg-2 col-form-label">Maks.Dosya Sayısı</label>
                                    <div class="col-lg-9">
                                        <select class="form-select form-select-sm" v-model="field.maxfilecount">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body bg-light d-flex justify-content-between p-2">
                                <div class="d-flex ps-2 flex-row">
                                    <div class="me-2">
                                        <button v-if="index > 0"
                                                @click="moveUp(index)"
                                                type="button" class="btn btn-sm btn-secondary    btn-icon">
                                            <i class="ph-arrow-up"></i>
                                        </button>
                                    </div>
                                    <div>
                                        <button v-if="index < fields.length - 1"
                                                @click="moveDown(index)"
                                                type="button" class="btn btn-sm btn-secondary btn-icon">
                                            <i class="ph-arrow-down"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="d-flex pe-2 flex-row my-auto">
                                    <div class="me-3">
                                        <button
                                            @click="cloneField(index)"
                                            type="button" class="btn btn-sm btn-secondary">
                                            <i class="ph-clipboard me-2"></i>
                                            Kopyala
                                        </button>
                                    </div>
                                    <div>
                                        <button
                                            @click="deleteField(index)"
                                            type="button" class="btn btn-sm btn-danger">
                                            <i class="ph-trash me-2"></i>
                                            Sil
                                        </button>
                                    </div>
                                </div>
                            </div>
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
                form: {
                    id: '{{ $form->id ?? '' }}',
                    name: '{{ $form->name ?? '' }}',
                    code: '{{ $form->code ?? '' }}',
                    description: '{{ $form->description ?? '' }}',
                    max_submit: '{{ $form->max_submit ?? '' }}',
                    locale: '{{ $form->locale ?? '' }}',
                },
                fields: @json($form->fields ?? []),
            },
            methods: {
                moveUp: function (index) {
                    if (index > 0) {
                        var temp = this.fields[index];
                        this.fields[index] = this.fields[index - 1];
                        this.fields[index - 1] = temp;
                    }
                },
                moveDown: function (index) {
                    if (index < this.fields.length - 1) {
                        var temp = this.fields[index];
                        this.fields[index] = this.fields[index + 1];
                        this.fields[index + 1] = temp;
                    }
                },
                cloneField: function (index) {
                    var field = { ...this.fields[index] };
                    this.fields.splice(index + 1, 0, field);
                },
                deleteField: function (index) {
                    this.fields.splice(index, 1);
                },
                addField: function (type){
                    this.fields.push({
                        type: type,
                        name: '',
                        placeholder: '',
                        required: false,
                        addval: '',
                        values: [],
                        maxfilecount: 1,
                        inputtype: 'text',
                        filetype: 'images',
                    });
                },
                addFieldValue: function (index){
                    var value = this.fields[index].addval;
                    if (value != '') {
                        this.fields[index].values.push(value);
                        this.fields[index].addval = '';
                    }
                },
                removeFieldValue: function (vlindx,index){
                    this.fields[index].values.splice(vlindx, 1);
                },
                saveForm: function (){

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

                    var data = {
                        form: this.form,
                        fields: this.fields,
                        name: this.form.name,
                    };
                    axios.post('{{ route('admin.form.store') }}', data)
                        .then(function (response) {
                            if (response.data.status == 'success') {
                                if(response.data.redirect) {
                                    window.location.href = response.data.redirect;
                                }
                            }
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                }
            }
        });
    </script>
@endsection



