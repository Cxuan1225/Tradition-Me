<h2 class="text-primary">{{ __('User Preferences') }}</h2>
<hr class="mt-2 mb-4">
<section>
    <header>
        <h2 class="h4 text-dark">
            {{ __('Update User Preference and Measurements') }}
        </h2>

        <p class="mt-1 text-muted">
            {{ __('Select Your Preference and Update Measurements') }}
        </p>
    </header>

    <!-- Display Flash Messages -->
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Display User's Current Preference and Calculated Size -->
    <div class="mb-4">
        <h5 class="text-secondary">{{ __('Current Preference:') }}</h5>
        <p>
            <strong>{{ __('Color:') }}</strong>
            {{ ucfirst($user->preference->preference_color ?? 'N/A') }}
        </p>

        <h5 class="text-secondary">{{ __('Calculated Preferred Size:') }}</h5>
        <p>
            <strong>{{ __('Size:') }}</strong>
            {{ $user->preference->preference_size ?? 'N/A' }}
        </p>
    </div>

    <form method="post" action="{{ route('profile.updatePreference') }}" class="mt-4">
        @csrf
        @method('put')

        <!-- User Preference -->
        <div class="form-group mb-4">
            <label for="color">{{ __('Color') }}</label>
            <div class="d-flex flex-wrap">
                @foreach (['white', 'black', 'grey', 'red', 'green', 'blue', 'yellow'] as $color)
                    <div class="form-check form-check-inline">
                        <input type="radio" class="form-check-input" id="color{{ $color }}" name="color"
                            value="{{ $color }}" @if (optional($user->preference)->preference_color === $color) checked @endif>
                        <label class="form-check-label" for="color{{ $color }}">
                            {{ ucfirst($color) }}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- User Measurements -->
        <div class="form-group mb-4">
            <label for="chest">{{ __('Chest (cm)') }}</label>
            <input type="number" class="form-control" id="chest" name="chest" step="0.1" min="30"
                max="150" value="{{ old('chest', $user->measurement->chest ?? '') }}">
        </div>

        <div class="form-group mb-4">
            <label for="waist">{{ __('Waist (cm)') }}</label>
            <input type="number" class="form-control" id="waist" name="waist" step="0.1" min="25"
                max="130" value="{{ old('waist', $user->measurement->waist ?? '') }}">
        </div>

        <div class="form-group mb-4">
            <label for="hips">{{ __('Hips (cm)') }}</label>
            <input type="number" class="form-control" id="hips" name="hips" step="0.1" min="30"
                max="150" value="{{ old('hips', $user->measurement->hips ?? '') }}">
        </div>

        <div class="form-group mb-4">
            <label for="arm_length">{{ __('Arm Length (cm)') }}</label>
            <input type="number" class="form-control" id="arm_length" name="arm_length" step="0.1" min="30"
                max="100" value="{{ old('arm_length', $user->measurement->arm_length ?? '') }}">
        </div>

        <div class="form-group mb-4">
            <label for="foot_length">{{ __('Foot Length (cm)') }}</label>
            <input type="number" class="form-control" id="foot_length" name="foot_length" step="0.1" min="20"
                max="35" value="{{ old('foot_length', $user->measurement->foot_length ?? '') }}">
        </div>

        <button class="btn btn-primary" type="submit">{{ __('Save') }}</button>
    </form>

</section>
