<button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
    data-bs-target="#editAddressModal{{ $address->id }}">
    Edit
</button>
@foreach ($userAddresses as $address)
    <div class="modal fade" id="editAddressModal{{ $address->id }}" tabindex="-1"
        aria-labelledby="editAddressModalLabel{{ $address->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editAddressModalLabel{{ $address->id }}">Edit Address</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Edit Address Form -->
                    <form method="POST" action="{{ route('profile.updateAddress', $address->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="recipient_name" class="form-label">Recipient Name</label>
                            <input type="text" class="form-control" id="recipient_name" name="recipient_name"
                                value="{{ $address->recipient_name }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="phone_number" class="form-label">Phone Number</label>
                            <input type="text" class="form-control" id="phone_number" name="phone_number"
                                value="{{ $address->phone_number }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="address_line1" class="form-label">Address Line 1</label>
                            <input type="text" class="form-control" id="address_line1" name="address_line1"
                                value="{{ $address->address_line1 }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="address_line2" class="form-label">Address Line 2</label>
                            <input type="text" class="form-control" id="address_line2" name="address_line2"
                                value="{{ $address->address_line2 }}">
                        </div>

                        <div class="mb-3">
                            <label for="postal_code" class="form-label">Postal Code</label>
                            <input type="text" class="form-control" id="postal_code" name="postal_code"
                                value="{{ $address->postal_code }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="state" class="form-label">State</label>
                            <select id="state" name="state" class="form-control" required>
                                @foreach (['Johor', 'Kedah', 'Kelantan', 'Malacca', 'Negeri Sembilan', 'Pahang', 'Penang', 'Perak', 'Perlis', 'Sabah', 'Sarawak', 'Selangor', 'Terengganu', 'Kuala Lumpur', 'Labuan', 'Putrajaya'] as $state)
                                    <option value="{{ $state }}"
                                        {{ $address->state == $state ? 'selected' : '' }}>{{ $state }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="reference" class="form-label">Reference</label>
                            <input type="text" class="form-control" id="reference" name="reference"
                                value="{{ $address->reference }}">
                        </div>

                        <div class="form-check mb-3">
                            <input type="checkbox" class="form-check-input" id="is_default" name="is_default"
                                {{ $address->is_default ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_default">Set as Default Address</label>
                        </div>

                        <button type="submit" class="btn btn-primary">Update Address</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach
