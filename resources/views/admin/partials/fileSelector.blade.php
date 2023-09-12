

<div id="fileSelectorApp">
    <div class="modal bg-body fade" tabindex="-1" id="fileSelectorModal">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content shadow-none ">
                <div class="modal-header p-2">
                    <h5 class="modal-title">Medya Galerisi</h5>
                    <!--begin::Close-->
                    <div @click="closeModal()" class="btn btn-icon btn-light btn-sm  ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ph-x"></i>
                    </div>
                    <!--end::Close-->
                </div>
                <div class="modal-body pt-1  scroll w-100 h-100">
                    <div class="d-flex row  w-100 h-100 justify-content-center">

                        <div  @click="$refs.file.click()"  class="col-md-2 col-4 border cursor-pointer border-primary border-3 border-dashed d-flex justify-content-center align-content-center align-items-center rounded-3 m-2 p-1" >
                            <div class="d-flex flex-column justify-content-center align-content-center align-items-center me-2">
                                <div class="text-center fw-bold">
                                    Yeni Dosya Yükle
                                </div>
                                <input id="files" multiple  @change="uploadFile()" ref="file" type="file" style="display: none">
                                <div>
                                    <i class="fa fa-upload mt-2 fs-2 text-primary"></i>
                                </div>
                            </div>
                        </div>

                        <div v-for="(item,index) in files" @click="selectFile(item)" class="cursor-pointer border  col-md-1 col-sm-2 col-4 rounded-3 m-1 p-1" :class="{'bg-primary': selectedFiles.includes(item)}">
                            <div class="rounded cursor-pointer"    >
                                <div v-if="item.is_image" >
                                    <img v-if="item.extension != 'svg'" :src="item.thumbnail" class="rounded" style="object-fit: contain;width: 100%; height: 100%;">
                                    <img v-else :src="item.url" class="rounded" style="object-fit: cover;width: 100%; height: 100%;">
                                </div>

                                <div v-else class="rounded text-center text-nowrap">
                                    <div>
                                        <span class="bg-dark text-white p-1 rounded">@{{ item.extension }}</span>
                                    </div>
                                    <div class="text-truncate text-wrap w-100 h-100">
                                        <span style="font-size: 12px;line-height: 1rem;letter-spacing: 0px;" class="fs-sm">@{{ item.orginal_name }}</span>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-1 col-4 border cursor-pointer border-gray-400 border-3 border-dashed d-flex justify-content-center align-content-center align-items-center rounded-3 m-2 p-1">
                            <div @click="loadMore()" class="cursor-pointer p-1 bg-light rounded d-flex flex-grow-1 w-100 h-100" >
                                <div class="d-flex flex-column h-100 w-100 flex-fill flex-grow-1 align-items-center justify-content-center">
                                    <i class="fa fa-plus fs-2 text-gray-400"></i>
                                    <span>Daha Fazla</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer p-1">
                    <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">İptal</button>
                    <button @click="selectFiles()"  type="button" class="btn btn-sm btn-primary">SEÇİMİ TAMAMLA</button>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    $(document).on('click', '.selectImage', function(){
        fileSelectorApp.mode = 'select';
        fileSelectorApp.selector = 'html';
        fileSelectorApp.selectedFiles = [];

        var maxSelectCount = $(this).data('max-select-count');
        if(maxSelectCount){
            fileSelectorApp.maxSelectCount = maxSelectCount;
        }else{
            fileSelectorApp.maxSelectCount = 1;
        }

        var targetShow = $(this).data('target-show');
        if(targetShow){
            fileSelectorApp.targetShow = '#'+targetShow;
        }else{
            fileSelectorApp.targetShow = '';
        }

        var targetValue = $(this).data('target-value');
        if(targetValue){
            fileSelectorApp.targetValue = '#'+targetValue;
        }else{
            fileSelectorApp.targetValue = '';
        }

        var thumbnailimg = $(this).data('thumbnail');
        if(thumbnailimg){
            fileSelectorApp.thumnailimg = thumbnailimg;
        }else{
            fileSelectorApp.thumnailimg = 'mini';
        }

        var selector = $(this).data('selector');
        if(selector){
            fileSelectorApp.selector = selector;
        }else{
            fileSelectorApp.selector = 'html';
        }

        var fileType = $(this).data('file-type');
        if(fileType){
            fileSelectorApp.fileType = fileType;
        }else{
            fileSelectorApp.fileType = 'all';
        }



        loadMedia();
    });

    $(document).on('click', '.addImage', function(){
        fileSelectorApp.mode = 'add';
        fileSelectorApp.selectedFiles = [];

        var maxSelectCount = $(this).data('max-select-count');
        if(maxSelectCount){
            fileSelectorApp.maxSelectCount = maxSelectCount;
        }else{
            fileSelectorApp.maxSelectCount = 1;
        }

        var targetfunction = $(this).data('target-func');
        if(targetfunction){
            fileSelectorApp.targetFunction = targetfunction;
        }else{
            fileSelectorApp.targetFunction = '';
        }

        var targetfunctionparam = $(this).data('target-func-param');
        if(targetfunctionparam != undefined){
            fileSelectorApp.targetFunctionParam = targetfunctionparam;
        }else{
            fileSelectorApp.targetFunctionParam = '';
        }

        var fileType = $(this).data('file-type');
        if(fileType){
            fileSelectorApp.fileType = fileType;
        }else{
            fileSelectorApp.fileType = 'all';
        }

        loadMedia();
    });

    function loadMedia(){
        $('#fileSelectorModal').modal('show');
        fileSelectorApp.getFiles();
        fileSelectorApp.onPage = 1;
    }

    function pushItem(item){
        fileSelectorApp.files.unshift(item.data);
    }

    var fileSelectorApp = new Vue({
        el: '#fileSelectorApp',
        data: {
            files: [],
            selectedFiles : [],
            maxSelectCount: 1,
            onPage : 1,
            targetShow: '',
            targetValue: '',
            targetFunction: '',
            thumnailimg : '',
            mode: 'select',
            selector: 'html',
            targetFunctionParam: '',
            fileType : 'all'
        },
        methods: {
            getFiles: function(){
                axios.get('/getfiles', {
                    params: {
                        fileType: this.fileType
                    }
                })
                    .then(response => {
                        this.files = response.data;
                    })
                    .catch(error => {
                        console.log(error);
                    });
            },
            selectFile: function(file){
                if(this.selectedFiles.includes(file)){
                    this.selectedFiles = this.selectedFiles.filter(item => item !== file);
                }else{
                    if(this.selectedFiles.length < this.maxSelectCount){
                        this.selectedFiles.push(file);
                    }else{
                        //replace first item
                        this.selectedFiles.shift();
                        this.selectedFiles.push(file);
                    }
                }
            },
            closeModal: function(){
                $('#fileSelectorModal').modal('hide');
            },
            loadMore: function(){
                this.onPage++;
                axios.get('/getfiles?page='+this.onPage, {
                    params: {
                        fileType: this.fileType
                    }
                })
                    .then(response => {
                        this.files = this.files.concat(response.data);
                    })
                    .catch(error => {
                        console.log(error);
                    });
            },
            selectFiles: function(){


                if(this.mode == 'add'){
                    if(this.targetFunction){
                        if(this.targetFunctionParam != undefined){
                            window[this.targetFunction](this.selectedFiles, this.targetFunctionParam);
                        }else{
                            window[this.targetFunction](this.selectedFiles);
                        }
                    }
                }else
                {
                    if(this.selectedFiles.length > 0){
                        if(this.targetShow){
                            if(this.thumnailimg === 'full'){
                                $(this.targetShow).attr('src', this.selectedFiles[0].url);
                            }
                            else{
                                $(this.targetShow).attr('src', this.selectedFiles[0].thumbnail);
                            }
                        }
                        if(this.targetValue){
                            $(this.targetValue).val(this.selectedFiles[0].id);
                        }
                    }
                }

                $('#fileSelectorModal').modal('hide');
            },
            uploadFile: function(){
                for(var i = 0; i < this.$refs.file.files.length; i++ ){
                    var formData = new FormData();
                    let file = this.$refs.file.files[i];
                    formData.append('file', file);
                    let file_randomkey = Math.random().toString(36).substring(2, 15);

                    fileSelectorApp.files.unshift({
                        'thumbnail': '{{asset('assets/img/loading2.gif')}}',
                        'index': file_randomkey,
                    });

                    axios.post('/uploadfile', formData, {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            },
                        }
                    ).then(function(response){
                        fileSelectorApp.files = fileSelectorApp.files.filter(item => item.index !== file_randomkey);
                        fileSelectorApp.files.unshift(response.data);
                    }).catch(function(error){
                        console.log(error);
                    });
                }
            },
        }
    });
</script>
