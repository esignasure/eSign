<template>
    <div class="container-fluid">
        <div class="position-relative">
            <div class="folder-list-wrapper">
                <section class="folder-navigation">
                    <h3 class="folder-navigation" @click="getFolders">
                        My Documents
                    </h3>
                    <button v-if="folderNavigationArray.length" type="button"
                            class="btn access-button form-btn"
                            style="padding: 2px 10px;box-shadow: none;"
                    @click="getBackToFolders">
                        <i class="fa fa-arrow-left mr-2" aria-hidden="true"></i>Go Back
                    </button>

                </section>
                <div class="folder-container mt-3">
                    <ul v-if="folders.length"  v-bind:class="{ 'delete-folder': showDeleteButton}">
                        <li v-for="(folder, index) in folders" class="folder-box position-relative">
                            <a class="link-btn" @click="getSubFolderAndFiles(folder.id, folder.name)">
                                <div class="folder">
                                    <i class="fa fa-folder mr-2" aria-hidden="true"></i>
                                </div>
                                <div class="folder-text" v-bind:title="folder.name">{{folder.name}}</div>
                            </a>
                            <div class="folder-delete" @click="deleteFolder(folder.id)">
                                <i class="fa fa-trash icon-delete" aria-hidden="true"></i>
                            </div>
                            <div class="folder-edit" @click="editFolder(folder)">
                                <i class="fa fa-pencil icon-edit" aria-hidden="true"></i>
                            </div>
                        </li>
                    </ul>
                    <div v-if="!folders.length && !documents.length" class="empty-directory">This folder is empty.</div>
                    <div class="clearfix"></div>
                </div>

                <div class="documents-container">
                    <ul v-if="documents.length">
                        <li v-for="(document, index) in documents">
                            <a class="link-btn" @click="previewDocument(document.id)">
                                <i v-bind:class="getDocumentIcon(document.file_name)" class="file" ></i><span class="folder-text" v-bind:title="document.file_name">{{document.file_name}}</span>
                                
                            </a>
                            <span class="document-delete pull-right" @click="deleteDocument(document.id)">
                                    <i class="fa fa-trash "></i>
                                </span>
                            
                        </li>
                    </ul>
                </div>
            </div>
            <div class="file-content">
                <div class="file-container " v-if="!showPreview">
                    <vue-dropzone ref="myVueDropzone" id="dropzone" :options="dropzoneOptions"   @vdropzone-success="onComplete" @vdropzone-sending="sendingEvent" @vdropzone-max-files-exceeded="maxFilesExceeded" :useCustomSlot=true>
                        <div class="dropzone-custom-content1">
                            <div class="text-center drag-drop-box1">
                                <br/>
                                <div class="drag-text">Drag and drop files onto this windows to upload.</div>
                                <label style="font-size: 16px;margin: 10px 0;">Or</label>
                                <br/>
                                <a title="Upload Files" class="link-btn"><i class="fa fa-upload mr-2" aria-hidden="true"></i>Click here to upload.</a>
                            </div>
                        </div>
                    </vue-dropzone>
                </div>
                <div class="filePreview " v-else>
                    <!--<iframe src="https://docs.google.com/viewer?url=http://13.71.190.166/fees_report_2018-10.pdf&embedded=true" style="width:600px; height:500px;" frameborder='0'>
                    </iframe>-->
                    <div class="backBtn"><button type="button" class="btn btn-md access-button form-btn" @click="backToDocuments" style="padding: 2px 10px; box-shadow: none;"><i class="fa fa-arrow-left mr-2" aria-hidden="true"></i>Go Back To Documents</button></div>
                    <!--<iframe v-if="pdfFile"  class="img" v-bind:src="docPreviewUrl" width="100%" height="500px" border="0"></iframe>-->
                    <div v-if="pdfFile" id="holder"></div>
                    <VueDocPreview v-else v-bind:value="docPreviewUrl" type="office" />

                </div>
            </div>
            <div class="file-tool">
                <ul class="file-tool-list" id="file-tool-list">
                    <li>
                        <a @click="mounted" class="link-btn" title="Dropbox Authentication"><i class="fa fa-dropbox mr-2" aria-hidden="true"></i>Dropbox Authentication</a>
                    </li>
                    <!--<li>
                        <a class="link-btn" title="Upload Files"><i class="fa fa-upload mr-2" aria-hidden="true"></i>Upload Documents</a>
                    </li>-->
                    <li>
                        <a class="link-btn" title="New Folder" @click="openCreateFolderModal"><i class="fa fa-folder-o mr-2" aria-hidden="true"></i>New Folder</a>
                    </li>
                    <li>
                        <a class="link-btn" title="User Signatures" @click="showHideUserSignatures"><i class="fa fa-edit mr-2" aria-hidden="true"></i>User Signatures</a>
                        <ul v-if="userSignatures">
                            <li><a class="link-btn" title="New Signature" @click="createNewSignature"><i class="fa fa-edit mr-2" aria-hidden="true"></i>New Signature</a></li>
                            <li><a title="Upload Signature" class="link-btn" @click="uploadSignature"><i aria-hidden="true" class="fa fa-upload mr-2"></i>Upload Signature.</a></li>
                        </ul>
                    </li>
                    <li v-if="!showDeleteButton && folders.length" class="mt-3">
                        <a class="link-btn color-red" title="New Folder" @click="showHideDeleteOption"><i class="fa fa-trash mr-2" aria-hidden="true"></i>Remove Folder</a>
                    </li>
                    <li v-if="showDeleteButton && folders.length" class="mt-3">
                        <a class="link-btn color-red" title="New Folder" @click="showHideDeleteOption"><i class="fa fa-times-circle mr-2" aria-hidden="true"></i>Cancel Remove</a>
                    </li>
                    <li v-if="showPreview" class="mt-3">
                        <a class="link-btn" title="Tools" @click="openTools"><i class="fa fa-gear mr-2" area-hidden="true"></i>Tools</a>
                    </li>
                </ul>
                <div v-if="docTools">
                    <ul>
                        <li class="mt-3">
                            <a class="link-btn" ><i class="fa fa-pencil"></i>Sign</a>
                            <ul>
                                <li><label><input type="checkbox" value="create" v-model="signOptions" v-on:change="changeSignOptions"><span>Create Signature</span></label></li>
                                <li><label><input type="checkbox" value="stored" v-model="signOptions" v-on:change="changeSignOptions"><span>Stored Signature</span></label></li>
                            </ul>

                        </li>
                    </ul>
                </div>
                <!--<div><ul class="signs"><li><a id="1" class="link-btn"><img src="http://localhost:8000/storage/1/signatures/1543995430.png" draggable="true" style="width: 50px; height: 50px;"> <span title="1543995430.png" class="folder-text">1543995430.png</span></a> <span class="document-delete pull-right"><i class="fa fa-trash "></i></span></li><li><a id="2" class="link-btn"><img src="http://localhost:8000/storage/1/signatures/1543996234.png" draggable="true" style="width: 50px; height: 50px;"> <span title="1543996234.png" class="folder-text">1543996234.png</span></a> <span class="document-delete pull-right"><i class="fa fa-trash "></i></span></li></ul></div>-->
                <div v-bind:class="storedSignature" class="signsDiv">
                    <ul v-if="signaures.length" class="signs">
                        <li v-for="(signaure, index) in signaures">
                            <a class="link-btn" v-bind:id="signaure.id">
                                <img v-bind:src="signaure.file_path" v-bind:draggable=true  style="width:50px;height:50px" />
                                <span class="folder-text" v-bind:title="signaure.file_name">{{signaure.file_name}}</span>

                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!--MODAl FOR NEW FOlDER CREATE-->
        <div class="modal" id="modal-new-folder">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form v-on:submit.prevent="createFolder" id="myform" class="form-horizontal">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Create New Folder</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="folderName">Folder Name</label>
                                    <input type="text" class="form-control" id="folderName" placeholder="Folder Name" v-model="formData.name">
                                </div>
                            </div>
                        </div>
                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-blue form-btn">Create Folder</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal" id="modal-dropbox">
            <div class="modal-dialog">
                <div class="modal-content">

                </div>
            </div>
        </div>
        <!--MODAl FOR NEW IGNATURE CREATE-->
        <div v-bind:class="getSignatureModalClass()" class="modal1 SignatureModal" id="modal-new-signature">
            <div class="modal-dialog">
                <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Create New Signature</h4>
                            <button type="button"@click="closeNewSignatureModal" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body">
                            <div v-if="userUploadSignatures && !overwriteSign" class="box-body wrapper">
                                <label>Upload Signature File</label>
                                <input type="file" accept="image/*" id="file" ref="file" v-on:change="handleFileUpload()"/>
                            </div>
                            <div v-else-if="!userUploadSignatures && !overwriteSign" class="box-body wrapper">
                                <VueSignaturePad width="500px" height="240px" ref="signaturePad" />
                                <!--<canvas class="signature"></canvas>-->
                            </div>
                            <div v-if="overwriteSign" class="signatureList">
                                <p>Select Signature to replace with new:</p>
                                <ul v-if="signaures.length" class="">
                                    <li v-for="(signaure, index) in signaures">
                                        <a class="link-btn" @click="replaceSignature(signaure.id)" v-bind:id="signaure.id">
                                            <img v-bind:src="signaure.file_path" v-bind:draggable=true  style="width:50px;height:50px" />
                                            <span class="folder-text" v-bind:title="signaure.file_name">{{signaure.file_name}}</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- Modal footer -->
                        <div v-if="userUploadSignatures" class="modal-footer">
                            <button @click="saveUserSignatures" class="btn btn-blue form-btn">Save</button>
                        </div>
                        <div v-else class="modal-footer">
                            <button @click="save" class="btn btn-blue form-btn">Save</button>
                            <button @click="undo" class="btn btn-danger form-btn">Undo</button>
                            <button @click="clear" class="btn btn-danger form-btn">Clear</button>
                        </div>

                </div>
            </div>
        </div>
        <div v-if="isDocumentPasswordProtected" class="SignatureModal">
            <div class="modal-dialog">
                <form v-on:submit.prevent="getUserPass" id="passform" class="form-horizontal">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Provide Document Passsword</h4>
                            <button type="button"@click="closeDocPassword" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class="form-froup">
                                <label>Document Passord:</label>
                                <input type="password" class="form-control" placeholder="Folder Name" required v-model="passData.password" />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-blue form-btn">Open Document</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <notifications animation-type="velocity"/>
        <loading v-show="showLoader"></loading>
    </div>
