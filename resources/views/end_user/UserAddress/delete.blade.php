<button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
    data-bs-target="#deleteAddressModal{{ $address->id }}">
    Delete
</button>
@foreach ($userAddresses as $address)
    <div class="modal fade" id="deleteAddressModal{{ $address->id }}" tabindex="-1"
        aria-labelledby="deleteAddressModalLabel{{ $address->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteAddressModalLabel{{ $address->id }}">Delete Address</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this address?</p>
                </div>
                <div class="modal-footer">
                    <form method="POST" action="{{ route('profile.deleteAddress', $address->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach
