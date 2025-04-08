<section class="mb-4">
    <header>
        <h2 class="h4 text-dark">
            {{ __('Delete Account') }}
        </h2>
        <p class="mt-2 text-muted">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <x-danger-button data-bs-toggle="modal" data-bs-target="#confirmDeleteModal">
        {{ __('Delete Account') }}
    </x-danger-button>

    <!-- Bootstrap Modal -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form method="post" action="{{ route('profile.destroy') }}">
                @csrf
                @method('delete')

                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="confirmDeleteModalLabel">{{ __('Confirm Account Deletion') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body bg-light">
                        <p>
                            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted.') }}
                        </p>
                        <p>
                            {{ __('Please enter your password to confirm you would like to permanently delete your account.') }}
                        </p>

                        <div class="mb-3">
                            <label for="password" class="form-label sr-only">{{ __('Password') }}</label>
                            <input id="password" name="password" type="password" class="form-control"
                                placeholder="{{ __('Password') }}" required>
                            <x-input-error :messages="$errors->userDeletion->get('password')" class="text-danger mt-2" />
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                        <x-danger-button>{{ __('Delete Account') }}</x-danger-button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