</template>

<script>
    import notify from './shared/Notify'
    import common from './shared/Common'
    import vue2Dropzone from 'vue2-dropzone'
    import 'vue2-dropzone/dist/vue2Dropzone.min.css'
    import VueDocPreview from 'vue-doc-preview'
    import VueSignaturePad from 'vue-signature-pad';

    Vue.use(VueSignaturePad);

    require('../main');
    export default {
        name: "documents",
        data: function () {
            return {
                showLoader: false,
                url: 'create-folder',
                folders: [],
                documents: [],
                showDeleteButton: false,
                currentFolder: {
                    parentId:0,
                },
                folderNavigationArray: [],
                formData: {
                    id: 0,
                    parentId:0,
                    userId: '',
                    name: ''
                },
                dropzoneOptions: {
                    url: common.data().serverPath +'/upload-document',
                    maxFilesize: 2,
                    maxFiles: 2,
                    headers: {
                        "X-CSRF-TOKEN": document.head.querySelector("[name=csrf-token]").content
                    }
                },
                docPreviewUrl: '',
                showPreview: false,
                pdfFile: true,
                pad: 'closed',
                fData:{signatureData:'',type:'',replaceSignId:'',fileext:''},
                docTools:false,
                userSignatures:false,
                userUploadSignatures:false,
                createSignature:false,
                storedSignature:'closed',
                signaures: [],
                signOptions: [],
                file: '',
                overwriteSign: false,
                isDocumentPasswordProtected:false,
                passData:{
                    password:'',
                    passProtctedDocUrl:''
                }
            }
        },
        created: function () {
            this.showLoader = true;
            this.getFolders();

        },
        components: {
            vueDropzone: vue2Dropzone,
            VueDocPreview
        },
        methods: {
            /**
             * Get the all parent folder
             * */
            getFolders: function () {
                this.showLoader = true;
                const url = common.data().serverPath + 'get-folders';
                Axios.get(url).then((response) => {
                    this.showLoader = false;
                    if (response.data.success) {
                        this.folders = response.data.data.folders;
                        this.documents = response.data.data.documents;
                        this.signaures = response.data.data.signatures;
                        this.currentFolder.parentId = 0;
                        this.folderNavigationArray = [];
                    } else {
                        notify.methods.notifyError(response.data.error.message);
                    }
                })
                .catch((error) => {
                    this.showLoader = false;
                    notify.methods.notifyError('Something went wrong. Please refresh the page.');
                })
            },

            /**
             * get the sub folders and files
             * @param folderId
             */
            getSubFolderAndFiles: function (folderId, pushNavigation = true) { // get the annual rate
                this.showLoader = true;
                const url = common.data().serverPath + 'get-sub-folders/' + folderId;
                Axios.get(url).then((response) => {
                    this.showLoader = false;
                    if (response.data.success) {
                        this.folders = response.data.data.folders;
                        this.documents = response.data.data.documents;
                        this.currentFolder.parentId = folderId;
                        if (pushNavigation) {
                            this.folderNavigationArray.push(folderId);
                        }

                    } else {
                        notify.methods.notifyError(response.data.error.message);
                    }
                })/*.catch((error) => {
                    alert('failed');
                    this.showLoader = false;
                    notify.methods.notifyError('Something went wrong. Please refresh the page.');
                })*/
            },

            /**
             * Create new folder
             */
            createFolder: function () { // Create folder
                this.showLoader = true;
                const url = common.data().serverPath + 'create-folder';
                this.formData.parentId = this.currentFolder.parentId;
                Axios.post(url, this.formData)
                    .then((response) => {
                        this.showLoader = false;
                        if (response.data.success) {
                            notify.methods.notifySuccess(response.data.message);
                            $('#modal-new-folder').modal('hide');

                            if (this.currentFolder.parentId > 0) {
                                this.getSubFolderAndFiles(this.currentFolder.parentId, false);
                            } else {
                                this.getFolders();
                            }

                        } else {
                            if (response.data.error.statusCode === 103) {
                                notify.methods.notifyError(response.data.error.errorDescription);
                            } else {
                                notify.methods.notifyError(response.data.error.message);
                            }
                        }
                    })
                    .catch((error) => {
                        this.showLoader = false;
                        notify.methods.notifyError('Something went wrong. Please try again.');
                    })
            },

            /**
             * Opend create folder pop-up
             */
            openCreateFolderModal: function() {
                this.formData.name = '';
                this.formData.id = 0;
                $('#modal-new-folder').modal('show');
            },

            /**
             * got back to recent folder
             *
             */
            getBackToFolders: function() {
                this.showDeleteButton = false;
                const folderId = this.folderNavigationArray[this.folderNavigationArray.length - 2];
                if (typeof folderId === 'undefined') {
                    this.getFolders();
                } else {
                    this.getSubFolderAndFiles(folderId, false);
                    this.folderNavigationArray.splice(-1);

                    //console.log(this.folderNavigationArray);
                }

            },

            /**
             * show hide delete button
             *
             */
            showHideDeleteOption: function () {
                this.showDeleteButton = !this.showDeleteButton;
            },

            /**
             * delete the specific folder
             * @param id
             */
            deleteFolder: function (id) { // save annual rate
                if (confirm("Are you sure you want to delete this folder?")) {
                    this.showLoader = true;
                    const url = common.data().serverPath + 'delete-folder/' + id;
                    Axios.delete(url)
                        .then((response) => {
                            this.showLoader = false;
                            if (response.data.success) {
                                notify.methods.notifySuccess(response.data.message);
                                if (this.currentFolder.parentId > 0) {
                                    this.getSubFolderAndFiles(this.currentFolder.parentId, false);
                                } else {
                                    this.getFolders();
                                }

                            } else {
                                notify.methods.notifyError(response.data.error.message);
                            }
                        })
                        .catch((error) => {
                            this.showLoader = false;
                            notify.methods.notifyError('Something went wrong. Please try again.');
                        })
                }
            },

            /**
             * delete the specific document
             * @param id
             */
            deleteDocument: function (id) { // save annual rate
                if (confirm("Are you sure you want to delete this document?")) {
                    this.showLoader = true;
                    const url = common.data().serverPath + 'delete-document/' + id;
                    Axios.delete(url)
                        .then((response) => {
                            this.showLoader = false;
                            if (response.data.success) {
                                notify.methods.notifySuccess(response.data.message);
                                if (this.currentFolder.parentId > 0) {
                                    this.getSubFolderAndFiles(this.currentFolder.parentId, false);
                                } else {
                                    this.getFolders();
                                }

                            } else {
                                notify.methods.notifyError(response.data.error.message);
                            }
                        })
                        .catch((error) => {
                            this.showLoader = false;
                            notify.methods.notifyError('Something went wrong. Please try again.');
                        })
                }
            },

            /**
             * Append Parameter to dropzone
             * 
             */
            sendingEvent: function(file,xhr,formData){
                console.log('sendingEvent');
                formData.append('user_directory_id',this.currentFolder.parentId);
            },
            mounted: function(){
                //console.log('mounted');
                Axios.get(common.data().serverPath + 'get-auth-url').then((response) => {
                     //url =  response.data;
                     //console.log(response.data);
                    this.openDropboxLogin(response.data.authUrl,response.data.redirectUrl,);
                    /*$('#modal-dropbox .modal-content').html(response.data)
                    //$('#modal-dropbox .modal-content').html('<iframe style="border: 0px; " src="' +url + '" width="100%" height="100%"></iframe>')
                    $('#modal-dropbox').modal('show');*/
                }).catch((error) => {
                    //console.log(error);
                    notify.methods.notifyError('Unable to fetch authentication. Please try again.');
                })

            },

            /**
             * After successful upload reload files and folders.
             */
            onComplete : function(file, response){
                if(response.success){
                    this.$refs.myVueDropzone.removeAllFiles();
                    notify.methods.notifySuccess(response.message);
                    if (this.currentFolder.parentId > 0) {
                        this.getSubFolderAndFiles(this.currentFolder.parentId, false);
                    } else {
                        this.getFolders();
                    }
                }else{
                    if (response.error.statusCode === 103) {
                        notify.methods.notifyError(response.error.errorDescription);
                    } else {
                        notify.methods.notifyError(response.error.message);
                    }
                }
                
            },
            maxFilesExceeded : function (file){
                notify.methods.notifyError('You have reached max file upload limit. '+file.name+' has not been uploaded.');
            },

            /**
             * Preview the document
             */
            previewDocument : function (documentId){
                this.showLoader = true;
                this.backToDocuments();
                const url = common.data().serverPath + 'get-document/' + documentId + '/' + this.currentFolder.parentId;
                Axios.get(url).then((response) => {
                    if (response.data.success) {
                        if(response.data.data.mimeType != 'application/pdf'){
                            this.pdfFile=false;
                        }else{
                            this.pdfFile=true;
                        }
                        this.docPreviewUrl = response.data.data.url;
                        this.getPreview(this.docPreviewUrl);
                        this.showLoader = false;
                        this.showPreview = true;
                    } else {

                        notify.methods.notifyError(response.data.error.message);
                    }
                }).catch((error) => {
                    this.showLoader = false;
                    notify.methods.notifyError('Unable to fetch the document. Please try again.');
                })

            },
            backToDocuments : function(){
                this.showPreview = false;
            },
            getDocumentIcon: function (fileName){
                var ext = fileName.substr(fileName.lastIndexOf('.') + 1);
                var icon = (ext === 'pdf') ? 'fa fa-file-pdf-o' : 'fa fa-file-word-o';
                return icon;
            },
            editFolder: function (folder) {
                this.formData.name = folder.name;
                this.formData.id = folder.id;
                this.formData.parentId = this.currentFolder.parentId;
                $('#modal-new-folder').modal('show');
            },
            /**
             * get document Preview
             */
            getPreview : function(url){

                // Loaded via <script> tag, create shortcut to access PDF.js exports.
                var pdfjsLib = window['pdfjs-dist/build/pdf'];

                // The workerSrc property shall be specified.
                //pdfjsLib.GlobalWorkerOptions.workerSrc = '//mozilla.github.io/pdf.js/build/pdf.worker.js';

                pdfjsLib.disableWorker = true;
                // Asynchronous download of PDF
                if(this.passData.password){
                    var loadingTask = pdfjsLib.getDocument({ url: this.passData.passProtctedDocUrl, password: this.passData.password });
                    this.isDocumentPasswordProtected = false;
                    this.passData.password = '';
                }else{
                    var loadingTask = pdfjsLib.getDocument(url);
                }
                loadingTask.promise.then((pdf) => {

                    for(var num = 1; num <= pdf.numPages; num++) {

                        $('#holder').append('<div id="docPage'+num+'" class="docPage" style="position:relative;"></div>');
                        var cnt=0;

                        pdf.getPage(num).then((page) => {
                            this.showLoader = false;
                            cnt++;
                            var viewport = page.getViewport(1.2);
                            var canvas = document.createElement('canvas');
                            canvas.id = "pageOrigin"+cnt;

                            var ctx = canvas.getContext('2d');
                            var renderContext = {
                                canvasContext: ctx,
                                viewport: viewport
                            };

                            canvas.height = viewport.height;
                            canvas.width = viewport.width;

                            var can = document.createElement('canvas');
                            can.id = "page"+cnt;
                            canvas.addEventListener('dragover', function(e){e.preventDefault();
                                return false;});
                            var context = can.getContext('2d');
                            var renderCnt = {
                                canvasContext: context,
                                viewport: viewport
                            };
                            can.height = viewport.height;
                            can.width = viewport.width;
                            $('#docPage'+cnt).css({height:viewport.height})
                            $('#docPage'+cnt).append(can);
                            $('#docPage'+cnt).append(canvas);

                            page.render(renderContext);
                            this.initCanvas(can,'#docPage'+cnt);
                        });
                    }
                }, (reason)=> {
                    //console.log(reason);
                    // PDF loading error
                    var passError = reason.name
                    if(passError=='PasswordException'){
                        /*if(reason.code == 1){
                            notify.methods.notifyError('Document is Password protected.'+reason.message);
                        }*/
                        notify.methods.notifyError(reason.message);
                        this.isDocumentPasswordProtected = true;
                        this.passData.passProtctedDocUrl = url;
                        this.showLoader = false;
                    }
                });
            },

            /**
             * Opend create new signature pop-up
             */
            openNewSignatureModal: function() {
                this.pad = 'open';
            },
            /**
             * Close create new signature pop-up
             */
            closeNewSignatureModal: function() {
                this.pad = 'closed';
                if(this.userUploadSignatures == false)
                    this.undo();
            },
            getSignatureModalClass: function(){
                return this.pad;
            },
            /**
             * undo signature pad
             */
            undo() {
                this.$refs.signaturePad.undoSignature();
            },
            /**
             * save signature pad canvas
             */
            save() {
                //const { isEmpty, data } = this.$refs.signaturePad.saveSignature();
                const reurned = this.$refs.signaturePad.saveSignature();
                if(!reurned.isEmpty){
                    this.showLoader = true;
                    /*const url = common.data().serverPath + 'create-signature';*/
                    this.fData.signatureData = reurned.data;
                    this.fData.type = 'create';
                    this.fData.fileext = '';
                    if(this.signaures.length >= 6){
                        this.fData.replaceSignId='';
                        this.overwriteSign = true;
                        this.showLoader = false;
                    }else{
                        this.saveSignature();
                    }
                    /*Axios.post(url, this.fData).then((response) => {
                        this.showLoader = false;
                        if (response.data.success) {
                            notify.methods.notifySuccess(response.data.message);
                            this.pad = 'closed';
                        } else {
                            if (response.data.error.statusCode === 103) {
                                notify.methods.notifyError(response.data.error.errorDescription);
                            } else {
                                notify.methods.notifyError(response.data.error.message);
                            }
                        }
                    })
                    .catch((error) => {
                        this.showLoader = false;
                        notify.methods.notifyError('Something went wrong. Please try again.');
                    })*/
                }else{
                    notify.methods.notifyError('Returned empty signature.Please try again.');
                }


            },
            /**
             * clear signature pad canvas
             */
            clear:function () {
                this.$refs.signaturePad.clearSignature();
            },

            openTools: function(){
                this.docTools=true;
            },
            storedSignatures: function(){
                this.showLoader = true;
                const url = common.data().serverPath + 'get-signatures';
                Axios.get(url).then((response) => {
                    //console.log(response);
                    this.showLoader = false;
                    if (response.data.success) {
                        this.signaures = response.data.signatures;
                    } else {
                        notify.methods.notifyError(response.data.error.message);
                    }
                })
                .catch((error) => {
                        this.showLoader = false;
                    notify.methods.notifyError('Something went wrong. Please refresh the page.');
                })
            },
            changeSignOptions: function(){
                var optss = this.signOptions;
                if(optss.includes('stored')){
                    this.storedSignature='open';
                }else{
                    this.storedSignature='closed';
                }
                if(optss.includes('create')){
                    this.createSignature=true;
                }else{
                    this.createSignature=false;
                }

            },
            initCanvas: function(canvas,canvasContainerDiv) {
                var ctx = canvas.getContext('2d');
                var signImage = new Image();
                $(canvasContainerDiv).each(function(index) {

                    var canvasContainer = $(this)[0];
                    var canvasObject = $("canvas", this)[0];
                    var imageOffsetX, imageOffsetY;

                    function handleDragStart(e) {
                        [].forEach.call(images, function (img) {
                            img.classList.remove('img_dragging');
                        });
                        this.classList.add('img_dragging');

                        var imageOffset = $(this).offset();
                        imageOffsetX = e.clientX - imageOffset.left;
                        imageOffsetY = e.clientY - imageOffset.top;
                    }

                    function handleDragOver(e) {
                        if (e.preventDefault) {
                            e.preventDefault();
                        }
                        e.dataTransfer.dropEffect = 'copy';
                        return false;
                    }

                    function handleDragEnter(e) {
                        this.classList.add('over');
                    }

                    function handleDragLeave(e) {
                        this.classList.remove('over');
                    }

                    function handleDrop(e) {
                        e = e || window.event;
                        if (e.preventDefault) {
                            e.preventDefault();
                        }
                        if (e.stopPropagation) {
                            e.stopPropagation();
                        }
                        var img = document.querySelector('.signs img.img_dragging');
                        var offset = $(canvasObject).offset();
                        var y = e.clientY - (offset.top + imageOffsetY);
                        var x = e.clientX - (offset.left + imageOffsetX);
                        var newImage = new Image(img);
                        newImage.src=img.src;
                        newImage.width=img.width;
                        newImage.height=img.height;
                        signImage = newImage;
                        newImage.onload = function(){
                            //ctx.clearRect(0,0,canvas.width,canvas.height);
                            ctx.drawImage(signImage,x,y,img.width,img.height);
                        };
                        return false;
                    }

                    function handleDragEnd(e) {
                        [].forEach.call(images, function (img) {
                            img.classList.remove('img_dragging');
                        });
                    }

                    var images = document.querySelectorAll('.signs img');
                    [].forEach.call(images, function (img) {
                        img.addEventListener('dragstart', handleDragStart, false);
                        img.addEventListener('dragend', handleDragEnd, false);
                    });
                    canvasContainer.addEventListener('dragenter', handleDragEnter, false);
                    canvasContainer.addEventListener('dragover', handleDragOver, false);
                    canvasContainer.addEventListener('dragleave', handleDragLeave, false);
                    canvasContainer.addEventListener('drop', handleDrop, false);

                    var canvasOffset=$(canvasObject).offset();
                    var offsetX=canvasOffset.left;
                    var offsetY=canvasOffset.top;
                    var canvasWidth=canvas.width;
                    var canvasHeight=canvas.height;
                    var isDragging=false;
                    var canMouseX = 0, canMouseY =0;

                    function handleMouseDown(e){
                        canMouseX=parseInt(e.clientX-offsetX);
                        canMouseY=parseInt(e.clientY-offsetY);
                        // set the drag flag
                        isDragging=true;
                    }
                    function handleMouseUp(e){

                        canMouseX=parseInt(e.clientX-offsetX);
                        canMouseY=parseInt(e.clientY-offsetY);
                        // clear the drag flag
                        isDragging=false;
                    }
                    function handleMouseOut(e){
                        canMouseX=parseInt(e.clientX-offsetX);
                        canMouseY=parseInt(e.clientY-offsetY);
                        // user has left the canvas, so clear the drag flag//
                        isDragging=false;
                    }
                    function handleMouseMove(e){
                        canMouseX=parseInt(e.clientX-offsetX);
                        canMouseY=parseInt(e.clientY-offsetY);
                        // if the drag flag is set, clear the canvas and draw the image
                        if(isDragging){
                            ctx.clearRect(0,0,canvasWidth,canvasHeight);
                            //ctx.drawImage(signImage,canMouseX-128/2,canMouseY-120/2,128,120);
                            ctx.drawImage(signImage,canMouseX-signImage.width/2,canMouseY-signImage.height/2,signImage.width,signImage.height);
                        }
                    }
                    $(canvasObject).mousedown(function(e){handleMouseDown(e);});
                    $(canvasObject).mousemove(function(e){handleMouseMove(e);});
                    $(canvasObject).mouseup(function(e){handleMouseUp(e);});
                    $(canvasObject).mouseout(function(e){handleMouseOut(e);});
                });
            },
            showHideUserSignatures :function(){
                if(this.userSignatures == true){
                    this.userSignatures = false;
                }else{
                    this.userSignatures = true;
                }
            },
            createNewSignature: function(){
                this.userUploadSignatures = false;
                this.openNewSignatureModal();
            },
            uploadSignature: function(){
                this.userUploadSignatures = true;
                this.openNewSignatureModal();
            },
            saveUserSignatures: function () {
                this.showLoader = true;
                this.getBase64(this.file).then(
                    data => this.fData.signatureData = data
                );

                this.fData.type = 'upload';
                if(this.signaures.length >= 6){
                    this.fData.replaceSignId='';
                    this.overwriteSign = true;
                    this.showLoader = false;
                }else{
                    this.saveSignature();
                }
            },
            handleFileUpload: function(){
                this.file = this.$refs.file.files[0];
            },
            /**
             * save signature to database
             */
            saveSignature: function(){
                this.showLoader = true;
                const url = common.data().serverPath + 'create-signature';

                Axios.post(url, this.fData).then((response) => {
                    this.storedSignatures();
                    this.showLoader = false;
                    if (response.data.success) {
                        notify.methods.notifySuccess(response.data.message);
                        this.pad = 'closed';
                    } else {
                        if (response.data.error.statusCode === 103) {
                            notify.methods.notifyError(response.data.error.errorDescription);
                        } else {
                            notify.methods.notifyError(response.data.error.message);
                        }
                    }
                })
                .catch((error) => {
                        this.showLoader = false;
                    notify.methods.notifyError('Something went wrong. Please try again.');
                })
            },
            replaceSignature: function(signatureId){
                this.fData.replaceSignId = signatureId;
                this.overwriteSign = false;
                this.saveSignature();
            },
            getBase64: function(file){
                return new Promise((resolve, reject) => {
                    const reader = new FileReader();
                    reader.readAsDataURL(file);
                    this.fData.fileext = file.name.split('.').pop().toLowerCase();
                    reader.onload = () => resolve(reader.result);
                    reader.onerror = error => reject(error);
                });
            },
            closeDocPassword: function(){
                this.isDocumentPasswordProtected = false;
                this.passData.passProtctedDocUrl = '';
                this.passData.password = '';
            },
            getUserPass: function(){
                this.showLoader = true;
                this.getPreview(this.passData.passProtctedDocUrl);
            },
            openDropboxLogin: function (_url,redirectUrl) {
                var win         =   window.open(_url, "windowname", 'width=800, height=600');

                var pollTimer   =   window.setInterval(() => {
                    try {
                        var url =   win.document.URL;
                        //console.log(url);

                        if (url.indexOf(redirectUrl) != -1) {
                            window.clearInterval(pollTimer);
                            win.close();
                            /*var code =   this.gup(url, 'code','&');
                            var state =   this.gup(url, 'state','?');*/
                        }
                    } catch(e) {
                    }
                }, 500);

            },
            gup: function (url,name,char) {
                name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
                var regexS = "[\\#"+char+"]"+name+"=([^&#]*)";
                var regex = new RegExp( regexS );
                var results = regex.exec( url );
                if( results == null )
                    return "";
                else
                    return results[1];
            },

        },
        mounted : function() {
        },

    }



</script>
