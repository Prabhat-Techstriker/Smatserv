  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
   <!--  <a href="index3.html" class="brand-link">
      <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a> -->

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('public/dist/img/userpic.png') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="{{url('dashboard')}}" class="d-block">Admin</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column sidebar" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item has-treeview" id="klo">
            <!-- <a href="javascript:" class="nav-link active"> -->
            <a href="{{url('add-vehicle')}}" class="nav-link">
              <i class="nav-icon fa fa-wrench"></i>
              <p>
                Providers Approval
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{url('admin/providers-list')}}" class="nav-link">
                  <!-- <i class="far fa-circle nav-icon"></i> -->
                  <i class="far fa-check-square"></i>
                  <p>Providers List</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item has-treeview">
            <a href="javascript:" class="nav-link">
              <i class="nav-icon fa fa-users"></i>
              <p>
                Service
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{url('admin/all-users-list')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Users</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('admin/all-providers-list')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Providers</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item has-treeview">
            <a href="javascript:" class="nav-link">
              <i class="nav-icon fa fa-car"></i>
              <p>
                Service vehicle prices
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{url('admin/add-vehicle')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add service vehicle</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('admin/vehicle-list')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>List vehicles</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item has-treeview">
            <a href="javascript:" class="nav-link">
              <i class="fas fa-shopping-bag"></i>
              <p>
                Payment Info
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{url('admin/payment-info')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Payment List</p>
                </a>
              </li>
              <!-- <li class="nav-item">
                <a href="{{url('admin/vehicle-list')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>List vehicles</p>
                </a>
              </li> -->
            </ul>
          </li>

          <li class="nav-item has-treeview">
            <a href="{{url('admin/review')}}" class="nav-link">
              <i class="fa fa-star"></i>
              <p>
                Rating-Review
                <!-- <i class="fas fa-angle-left right"></i> -->
              </p>
            </a>
          </li>

          <li class="nav-item has-treeview">
            <a href="{{url('admin/advertisement')}}" class="nav-link">
              <i class="fab fa-adversal"></i>
              <p>
                Advertisement
                <!-- <i class="fas fa-angle-left right"></i> -->
              </p>
            </a>
          </li>

          <li class="nav-item has-treeview">
            <a href="{{url('admin/offerspage')}}" class="nav-link">
              <i class="fas fa-bell"></i>
              <p>
                Offers
                <!-- <i class="fas fa-angle-left right"></i> -->
              </p>
            </a>
          </li>

          <li class="nav-item has-treeview">
            <a href="{{url('admin/support')}}" class="nav-link">
              <i class="fas fa-info-circle"></i>
              <p>
                Support
                <!-- <i class="fas fa-angle-left right"></i> -->
              </p>
            </a>
          </li>

          <li class="nav-item has-treeview">
            <a href="{{url('admin/about-us')}}" class="nav-link">
              <i class="far fa-address-book"></i>
              <p>
                About us
                <!-- <i class="fas fa-angle-left right"></i> -->
              </p>
            </a>
          </li>

          <li class="nav-item has-treeview">
            <a href="{{url('admin/privacy-policy')}}" class="nav-link">
              <i class="fas fa-user-secret"></i>
              <p>
                Privacy policy
                <!-- <i class="fas fa-angle-left right"></i> -->
              </p>
            </a>
          </li>

          <li class="nav-item has-treeview">
            <a href="{{url('admin/FAQ')}}" class="nav-link">
              <i class="far fa-question-circle"></i>
              <p>
                FAQ
                <!-- <i class="fas fa-angle-left right"></i> -->
              </p>
            </a>
          </li>

          <li class="nav-item has-treeview">
            <a href="{{url('admin/contact-us')}}" class="nav-link">
              <i class="fas fa-address-book"></i>
              <p>
                Contact us
                <!-- <i class="fas fa-angle-left right"></i> -->
              </p>
            </a>
          </li>

          <li class="nav-item has-treeview">
            <a href="{{url('/logout')}}" class="nav-link">
              <i class="fa fa-power-off"></i>
              <p>
                Logout
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>