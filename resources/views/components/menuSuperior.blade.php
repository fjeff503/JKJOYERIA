    <!--MENU SUPERIOR-->
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row default-layout-navbar navbar-dark bg-dark">
        {{-- Logos responsivos --}}
        <div
            class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center navbar-dark bg-dark">
            <a class="navbar-brand brand-logo mr-0" href="/"><img src="{{ asset('melody/images/logo.png') }}"
                    alt="logo"></a>
            <a class="navbar-brand brand-logo-mini" href="/"><img src="{{ asset('melody/images/logo-mini.svg') }}"
                    alt="logo">
            </a>
        </div>
        {{-- FIN Logos responsivos --}}

        <div class="navbar-menu-wrapper d-flex align-items-stretch">
            {{-- Boton para desplazar el menu a la izquierda --}}
            <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                <span class="fas fa-bars"></span>
            </button>
            {{-- FIN Boton para desplazar el menu a la izquierda --}}

            {{-- Boton para desplazar el menu a la izquierda cuando este en celular --}}
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
                data-toggle="offcanvas">
                <span class="fas fa-bars"></span>
            </button>
            {{-- FIN Boton para desplazar el menu a la izquierda cuando este en celular --}}

            {{-- Opciones del empleado --}}
            <ul class="navbar-nav navbar-nav-right">
                <li class="nav-item nav-profile dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                        <i class="fas fa-user text-white"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                        <a class="dropdown-item">
                            <i class="fas fa-cog text-primary"></i>
                            Settings
                        </a>
                        <div class="dropdown-divider"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item" style="background: none; border: none; width: 100%; text-align: left;">
                                <i class="fas fa-power-off text-primary"></i> Cerrar sesión
                            </button>
                        </form>
                    </div>
                </li>
                {{-- Opciones personales de cada --}}
                @yield('options')
            </ul>
            {{-- FIN Opciones del empleado --}}


        </div>
    </nav>
