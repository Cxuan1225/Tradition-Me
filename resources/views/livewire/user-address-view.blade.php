<div class="tab-pane fade" id="v-pills-address" role="tabpanel" aria-labelledby="v-pills-address-tab">
    <h2 class="text-primary">{{ __('User Address') }}</h2>
    <hr class="mt-2 mb-4">

    <!-- Flex container for layout -->
    <div class="d-flex flex-column flex-md-row">
        <div class="flex-shrink-1 me-md-3 mb-3 mb-md-0">
            <h2 class="h4 text-dark">
                {{ __('User Addresses List') }}
            </h2>
        </div>

        <div class="ms-md-auto mb-3">
            @include('end_user.UserAddress.create')
        </div>
    </div>

    <div class="table-responsive mt-3">
        <table class="table table-striped table-hover">
            <thead class="table-primary text-muted">
                <tr>
                    <th scope="col">Recipient Name</th>
                    <th scope="col">Phone Number</th>
                    <th scope="col">Address Line 1</th>
                    <th scope="col">Address Line 2</th>
                    <th scope="col">Postal Code</th>
                    <th scope="col">State</th>
                    <th scope="col">Reference</th>
                    <th scope="col">Default Address</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($userAddresses as $address)
                    <tr>
                        <td>{{ $address->recipient_name }}</td>
                        <td>{{ $address->phone_number }}</td>
                        <td>{{ $address->address_line1 }}</td>
                        <td>{{ $address->address_line2 }}</td>
                        <td>{{ $address->postal_code }}</td>
                        <td>{{ $address->state }}</td>
                        <td>{{ $address->reference }}</td>
                        <td>
                            @if ($address->is_default)
                                <span class="badge bg-success">Default</span>
                            @else
                                <span class="badge bg-secondary">Not Default</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Actions">
                                @include('end_user.UserAddress.update')
                                @include('end_user.UserAddress.delete')
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center">No addresses found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>


</div>
