@php
    $role = auth()->user()->role;

    $menus = [
        [
            'title' => 'Dashboard',
            'icon' => 'bi-house-fill',
            'url' => 'dashboard',
            'roles' => ['1', '2', '3'],
        ],
        [
            'title' => 'Data Anggota',
            'icon' => 'bi-people-fill',
            'url' => 'anggota',
            'roles' => ['1', '3'],
        ],
        [
            'title' => 'Transaksi',
            'icon' => 'bi-cash-stack',
            'roles' => ['1', '2', '3'],
            'submenu' => [
                ['title' => 'Tambah Transaksi', 'url' => 'transaksi'],
                ['title' => 'Daftar Transaksi', 'url' => 'datatrans'],
            ],
        ],
        [
            'title' => 'Laporan Transaksi',
            'icon' => 'bi-file-earmark-text',
            'url' => 'laporan',
            'roles' => ['1', '2', '3'],
        ],
        [
            'title' => 'Riwayat Perubahan',
            'icon' => 'bi-clock-history',
            'url' => 'perubahan',
            'roles' => ['3'],
        ],
        [
            'title' => 'User Management',
            'icon' => 'bi-gear-fill',
            'roles' => ['1', '3'],
            'submenu' => [['title' => 'Profil', 'url' => 'profil'], ['title' => 'Users', 'url' => 'users']],
        ],
    ];
@endphp


<!--start sidebar -->
<aside class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div>
            <img src="assets/images/logo-icon.png" class="logo-icon" alt="logo icon">
        </div>
        <div>
            <h4 class="logo-text">Onedash</h4>
        </div>
        <div class="toggle-icon ms-auto"> <i class="bi bi-list"></i>
        </div>
    </div>
    <!--navigation-->
    <ul class="metismenu" id="menu">
        @foreach ($menus as $menu)
            @if (in_array($role, $menu['roles']))
                <li>
                    <a href="{{ isset($menu['submenu']) ? 'javascript:;' : url($menu['url']) }}"
                        {{ isset($menu['submenu']) ? 'class=has-arrow' : '' }}>
                        <div class="parent-icon"><i class="bi {{ $menu['icon'] }}"></i></div>
                        <div class="menu-title">{{ $menu['title'] }}</div>
                    </a>

                    @if (isset($menu['submenu']))
                        <ul>
                            @foreach ($menu['submenu'] as $submenu)
                                <li><a href="{{ url($submenu['url']) }}"><i class="bi bi-circle"></i>
                                        {{ $submenu['title'] }}</a></li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endif
        @endforeach
    </ul>
    <!--end navigation-->
</aside>
<!--end sidebar -->
