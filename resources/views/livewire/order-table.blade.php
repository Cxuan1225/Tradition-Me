<section class="mt-5">
    <div class="container">
        <hr class="my-4">
        <h5 class="mb-4 mt-4">Order Summary</h5>
        <div class="overflow-hidden">
            <input type="text" wire:model.live="search" placeholder="Search orders..." class="form-control mb-3" />
            @if ($orders && $orders->isNotEmpty())
                <div class="table-responsive">

                    <table id="orderTable" class="table text-center">
                        <thead>
                            <tr>
                                <th>
                                    <a href="#" wire:click.prevent="sortBy('id')">
                                        Order ID
                                        @if ($sortField == 'id')
                                            @if ($sortDirection == 'asc')
                                                &uarr;
                                            @else
                                                &darr;
                                            @endif
                                        @endif
                                    </a>
                                </th>
                                <th>
                                    <a href="#" wire:click.prevent="sortBy('total_price')">
                                        Total Price
                                        @if ($sortField == 'total_price')
                                            @if ($sortDirection == 'asc')
                                                &uarr;
                                            @else
                                                &darr;
                                            @endif
                                        @endif
                                    </a>
                                </th>
                                <th>
                                    <a href="#" wire:click.prevent="sortBy('status')">
                                        Status
                                        @if ($sortField == 'status')
                                            @if ($sortDirection == 'asc')
                                                &uarr;
                                            @else
                                                &darr;
                                            @endif
                                        @endif
                                    </a>
                                </th>
                                <th>
                                    <a href="#" wire:click.prevent="sortBy('created_at')">
                                        Created At
                                        @if ($sortField == 'created_at')
                                            @if ($sortDirection == 'asc')
                                                &uarr;
                                            @else
                                                &darr;
                                            @endif
                                        @endif
                                    </a>
                                </th>
                                <th>
                                    <a href="#" wire:click.prevent="sortBy('updated_at')">
                                        Updated At
                                        @if ($sortField == 'updated_at')
                                            @if ($sortDirection == 'asc')
                                                &uarr;
                                            @else
                                                &darr;
                                            @endif
                                        @endif
                                    </a>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td>
                                        <a href="{{ route('order.details', ['order' => $order->id]) }}"
                                            class="btn btn-link">
                                            {{ $loop->iteration }}
                                        </a>
                                    </td>
                                    <td>RM{{ number_format($order->total_price, 2) }}</td>
                                    <td>
                                        <span
                                            class="badge
                                            @if ($order->status == 'pending') bg-warning
                                            @elseif($order->status == 'cancel') bg-danger
                                            @else bg-success @endif">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $order->created_at->format('d M Y, h:i A') }}</td>
                                    <td>{{ $order->updated_at->format('d M Y, h:i A') }}</td>
                                    <td>
                                        <div class="d-flex flex-column align-items-center" style="gap: 10px;">
                                            @if ($order->status == 'pending')
                                                <form wire:submit.prevent="payOrder({{ $order->id }})">
                                                    <button class="btn btn-primary" type="submit">Pay Now</button>
                                                </form>
                                            @endif
                                            @if ($order->status == 'paid' || $order->status == 'pending')
                                                <form wire:submit.prevent="cancelOrder({{ $order->id }})">
                                                    <button class="btn btn-danger" type="submit">Cancel</button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $orders->links() }}
                </div>
            @else
                <p class="text-secondary">
                    No orders found.
                </p>
            @endif
        </div>
    </div>

</section>
