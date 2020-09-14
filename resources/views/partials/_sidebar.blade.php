    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
          <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Kuesio <sup>Alpha</sup></div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      @if(auth())
      <li class="nav-item {{ Request::segment(1) === 'dasbor' ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dasbor') }}">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dasbor</span></a>
      </li>
      @endif
      
      @if(Auth::user()->role->role === 'Admin')
      <!-- Divider -->
      <hr class="sidebar-divider">
      
      <!-- Heading -->
      <div class="sidebar-heading">
        Master Data
      </div>

      <li class="nav-item {{ Request::segment(1) === 'master' ? 'active' : '' }}">
        <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapseMaster">
          <i class="fas fa-fw fa-archive"></i>
          <span>Master</span>
        </a>
        <div id="collapseMaster" class="collapse {{ Request::segment(1) === 'master' ? 'show' : '' }}" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Kelola Master Data:</h6>
            <a class="collapse-item {{ Request::segment(2) === 'kelas' ? 'active' : '' }}" href="{{ route('kelas.index') }}">Kelas</a>
            <a class="collapse-item {{ Request::segment(2) === 'mata-kuliah' ? 'active' : '' }}" href="{{ route('matkul.index') }}">Mata Kuliah</a>
            <a class="collapse-item {{ Request::segment(2) === 'tahun-ajaran' ? 'active' : '' }}" href="{{ route('tahunAjaran.index') }}">Tahun Ajaran</a>
          </div>
        </div>
      </li>
      @endif
      
      @if(Auth::user()->role->role === 'Admin')
      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Manajemen Pengguna
      </div>

      <li class="nav-item {{ Request::segment(1) === 'users' ? 'active' : '' }}">
        <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapseUsers">
          <i class="fas fa-fw fa-users"></i>
          <span>Pengguna</span>
        </a>
        <div id="collapseUsers" class="collapse {{ Request::segment(1) === 'users' ? 'show' : '' }}" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Kelola Pengguna:</h6>
            <a class="collapse-item {{ Request::segment(2) === 'dosen' ? 'active' : '' }}" href="{{ route('dosen.index') }}">Dosen</a>
            <a class="collapse-item {{ Request::segment(2) === 'mahasiswa' ? 'active' : '' }}" href="{{ route('mahasiswa.index') }}">Mahasiswa</a>
            <a class="collapse-item {{ Request::segment(2) === 'alumni' ? 'active' : '' }}" href="{{ route('alumni.index') }}">Alumni</a>
          </div>
        </div>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">
      
      <!-- Heading -->
      <div class="sidebar-heading">
        Manajemen Kuesioner
      </div>

      <li class="nav-item {{ Request::segment(1) === 'kuesioner' ? 'active' : '' }}">
        <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapseKuesioner">
          <i class="fas fa-fw fa-book"></i>
          <span>Kuesioner</span>
        </a>
        <div id="collapseKuesioner" class="collapse {{ Request::segment(1) === 'kuesioner' ? 'show' : '' }}" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Kelola Kuesioner:</h6>
            <a class="collapse-item {{ Request::segment(2) === 'pembelajaran' ? 'active' : '' }}" href="{{ route('pembelajaran.index') }}">Pembelajaran</a>
            <a class="collapse-item {{ Request::segment(2) === 'layanan-mahasiswa' ? 'active' : '' }}" href="{{ route('kemahasiswaan.index') }}">Layanan Mahasiswa</a>
            <a class="collapse-item {{ Request::segment(2) === 'tracer-study' ? 'active' : '' }}" href="{{ route('tracerStudy.index') }}">Tracer Study</a>
          </div>
        </div>
      </li>
      @endif

      @if(Auth::user()->role->role === 'Dosen')
      <!-- Divider -->
      <hr class="sidebar-divider">
      
      <!-- Heading -->
      <div class="sidebar-heading">
        Respons Kuesioner
      </div>

      <li class="nav-item {{ Request::segment(1) === 'kuesioner' ? 'active' : '' }}">
        <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapseKuesioner">
          <i class="fas fa-fw fa-book"></i>
          <span>Kuesioner</span>
        </a>
        <div id="collapseKuesioner" class="collapse {{ Request::segment(1) === 'kuesioner' ? 'show' : '' }}" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Respons Kuesioner:</h6>
            <a class="collapse-item {{ Request::segment(3) === 'pembelajaran' ? 'active' : '' }}" href="{{ route('dosen.pembelajaran.index') }}">Pembelajaran</a>
          </div>
        </div>
      </li>
      @endif

      @if(Auth::user()->role->role === 'Mahasiswa')
      <!-- Divider -->
      <hr class="sidebar-divider">
      
      <!-- Heading -->
      <div class="sidebar-heading">
        Pengisian Kuesioner
      </div>

      <li class="nav-item {{ Request::segment(2) === 'kuesioner' ? 'active' : '' }}">
        <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapseMaster">
          <i class="fas fa-fw fa-book"></i>
          <span>Kuesioner</span>
        </a>
        <div id="collapseMaster" class="collapse {{ Request::segment(2) === 'kuesioner' ? 'show' : '' }}" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Pengisian Kuesioner:</h6>
            <a class="collapse-item {{ Request::segment(3) === 'pembelajaran' ? 'active' : '' }}" href="{{ route('mahasiswa.pembelajaran') }}">Pembelajaran</a>
            <a class="collapse-item {{ Request::segment(3) === 'layanan-mahasiswa' ? 'active' : '' }}" href="{{ route('mahasiswa.kemahasiswaan') }}">Layanan Mahasiswa</a>
          </div>
        </div>
      </li>
      @endif

      @if(Auth::user()->role->role === 'Alumni')
      <!-- Divider -->
      <hr class="sidebar-divider">
      
      <!-- Heading -->
      <div class="sidebar-heading">
        Pengisian Kuesioner
      </div>

      <li class="nav-item {{ Request::segment(2) === 'kuesioner' ? 'active' : '' }}">
        <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapseMaster">
          <i class="fas fa-fw fa-book"></i>
          <span>Kuesioner</span>
        </a>
        <div id="collapseMaster" class="collapse {{ Request::segment(2) === 'kuesioner' ? 'show' : '' }}" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Pengisian Kuesioner:</h6>
            <a class="collapse-item {{ Request::segment(3) === 'tracer-study' ? 'active' : '' }}" href="{{ route('alumni.tracerStudy') }}">Tracer Study</a>
          </div>
        </div>
      </li>
      @endif

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->
