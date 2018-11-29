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
                        </li>
                    </ul>
                    <div v-if="!folders.length && !documents.length" class="empty-directory">This folder is empty.</div>
                    <div class="clearfix"></div>
                </div>

                <div class="documents-container">
                    <ul v-if="documents.length">
                        <li v-for="(document, index) in documents">
                            <a class="link-btn" v-bind:href="document.file_path" target="_blank">
                                <i class="fa fa-file file"></i><span class="folder-text" v-bind:title="document.file_original_name">{{document.file_original_name}}</span>
                                
                            </a>
                            <span class="document-delete pull-right" @click="deleteDocument(document.id)">
                                    <i class="fa fa-trash "></i>
                                </span>
                            
                        </li>
                    </ul>
                </div>
            </div>
            <div class="file-content">
                <div class="file-container">
                    <vue-dropzone ref="myVueDropzone" id="dropzone" :options="dropzoneOptions" @vdropzone-success="onComplete" @vdropzone-sending="sendingEvent" @vdropzone-max-files-exceeded="maxFilesExceeded" :useCustomSlot=true>
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
            </div>
            <div class="file-tool">
                <ul class="file-tool-list">
                    <!--<li>
                        <a class="link-btn" title="Upload Files"><i class="fa fa-upload mr-2" aria-hidden="true"></i>Upload Documents</a>
                    </li>-->
                    <li>
                        <a class="link-btn" title="New Folder" @click="openCreateFolderModal"><i class="fa fa-folder-o mr-2" aria-hidden="true"></i>New Folder</a>
                    </li>
                    <li v-if="!showDeleteButton && folders.length" class="mt-3">
                        <a class="link-btn color-red" title="New Folder" @click="showHideDeleteOption"><i class="fa fa-trash mr-2" aria-hidden="true"></i>Remove Folder</a>
                    </li>
                    <li v-if="showDeleteButton && folders.length" class="mt-3">
                        <a class="link-btn color-red" title="New Folder" @click="showHideDeleteOption"><i class="fa fa-times-circle mr-2" aria-hidden="true"></i>Cancel Remove</a>
                    </li>
                </ul>
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
        <notifications animation-type="velocity"/>
        <loading v-show="showLoader"></loading>
    </div>
</template>

<script>
    import notify from './shared/Notify'
    import common from './shared/Common'
    import vue2Dropzone from 'vue2-dropzone'
    import 'vue2-dropzone/dist/vue2Dropzone.min.css'

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
                }
            }
        },
        created: function () {
            this.showLoader = true;
            this.getFolders();
        },
        components: {
            vueDropzone: vue2Dropzone
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

                    console.log(this.folderNavigationArray);
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
                formData.append('user_directory_id',this.currentFolder.parentId);
            },
            onComplete : function(file, response){
                console.log(response);
                if(response.success){
                    this.$refs.myVueDropzone.removeAllFiles();
                    notify.methods.notifySuccess(response.message);
                    if (this.currentFolder.parentId > 0) {
                        this.getSubFolderAndFiles(this.currentFolder.parentId, false);
                    } else {
                        this.getFolders();
                    }
                }else{
                    notify.methods.notifyError(response.error.message);
                }
                
            },
            maxFilesExceeded : function (file){
            console.log('LIMIT EXCEEDDED');
            console.log(file.name);
                notify.methods.notifyError('You have reached max file upload limit. '+file.name+' has not been uploaded.');
            },
            testMethod: function () {

                notify.methods.notifySuccess('this is success message');
            }
        }
    }
</script>
