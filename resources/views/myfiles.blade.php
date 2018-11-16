@extends('layouts.main')

@section('content')
    <div class="content-wrapper">
        <div class="container-fluid">
            <section class="header-my-files">
                <h3 class="header-text">My Files</h3>
            </section>
            <div class="position-relative">
                <div class="file-menu">
                    <ul class="file-menu-list">
                        <li>
                            <a href="#" class="active" title="Uploads">Uploads</a>
                        </li>
                        <li>
                            <a href="#" title="Paused">Paused</a>
                        </li>
                        <li>
                            <a href="#" title="My Signed Documents">My Signed Documents</a>
                        </li>
                        <li>
                            <a href="#" title="History">History</a>
                        </li>
                        <li>
                            <a href="#" title="Signed">Signed</a>
                        </li>
                        <li>
                            <a href="#" title="Deleted">Deleted</a>
                        </li>
                    </ul>
                </div>
                <div class="file-content">
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb" style="background: transparent;">
                            <li><a href="#">My Files</a></li>
                            <li class="active">Uploads</li>
                        </ol>
                    </div>
                    <div class="file-container">
                        {{--Files contect will be go here--}}
                        <div class="empty-folder">
                            This folder is empty
                        </div>
                    </div>
                </div>
                <div class="file-tool">
                    <ul class="file-tool-list">
                        <li>
                            <a href="#" title="Upload Files"><i class="fa fa-upload mr-5" aria-hidden="true"></i>Upload Files</a>
                        </li>
                        <li>
                            <a href="#" title="Upload Folder"><i class="fa fa-folder-o mr-5" aria-hidden="true"></i>Upload Folder</a>
                        </li>
                        <li>
                            <a href="#" title="New Folder"><i class="fa fa-folder-o mr-5" aria-hidden="true"></i>New Folder</a>
                        </li>
                    </ul>
                </div>
            </div>

    </div>
    </div>
@stop


