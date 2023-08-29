<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>The Pharmassist</title>
    <meta name="robots" content="index, follow" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="author" content="Gapconcepts" />
    <link rel="icon" type="image/x-icon" href="https://thepharmassist242.com//panel/assets/images/logo.png">
    <meta name="copyright" content="" />


  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- data table -->

    <!-- compulsory global.css -->
    <link rel="stylesheet" href="{{asset('panel/assets/main.css')}}">
    <link rel="stylesheet" href="{{asset('panel/assets/sass/utility/typography.css')}}">
    <link rel="stylesheet" href="{{asset('panel/assets/css/media.css')}}">

    <!-- fonts -->
    <!-- <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet"> -->
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <!-- icons -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        body {
            background: url(panel/assets/images/login-bg.jpeg) center/cover no-repeat;
        }
          .error {
        color: red;
    }
    </style>
</head>

<body>
    <div class="cover-login d-flex align-items-center justify-content-center">
        <div class="cover-loging-content">
            <div class="loging-logo text-center">
                <img src="{{asset('panel/assets/images/logo.png')}}" alt="" class="text-center">
            </div>
            <div class="inner-login-content mt-4 mt-md-5">
                <div class="ps-5">
                    <h3>Login as a Admin </h3>
                    <div class="hb-line"></div>
                </div>
                  <form id="login"  autocomplete="off">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" id="email" class="form-control"
                            placeholder="Enter your Email Address">
                    </div>
                    <div class="form-group password-eye">
                        <label>Password</label>
                        <input id="password-field" type="password" name="password" class="form-control"
                            placeholder="Enter your Password">
                        <i class="toggle-password fas fa-eye" toggle="#password-field"></i>
                    </div>
                    <br>
                    <div class="form-group text-center">
                        <button id="loginBtn" type="submit"
                            class="primary-btn justify-content-center w-100">LOGIN</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
</body>

</html>
  <script>
        $(document).ready(function() {
            if ($("#login").length > 0) {
                $("#login").validate({
                    rules: {
                        email: "required",
                        password: "required",
                    }
                });
            }
        });
    </script>
<script>
    $('#login').on('submit', function(e) {

           var email = document.getElementById('email').value;
            var password = document.getElementById('password-field').value;

            if (email != '' && password != '') {
        e.preventDefault();
        $('#loginBtn').empty().append('Please Wait..')
        $('#loginBtn').css({
            'cursor': 'not-allowed',
            'background': 'var(--black-btn-clr)'
        })
        var formdata = new FormData(this)
        $.ajax({
            url: '{{ route('admin.login.store') }}',
            type: 'POST',
            cache: false,
            processData: false,
            contentType: false,
            data: formdata,
            success: function(res) {
                if (res.code == 404) {
                    swal(res.msg, {
                        icon: 'error'
                    })
                    $('#loginBtn').empty().append('LOGIN')
                    $('#loginBtn').css({
                        'cursor': 'pointer',
                        'background': '#508FF4'
                    })
                    $('#email').val('')
                    $('#password-field').val('')
                } else {
                    swal(res.msg, {
                            icon: 'success'
                        })
                        .then((value) => {
                            window.location.href = '{{ route('admin.dashboard') }}'
                        });
                }
            }
        })
    }
    })
</script>

<script>
    $(".toggle-password").click(function() {
        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $($(this).attr("toggle"));
        if (input.attr("type") == "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });
</script>
