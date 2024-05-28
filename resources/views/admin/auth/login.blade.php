<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>My Health Coatch | Login</title>
        <!-- Bootstrap -->
        <link href="{{ url('assets/admin/vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
        <!-- Font Awesome -->
        <link href="{{ url('assets/admin/vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
        <!-- NProgress -->
        <link href="{{ url('assets/admin/vendors/nprogress/nprogress.css') }}" rel="stylesheet">
        <!-- Animate.css -->
        <link href="{{ url('assets/admin/vendors/animate.css/animate.min.css') }}" rel="stylesheet">
        <!-- Custom Theme Style -->
        <link href="{{ url('assets/admin/build/css/custom.min.css') }}" rel="stylesheet">
    </head>
    <body class="login">
        <div>
            <div class="login_wrapper">
                <div class="animate form login_form">
                    @if ($errors->any())
                        <div class="alert alert-danger" role="alert">
                            <h4 class="alert-heading">Failed to login:</h4>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <hr>
                        </div>
                    @endif
                    @if (Session::has('error'))
                        <div class="alert alert-danger" role="alert">
                            <h4 class="alert-heading">Failed to login:</h4>
                            {{ Session::get('error') }}
                            <hr>
                        </div>
                    @endif
                    @if (Session::has('success'))
                        <div class="alert alert-success" role="alert">
                            <h4 class="alert-heading">Success:</h4>
                            {{ Session::get('success') }}
                            <hr>
                        </div>
                    @endif
                    <section class="login_content">
                        <form action="{{ route('auth.login') }}" method="POST">@csrf
                            <h1>Welcome</h1>
                            <div>
                                <input type="text" name="email" id="email" class="form-control" placeholder="Email Address" />
                            </div>
                            <div>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Password" />
                            </div>
                            <div class="clearfix"></div>
                            <div>
                                <button type="submit" class="btn btn-success" style="width: 100%;">Login</button>
                            </div>
                            <div>
                                <a style="float: right;" href="#">Lost your password?</a>
                            </div>
                            <div class="clearfix"></div>
                            <div class="separator">
                                <div>
                                    <img src="{{ asset('assets/admin/images/logo.png') }}" width="80px" />
                                    <h1>My health Coach</h1>
                                </div>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </body>
</html>