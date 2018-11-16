<!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">

      <?php
          // @TODO:: this is temp solution due to lack of time, please find with valid standard
          $fullUrl = Request::path();
          $subUrl = explode('/', $fullUrl);
          $url = $subUrl[0];
      ?>
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="{{ $url == 'home' ? 'active' : '' }}">
          <a href="{{ route('home') }}">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>
        <li>
          <a href="#">
            <i class="fa fa-user"></i> <span>Manage Accounts</span>
          </a>
        </li>
        <li>
          <a href="#">
            <i class="fa fa-address-book"></i> <span>Manage Contacts</span>
          </a>
        </li>
        <li class="{{ $url == 'myfiles' ? 'active' : '' }}">
          <a href="{{ route('myfiles') }}">
            <i class="fa fa-file"></i> <span>My Files</span>
          </a>
        </li>
        <li>
          <a href="#">
            <i class="fa fa-history"></i> <span>Transaction History</span>
          </a>
        </li>
        <li>
          <a href="#">
            <i class="fa fa-pencil-square-o"></i> <span>Sign My Document</span>
          </a>
        </li>
        <li>
          <a href="#">
            <i class="fa fa-pencil-square-o"></i> <span>Get It Signed!</span>
          </a>
        </li>
        <li>
          <a href="#">
            <i class="fa fa-universal-access"></i> <span>Manage Access</span>
          </a>
        </li>
        <li>
          <a href="#">
            <i class="fa fa-envelope"></i> <span>Messages</span>
          </a>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
