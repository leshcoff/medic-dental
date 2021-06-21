<div id="navbar2" class="app-navbar vertical">
    <div class="navbar-wrap">

        <button class="no-style navbar-toggle navbar-close icofont-close-line d-lg-none"></button>


        <div class="app-logo">
            <div class="logo-wrap">
                <img src="{{ asset('assets/img/logo.png') }}" alt="" width="147" height="33" class="logo-img">
            </div>
        </div>


        <div class="main-menu">
            <nav class="main-menu-wrap">
                <ul class="menu-ul">
                    <li class="menu-item">
                        <span class="group-title">Consultorio</span>
                    </li>
                    <li class="menu-item">
                        <a class="item-link" href="{{ route('home') }}">
                            <span class="link-icon icofont-thermometer-alt"></span>
                            <span class="link-text">Dashboard</span>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a class="item-link" href="{{ route('patients.index') }}">
                            <span class="link-icon icofont-paralysis-disability"></span>
                            <span class="link-text">Pacientes</span>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a class="item-link" href="{{ route('medics.index') }}">
                            <span class="link-icon icofont-doctor"></span>
                            <span class="link-text">Medicos</span>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a class="item-link" href="{{ route('appointments.index') }}">
                            <span class="link-icon icofont-stethoscope-alt"></span>
                            <span class="link-text">Citas</span>
                        </a>
                    </li>

                   



                    <li class="menu-item">
                        <span class="group-title">Apps</span>
                    </li>
                    <li class="menu-item has-sub">
                        <a class="item-link" href="#">
                            <span class="link-text">Service pages</span>
                            <span class="link-caret icofont-thin-right"></span>
                        </a>
                        <ul class="sub">
                            <li class="menu-item">
                                <a class="item-link" href="invoices.html"><span class="link-text">Invoices</span></a>
                            </li>
                            <li class="menu-item">
                                <a class="item-link" href="pricing.html"><span class="link-text">Pricing</span></a>
                            </li>
                            <li class="menu-item">
                                <a class="item-link" href="edit-account.html"><span class="link-text">Edit account</span></a>
                            </li>
                            <li class="menu-item">
                                <a class="item-link" href="user-profile.html"><span class="link-text">User profile</span></a>
                            </li>
                            <li class="menu-item">
                                <a class="item-link" href="events-timeline.html"><span class="link-text">Events timeline</span></a>
                            </li>
                        </ul>
                    </li>
                    <li class="menu-item has-sub">
                        <a class="item-link" href="#">
                            <span class="link-text">Sessions</span>
                            <span class="link-caret icofont-thin-right"></span>
                        </a>
                        <ul class="sub">
                            <li class="menu-item">
                                <a class="item-link" href="sign-in.html"><span class="link-text">Sign in</span></a>
                            </li>
                            <li class="menu-item">
                                <a class="item-link" href="sign-up.html"><span class="link-text">Sign up</span></a>
                            </li>
                            <li class="menu-item">
                                <a class="item-link" href="page-404.html"><span class="link-text">404</span></a>
                            </li>
                            <li class="menu-item">
                                <a class="item-link" href="page-500.html"><span class="link-text">500</span></a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>


        <div class="add-patient">
            <button class="btn btn-primary" data-toggle="modal" data-target="#add-patient">
                <span class="btn-icon icofont-plus mr-2"></span>
                Add Patient
            </button>
        </div>


        <div class="assistant-menu">
            <a class="link" href="#">
                <span class="link-icon icofont-ui-settings"></span>Configuraciones
            </a>
            <a class="link" href="#">
                <span class="link-icon icofont-question-square"></span>Soporte
            </a>
        </div>






        <div class="navbar-skeleton vertical">
            <div class="top-part">
                <div class="sk-logo bg animated-bg"></div>
                <div class="sk-menu">
                    <span class="sk-menu-item menu-header bg-1 animated-bg"></span>
                    <span class="sk-menu-item bg animated-bg w-75"></span>
                    <span class="sk-menu-item bg animated-bg w-80"></span>
                    <span class="sk-menu-item bg animated-bg w-50"></span>
                    <span class="sk-menu-item bg animated-bg w-75"></span>
                    <span class="sk-menu-item bg animated-bg w-50"></span>
                    <span class="sk-menu-item bg animated-bg w-60"></span>
                </div>
                <div class="sk-menu">
                    <span class="sk-menu-item menu-header bg-1 animated-bg"></span>
                    <span class="sk-menu-item bg animated-bg w-60"></span>
                    <span class="sk-menu-item bg animated-bg w-40"></span>
                    <span class="sk-menu-item bg animated-bg w-60"></span>
                    <span class="sk-menu-item bg animated-bg w-40"></span>
                    <span class="sk-menu-item bg animated-bg w-40"></span>
                    <span class="sk-menu-item bg animated-bg w-40"></span>
                    <span class="sk-menu-item bg animated-bg w-40"></span>
                </div>
                <div class="sk-menu">
                    <span class="sk-menu-item menu-header bg-1 animated-bg"></span>
                    <span class="sk-menu-item bg animated-bg w-60"></span>
                    <span class="sk-menu-item bg animated-bg w-50"></span>
                </div>
                <div class="sk-button animated-bg w-90"></div>
            </div>

            <div class="bottom-part">
                <div class="sk-menu">
                    <span class="sk-menu-item bg-1 animated-bg w-60"></span>
                    <span class="sk-menu-item bg-1 animated-bg w-80"></span>
                </div>
            </div>

            <div class="horizontal-menu">
                <span class="sk-menu-item bg animated-bg"></span>
                <span class="sk-menu-item bg animated-bg"></span>
                <span class="sk-menu-item bg animated-bg"></span>
                <span class="sk-menu-item bg animated-bg"></span>
                <span class="sk-menu-item bg animated-bg"></span>
                <span class="sk-menu-item bg animated-bg"></span>
            </div>
        </div>

    </div>
</div>
