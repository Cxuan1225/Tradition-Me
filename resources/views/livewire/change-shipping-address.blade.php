<div class="modal fade" id="ChangeShippingAddressModal" tabindex="-1" aria-labelledby="ChangeShippingAddressModalLabel"
    aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ChangeShippingAddressModalLabel">Select Shipping Address</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form wire:submit.prevent="updateDefaultAddress">
                <div class="modal-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Select</th>
                                <th>Recipient Name</th>
                                <th>Address</th>
                                <th>Phone Number</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($addresses as $address)
                                <tr>
                                    <td>
                                        <input type="radio" name="default_address" wire:model="selectedAddressId"
                                            value="{{ $address->id }}"
                                            {{ $selectedAddressId == $address->id ? 'checked' : '' }}>
                                    </td>
                                    <td>{{ $address->recipient_name }}</td>
                                    <td>
                                        {{ $address->address_line1 }}, {{ $address->postal_code }}
                                        @if ($address->address_line2)
                                            {{ $address->address_line2 }}
                                        @endif
                                        {{ $address->city }}, {{ $address->state }}
                                    </td>
                                    <td>{{ $address->phone_number }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save
                        changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
