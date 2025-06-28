{{-- Menu Lateral --}}
<nav class="sidebar sidebar-offcanvas bg-light navbar-light pt-4" id="sidebar">
    {{-- Items del menu --}}
    <ul class="nav">
        {{-- Nombre rol y fotografia --}}
        @if (Auth::check())
        <li class="nav-item nav-profile">
            <div class="nav-link">
                <div class="profile-image">
                    {{-- FOTOGRAFIA --}}
                    {{-- <img src="{{ asset('melody/images/faces/face5.jpg') }}" alt="profile"> --}}
                    <i class="fas fa-solid fa-user text-primary"></i>
                </div>
                <div class="profile-name">
                    {{-- NOMBRE --}}
                    <p class="name" style="max-width: 100%; white-space: normal; word-wrap: break-word; overflow-wrap: break-word;">
                        {{ Auth::user()->name }}
                    </p>
                    {{-- ROL --}}
                    <p class="designation">
                        @if (Auth::user()->idRole == 1)
                            Usuario
                        @elseif (Auth::user()->idRole == 2)
                            Vendedor
                        @elseif (Auth::user()->idRole == 3)
                            Administrador
                        @else
                            Rol desconocido
                        @endif
                    </p>
                </div>
            </div>
        </li>
        @endif

        {{-- OPCIONES DEL MENU --}}
        {{-- DASHBOARD --}}
        <li class="nav-item">
            <a class="nav-link" href="/inicio">
                <i class="fas fa-home menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>

        {{-- CATEGORIA --}}
        <li class="nav-item">
            <a class="nav-link" href="/categories">
                <i class="fas fa-tags menu-icon"></i>
                <span class="menu-title">Categor&iacute;as</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="/clients">
                <i class="fas fa-users menu-icon"></i>
                <span class="menu-title">Clientes</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="/package_states">
                <i class="fas fa-archive menu-icon"></i>
                <span class="menu-title">Estado Paquetes</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="/payment_states">
                <i class="fas fa-check-square menu-icon"></i>
                <span class="menu-title">Estado Pagos</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="/parcels">
                <i class="fas fa-truck menu-icon"></i>
                <span class="menu-title">Encomendistas</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="/providers">
                <i class="fas fa-cart-plus menu-icon"></i>
                <span class="menu-title">Proveedores</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="/delivery_points">
                <i class="fas fa-map-pin menu-icon"></i>
                <span class="menu-title">Puntos de entrega</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="/products">
                <i class="fas fa-plus-square menu-icon"></i>
                <span class="menu-title">Productos</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="/users">
                <i class="fas fa-user menu-icon"></i>
                <span class="menu-title">Usuarios</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="/bugs">
                <i class="fas fa-bug menu-icon"></i>
                <span class="menu-title">Errores</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#page-layouts" aria-expanded="false"
                aria-controls="page-layouts">
                <i class="far fa-file-alt menu-icon"></i>
                <span class="menu-title">Reportes</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="page-layouts">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link"
                            href="pages/layout/boxed-layout.html">Categor&iacute;as</a></li>
                    <li class="nav-item"> <a class="nav-link" href="pages/layout/rtl-layout.html">Eliminar</a></li>
                    <li class="nav-item"> <a class="nav-link" href="pages/layout/horizontal-menu.html">Horizontal
                            Menu</a></li>
                </ul>
            </div>
        </li>
    </ul>
</nav>
{{-- FIN Menu Lateral --}}
