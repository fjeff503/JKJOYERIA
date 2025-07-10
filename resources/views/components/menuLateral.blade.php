{{-- Menu Lateral --}}
<nav class="sidebar sidebar-offcanvas bg-light navbar-light pt-4" id="sidebar">
    {{-- Items del menu --}}
    <ul class="nav">


        {{-- OPCIONES DEL MENU --}}
        {{-- DASHBOARD --}}
        <li class="nav-item">
            <a class="nav-link" href="/">
                <i class="fas fa-home menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>


        {{-- CATEGORIA --}}
        @if (Auth::user()->role->name === 'admin')
            <li class="nav-item">
                <a class="nav-link" href="/categories">
                    <i class="fas fa-folder menu-icon"></i>
                    <span class="menu-title">Categor&iacute;as</span>
                </a>
            </li>
        @endif

        {{-- CLIENTES --}}
        <li class="nav-item">
            <a class="nav-link" href="/clients">
                <i class="fas fa-users menu-icon"></i>
                <span class="menu-title">Clientes</span>
            </a>
        </li>

        {{-- ESTADO DE LOS PAQUETES --}}
        @if (Auth::user()->role->name === 'admin')
            <li class="nav-item">
                <a class="nav-link" href="/package_states">
                    <i class="fas fa-archive menu-icon"></i>
                    <span class="menu-title">Estado Paquetes</span>
                </a>
            </li>
        @endif

        {{-- ESTADOS DE PAGO --}}
        @if (Auth::user()->role->name === 'admin')
            <li class="nav-item">
                <a class="nav-link" href="/payment_states">
                    <i class="fas fa-check-square menu-icon"></i>
                    <span class="menu-title">Estado Pagos</span>
                </a>
            </li>
        @endif

        {{-- ENCOMENDISTAS --}}
        <li class="nav-item">
            <a class="nav-link" href="/parcels">
                <i class="fas fa-truck menu-icon"></i>
                <span class="menu-title">Encomendistas</span>
            </a>
        </li>

        {{-- PROVEEDORES --}}
        @if (Auth::user()->role->name === 'admin')
            <li class="nav-item">
                <a class="nav-link" href="/providers">
                    <i class="fas fa-user-tie menu-icon"></i>
                    <span class="menu-title">Proveedores</span>
                </a>
            </li>
        @endif

        {{-- PUNTOS DE ENTREGA --}}
        <li class="nav-item">
            <a class="nav-link" href="/delivery_points">
                <i class="fas fa-map-pin menu-icon"></i>
                <span class="menu-title">Puntos de entrega</span>
            </a>
        </li>

        {{-- PRODUCTOS --}}
        <li class="nav-item">
            <a class="nav-link" href="/products">
                <i class="fas fa-tags menu-icon"></i>
                <span class="menu-title">Productos</span>
            </a>
        </li>

        {{-- USUARIOS --}}
        @if (Auth::user()->role->name === 'admin')
            <li class="nav-item">
                <a class="nav-link" href="/users">
                    <i class="fas fa-user menu-icon"></i>
                    <span class="menu-title">Usuarios</span>
                </a>
            </li>
        @endif

        {{-- ERRORES --}}
        @if (Auth::user()->role->name === 'admin')
            <li class="nav-item">
                <a class="nav-link" href="/bugs">
                    <i class="fas fa-bug menu-icon"></i>
                    <span class="menu-title">Errores</span>
                </a>
            </li>
        @endif

        {{-- COMPRAS --}}
        @if (Auth::user()->role->name === 'admin')
            <li class="nav-item">
                <a class="nav-link" href="/purchases">
                    <i class="fas fa-box menu-icon"></i>
                    <span class="menu-title">Compras</span>
                </a>
            </li>
        @endif

        {{-- VENTAS --}}
        <li class="nav-item">
            <a class="nav-link" href="/sales">
                <i class="fas fa-shopping-cart menu-icon"></i>
                <span class="menu-title">Ventas</span>
            </a>
        </li>

        {{-- REPORTES --}}
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
