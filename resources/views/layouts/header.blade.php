<header class="main-header">
  <!-- Logo -->
  <a href="{{ route('home') }}" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini"><b>eSign</b></span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg"><b>eSign</b></span>
  </a>
  <!-- Header Navbar: style can be found in header.less -->
  <nav class="navbar navbar-static-top navbar-clr">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
      <span class="sr-only">Toggle navigation</span>
    </a>

    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        <!-- Messages: style can be found in dropdown.less-->
        <li class="dropdown user user-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <img src="{{ asset('assets/image/avatar.png') }}" class="user-image" alt="Admin Image">
            <span class="hidden-xs">{{ Auth::user()->name }}</span>
          </a>
          <ul class="dropdown-menu">
            <!-- User image -->
            <li class="user-header">
              <img src="{{ asset('assets/image/avatar.png') }}" class="img-circle" alt="Admin Image">

              <p>
                {{ Auth::user()->name }}
              </p>
            </li>
            <!-- Menu Body -->

            <!-- Menu Footer-->
            <li class="user-footer">
              {{--<div class="pull-left">
                <a href="#" class="btn btn-default btn-flat">Profile</a>
              </div>--}}
              <div class="pull-right">
                {{--<a href="#" class="btn btn-default btn-flat">Sign out</a>--}}
                <a href="{{ route('logout') }}" class="btn btn-default btn-flat"
                   onclick="event.preventDefault();
                   document.getElementById('logout-form').submit();">
                  Logout
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  {{ csrf_field() }}
                </form>
              </div>
            </li>
          </ul>
        </li>
        <!-- Control Sidebar Toggle Button -->

      </ul>
    </div>
  </nav>
</header>