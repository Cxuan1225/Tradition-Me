@extends('layouts/end_user/app')

@section('content')
    <div class="container" style="padding-top: 120px;">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card bg-light">
                    <div class="card-header bg-primary text-white"><b>{{ __('Reset Password') }}</b></div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('password.store') }}">
                            @csrf

                            <!-- Password Reset Token -->
                            <input type="hidden" name="token" value="{{ $request->route('token') }}">

                            <!-- Email Address -->
                            <div class="mb-3">
                                <label for="email" class="form-label">{{ __('Email') }}</label>
                                <input id="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email', $request->email) }}" required autofocus autocomplete="username"
                                    readonly>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label for="password" class="form-label">{{ __('Password') }}</label>
                                <div class="input-group">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="new-password">
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

                            <!-- Confirm Password -->
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
                                <div class="input-group">
                                    <input id="password_confirmation" type="password"
                                        class="form-control @error('password_confirmation') is-invalid @enderror"
                                        name="password_confirmation" required autocomplete="new-password">
                                    <button type="button" class="btn btn-outline-secondary" id="showConfirmPassword"
                                        title="Show Password">
                                        <i class="fas fa-eye" aria-hidden="true"></i>
                                    </button>
                                </div>
                                @error('password_confirmation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit"
                                    class="btn btn-primary btn-block">{{ __('Reset Password') }}</button>
                            </div>
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
            const confirmField = $('#password_confirmation');
            const togglePassword = $('#showPassword');
            const toggleConfirmPassword = $('#showConfirmPassword');

            togglePassword.on('click', function() {
                const type = passwordField.attr('type') === 'password' ? 'text' : 'password';
                passwordField.attr('type', type);

                const icon = $(this).find('i');
                icon.toggleClass('fa-eye fa-eye-slash');

                const title = passwordField.attr('type') === 'password' ? 'Show Password' : 'Hide Password';
                $(this).attr('title', title);
            });

            toggleConfirmPassword.on('click', function() {
                const type = confirmField.attr('type') === 'password' ? 'text' : 'password';
                confirmField.attr('type', type);

                const icon = $(this).find('i');
                icon.toggleClass('fa-eye fa-eye-slash');

                const title = confirmField.attr('type') === 'password' ? 'Show Password' : 'Hide Password';
                $(this).attr('title', title);
            });
        });
    </script>
@endsection
