<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"><!-- mobile responsive meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <link href="{{ asset('css/landing/slick.min.css') }}" rel="stylesheet"><!-- Slick Carousel -->
    <link href="{{ asset('css/landing/slick-theme.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/landing/jquery.fancybox.min.css') }}" rel="stylesheet">
    <!-- FancyBox -->
    <link href="{{ asset('css/landing/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/landing/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/landing/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/landing/jquery-ui.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/landing/jquery.timepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/landing/font-google-roboto.css') }}" rel="stylesheet">
    <link href="{{ asset('css/landing/style.css') }}" rel="stylesheet">
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
    <link rel="icon" href="images/favicon.ico" type="image/x-icon">
    <!--Favicon-->
    @stack('styles')

</head>


<body>
    <div id="app" class="page-wrapper">
        <!--Header Upper-->
        <section class="header-uper">
            <div class="row">
                <div class="col-md-5 col-lg-5 col-12">
                    <div class="row">
                        <div class="col-md-12 col-lg-12 main-logo text-lg-left text-md-left text-center">
                            <img src="https://pli.ifciltd.com/images/ifci-logo.png" alt="" height="90">
                        </div>
                    </div>

                </div>
                <div class="col-md-2 col-lg-2 col-12">
                    <div class="row">
                        <div class="col-md-12 col-lg-12 text-lg-left text-md-left text-center">
                            <img src="https://pli.ifciltd.com/images/mii-logo.png" alt="" height="80">
                        </div>
                    </div>
                </div>
                <div class="col-md-5 col-lg-5 col-12 p-0 m-0">
                    <div class="row">
                        <div class="col-md-12 col-lg-12 text-lg-right text-md-right text-center">
                            <img src="{{asset('images/doplogo.png')}}" alt="" height="90" class="min-logo">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--Header Upper-->
        <div class="row">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center breaking-news bg-white">
                    <div
                        class="d-flex flex-row flex-grow-1 flex-fill justify-content-center bg-danger text-white px-1 news">
                        <span class="d-flex align-items-center">What's New</span></div>
                    <marquee class="news-scroll" behavior="scroll" direction="left" onmouseover="this.stop();"
                        onmouseout="this.start();">
                        <!-- <span><b> Re-invitation of applications under PLI Scheme for Bulk Drugs (Round-III). Refer Scheme & Guidelines Section for detailed notice. Last date of receipt of applications is 30th April 2022.</b></span> -->
                    </marquee>
                </div>
            </div>
        </div>

        <nav class="navbar navbar-expand-lg">
            <div class="navbar-header">
                <button type="button" data-target="#navbarCollapse" data-toggle="collapse"
                    class="navbar-toggle navbar-toggler ml-auto">
                    <span class="navbar-toggler-icon"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>


            <div class="collapse navbar-collapse justify-content-start" id="navbarCollapse">
                <ul class="navbar-nav ml-5">
                    <li class="nav-item">
                        <a class="nav-link" href="./">
                            <i class="fas fa-home"></i> Home
                            <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item dropdown dmenu">
                        <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                            About Us
                        </a>
                        <div class="dropdown-menu sm-menu">
                            <a class="dropdown-item" href="https://pharmaceuticals.gov.in">DoP</a>
                            <a class="dropdown-item" href="https://www.ifciltd.com/?q=en/content/what-we-are">About
                                PMA</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./guidelines">
                            Scheme & Guidelines
                        </a>
                    </li>
                    {{-- @if(Carbon\Carbon::now()->lt(Carbon\Carbon::parse('2022-03-13 23:59:00')))  --}}
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">
                            Registration
                        </a>
                    </li>
                    {{-- @endif --}}
                    <li class="nav-item">
                        <a class="nav-link" href="./contact-us"><i class="fas fa-phone"></i> Contact Us</a>
                    </li>
                    <li class="nav-item ml-4">
                        <a href="#" class="text-warning" style="font-size: 12px;">
                            For any queries, Please contact at bdpli[at]ifciltd[dot]com and
                            pharma-bureau[at]gov[dot]in</a>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right ml-auto mr-1">
                    @if(Route::has('login'))
                    @auth
                    @if(Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Admin-Ministry'))
                     <a href="{{ route('admin.home') }}" class="btn btn-outline-warning my-1 text-white btn-block">Admin
                        Dashboard</a>
                   {{-- <a href="{{ route('admin.dashboard.dashboard') }}" class="btn btn-outline-warning my-1 text-white btn-block">Admin
                        Dashboard</a> --}}
                    @else
                    <a href="{{ route('home') }}" class="btn btn-outline-warning my-1 text-white btn-block">My
                        Dashboard</a>
                    @endif

                    @else
                    <li class="mr-2">
                        <a href="{{ route('login') }}" class="btn btn-outline-success my-1 text-white btn-block">
                            <i class="fas fa-sign-in-alt"></i>
                            Login</a>
                    </li>

                  <!-- <li>
                    @if(Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-outline-success my-1 text-white btn-block">
                    <i class="fas fa-user-plus"></i> Register</a>
                    @endif
                    </li> -->

                    @endauth
                    @endif
                </ul>

            </div>
        </nav>

        <main>
            @yield('content')
        </main>

        <!--footer-main-->
        <footer class="footer-main">
            <div class="footer-top">
                <div class="container-fluid text-md-left mt-2">
                    <div class="row">
                        <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mb-3">
                            <h6 class="text-uppercase font-weight-bold">IFCI Ltd.</h6>
                            <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
                            <p>
                                <a href="{{ route('copyright-policy') }}">Copyright Policy</a>
                            </p>
                            <p>
                                <a href="{{ route('hyperlink-policy') }}">Hyper Linking Policy</a>
                            </p>
                            <p>
                                <a href="{{ route('privacy-policy') }}">Privacy Policy</a>
                            </p>

                        </div>

                        <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mb-2">
                            <h6 class="text-uppercase font-weight-bold">Useful links</h6>
                            <hr class="deep-purple accent-2 mb-2 mt-0 d-inline-block mx-auto">
                            <p><a href="https://www.ifciltd.com/?q=en/content/what-we-are">About Us</a></p>
                            <p><a href="./guidelines">Schemes & Guidelines</a></p>
                            <p><a href="./contact-us">Contact Us</a></p>
                        </div>


                        <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-3">
                            <!-- Links -->
                            <h6 class="text-uppercase font-weight-bold">Contact</h6>
                            <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto">
                            <p>General support kindly contact on:</p>
                            <p class="ml-3"><i class="fas fa-user mr-3"></i> Contact Person : Shivam Kumar </p>
                            <p class="ml-3"><i class="fas fa-phone mr-3"></i> Phone : +91 9643590975 </p>
                            <p class="ml-3"><i class="fas fa-envelope mr-3"></i> Email : shivam[dot]kumar[at]ifciltd[dot]com </p>
                            
                            <p class="ml-3"><i class="fas fa-home mr-3"></i> IFCI Tower, 61, Nehru Place, New Delhi </p>
                            <p class="ml-3"><i class="fas fa-envelope mr-3"></i> bdpli[at]ifciltd[dot]com</p>
                        </div>

                        <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-1">
                           
                            <h6 class="text-uppercase font-weight-bold">TECHNICAL CONTACT</h6>
                            <div style="height: 30px; clear:both;"></div>
                            <p>For technical support kindly contact on:</p>
                            <p class="ml-3"><i class="fas fa-envelope mr-3"></i> Email : advisory[dot]support[at]ifciltd[dot]com</p>
                            <p class="ml-3"><i class="fas fa-phone mr-3"></i> Phone : + 91 9870200156 , + 91 11 2623 0203  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>[Only Office Hours]</b></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <div class="container clearfix">
                    <div class="copyright-text">
                        <p>&copy; Copyright 2020. All Rights Reserved by
                            <a href="https://www.ifciltd.com/">IFCI Ltd</a>
                        </p>
                    </div>

                </div>
            </div>
        </footer>
        <!--End footer-main-->



    </div>
    <!--End pagewrapper-->

    <!-- Scripts-->

    <script src="{{ asset('js/landing/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ asset('js/landing/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/landing/slick.min.js') }}"></script>
    <script src="{{ asset('js/landing/jquery.fancybox.min.js') }}"></script>
    <script src="{{ asset('js/landing/wow.min.js') }}"></script>
    <script src="{{ asset('js/landing/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('js/landing/jquery.timepicker.min.js') }}"></script>
    <script src="{{ asset('js/landing/script.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    @include('sweet::alert')
    @stack('scripts')
</body>

</html>
