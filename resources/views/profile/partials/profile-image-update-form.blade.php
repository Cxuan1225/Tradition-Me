<section class="mb-4">
    <header>
        <h2 class="h4 text-dark">
            {{ __('Update Profile Image') }}
        </h2>
        <p class="mt-2 text-muted">
            {{ __('Upload a new profile image to update your account.') }}
        </p>
    </header>
    <div class="row">
        <!-- Profile Image Update Form -->
        <div class="col-md-8">
            <form method="POST" action="{{ route('image.update') }}" enctype="multipart/form-data">
                @csrf
                @method('POST')
                <div class="mb-3">
                    <label for="profile_image" class="form-label">{{ __('Profile Image') }}</label>
                    <input id="profile_image" name="profile_image" type="file" class="form-control" accept="image/*">
                    @error('profile_image')
                        <div class="alert alert-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <x-primary-button>{{ __('Upload Image') }}</x-primary-button>
            </form>
        </div>

        <!-- Profile Image Display -->
        <div class="col-md-4 d-flex justify-content-center align-items-center">
            @if ($user->profile_image)
                <img src="{{ asset('storage/' . $user->profile_image) }}" alt="{{ $user->name }}"
                    class="img-thumbnail" style="max-width: 350px; height: auto;">
            @else
                <img src="{{ asset('default-profile.png') }}" alt="{{ $user->name }}" class="img-thumbnail"
                    style="max-width: 150px; height: auto;">
            @endif
        </div>
</section>
