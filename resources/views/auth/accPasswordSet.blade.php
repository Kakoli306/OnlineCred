<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Aba+</title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="images/favicon.png">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset('assets/dashboard/')}}/css/bootstrap.min.css">
    <!-- Plugin -->
    <link rel="stylesheet" href="{{asset('assets/dashboard/')}}/vendor/date-picker/daterangepicker.css">
    <link rel="stylesheet" href="{{asset('assets/dashboard/')}}/vendor/ladda-button/ladda.min.css">
    <link rel="stylesheet" href="{{asset('assets/dashboard/')}}/vendor/select2/select2.min.css">
    <link rel="stylesheet" href="{{asset('assets/dashboard/')}}/vendor/selectize/selectize.css">
    <!-- Style CSS -->
    <link rel="stylesheet" href="{{asset('assets/dashboard/')}}/css/typography.css">
    <link rel="stylesheet" href="{{asset('assets/dashboard/')}}/css/style.css">
    <link rel="stylesheet" href="{{asset('assets/dashboard/')}}/css/responsive.css">
    <link rel="stylesheet" href="{{asset('assets/dashboard/')}}/css/custom.css">
</head>
<body>
<!-- Sign in Start -->
<section class="sign-in-page">
    <div id="particles-js"></div>
    <div class="container sign-in-page-bg">
        <div class="row no-gutters">
            <div class="col-md-6"></div>
            <div class="col-md-6 align-self-center">
                <div class="sign-in-from">
                    <img src="{{asset('assets/dashboard/')}}/images/logo_new.png" style="height: 50px;width: 50%" class="img-fluid d-block mx-auto mb-3" alt="">
                    <form action="{{route('provider.account.pass.setup')}}" method="post" class="needs-validation mt-3" novalidate>
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputEmail1">New Password</label>
                            <input type="password" name="pass" class="form-control mb-0" id="exampleInputEmail1" placeholder="Enter Email" required>
                            <input type="hidden" name="token_id" value="{{$access->verify_id}}" required>
                            <div class="invalid-feedback">Enter Password</div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Confirm Password</label>
                            <input type="password" name="cpass" class="form-control mb-0" id="exampleInputPassword1" placeholder="Password" required>
                            <div class="invalid-feedback">Enter Confirm Password</div>
                        </div>
                        <div class="d-inline-block w-100">
                            <button type="submit" class="btn btn-primary float-right">Setup</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Sign in END -->
<!-- Jq Files -->
<script src="{{asset('assets/dashboard/')}}/js/jquery.min.js"></script>
<script src="{{asset('assets/dashboard/')}}/js/popper.min.js"></script>
<script src="{{asset('assets/dashboard/')}}/js/bootstrap.min.js"></script>
<!-- Plugin -->
<script src="{{asset('assets/dashboard/')}}/vendor/date-picker/moment.min.js"></script>
<script src="{{asset('assets/dashboard/')}}/vendor/date-picker/daterangepicker.js"></script>
<script src="{{asset('assets/dashboard/')}}/vendor/ladda-button/spin.min.js"></script>
<script src="{{asset('assets/dashboard/')}}/vendor/ladda-button/ladda.min.js"></script>
<script src="{{asset('assets/dashboard/')}}/vendor/ladda-button/ladda-activation.js"></script>
<script src="{{asset('assets/dashboard/')}}/vendor/select2/select2.min.js"></script>
<script src="{{asset('assets/dashboard/')}}/vendor/selectize/selectize.min.js"></script>
<script src="{{asset('assets/dashboard/')}}/vendor/jquery.mask.js"></script>
<script src="{{asset('assets/dashboard/')}}/vendor/tablesorter.min.js"></script>
<script src="{{asset('assets/dashboard/')}}/vendor/particle-js/particles.min.js"></script>
<script src="{{asset('assets/dashboard/')}}/vendor/particle-js/app.js"></script>
<!-- Custom JavaScript -->
<script src="{{asset('assets/dashboard/')}}/js/custom.js"></script>
</body>
</html>
