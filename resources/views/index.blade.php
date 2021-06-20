@extends('layouts.app')



@section('content')

    <div class="main-content-wrap">
        <div class="page-content">

            <div class="row">
                <div class="col col-12 col-md-6 col-xl-3">
                    <div class="card animated fadeInUp delay-01s bg-light">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col col-5">
                                    <div class="icon p-0 fs-48 text-primary opacity-50 icofont-first-aid-alt"></div>
                                </div>

                                <div class="col col-7">
                                    <h6 class="mt-0 mb-1">Proximas citas</h6>
                                    <div class="count text-primary fs-20">213</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col col-12 col-md-6 col-xl-3">
                    <div class="card animated fadeInUp delay-02s bg-light">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col col-5">
                                    <div class="icon p-0 fs-48 text-primary opacity-50 icofont-wheelchair"></div>
                                </div>

                                <div class="col col-7">
                                    <h6 class="mt-0 mb-1">Nuevos pacientes</h6>
                                    <div class="count text-primary fs-20">104</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col col-12 col-md-6 col-xl-3">
                    <div class="card animated fadeInUp delay-03s bg-light">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col col-5">
                                    <div class="icon p-0 fs-48 text-primary opacity-50 icofont-blood"></div>
                                </div>

                                <div class="col col-7">
                                    <h6 class="mt-0 mb-1">Cirugias</h6>
                                    <div class="count text-primary fs-20">24</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col col-12 col-md-6 col-xl-3">
                    <div class="card animated fadeInUp delay-04s bg-light">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col col-5">
                                    <div class="icon p-0 fs-48 text-primary opacity-50 icofont-dollar-true"></div>
                                </div>

                                <div class="col col-7">
                                    <h6 class="mt-0 mb-1 text-nowrap">Facturacíon del Mes</h6>
                                    <div class="count text-primary fs-20">$5238</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card ">
                <div class="card-header">
                    Citas del 01 al 21 de Junio/2021
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th scope="col">Foto</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Correo</th>
                                <th scope="col">Fecha</th>
                                <th scope="col">Hora</th>
                                <th scope="col">Folio</th>
                                <th scope="col">Medico</th>
                                <th scope="col">Asunto</th>
                                <th scope="col">Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>
                                    <img src="../assets/content/user-40-1.jpg" alt="" width="40" height="40" class="rounded-500">
                                </td>
                                <td>
                                    <strong>Liam</strong>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center nowrap text-primary">
                                        <span class="icofont-ui-email p-0 mr-2"></span>
                                        liam@gmail.com
                                    </div>
                                </td>
                                <td>
                                    <div class="text-muted text-nowrap">10 Feb 2018</div>
                                </td>
                                <td>
                                    <div class="text-muted text-nowrap">9:15 - 9:45</div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center nowrap text-primary">
                                        <span class="icofont-ui-cell-phone p-0 mr-2"></span>
                                        0126595743
                                    </div>
                                </td>
                                <td>Dr. Benjamin</td>
                                <td>mumps</td>
                                <td>
                                    <div class="actions">
                                        <button class="btn btn-info btn-sm btn-square rounded-pill">
                                            <span class="btn-icon icofont-ui-edit"></span>
                                        </button>
                                        <button class="btn btn-error btn-sm btn-square rounded-pill">
                                            <span class="btn-icon icofont-ui-delete"></span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <img src="../assets/content/user-40-2.jpg" alt="" width="40" height="40" class="rounded-500">
                                </td>
                                <td>
                                    <strong>Emma</strong>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center nowrap text-primary">
                                        <span class="icofont-ui-email p-0 mr-2"></span>
                                        emma@gmail.com
                                    </div>
                                </td>
                                <td>
                                    <div class="text-muted text-nowrap">5 Dec 2018</div>
                                </td>
                                <td>
                                    <div class="text-muted text-nowrap">9:00 - 9:30</div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center nowrap text-primary">
                                        <span class="icofont-ui-cell-phone p-0 mr-2"></span>
                                        0126595743
                                    </div>
                                </td>
                                <td>Dr. Liam</td>
                                <td>arthritis</td>
                                <td>
                                    <div class="actions">
                                        <button class="btn btn-info btn-sm btn-square rounded-pill">
                                            <span class="btn-icon icofont-ui-edit"></span>
                                        </button>
                                        <button class="btn btn-error btn-sm btn-square rounded-pill">
                                            <span class="btn-icon icofont-ui-delete"></span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <img src="../assets/content/user-40-3.jpg" alt="" width="40" height="40" class="rounded-500">
                                </td>
                                <td>
                                    <strong>Olivia</strong>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center nowrap text-primary">
                                        <span class="icofont-ui-email p-0 mr-2"></span>
                                        olivia@gmail.com
                                    </div>
                                </td>
                                <td>
                                    <div class="text-muted text-nowrap">13 Oct 2018</div>
                                </td>
                                <td>
                                    <div class="text-muted text-nowrap">12:00 - 12:45</div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center nowrap text-primary">
                                        <span class="icofont-ui-cell-phone p-0 mr-2"></span>
                                        0126595743
                                    </div>
                                </td>
                                <td>Dr. Noah</td>
                                <td>depression</td>
                                <td>
                                    <div class="actions">
                                        <button class="btn btn-info btn-sm btn-square rounded-pill">
                                            <span class="btn-icon icofont-ui-edit"></span>
                                        </button>
                                        <button class="btn btn-error btn-sm btn-square rounded-pill">
                                            <span class="btn-icon icofont-ui-delete"></span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <img src="../assets/content/user-40-4.jpg" alt="" width="40" height="40" class="rounded-500">
                                </td>
                                <td>
                                    <strong>Ava</strong>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center nowrap text-primary">
                                        <span class="icofont-ui-email p-0 mr-2"></span>
                                        ava@gmail.com
                                    </div>
                                </td>
                                <td>
                                    <div class="text-muted text-nowrap">26 Dec 2018</div>
                                </td>
                                <td>
                                    <div class="text-muted text-nowrap">14:15 - 14:30</div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center nowrap text-primary">
                                        <span class="icofont-ui-cell-phone p-0 mr-2"></span>
                                        0126595743
                                    </div>
                                </td>
                                <td>Dr. Emma</td>
                                <td>diarrhoea</td>
                                <td>
                                    <div class="actions">
                                        <button class="btn btn-info btn-sm btn-square rounded-pill">
                                            <span class="btn-icon icofont-ui-edit"></span>
                                        </button>
                                        <button class="btn btn-error btn-sm btn-square rounded-pill">
                                            <span class="btn-icon icofont-ui-delete"></span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <img src="../assets/content/user-40-5.jpg" alt="" width="40" height="40" class="rounded-500">
                                </td>
                                <td>
                                    <strong>Noah</strong>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center nowrap text-primary">
                                        <span class="icofont-ui-email p-0 mr-2"></span>
                                        noah@gmail.co
                                    </div>
                                </td>
                                <td>
                                    <div class="text-muted text-nowrap">15 Jun 2018</div>
                                </td>
                                <td>
                                    <div class="text-muted text-nowrap">17:30 - 18:00</div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center nowrap text-primary">
                                        <span class="icofont-ui-cell-phone p-0 mr-2"></span>
                                        0126595743
                                    </div>
                                </td>
                                <td>Dr. James</td>
                                <td>dyslexia</td>
                                <td>
                                    <div class="actions">
                                        <button class="btn btn-info btn-sm btn-square rounded-pill">
                                            <span class="btn-icon icofont-ui-edit"></span>
                                        </button>
                                        <button class="btn btn-error btn-sm btn-square rounded-pill">
                                            <span class="btn-icon icofont-ui-delete"></span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <img src="../assets/content/user-40-6.jpg" alt="" width="40" height="40" class="rounded-500">
                                </td>
                                <td>
                                    <strong>Isabella</strong>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center nowrap text-primary">
                                        <span class="icofont-ui-email p-0 mr-2"></span>
                                        isabella@gmail.com
                                    </div>
                                </td>
                                <td>
                                    <div class="text-muted text-nowrap">2 Jul 2018</div>
                                </td>
                                <td>
                                    <div class="text-muted text-nowrap">10:00 - 10:15</div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center nowrap text-primary">
                                        <span class="icofont-ui-cell-phone p-0 mr-2"></span>
                                        0126595743
                                    </div>
                                </td>
                                <td>Dr. Noah</td>
                                <td>flu</td>
                                <td>
                                    <div class="actions">
                                        <button class="btn btn-info btn-sm btn-square rounded-pill">
                                            <span class="btn-icon icofont-ui-edit"></span>
                                        </button>
                                        <button class="btn btn-error btn-sm btn-square rounded-pill">
                                            <span class="btn-icon icofont-ui-delete"></span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <img src="../assets/content/user-40-7.jpg" alt="" width="40" height="40" class="rounded-500">
                                </td>
                                <td>
                                    <strong>Sophia</strong>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center nowrap text-primary">
                                        <span class="icofont-ui-email p-0 mr-2"></span>
                                        sophia@gmail.com
                                    </div>
                                </td>
                                <td>
                                    <div class="text-muted text-nowrap">9 Oct 2018</div>
                                </td>
                                <td>
                                    <div class="text-muted text-nowrap">8:30 - 8:45</div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center nowrap text-primary">
                                        <span class="icofont-ui-cell-phone p-0 mr-2"></span>
                                        0126595743
                                    </div>
                                </td>
                                <td>Dr. Olivia</td>
                                <td>fracture</td>
                                <td>
                                    <div class="actions">
                                        <button class="btn btn-info btn-sm btn-square rounded-pill">
                                            <span class="btn-icon icofont-ui-edit"></span>
                                        </button>
                                        <button class="btn btn-error btn-sm btn-square rounded-pill">
                                            <span class="btn-icon icofont-ui-delete"></span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    Actividad del consultorio
                </div>
                <div class="card-body">
                    <div id="surveyEcharts" class="chat-container container-h-400"></div>
                </div>
            </div>


        </div>
    </div>

@endsection
