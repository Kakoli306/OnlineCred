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

    <link rel="stylesheet" href="{{asset('assets/dashboard/')}}/vendor/custom-select/jquery-ui.css">
    <link rel="stylesheet" href="{{asset('assets/dashboard/')}}/vendor/custom-select/jquery.multiselect.css">
    <link rel="stylesheet" href="{{asset('assets/dashboard/')}}/vendor/custom-select/jquery.multiselect.filter.css">

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
                    <a href="{{route('basestaff.dashboard')}}" class="iq-waves-effect"><i
                            class="ri-home-4-line"></i><span>Dashboard </span></a>
                </li>
                <li>
                    <a href="{{route('basestaff.provider')}}" class="iq-waves-effect"><i
                            class="fa fa-user-plus"></i><span>Provider</span></a>
                </li>
                <li><a href="{{route('basestaff.report')}}" class="iq-waves-effect"><i
                            class="las la-chart-bar"></i><span>Report</span></a></li>
                <li><a href="{{route('basestaff.activity')}}" class="iq-waves-effect"><i
                            class="las la-file-archive"></i><span>Account Activity</span></a></li>
                <li><a href="{{route('basestaff.reminder')}}" class="iq-waves-effect"><i
                            class="las la-bell"></i><span>Reminders</span>
                        <?php

                        $today_date = \Carbon\Carbon::now()->format('Y-m-d');
                        $userid = Auth::user()->id;
                        $userType = Auth::user()->account_type;


                        $assign_prc = \App\Models\assign_practice_user::where('user_id', Auth::user()->id)
                            ->where('user_type', Auth::user()->account_type)->get();

                        $fac_id = [];
                        foreach ($assign_prc as $ass_prc) {
                            array_push($fac_id, $ass_prc->practice_id);
                        }

                        $reminders_count = \App\Models\reminder::where('followup_date', "<=", $today_date)
                            ->whereIn('facility_id', $fac_id)
                            ->where('assignedto_user_id', $userid)
                            ->where('assignedto_user_type', $userType)
                            ->where('is_show', 1)
                            ->count();
                        ?>
                        <span
                            class="badge badge-danger">({{$reminders_count}})</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('basestaff.download.files')}}" class="iq-waves-effect"><i
                            class="ri-water-flash-line"></i><span>Download Files</span></a>
                </li>
                <li><a href="{{route('basestaff.practice.lists')}}" class="iq-waves-effect"><i
                            class="ri-settings-line"></i><span>Update Practice</span></a>
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
                    @yield('basestaffheaderselect')
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
                        <ul class="navbar-nav ml-auto navbar-list">
                            <li class="nav-item iq-full-screen">
                                <a href="#" class="iq-waves-effect" id="btnFullscreen"><i
                                        class="ri-fullscreen-line"></i></a>
                            </li>

                        </ul>
                    </div>
                    <ul class="navbar-list">
                        <li>
                            <a href="#" class="search-toggle iq-waves-effect d-flex align-items-center">
                                <img src="{{asset('assets/dashboard/')}}/images/user/1.jpg"
                                     class="img-fluid rounded mr-3" alt="user">
                                <div class="caption">
                                    <h6 class="mb-0 line-height">{{Auth::user()->name}}</h6>
                                    <span class="font-size-12">Available</span>
                                </div>
                            </a>
                            <div class="iq-sub-dropdown iq-user-dropdown">
                                <div class="iq-card shadow-none m-0">
                                    <div class="iq-card-body p-0 ">
                                        <div class="bg-primary p-3">
                                            <h5 class="mb-0 text-white line-height">Hello Bini Jets</h5>
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
                                            <a class="bg-primary iq-sign-btn" href="{{route('account.manager.logout')}}"
                                               role="button">Sign
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
        <div class="modal fade" id="createPractice" data-backdrop="static">
            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4>Create Practice</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <form action="{{route('admin.practice.save')}}" method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label>Business Name<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-sm" name="business_name"
                                           required>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label>DBA Name<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-sm" name="dba_name" required>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label>Tax Id No.<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-sm" name="tax_id"
                                           data-mask="00-0000000" pattern=".{10}" required>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label>NPI<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-sm" name="npi"
                                           data-mask="0000000000" pattern=".{10}" required>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label>Address<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-sm" name="address" required>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <div class="row no-gutters">
                                        <div class="col-md">
                                            <label>City<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control form-control-sm" name="city"
                                                   required>
                                        </div>
                                        <div class="col-md px-2">
                                            <label>State<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control form-control-sm" name="state"
                                                   required>
                                        </div>
                                        <div class="col-md">
                                            <label>Zip<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control form-control-sm" name="zip" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label>Phone Number<span class="text-danger">*</span></label>
                                    <input type="text" name="phone_number" class="form-control form-control-sm"
                                           data-mask="(000)-000-0000" pattern=".{14,}" required="" autocomplete="off"
                                           maxlength="14">
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label>Medicaid<span class="text-danger">*</span></label>
                                    <input type="text" name="medicaid" class="form-control form-control-sm" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Create & Continue
                                {{--                                <i class='bx bx-loader align-middle ml-2'></i>--}}
                            </button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Create provider modal -->

        <!-- Main Content-->
        <div class="container-fluid">
            <div class="iq-card">
                @yield('basestaff')
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


<script src="{{asset('assets/dashboard/')}}/vendor/custom-select/jquery-ui.js"></script>
<script src="{{asset('assets/dashboard/')}}/vendor/custom-select/jquery.multiselect.filter.js"></script>
<script src="{{asset('assets/dashboard/')}}/vendor/custom-select/jquery.multiselect.js"></script>
<script src="{{asset('assets/dashboard/')}}/vendor/custom-select/multiselect-activation.js"></script>

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
