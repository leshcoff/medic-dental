<div id="navbar1" class="app-navbar horizontal">
    <div class="navbar-wrap">

        <button class="no-style navbar-toggle navbar-open d-lg-none">
            <span></span><span></span><span></span>
        </button>


        <div class="app-actions">
            <div class="dropdown item">
                <button
                    class="no-style dropdown-toggle"
                    type="button"
                    data-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false"
                    data-offset="0, 12"
                >
                    <span class="icon icofont-notification"></span>
                    <span class="badge badge-danger badge-sm">5</span>
                </button>

                <div class="dropdown-menu dropdown-menu-right dropdown-menu-w-280">
                    <div class="menu-header">
                        <h4 class="h5 menu-title mt-0 mb-0">Notifications</h4>

                        <a href="#" class="text-danger">Clear All</a>
                    </div>

                    <ul class="list">
                        <li>
                            <a href="#">
                                <span class="icon icofont-heart"></span>

                                <div class="content">
                                    <span class="desc">Sara Crouch liked your photo</span>
                                    <span class="date">17 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span class="icon icofont-users-alt-6"></span>

                                <div class="content">
                                    <span class="desc">New user registered</span>
                                    <span class="date">23 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span class="icon icofont-share"></span>

                                <div class="content">
                                    <span class="desc">Amanda Lie shared your post</span>
                                    <span class="date">25 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span class="icon icofont-users-alt-6"></span>

                                <div class="content">
                                    <span class="desc">New user registered</span>
                                    <span class="date">32 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span class="icon icofont-ui-message"></span>

                                <div class="content">
                                    <span class="desc">You have a new message</span>
                                    <span class="date">58 minutes ago</span>
                                </div>
                            </a>
                        </li>
                    </ul>

                    <div class="menu-footer">
                        <button class="btn btn-primary btn-block">
                            Ver todas las notificaciones
                            <span class="btn-icon ml-2 icofont-tasks-alt"></span>
                        </button>
                    </div>
                </div>
            </div>

            <div class="dropdown item">
                <button
                    class="no-style dropdown-toggle"
                    type="button"
                    data-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false"
                    data-offset="0, 10"
                >
                <span class="d-flex align-items-center">
                  <img src="{{ asset('assets/content/user-400-1.jpg') }}" alt="" width="40" height="40" class="rounded-500 mr-1">
                  <i class="icofont-simple-down"></i>
                </span>
                </button>
                <div class="dropdown-menu dropdown-menu-right dropdown-menu-w-180">
                    <ul class="list">
                        <li>
                            <a href="#" class="align-items-center"><span class="icon icofont-ui-home"></span>Mi cuenta</a>
                        </li>

                        <li>
                            <a href="#" class="align-items-center"><span class="icon icofont-ui-calendar"></span>Calendario</a>
                        </li>
                        <li>
                            <a href="#" class="align-items-center"><span class="icon icofont-ui-settings"></span>Ajustes</a>
                        </li>
                        <li>
                            <a href="{{ route('logout') }}" class="align-items-center"><span class="icon icofont-logout"></span>Salir</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>




        <div class="navbar-skeleton horizontal">
            <div class="left-part d-flex align-items-center">
                <span class="navbar-button bg animated-bg d-lg-none"></span>
                <span class="sk-logo bg animated-bg d-none d-lg-block"></span>
                <span class="search d-none d-md-block bg animated-bg"></span>
            </div>

            <div class="right-part d-flex align-items-center">
                <div class="icon-box">
                    <span class="icon bg animated-bg"></span>
                    <span class="badge"></span>
                </div>
                <span class="avatar bg animated-bg"></span>
            </div>
        </div>



    </div>
</div>
