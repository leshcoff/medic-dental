<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>@yield('title')</title>
    <meta name="keywords" content="MedicApp">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="_token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/img/favicon.ico') }}">

    <!-- Plugins CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/icofont.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/simple-line-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/jquery.typeahead.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-select.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/Chart.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/morris.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/leaflet.css') }}">

    <!-- Theme CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <!-- additional styles for plugins -->
    @stack('csscustom')
</head>


<body class="vertical-layout boxed">
    <div class="app-loader main-loader">
        <div class="loader-box">
            <div class="bounceball"></div>
            <div class="text">Medic Dental<span>app</span></div>
        </div>
    </div>
    <!-- .main-loader -->

    <div class="page-box">
        <div class="app-container">
        <!-- Horizontal navbar -->
        @include('layouts.top-navigator')


        <!-- end Horizontal navbar -->

        <!-- Vertical navbar -->
        @include('layouts.menu-navigator')
        <!-- end Vertical navbar -->


        <main class="main-content">
            <div class="app-loader"><i class="icofont-spinner-alt-4 rotate"></i></div>

            @yield('content')

        </main>

        <!-- Footer  -->
        @include('layouts.footer')


        <div class="content-overlay"></div>
    </div>
    </div>

    <!-- Add patients modals -->
    <div class="modal fade" id="add-patient" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add new patient</h5>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group avatar-box d-flex">
                            <img src="../assets/content/anonymous-400.jpg" width="40" height="40" alt="" class="rounded-500 mr-4">

                            <button class="btn btn-outline-primary" type="button">
                                Select image<span class="btn-icon icofont-ui-user ml-2"></span>
                            </button>
                        </div>

                        <div class="form-group">
                            <input class="form-control" type="text" placeholder="Name">
                        </div>

                        <div class="form-group">
                            <input class="form-control" type="number" placeholder="Number">
                        </div>

                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <input class="form-control" type="number" placeholder="Age">
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <select class="selectpicker" title="Gender">
                                        <option class="d-none">Gender</option>
                                        <option>Male</option>
                                        <option>Female</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-0">
                            <textarea class="form-control" placeholder="Address" rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer d-block">
                    <div class="actions justify-content-between">
                        <button type="button" class="btn btn-error" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-info">Add patient</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end Add patients modals -->

    <!-- Add patients modals -->
    <div class="modal fade" id="settings" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Application's settings</h5>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label>Layout</label>
                            <select class="selectpicker" title="Layout" id="layout">
                                <option value="horizontal-layout">Horizontal</option>
                                <option value="vertical-layout">Vertical</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Light/dark topbar</label>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="topbar">
                                <label class="custom-control-label" for="topbar"></label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Light/dark sidebar</label>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="sidebar">
                                <label class="custom-control-label" for="sidebar"></label>
                            </div>
                        </div>

                        <div class="form-group mb-0">
                            <label>Boxed/fullwidth mode</label>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="boxed" checked>
                                <label class="custom-control-label" for="boxed"></label>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer d-block">
                    <div class="actions justify-content-between">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button id="reset-to-default" type="button" class="btn btn-error">Reset to default</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end Add patients modals -->


    <script src="{{ asset('assets/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-migrate-1.4.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.typeahead.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.barrating.min.js') }}"></script>
    <script src="{{ asset('assets/js/Chart.min.js') }}"></script>
    <script src="{{ asset('assets/js/raphael-min.js') }}"></script>
    <script src="{{ asset('assets/js/morris.min.js') }}"></script>
    <script src="{{ asset('assets/js/echarts.min.js') }}"></script>
    <script src="{{ asset('assets/js/echarts-gl.min.js') }}"></script>

    <!-- page specific plugins -->
    @yield('js')

    <script src="{{ asset('assets/js/main.js') }}"></script>

    <!-- Escom Base, Components and Settings -->
    {{ Html::script('assets/js/escom/em.application.core.js') }}
    {{ Html::script('assets/js/escom/em.modals.min.js') }}

    @stack('jscustom')

</body>
</html>
