<section class="mt-5">
    <div class="container">
        <div class="card mt-4">
            <div class="card-body">
                <h5 class="card-title">Shipping Address</h5>
                @if ($defaultAddress)
                    <p class="card-text mb-4">
                        {!! $defaultAddress !!}
                    </p>
                    <div class="d-flex justify-content-between align-items-center border-top pt-3 mt-3">
                        <div>
                            @include('end_user.UserAddress.create')
                        </div>
                        <div>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#ChangeShippingAddressModal">
                                Change Shipping Address
                            </button>
                        </div>

                    </div>
                @else
                    <p class="text-secondary">
                        No address selected. Please add an address.
                    </p>
                    @include('end_user.UserAddress.create')
                @endif
            </div>
        </div>
        <hr class="my-4">
        <h5 class="mb-4 mt-4">Shopping Cart</h5>
        <div class="overflow-hidden">
            @if ($cart)
                @if ($cart->items->isNotEmpty())
                    <div class="table-responsive">
                        <table class="table text-center">
                            <thead>
                                <tr>
                                    <th class="text-start" scope="col" style="width: 24%;">Product</th>
                                    <th scope="col" style="width: 14%;">Quantity</th>
                                    <th scope="col" style="width: 19%;">Unit Price</th>
                                    <th scope="col" style="width: 19%;">Total Price</th>
                                    <th scope="col" style="width: 19%;">
                                        <span>Actions</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody wire:ignore>
                                @foreach ($cart->items as $index => $item)
                                    @livewire('cart-table-item', ['cartItemId' => $item->id], key($item->id))
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4 border-top py-4">
                        <div class="pt-3">
                            <div class="d-flex justify-content-between">
                                <span class="fw-bold">Total:</span>
                                <span wire:model.live="totalPrice">RM{{ $totalPrice }}</span>
                            </div>
                        </div>

                        <div class="border-top mt-4 pt-4 d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center me-3">
                                <label class="form-label mb-0">Items Per Page</label>
                                <select class="form-select ms-2" wire:model.live="itemsPerPage">
                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </div>
                            <div>
                                <form wire:submit.prevent="createCheckoutSession">
                                    <button class="btn btn-primary" type="submit">Proceed to Payment</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <p class="text-secondary">
                        The cart is empty
                    </p>
                @endif
            @else
                <p class="text-secondary">
                    The cart is empty
                </p>
            @endif
        </div>
    </div>
    @livewire('change-shipping-address')
</section>
