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
                    <div v-else class="empty-directory">This folder is empty.</div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="file-content">
                <div class="file-container">
                    <div class="text-center drag-drop-box">
                        <br/>
                        <div class="drag-text">Drag and drop files onto this windows to upload.</div>

                        <label style="font-size: 16px;margin: 10px 0;">Or</label>
                        <br/>
                        <a title="Upload Files" class="link-btn"><i class="fa fa-upload mr-2" aria-hidden="true"></i>Click here to upload.</a>

                    </div>
                </div>
            </div>
            <div class="file-tool">
                <ul class="file-tool-list">
                    <li>
                        <a class="link-btn" title="Upload Files"><i class="fa fa-upload mr-2" aria-hidden="true"></i>Upload Documents</a>
                    </li>
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
    require('../main');
    export default {
        name: "documents",
        data: function () {
            return {
                showLoader: false,
                url: 'create-folder',
                folders: [],
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
                }
            }
        },
        created: function () {
            this.showLoader = true;
            this.getFolders();
        },
        components: {

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
                        this.folders = response.data.data;
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
                        this.folders = response.data.data;
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

            testMethod: function () {
                notify.methods.notifySuccess('this is success message');
            }
        }
    }
</script>
