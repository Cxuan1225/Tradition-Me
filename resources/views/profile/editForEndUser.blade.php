@extends($layout)

@section('content')
    <div class="container-fluid" style="padding-top: 120px;">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 vh-100 border-end border-secondary">
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <a class="nav-link text-primary active" id="v-pills-profile-tab" data-bs-toggle="pill"
                        href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="true">
                        Profile
                    </a>
                    <a class="nav-link text-primary" id="v-pills-preference-tab" data-bs-toggle="pill"
                        href="#v-pills-preference" role="tab" aria-controls="v-pills-preference" aria-selected="true">
                        User Preference
                    </a>
                    <a class="nav-link text-primary" id="v-pills-password-tab" data-bs-toggle="pill"
                        href="#v-pills-password" role="tab" aria-controls="v-pills-password" aria-selected="false">
                        Update Password
                    </a>
                    <a class="nav-link text-primary" id="v-pills-address-tab" data-bs-toggle="pill" href="#v-pills-address"
                        role="tab" aria-controls="v-pills-address" aria-selected="false">
                        Update Address
                    </a>
                    <a class="nav-link text-primary" id="v-pills-delete-tab" data-bs-toggle="pill" href="#v-pills-delete"
                        role="tab" aria-controls="v-pills-delete" aria-selected="false">
                        Delete Account
                    </a>
                    @if (session()->has('error'))
                        <hr class="my-4">
                        <span>Error:</span>
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9">
                <div class="tab-content" id="v-pills-tabContent">
                    <!-- Profile Section -->
                    <div class="tab-pane fade show active" id="v-pills-profile" role="tabpanel"
                        aria-labelledby="v-pills-profile-tab">
                        <h2 class="text-primary">{{ __('Profile') }}</h2>
                        <hr class="mt-2 mb-4">
                        <!-- Update Profile Picture Form -->
                        @include('profile.partials.profile-image-update-form')
                        <hr class="my-4">
                        @include('profile.partials.update-profile-information-form')
                    </div>

                    <div class="tab-pane fade show " id="v-pills-preference" role="tabpanel"
                        aria-labelledby="v-pills-preference-tab">
                        @include('end_user.userPreference')
                    </div>

                    <!-- Update Password Section -->
                    <div class="tab-pane fade" id="v-pills-password" role="tabpanel" aria-labelledby="v-pills-password-tab">
                        <h2 class="text-primary">{{ __('Update Password') }}</h2>
                        <hr class="mt-2 mb-4">
                        <!-- Password Update Form -->
                        @include('profile.partials.update-password-form')
                    </div>

                    <!-- New Address Section -->
                    @livewire('user-address-view')

                    <!-- Delete Account Section -->
                    <div class="tab-pane fade" id="v-pills-delete" role="tabpanel" aria-labelledby="v-pills-delete-tab">
                        <h2 class="text-primary">{{ __('Delete Account') }}</h2>
                        <hr class="mt-2 mb-4">
                        <!-- Account Deletion Form -->
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
