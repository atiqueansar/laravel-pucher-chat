<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Signup</title>
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
        .has-error{
            border-color:red;
        }
    </style>
</head>
<body>

<div class="container">
    <form id="signupForm">
        <div class="row align-items-center justify-content-center w-100 vh-100">
            <div class="col-lg-5 bg-white py-3 rounded-lg shadow">
                <div class="alert alert-danger data--validate" style="display: none;"></div>
                <div class="alert alert-success data--success" style="display: none;"></div>
                <div class="data--email">
                    <h4 class="text-dark fw-500 s-24">Welcome Back</h4>
                    <p class="text-dark fw-300 s-18">Sing up to your account to continue.</p>
                    <label for="package">Select Package</label>
                    <select name="package" id="package" class="form-control">
                        <option value="Silver">Silver</option>
                        <option value="Golden">Golden</option>
                        <option value="Platinum">Platinum</option>
                    </select>
                    <br>
                    <input type="text" name="name" id="name" class="form-control s-18 fw-500 shadow-sm mb-3" placeholder="Fullname" style="height: 70px;">
                    <input type="email" name="email" id="email" class="form-control s-18 fw-500 shadow-sm mb-3" placeholder="Email address" style="height: 70px;">
                    <input type="password" name="password" id="password" class="form-control s-18 fw-500 shadow-sm mb-3" placeholder="Password" style="height: 70px;">
                    <button onclick="signup(this)" type="button" class="btn btn-primary bg-blue border-0 btn-block" style="height: 70px;">
                        Signup
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

    function signup(input) {
        $(input).attr('disabled', true);
        $('.text-danger').remove();
        $('.has-error').removeClass('has-error');
        axios.post(`{{route('signup-user')}}`, $('form#signupForm').serialize()).then(function (response) {
            if (response.data.status == 'success'){
                $('.data--success').text(response.data.msg).show();
                setTimeout(function () {
                    $(input).attr('disabled',false);
                    window.location.href = `{{route('login')}}`;
                }, 1500);
            } else {
                $('.text-danger').remove();
                $('.has-error').removeClass('has-error');
            }
        }).catch(function (error) {
            $(input).attr('disabled',false);
            $.each(error.response.data.errors, function (k, v) {
                $('input[name="' + k + '"]').addClass("has-error");
                $('input[name="' + k + '"]').after("<span class='text-danger'>" + v[0] + "</span>");
            });
        });
    }
</script>
</body>
</html>
