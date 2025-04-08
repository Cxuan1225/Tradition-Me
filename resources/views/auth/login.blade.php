@extends('layouts/end_user/app')

@section('content')
    <div class="container" style="padding-top: 120px;">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card bg-light">
                    <div class="card-header bg-primary text-white"><b>{{ __('Login') }}</b></div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="login" class="form-label">{{ __('Username Or Email Address') }}</label>
                                <input id="login" type="text"
                                    class="form-control @error('login') is-invalid @enderror" name="login"
                                    value="{{ old('login') }}" required autocomplete="login" autofocus>
                                @error('login')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">{{ __('Password') }}</label>
                                <div class="input-group">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="current-password">
                                    <button type="button" class="btn btn-outline-secondary" id="showPassword"
                                        title="Show Password">
                                        <i class="fas fa-eye" aria-hidden="true"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3 form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                    {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">
                                    {{ __('Remember me') }}
                                </label>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-block">{{ __('Login') }}</button>
                            </div>

                            @if (Route::has('password.request'))
                                <div class="mt-3 text-center">
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr class="my-4">
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            const passwordField = $('#password');
            const togglePassword = $('#showPassword');

            togglePassword.on('click', function() {
                const type = passwordField.attr('type') === 'password' ? 'text' : 'password';
                passwordField.attr('type', type);

                const icon = $(this).find('i');
                icon.toggleClass('fa-eye fa-eye-slash');

                const title = passwordField.attr('type') === 'password' ? 'Show Password' : 'Hide Password';
                $(this).attr('title', title);
            });
        });
    </script>
@endsection
