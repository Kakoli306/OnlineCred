<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Practice Management</title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{asset('assets/dashboard/')}}/images/favicon.png">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset('assets/dashboard/')}}/css/bootstrap.min.css">
    <!-- Plugin -->
    <link rel="stylesheet" href="{{asset('assets/dashboard/')}}/vendor/date-picker/daterangepicker.css">
    <link rel="stylesheet" href="{{asset('assets/dashboard/')}}/vendor/select2/select2.min.css">
    <!-- Style CSS -->
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="{{asset('assets/dashboard/')}}/css/typography.css">
    <link rel="stylesheet" href="{{asset('assets/dashboard/')}}/css/style.css">
    <link rel="stylesheet" href="{{asset('assets/dashboard/')}}/css/responsive.css">
    <link rel="stylesheet" href="{{asset('assets/dashboard/')}}/css/custom.css">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/')}}/toastr/build/toastr.min.css">
    @yield('css')
</head>
<body class="sidebar-main-menu">
<!-- Preloader  -->
<div id="loading">
    <div id="loading-center"></div>
</div>
<!-- Sidebar  -->
<div class="iq-sidebar">
    <div class="iq-sidebar-logo d-flex justify-content-between">
        <a href="{{route('admin.dashboard')}}">
            <img src="{{asset('assets/dashboard/')}}/images/plus.png" class="img-fluid align-middle" alt="aba+">
        </a>
        <div class="iq-menu-bt-sidebar">
            <div class="iq-menu-bt align-self-center">
                <div class="wrapper-menu">
                    <div class="main-circle"><i class="ri-more-fill"></i></div>
                    <div class="hover-circle"><i class="ri-more-2-fill"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div id="sidebar-scrollbar">
        <nav class="iq-sidebar-menu">
            <ul id="iq-sidebar-toggle" class="iq-menu">
                <li>
                    <a href="{{route('provider.dashboard')}}" class="iq-waves-effect"><i
                            class="ri-home-4-line"></i><span>Dashboard </span></a>
                </li>

                <li>
                    <a href="{{route('providers.info')}}" class="iq-waves-effect"><i
                            class="fa fa-user-plus"></i><span>Info</span></a>
                </li>


            </ul>
        </nav>
        <div class="p-3"></div>
    </div>
</div>
<!-- Wrapper Start -->
<div class="wrapper">
    <!-- Page Content  -->
    <div id="content-page" class="content-page">
        <!-- TOP Nav Bar -->
        <div class="iq-top-navbar header-top-sticky">
            <div class="iq-navbar-custom">
                <nav class="navbar navbar-expand-lg navbar-light p-0">
                    @yield('headerselect')
                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                        <i class="ri-menu-3-line"></i>
                    </button>
                    <div class="iq-menu-bt align-self-center">
                        <div class="wrapper-menu">
                            <div class="main-circle"><i class="ri-more-fill"></i></div>
                            <div class="hover-circle"><i class="ri-more-2-fill"></i></div>
                        </div>
                    </div>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">

                    </div>
                    <ul class="navbar-list">
                        <li>
                            <a href="#" class="search-toggle iq-waves-effect d-flex align-items-center">
                                <img src="{{asset('assets/dashboard/')}}/images/user/1.jpg" class="img-fluid rounded mr-3" alt="user">
                                <div class="caption">
                                    <h6 class="mb-0 line-height">{{Auth::user()->full_name}}</h6>
                                    <span class="font-size-12">Available</span>
                                </div>
                            </a>
                            <div class="iq-sub-dropdown iq-user-dropdown">
                                <div class="iq-card shadow-none m-0">
                                    <div class="iq-card-body p-0 ">
                                        <div class="bg-primary p-3">
                                            <h5 class="mb-0 text-white line-height">Hello {{Auth::user()->full_name}}</h5>
                                            <span class="text-white font-size-12">Available</span>
                                        </div>
                                        <a href="profile.html" class="iq-sub-card iq-bg-primary-hover">
                                            <div class="media align-items-center">
                                                <div class="rounded iq-card-icon iq-bg-primary">
                                                    <i class="ri-file-user-line"></i>
                                                </div>
                                                <div class="media-body ml-3">
                                                    <h6 class="mb-0 ">My Profile</h6>
                                                    <p class="mb-0 font-size-12">View personal profile details.
                                                    </p>
                                                </div>
                                            </div>
                                        </a>
                                        <a href="profile-edit.html" class="iq-sub-card iq-bg-primary-hover">
                                            <div class="media align-items-center">
                                                <div class="rounded iq-card-icon iq-bg-primary">
                                                    <i class="ri-profile-line"></i>
                                                </div>
                                                <div class="media-body ml-3">
                                                    <h6 class="mb-0 ">Edit Profile</h6>
                                                    <p class="mb-0 font-size-12">Modify your personal details.
                                                    </p>
                                                </div>
                                            </div>
                                        </a>
                                        <div class="d-inline-block w-100 text-center p-3">
                                            <a class="bg-primary iq-sign-btn" href="{{route('provider.logout')}}" role="button">Sign
                                                out<i class="ri-login-box-line ml-2"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <!-- Create facility modal -->

        <!-- Create provider modal -->

        <!-- Main Content-->
        <div class="container-fluid">
            <div class="iq-card">
                @yield('proider')
            </div>
        </div>
        <!--/ Main Content-->
    </div>
</div>
<!-- Jq Files -->
<script src="{{asset('assets/dashboard/')}}/js/jquery.min.js"></script>
<script src="{{asset('assets/dashboard/')}}/js/popper.min.js"></script>
<script src="{{asset('assets/dashboard/')}}/js/bootstrap.min.js"></script>

<!-- Plugin -->
<script src="{{asset('assets/dashboard/')}}/vendor/date-picker/moment.min.js"></script>
<script src="{{asset('assets/dashboard/')}}/vendor/date-picker/daterangepicker.js"></script>
<script src="{{asset('assets/dashboard/')}}/vendor/select2/select2.min.js"></script>
<script src="{{asset('assets/dashboard/')}}/vendor/jquery.mask.js"></script>
<!-- Custom JavaScript -->
<script src="{{asset('assets/dashboard/')}}/js/custom.js"></script>

<script src="{{asset('assets/toastr/')}}/build/toastr.min.js"></script>

<!-- toastr init -->
<script src="{{asset('assets/toastr/')}}/toastr.init.js"></script>
<!-- Custom JavaScript -->
<script src="{{asset('assets/dashboard/js/bootstrap-notify.min.js')}}"></script>

@yield('js')
@include('layouts.message')
</body>
</html>
