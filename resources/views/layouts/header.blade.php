<?php
// @TODO:: this is temp solution due to lack of time, please find with valid standard
$fullUrl = Request::path();
$subUrl = explode('/', $fullUrl);
$url = $subUrl[0];
?>
<div class="header-wrapper">
    <div class="brand-header {{ $url == 'home' ? 'd-none' : '' }}">
        <a href="{{ route('home') }}"><img src="{{ asset('assets/image/esign-logo.png') }}"></a>
    </div>
    <div class="text-right px-3 pt-3">
        <span class="mr-3 font-blue-light-14">01/01/2018 12:00 PM</span>
        <a href="{{ route('logout') }}" style="margin-top: -3px"
           onclick="event.preventDefault();
                   document.getElementById('logout-form').submit();"
           class="btn access-button main-btn logout font-blue-light-12">Log Out</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>
    </div>
    <div class="header text-right">

        {{--<div class="list-inline-item">--}}
        {{--<img class="icon-head"  src="{{ asset('assets/image/home-icon.png') }}">--}}
        {{--<img class="ml-3 icon-head"  src="{{ asset('assets/image/us.png') }}">--}}
        {{--</div>--}}

        <div class="menu-wrapper" align="center">
            <a href="{{ route('myfiles') }}" class="circle" align="center">
                <img class="icon-head" src="{{ asset('assets/image/menu-icons/upload-document.png') }}">
            </a>
            <div class="menu-text">Upload Document</div>
        </div>
        <div class="menu-wrapper" align="center">
            <a href="{{ route('home') }}" class="circle" align="center">
                <img class="icon-head" src="{{ asset('assets/image/menu-icons/sign-document.png') }}">
            </a>
            <div class="menu-text">Sign Document</div>
        </div>
        <div class="menu-wrapper" align="center">
            <a href="{{ route('home') }}" class="circle" align="center">
                <img class="icon-head" src="{{ asset('assets/image/menu-icons/get-signed.png') }}">
            </a>
            <div class="menu-text">Get it Signed</div>
        </div>
        <div class="menu-wrapper" align="center">
            <a href="{{ route('home') }}" class="circle" align="center">
                <img class="icon-head" src="{{ asset('assets/image/menu-icons/send-document.png') }}">
            </a>
            <div class="menu-text">Send Document</div>
        </div>
        <div class="menu-wrapper" align="center">
            <a href="{{ route('home') }}" class="circle" align="center">
                <img class="icon-head" src="{{ asset('assets/image/menu-icons/template.png') }}">
            </a>
            <div class="menu-text">Create Template</div>
        </div>
        <div class="menu-wrapper" align="center">
            <a href="{{ route('home') }}" class="circle" align="center">
                <img class="icon-head" src="{{ asset('assets/image/menu-icons/users.png') }}">
            </a>
            <div class="menu-text">Add User</div>
        </div>
        <div class="menu-wrapper" align="center">
            <a href="{{ route('home') }}" class="circle" align="center">
                <img class="icon-head" src="{{ asset('assets/image/menu-icons/access.png') }}">
            </a>
            <div class="menu-text">Set up access</div>
        </div>
        <div class="menu-wrapper" align="center">
            <a href="{{ route('home') }}" class="circle" align="center">
                <img class="icon-head" src="{{ asset('assets/image/menu-icons/contacts.png') }}">
            </a>
            <div class="menu-text">Contact</div>
        </div>
        <div class="menu-wrapper" align="center">
            <a href="{{ route('home') }}" class="circle" align="center">
                <img class="icon-head" src="{{ asset('assets/image/menu-icons/recent-activity.png') }}">
            </a>
            <div class="menu-text">Recent Activity</div>
        </div>
        <div class="menu-wrapper" align="center">
            <a href="{{ route('home') }}" class="circle" align="center">
                <img class="icon-head" src="{{ asset('assets/image/menu-icons/message.png') }}">
            </a>
            <div class="menu-text">New Message</div>
        </div>

        <div class="menu-wrapper" align="center">
            <a href="{{ route('home') }}" class="circle" align="center">
                <img class="icon-head" src="{{ asset('assets/image/menu-icons/home.png') }}">
            </a>
            <div class="menu-text">Home</div>
        </div>

        {{--PROFILE MENU--}}
        <div class="menu-wrapper" align="center">
            <a href="{{ route('home') }}" class="circle" align="center">
                <img class="icon-head" src="{{ asset('assets/image/menu-icons/profile.png') }}">
            </a>
            <div class="menu-text">Profile</div>
        </div>
        {{--<div class="list-inline-item time-container">
            <span class="mr-3 font-blue-light-14">01/01/2018 12:00 PM</span>
        </div>--}}

    </div>
</div>
