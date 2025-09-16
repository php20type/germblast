<!DOCTYPE html>
<html lang="en">
<head>
    <title>GermBlast</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <link rel="shortcut icon" href="{{ asset('img/logo/fevicon.png') }}" type="image/x-icon" />
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
                    <h4>Register</h4>
                </div>

                {{-- Registration Form --}}
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    {{-- Name --}}
                    <div class="form-group position-relative mb-4">
                        <small>Name</small>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="John Doe" required />
                        <label class="label-icon"><img src="{{ asset('img/home/profile.svg') }}"></label>
                        @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    {{-- Email --}}
                    <div class="form-group position-relative mb-4">
                        <small>Email Address</small>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="info@gmail.com" required />
                        <label class="label-icon"><img src="{{ asset('img/home/email.svg') }}"></label>
                        @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    {{-- Password --}}
                    <div class="form-group position-relative mb-4">
                        <small>Password</small>
                        <input type="password" name="password" class="form-control" placeholder="**********" required />
                        <label class="label-icon"><img src="{{ asset('img/home/password.svg') }}"></label>
                        @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    {{-- Confirm Password --}}
                    <div class="form-group position-relative mb-4">
                        <small>Confirm Password</small>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="**********" required />
                        <label class="label-icon"><img src="{{ asset('img/home/password.svg') }}"></label>
                        @error('password_confirmation') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    {{-- Submit Button --}}
                    <div class="form-group mb-5 mt-5">
                        <button type="submit" class="btn btn-primary rounded-pill w-100">REGISTER</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-lg-6 px-0 position-relative">
            <div class="login-image">
                <img src="{{ asset('img/home/register-left-image.png') }}" alt="Register Image" />
            </div>
        </div>
    </div>
</section>

<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/custom.js') }}"></script>
</body>
</html>
