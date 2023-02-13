<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <!-- Custom fonts for this template-->
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{asset('/')}}assets/css/sb-admin-2.css" rel="stylesheet">
    <style>
        .s-24{
            font-size: 24px;
        }
    </style>
</head>
<body>

<div class="container">
    <form id="loginForm">
        <div class="row align-items-center justify-content-center w-100 vh-100">
            <div class="col-lg-5 bg-white py-3 rounded-lg shadow">
                <div class="alert alert-danger data--validate" style="display: none;"></div>
                <div class="data--email">
                    <h4 class="text-dark fw-500 s-24">Welcome Back</h4>
                    <p class="text-dark fw-300 s-18">Log in to your account to continue.</p>
                    <input type="text" name="email" id="email" class="form-control s-18 fw-500 shadow-sm mb-3" placeholder="Email address" style="height: 70px;">
                    <p><a href="{{route('signup')}}" class="text-muted underline">I don't have account</a></p>
                    <button onclick="checkEmail(this)" type="button" class="btn btn-primary bg-blue border-0 btn-block" style="height: 70px;">
                        Continues
                    </button>
                </div>
                <div class="data--password" style="display: none;">
                    <h4 class="text-dark fw-500 s-24">Welcome Back</h4>
                    <p class="text-dark fw-300 s-18">Log in to your account to continue.</p>
                    <p><a onclick="changeEmail(this)" href="javascript:void(0)" class="text-muted underline">Change your email address</a></p>
                    <input type="password" name="password" id="password" class="form-control s-18 fw-500 shadow-sm mb-3" placeholder="Password" style="height: 70px;">
                    <button onclick="loginUser(this)" type="button" class="btn btn-primary bg-blue border-0 btn-block mb-3" style="height: 70px;">
                        Continues
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Bootstrap core JavaScript-->
<script src="{{asset('/')}}assets/vendor/jquery/jquery.min.js"></script>
<script src="{{asset('/')}}assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="{{asset('/')}}assets/vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="{{asset('/')}}assets/js/sb-admin-2.min.js"></script>

<!-- Page level plugins -->
{{--<script src="{{asset('/')}}assets/vendor/chart.js/Chart.min.js"></script>--}}

<!-- Page level custom scripts -->
{{--<script src="{{asset('/')}}assets/js/demo/chart-area-demo.js"></script>--}}
{{--<script src="{{asset('/')}}assets/js/demo/chart-pie-demo.js"></script>--}}
<script src="{{asset('/')}}assets/js/axios.min.js"></script>
<script type="text/javascript">
    function checkEmail(input) {
        $(input).attr('disabled', true);
        $('.data--validate').text('').hide();
        axios.post(`{{route('check-email')}}`, `email=${$('input[name="email"]').val()}`).then(function (response) {
            $(input).attr('disabled',false);
            if (response.data.status == 'success'){
                $('.data--email').hide();
                $('.data--password').show('slow');
            } else {
                $('.data--validate').text(response.data.msg).show();
            }
        }).catch(function (error) {
            $(input).attr('disabled',false);
            $('.data--validate').text('There is something went wrong.!').show();
        });
    }

    function changeEmail(input) {
        $('.data--validate').text('').hide();
        $('input[name="password"]').val('');
        $('.data--password').hide();
        $('.data--email').show('slow');
    }

    function loginUser(input) {
        $(input).attr('disabled', true);
        $('.data--validate').text('').hide();
        axios.post(`{{route('login-user')}}`, $('form#loginForm').serialize()).then(function (response) {
            $(input).attr('disabled',false);
            if (response.data.status == 'success'){
                location.replace("{{route('dashboard')}}");
            } else {
                $('.data--validate').text(response.data.msg).show();
            }
        }).catch(function (error) {
            $(input).attr('disabled',false);
            $('.data--validate').text('There is something went wrong.!').show();
        });
    }
</script>
</body>
</html>
