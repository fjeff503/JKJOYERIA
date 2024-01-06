{{-- Menu Lateral --}}
<nav class="sidebar sidebar-offcanvas bg-light navbar-light pt-4" id="sidebar">
    {{-- Items del menu --}}
    <ul class="nav">
        {{-- Nombre rol y fotografia --}}
        <li class="nav-item nav-profile">
            <div class="nav-link">
                <div class="profile-image">
                    {{-- FOTOGRAFIA --}}
                    {{-- <img src="{{ asset('melody/images/faces/face5.jpg') }}" alt="profile"> --}}
                    <i class="fas fa-solid fa-user text-primary"></i>
                </div>
                <div class="profile-name">
                    {{-- NOMBRE --}}
                    <p class="name">
                        Jefferson Pineda
                    </p>
                    {{-- ROL --}}
                    <p class="designation">
                        Super Admin
                    </p>
                </div>
            </div>
        </li>

        {{-- OPCIONES DEL MENU --}}
        {{-- DASHBOARD --}}
        <li class="nav-item">
            <a class="nav-link" href="/inicio">
                <i class="fa fa-home menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>

        {{-- CATEGORIA --}}
        <li class="nav-item">
            <a class="nav-link" href="/categories">
                <i class="fab fa-trello menu-icon"></i>
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
                <i class="fas fa-box menu-icon"></i>
                <span class="menu-title">Estado Paquetes</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="/payment_states">
                <i class="fas fa-receipt menu-icon"></i>
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
