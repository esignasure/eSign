@extends('layouts.main')

@section('content')

    <div class="container-fluid">
        {{--<div class="file-content text-center" align="center">
            <section class="header-my-files mb-2">
                <h3 class="header-text">My Documents / Files / Cabinets</h3>
            </section>
            <div class="folder-container mt-3" style="display: table">
                <ul>
                    <li>
                        <a href="/uploads">
                            <div class="folder">
                                <i class="fa fa-folder mr-2" aria-hidden="true"></i>
                            </div>
                            <div class="folder-text">Uploads</div>
                        </a>
                    </li>
                    <li>
                        <a href="/paused">
                            <div class="folder">
                                <i class="fa fa-folder mr-2" aria-hidden="true"></i>
                            </div>
                            <div class="folder-text">Paused</div>
                        </a>
                    </li>
                    <li>
                        <a href="/my-signed-documents">
                            <div class="folder">
                                <i class="fa fa-folder mr-2" aria-hidden="true"></i>
                            </div>
                            <div class="folder-text">My Signed Documents</div>
                        </a>
                    </li>
                    <li>
                        <a href="/deleted">
                            <div class="folder">
                                <i class="fa fa-folder mr-2" aria-hidden="true"></i>
                            </div>
                            <div class="folder-text">Deleted</div>
                        </a>
                    </li>
                    <li>
                        <a href="/history">
                            <div class="folder">
                                <i class="fa fa-folder mr-2" aria-hidden="true"></i>
                            </div>
                            <div class="folder-text">History</div>
                        </a>
                    </li>
                    <li>
                        <a href="/signed">
                            <div class="folder">
                                <i class="fa fa-folder mr-2" aria-hidden="true"></i>
                            </div>
                            <div class="folder-text">Signed</div>
                        </a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
        </div>--}}

        <div class="position-relative">
            <div class="folder-list-wrapper">
                <section class="header-my-files">
                    <h3 class="folder-navigation">My Documents</h3>
                </section>
                <div class="folder-container mt-3">
                    <ul>
                        <li>
                            <a href="/uploads">
                                <div class="folder">
                                    <i class="fa fa-folder mr-2" aria-hidden="true"></i>
                                </div>
                                <div class="folder-text">Uploads</div>
                            </a>
                        </li>
                        <li>
                            <a href="/paused">
                                <div class="folder">
                                    <i class="fa fa-folder mr-2" aria-hidden="true"></i>
                                </div>
                                <div class="folder-text">Paused</div>
                            </a>
                        </li>
                        <li>
                            <a href="/my-signed-documents">
                                <div class="folder">
                                    <i class="fa fa-folder mr-2" aria-hidden="true"></i>
                                </div>
                                <div class="folder-text">My Signed Documents</div>
                            </a>
                        </li>
                        <li>
                            <a href="/deleted">
                                <div class="folder">
                                    <i class="fa fa-folder mr-2" aria-hidden="true"></i>
                                </div>
                                <div class="folder-text">Deleted</div>
                            </a>
                        </li>
                        <li>
                            <a href="/history">
                                <div class="folder">
                                    <i class="fa fa-folder mr-2" aria-hidden="true"></i>
                                </div>
                                <div class="folder-text">History</div>
                            </a>
                        </li>
                        <li>
                            <a href="/signed">
                                <div class="folder">
                                    <i class="fa fa-folder mr-2" aria-hidden="true"></i>
                                </div>
                                <div class="folder-text">Signed</div>
                            </a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="file-content">
                <div class="file-container">
                    <div class="empty-folder text-center">
                        This folder is empty
                    </div>
                    <div class="text-center drag-drop-box">
                        <br/>
                        <div class="drag-text">Drag and drop files onto this windows to upload.</div>

                        <label style="    font-size: 16px;margin: 10px 0;">Or</label>
                        <br/>
                        <a href="#" title="Upload Files"><i class="fa fa-upload mr-2" aria-hidden="true"></i>Click here to upload.</a>

                    </div>
                </div>
            </div>
            <div class="file-tool">
                <ul class="file-tool-list">
                    <li>
                        <a href="#" title="Upload Files"><i class="fa fa-upload mr-2" aria-hidden="true"></i>Upload Documents</a>
                    </li>
                    {{--<li>
                        <a href="#" title="Upload Folder"><i class="fa fa-folder-o mr-2" aria-hidden="true"></i>Upload Folder</a>
                    </li>--}}
                    <li>
                        <a href="#" title="New Folder"><i class="fa fa-folder-o mr-2" aria-hidden="true"></i>New Folder</a>
                    </li>
                </ul>
            </div>

        </div>
    </div>

    {{--<div class="file-tool">
        <ul class="file-tool-list">
            <li>
                <a href="#" title="Upload Files"><i class="fa fa-upload mr-2" aria-hidden="true"></i>Upload Files</a>
            </li>
            --}}{{--<li>
                <a href="#" title="Upload Folder"><i class="fa fa-folder-o mr-2" aria-hidden="true"></i>Upload Folder</a>
            </li>--}}{{--
            <li>
                <a href="#" title="New Folder"><i class="fa fa-folder-o mr-2" aria-hidden="true"></i>New Folder</a>
            </li>
        </ul>
    </div>--}}
@stop


