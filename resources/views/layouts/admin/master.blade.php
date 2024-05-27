<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"><!-- mobile responsive meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>PLI BD Portal</title>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('summernote/summernote-bs4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin/master.css') }}" rel="stylesheet">



    <link href="{{ asset('Toastr/toastr.min.css') }}" rel="stylesheet" />

    @stack('styles')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper" id="app">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light text-sm" aria-label>
            <!-- Left navbar items -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link slow-spin" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <span class="nav-link text-dark font-weight-bold pt-1 my-0">
                        <h4>@yield('title')</h4>
                    </span>
                </li>
            </ul>

            <!-- Left navbar items -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <span class="nav-link text-dark pt-1 pr-0">
                        <h6>{{ Auth::user()->name }}</h6>
                    </span>
                </li>
            </ul>
        </nav>

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{ route('admin.home') }}" class="brand-link bg-dark">
                <img src="{{ asset('images/dashboard/logo.png') }}" alt="IFCI Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">PLI BD Portal</span>
            </a>
            <!-- Sidebar -->
            <div class="sidebar">
                <div class="user-panel">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="info">
                                <span class="text-warning">{{ Auth::user()->contact_person }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            @guest
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            @else
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();"
                                    class="btn btn-outline-warning btn-sm btn-block">
                                    {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                            @endguest
                        </div>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2" aria-label>
                    <ul class="nav nav-pills nav-sidebar flex-column text-sm nav-legacy nav-compact nav-child-indent"
                        data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                        @if (!Auth::user()->hasRole('CorresReply'))
                            <li class="nav-item">
                                <a href="{{ route('admin.home') }}" class="nav-link active">
                                    <i class="nav-icon fas fa-tachometer-alt text-info"></i>
                                    <p>
                                        Dashboard Summary
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="https://emails.azure.microsoft.com/redirect/?destination=https%3A%2F%2Fapp.powerbi.com%2FRedirect%3Faction%3DOpenLink%26linkId%3DUOlEGVafE5%26ctid%3De01f42f1-7a24-466f-8e70-66a4e507ee05%26pbi_source%3DlinkShare&p=bT1hYzdhYmE5MS03ZGQzLTRmZTMtOTc3My00YmFlMTNkMWY0YzcmdT1hZW8mbD1SZWRpcmVjdA%3D%3D"
                                    class="nav-link">
                                    <i class="nav-icon fas fa-chart-bar" aria-hidden="true"></i>
                                    <p>Reporting Dashboard</p>
                                </a>
                            </li>
                            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-users"></i>
                                    <p>
                                        Registrations
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('admin.users.index') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Overview
                                                <span class="right badge badge-danger">New</span>
                                            </p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-file-alt"></i>
                                    <p>
                                        Applications
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('admin.apps.index') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Overview
                                                <span class="right badge badge-danger">New</span>
                                            </p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('admin.appstatus.index') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Application Status</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.acknowledgement.index') }}" class="nav-link">
                                    <i class="nav-icon fas fa-inbox"></i>
                                    <p>
                                        Acknowledgment
                                    </p>
                                </a>
                            </li>
                            {{-- inject method you can call direct function from controller --}}
                            @inject('qtr_id', 'App\Http\Controllers\Admin\QRRController')

                            <li class="nav-item">
                                <a href="{{ route('admin.qrr.dash', ['qtr' => $qtr_id::getqrr()]) }}"
                                    class="nav-link">

                                    <i class="nav-icon fa fa-thermometer-three-quarters" aria-hidden="true"></i>
                                    <p>
                                        QRR
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.claim.claimdashboard') }}" class="nav-link">

                                    <i class="nav-icon fas fa-hand-paper" aria-hidden="true"></i>
                                    <p>
                                        Incentive Claim Form
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.claims.incentive', ['fy' => '1']) }}" class="nav-link">
                                    <i class="nav-icon fas fa-tachometer-alt "></i>
                                    <p>Claims Incentive

                                    </p>
                                </a>
                            </li>
                            {{-- <li class="nav-item">
                                <a href="{{ route('admin.claims.incentive.twentyper', ['fy' => '1']) }}" class="nav-link">
                                    <i class="nav-icon fas fa-tachometer-alt "></i>
                                    <p>Claims Incentive 20%

                                    </p>
                                </a>
                            </li> --}}
                            <li class="nav-item">
                                <a href="{{ route('admin.MIS.index', ['qtr' => 202101]) }}" class="nav-link">

                                    <i class="nav-icon fa fa-filter" aria-hidden="true"></i>
                                    <p>
                                        MIS
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.admin_brochure.index') }}" class="nav-link">

                                    <i class="nav-icon fa fa-book" aria-hidden="true"></i>
                                    <p>
                                        Product Brochures
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                    <em class="nav-icon fas fa-file-alt text-info"></em>
                                    <p>
                                        Invoice
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('admin.mail.index') }}" class="nav-link active">
                                            <em class="far fa-circle nav-icon"></em>
                                            <p>PLI Fixed

                                            </p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('admin.claimvariable.index') }}" class="nav-link active">
                                            <em class="far fa-circle nav-icon"></em>
                                            <p>PLI Claim Variable

                                            </p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('admin.parkclaimvariable.index') }}"
                                            class="nav-link active">
                                            <em class="far fa-circle nav-icon"></em>
                                            <p>Park Claim Variable</p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                            @if (AUTH::user()->hasRole('Admin'))
                                <li class="nav-item">
                                    <a href="{{ route('admin.grievances_list') }}" class="nav-link">
                                        <i class="nav-icon fas fa-comments"></i>
                                        <p>Grievances</p>
                                    </a>
                                </li>
                            @endif
                            <li class="nav-item">
                                <a href="{{ route('admin.additionaldetail.index') }}" class="nav-link">
                                    <i class="nav-icon fas fa-edit"></i>
                                    <p>Edit Detail</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.authoriseSignatorylist.admin_dash', 'ALL') }}"
                                    class="nav-link">

                                    <i class="nav-icon fa fa-exchange-alt" aria-hidden="true"></i>
                                    <p>Change Request</p>
                                </a>
                            </li>
                            @if (AUTH::user()->hasRole('Admin'))
                                <li class="nav-item">
                                    <a href="{{ route('admin.create_id') }}" class="nav-link">

                                        <i class="nav-icon fa fa-list" aria-hidden="true"></i>
                                        <p>
                                            Admin Listing
                                        </p>
                                    </a>
                                </li>
                            @endif
                            <li class="nav-item">
                                <a href="{{ route('admin.prayas.getdata') }}" class="nav-link">
                                    <i class="nav-icon fas fa-edit"></i>
                                    <p>Prayas</p>
                                </a>
                            </li>
                            @if (AUTH::user()->hasRole('Developer'))
                                <li class="nav-item">
                                    <a href="{{ route('admin.logs') }}" class="nav-link">
                                        <i class="nav-icon fa fa-history"></i>
                                        <p>
                                            Logs
                                        </p>
                                    </a>
                                </li>
                            @endif
                            <li class="nav-item">
                                <a href="{{ route('admin.bgtracker.index') }}" class="nav-link">
                                    <i class="nav-icon fas fa-coins"></i>
                                    <p>
                                        BG Tracker
                                    </p>
                                </a>
                            </li>
                        @endif
                        <li class=" nav-item">
                            <a href="{{ route('newcorrespondence.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-comment-alt"></i>
                                <p>Correspondence Module</p>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Main content -->
            <div class="content">
                <div class="container-fluid pt-2">
                    @yield('content')
                </div>
            </div>
        </div>

        <!-- Main Footer -->
        <footer class="main-footer text-sm">
            <!-- To the right -->
            <div class="float-right d-none d-sm-inline">
                PLI Portal
            </div>
            <!-- Default to the left -->
            <strong>Copyright &copy; 2020 <a href="https://www.ifciltd.com">IFCI Ltd.</a>.</strong> All rights
            reserved.
        </footer>
    </div>

    <!-- Scripts-->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/jsvalidation.min.js') }}"></script>
    <script src="{{ asset('js/Chart.min.js') }}"></script>
    <script src="{{ asset('js/chartjs-plugin-datalabels.min.js') }}"></script>
    <script src="{{ asset('js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('Toastr/toastr.min.js') }}"></script>



    @include('sweet::alert')
    @stack('scripts')
</body>

</html>
