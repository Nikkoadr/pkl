<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/admin/dashboard" class="brand-link">
        <img src="{{ asset('assets/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- User Panel -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                @if (Auth::user()->foto && file_exists(public_path('storage/foto/' . Auth::user()->foto)))
                    <img src="{{ asset('storage/foto/' . Auth::user()->foto) }}" class="img-circle elevation-2" alt="User Image">
                @else
                    <img src="{{ asset('assets/dist/img/avatar.png') }}" class="img-circle elevation-2" alt="Default User Image">
                @endif
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->nama }}</a>
            </div>
        </div>
        

        <!-- Menu Sidebar -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                
                <li class="nav-item">
                    <a href="/home/dashboard" class="nav-link {{ request()->is('home/dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/home/dudi" class="nav-link {{ request()->is('home/dudi') ? 'active' : '' }}">
                        <i class="nav-icon fa-solid fa-building"></i>
                        <p>DU/DI</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/home/users" class="nav-link {{ request()->is('home/users') ? 'active' : '' }}">
                        <i class="nav-icon fa-solid fa-users"></i>
                        <p>Users</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/home/guru" class="nav-link {{ request()->is('home/guru') ? 'active' : '' }}">
                        <i class="nav-icon fa-solid fa-chalkboard-teacher"></i>
                        <p>Guru</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/home/guru_pembimbing" class="nav-link {{ request()->is('home/guru_pembimbing') ? 'active' : '' }}">
                        <i class="nav-icon fa-solid fa-user-tie"></i>
                        <p>Guru Pembimbing</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/home/peserta" class="nav-link {{ request()->is('home/peserta') ? 'active' : '' }}">
                        <i class="nav-icon fa-solid fa-children"></i>
                        <p>Peserta</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/home/tempat_pkl" class="nav-link {{ request()->is('home/tempat_pkl') ? 'active' : '' }}">
                        <i class="nav-icon fa-solid fa-map-location-dot"></i>
                        <p>Tempat PKL</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/home/surat" class="nav-link {{ request()->is('home/surat') ? 'active' : '' }}">
                        <i class="nav-icon fa-solid fa-envelopes-bulk"></i>
                        <p>Surat</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/home/ejurnal" class="nav-link {{ request()->is('home/ejurnal') ? 'active' : '' }}">
                        <i class="nav-icon fa-solid fa-book"></i>
                        <p>E-Jurnal</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/home/nilai_jurnal" class="nav-link {{ request()->is('home/nilai_jurnal') ? 'active' : '' }}">
                        <i class="nav-icon fa-solid fa-book"></i>
                        <p>Nilai Jurnal</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/home/nilai_sidang" class="nav-link {{ request()->is('home/nilai_sidang') ? 'active' : '' }}">
                        <i class="nav-icon fa-solid fa-book"></i>
                        <p>Nilai Sidang</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/home/esertifikat" class="nav-link {{ request()->is('home/esertifikat') ? 'active' : '' }}">
                        <i class="nav-icon fa-solid fa-certificate"></i>
                        <p>E-Sertifikat</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/home/pengaturan" class="nav-link {{ request()->is('home/pengaturan') ? 'active' : '' }}">
                        <i class="nav-icon fa-solid fa-cogs"></i>
                        <p>Pengaturan</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
