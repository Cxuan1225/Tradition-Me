@extends($layout)

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Profile</h1>
                </div>
                <div class="col-sm-6">
                    <!-- Breadcrumb can go here -->
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row ">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h4 class="card-title mb-0">{{ __('Profile') }}</h4>
                        </div>
                        <div class="card-body">
                            <!-- Update Profile Picture Form -->
                            <div class="form-group">
                                @include('profile.partials.profile-image-update-form')
                            </div>
                            <hr class="my-4">
                            <!-- Profile Information Form -->
                            <div class="form-group">
                                @include('profile.partials.update-profile-information-form')
                            </div>
                            <hr class="my-4">
                            <!-- Password Update Form -->
                            <div class="form-group">
                                @include('profile.partials.update-password-form')
                            </div>
                            <hr class="my-4">
                            <!-- Account Deletion Form -->
                            <div class="form-group">
                                @include('profile.partials.delete-user-form')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
