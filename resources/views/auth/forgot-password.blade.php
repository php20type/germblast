<!DOCTYPE html>
<html lang="en">
<head>
    <title>GermBlast</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <link rel="shortcut icon" href="{{ asset('img/logo/fevicon.png') }}" type="image/x-icon" />
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
</head>

<body>

<section class="login-section">
    <div class="row mx-0">
        <div class="col-lg-6 px-0">
            <div class="login-form">
                <div class="login-heading mb-5">
                    <a href="#"><img class="mb-lg-5 mb-4" src="{{ asset('img/logo/logo.png') }}" /></a>
                    <h4>Forgot Password?</h4>
                </div>

                {{-- Password Reset Form --}}
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    {{-- Email Address --}}
                    <div class="form-group position-relative mb-4">
                        <small>EMAIL ADDRESS</small>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="info@gmail.com" required autofocus />
                        <label class="label-icon"><img src="{{ asset('img/home/email.svg') }}"></label>
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Success Message --}}
                    @if (session('status'))
                        <div class="alert alert-success">{{ session('status') }}</div>
                    @endif

                    {{-- Submit Button --}}
                    <div class="form-group mb-5 mt-5 pb-lg-5">
                        <button type="submit" class="btn btn-primary rounded-pill w-100">RESET PASSWORD</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-lg-6 px-0 position-relative">
            <div class="login-image">
                <img src="{{ asset('img/home/password-left-image.png') }}" alt="Reset Password Image" />
            </div>
        </div>
    </div>
</section>

<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/custom.js') }}"></script>

</body>
</html>
