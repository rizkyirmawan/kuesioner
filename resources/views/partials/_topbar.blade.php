        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            @if(auth())
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                @if(Auth::user()->role->role === 'Admin')
                  <span class="mr-2 d-none d-lg-inline text-gray-600 small">Administrator</span>
                  <img class="img-profile rounded-circle" src="{{ asset('img/user.png') }}" width="60">

                @else
                  <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->userable->nama }}</span>
                  @if(Auth::user()->userable->foto)
                    <img class="img-profile rounded-circle" src="{{ asset('storage/') . Auth::user()->userable->foto }}" width="60">
                  @else
                    <img class="img-profile rounded-circle" src="{{ asset('img/user.png') }}" width="60">
                  @endif
                @endif
                
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#">
                  <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                  Pengaturan
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>
            @endif

          </ul>

        </nav>
        <!-- End of Topbar -->
