<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/home/dashboard" class="brand-link">
        <img src="{{ asset('assets/dist/img/logo.png') }}" alt="PKL" class="brand-image elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- User Panel -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                    <img src="{{ auth()->user()->foto_profil ? asset('storage/foto_profil/' . auth()->user()->foto_profil) : asset('assets/dist/img/avatar.png') }}" class="img-circle elevation-2" alt="Foto Profil">
            </div>
            <div class="info">
                <a href="/home/profil" class="d-block">{{ Auth::user()->nama }}</a>
            </div>
        </div>
        
        <!-- Menu Sidebar -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Dashboard -->
                    <li class="nav-item">
                        <a href="/home/dashboard" class="nav-link {{ request()->is('home/dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    @can('guru_penguji')
                        <li class="nav-item">
                            <a href="/home/sidang_pkl" class="nav-link {{ request()->is('home/sidang_pkl') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-file-alt"></i>
                                <p>Sidang PKL</p>
                            </a>
                        </li>
                    @endcan
                    @can('admin')
                        <li class="nav-item {{ request()->is('home/tahun_ajaran','home/dudi','home/users','home/kelas') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ request()->is('home/tahun_ajaran','home/dudi','home/users','home/kelas') ? 'active' : '' }}">
                                <i class="nav-icon fa-solid fa-database"></i>
                                <p>
                                    Master Data
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="/home/tahun_ajaran" class="nav-link {{ request()->is('home/tahun_ajaran') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Tahun Ajaran</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/home/kelas" class="nav-link {{ request()->is('home/kelas') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Kelas</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/home/dudi" class="nav-link {{ request()->is('home/dudi') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>DU/DI</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item {{ request()->is('home/guru','home/guru_pembimbing','home/kaprodi') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->is('home/guru','home/guru_pembimbing','home/kaprodi') ? 'active' : '' }}">
                            <i class="nav-icon fa-solid fa-chalkboard-teacher"></i>
                            <p>
                                Guru
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/home/guru" class="nav-link {{ request()->is('home/guru') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Guru</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/home/kaprodi" class="nav-link {{ request()->is('home/kaprodi') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Kaprodi</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/home/guru_pembimbing" class="nav-link {{ request()->is('home/guru_pembimbing') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Guru Pembimbing</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="/home/peserta" class="nav-link {{ request()->is('home/peserta') ? 'active' : '' }}">
                            <i class="nav-icon fa-solid fa-children"></i>
                            <p>Peserta</p>
                        </a>
                    </li>
                    <li class="nav-item {{ request()->is('home/peserta_pkl','home/surat') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->is('home/peserta_pkl','home/surat') ? 'active' : '' }}">
                            <i class="nav-icon fa-solid fa-map-location-dot"></i>
                            <p>
                                PKL
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/home/peserta_pkl" class="nav-link {{ request()->is('home/peserta_pkl') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Peserta PKL</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/home/surat" class="nav-link {{ request()->is('home/surat') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Surat</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="/home/sidang_pkl" class="nav-link {{ request()->is('home/sidang_pkl') ? 'active' : '' }}">
                            <i class="nav-icon fa-solid fa-file-alt"></i>
                            <p>Sidang PKL</p>
                        </a>
                    </li>
                    <li class="nav-item {{ request()->is('home/logbook','home/nilai_pkl','home/nilai_sidang') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->is('home/logbook','home/nilai_pkl','home/nilai_sidang') ? 'active' : '' }}">
                            <i class="nav-icon fa-solid fa-book"></i>
                            <p>
                                Logbook & Nilai
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/home/logbook" class="nav-link {{ request()->is('home/logbook') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Logbook</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/home/nilai_pkl" class="nav-link {{ request()->is('home/nilai_pkl') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Nilai PKL</p>
                                </a>
                            </li>
                        </ul>
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
                @endcan
                @can('prodi')
                    <li class="nav-item {{ request()->is('home/tahun_ajaran','home/dudi','home/users','home/kelas') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->is('home/tahun_ajaran','home/dudi','home/users','home/kelas') ? 'active' : '' }}">
                            <i class="nav-icon fa-solid fa-database"></i>
                            <p>
                                Master Data
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/home/dudi" class="nav-link {{ request()->is('home/dudi') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>DU/DI</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item {{ request()->is('home/guru','home/guru_pembimbing') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->is('home/guru','home/guru_pembimbing') ? 'active' : '' }}">
                            <i class="nav-icon fa-solid fa-chalkboard-teacher"></i>
                            <p>
                                Guru
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/home/guru_pembimbing" class="nav-link {{ request()->is('home/guru_pembimbing') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Guru Pembimbing</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="/home/peserta" class="nav-link {{ request()->is('home/peserta') ? 'active' : '' }}">
                            <i class="nav-icon fa-solid fa-children"></i>
                            <p>Peserta</p>
                        </a>
                    </li>
                    <li class="nav-item {{ request()->is('home/peserta_pkl','home/surat') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->is('home/peserta_pkl','home/surat') ? 'active' : '' }}">
                            <i class="nav-icon fa-solid fa-map-location-dot"></i>
                            <p>
                                PKL
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/home/peserta_pkl" class="nav-link {{ request()->is('home/peserta_pkl') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Peserta PKL</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/home/surat" class="nav-link {{ request()->is('home/surat') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Surat</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="/home/sidang_pkl" class="nav-link {{ request()->is('home/sidang_pkl') ? 'active' : '' }}">
                            <i class="nav-icon fa-solid fa-file-alt"></i>
                            <p>Sidang PKL</p>
                        </a>
                    </li>
                    <li class="nav-item {{ request()->is('home/logbook','home/nilai_pkl','home/nilai_sidang') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->is('home/logbook','home/nilai_pkl','home/nilai_sidang') ? 'active' : '' }}">
                            <i class="nav-icon fa-solid fa-book"></i>
                            <p>
                                Logbook & Nilai
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/home/logbook" class="nav-link {{ request()->is('home/logbook') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Logbook</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/home/nilai_pkl" class="nav-link {{ request()->is('home/nilai_pkl') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Nilai PKL</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="/home/esertifikat" class="nav-link {{ request()->is('home/esertifikat') ? 'active' : '' }}">
                            <i class="nav-icon fa-solid fa-certificate"></i>
                            <p>E-Sertifikat</p>
                        </a>
                    </li>
                @endcan
                @can('guru_pembimbing')
                    <li class="nav-item {{ request()->is('home/tahun_ajaran','home/dudi','home/users','home/kelas') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->is('home/tahun_ajaran','home/dudi','home/users','home/kelas') ? 'active' : '' }}">
                            <i class="nav-icon fa-solid fa-database"></i>
                            <p>
                                Master Data
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/home/dudi" class="nav-link {{ request()->is('home/dudi') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>DU/DI</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item {{ request()->is('home/peserta_pkl','home/surat') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->is('home/peserta_pkl','home/surat') ? 'active' : '' }}">
                            <i class="nav-icon fa-solid fa-map-location-dot"></i>
                            <p>
                                PKL
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/home/peserta_pkl" class="nav-link {{ request()->is('home/peserta_pkl') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Peserta PKL</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/home/surat" class="nav-link {{ request()->is('home/surat') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Surat</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item {{ request()->is('home/logbook','home/nilai_pkl','home/nilai_sidang') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->is('home/logbook','home/nilai_pkl','home/nilai_sidang') ? 'active' : '' }}">
                            <i class="nav-icon fa-solid fa-book"></i>
                            <p>
                                Logbook & Nilai
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/home/logbook" class="nav-link {{ request()->is('home/logbook') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Logbook</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/home/nilai_pkl" class="nav-link {{ request()->is('home/nilai_pkl') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Nilai PKL</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
                @can('peserta')
                    <li class="nav-item {{ request()->is('home/logbook','home/nilai_pkl','home/nilai_sidang') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->is('home/logbook','home/nilai_pkl','home/nilai_sidang') ? 'active' : '' }}">
                            <i class="nav-icon fa-solid fa-book"></i>
                            <p>
                                Logbook & Nilai
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/home/logbook" class="nav-link {{ request()->is('home/logbook') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Logbook</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/home/nilai_pkl" class="nav-link {{ request()->is('home/nilai_pkl') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Nilai PKL</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
                </ul>
            </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
