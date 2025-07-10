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
            @if (Auth::check())
                <ul class="navbar-nav navbar-nav-right">
                    <li class="nav-item nav-profile dropdown border-0">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#"
                            data-toggle="dropdown" id="profileDropdown">
                            <div class="profile-image">
                                {{-- FOTOGRAFIA --}}
                                @if (Auth::user()->profile_photo)
                                    <img src="{{ Auth::user()->profile_photo }}" alt="Foto de perfil"
                                        style="width: 3rem; height: 3rem; border-radius: 50%;">
                                @else
                                    <i class="fas fa-solid fa-user text-white" style="font-size: 20px;"></i>
                                @endif
                            </div>
                            <div class="profile-name mx-3">
                                {{-- NOMBRE --}}
                                <p class="mb-0" style="font-weight: bold; font-size: 1em;">
                                    {{ Auth::user()->name }}
                                </p>
                                {{-- ROL --}}
                                <p class="mb-0" style="font-size: 0.7em; color: #c3c3c3;">
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
                        </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown"
                            aria-labelledby="profileDropdown">
                            <a class="dropdown-item" href="/users/profile/{{ Auth::id() }}">
                                <i class="fas fa-cog text-primary"></i> Perfil
                            </a>
                            <div class="dropdown-divider"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <div class="dropdown-item m-0 p-0">
                                    <button type="submit" class="dropdown-item"
                                        style="background: none; border: none; width: 100%; text-align: left; cursor:pointer;">
                                        <i class="fas fa-power-off text-primary"></i> Cerrar sesión
                                    </button>
                                </div>
                            </form>
                        </div>
                    </li>
                    {{-- Opciones personales de cada --}}
                    @yield('options')
                </ul>
            @endif
            {{-- FIN Opciones del empleado --}}


        </div>
    </nav>
