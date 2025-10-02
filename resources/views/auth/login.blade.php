<!DOCTYPE html>
<html lang="en">
<head>
    <title>GermBlast</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="shortcut icon" href="{{ asset('img/logo/fevicon.png') }}" />
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
</head>

<body>
<section class="login-section">
    <div class="row mx-0">
        <div class="col-lg-6 px-0">
            <div class="login-form">
                <div class="login-heading mb-5">
                    <a href="#"><img class="mb-lg-5 mb-4" src="{{ asset('img/logo/logo.png') }}" /></a>
                    <h4>Login</h4>
                </div>

                {{-- Login form --}}
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    {{-- Email Address --}}
                    <div class="form-group position-relative mb-4">
                        <small>EMAIL ADDRESS</small>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="info@gmail.com" required autofocus />
                        <label class="label-icon"><img src="{{ asset('img/home/email.svg') }}" /></label>
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="form-group position-relative mb-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <small>Password</small>
                            <a href="{{ route('password.request') }}" class="theme-color">Forgot Password?</a>
                        </div>
                        <input type="password" name="password" class="form-control" placeholder="**********" required />
                        <label class="label-icon"><img src="{{ asset('img/home/password.svg') }}" /></label>
                        @error('password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Remember Me --}}
                    <div class="form-group remember-me mb-5">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" />
                        <label class="form-check-label" for="remember"> Remember me </label>
                    </div>

                    {{-- Login Button --}}
                    <div class="form-group mb-5 pb-lg-5">
                        <button type="submit" class="btn btn-primary rounded-pill w-100">Login</button>
                    </div>

                    {{-- Register --}}
                    <div class="forget-password">
                        <p><span> Don't have an account? <a href="{{ route('register') }}" class="theme-color"> Register</a></span></p>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-lg-6 px-0 position-relative">
            <div class="login-image">
                <img src="{{ asset('img/home/login-left-image.png') }}" alt="Login Image" />
            </div>
        </div>
    </div>
</section>

<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/custom.js') }}"></script>
</body>
</html>
