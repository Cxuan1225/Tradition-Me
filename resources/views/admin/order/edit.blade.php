<!-- Edit order Button -->
<button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#editOrderModal{{ $order->id }}">
    Update Status
</button>

<!-- Edit order Modal -->
<div class="modal fade" id="editOrderModal{{ $order->id }}" tabindex="-1" role="dialog"
    aria-labelledby="editOrderModalLabel{{ $order->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="editOrderModalLabel{{ $order->id }}">Update Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('order.update', $order->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="userId">User ID</label>
                        <input type="text" class="form-control" id="userId" value="{{ $order->user_id }}"
                            readonly>
                    </div>
                    <div class="form-group">
                        <label for="totalPrice">Total Price</label>
                        <input type="text" class="form-control" id="totalPrice" value="{{ $order->total_price }}"
                            readonly>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" id="status" name="status">
                            @if ($order->status === 'cancel' || $order->status === 'refunded')
                                @if ($order->status === 'cancel')
                                    <option value="cancel" selected>Cancel</option>
                                @endif
                                <option value="refunded" {{ $order->status === 'refunded' ? 'selected' : '' }}>Refunded
                                </option>
                            @else
                                <option value="paid" {{ $order->status === 'paid' ? 'selected' : '' }}>Paid
                                </option>
                                <option value="shipping" {{ $order->status === 'shipping' ? 'selected' : '' }}>Shipping
                                </option>
                                <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>
                                    Delivered</option>
                            @endif
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="createdAt">Created At</label>
                        <input type="text" class="form-control" id="createdAt"
                            value="{{ $order->created_at->format('Y-m-d H:i:s') }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="updatedAt">Updated At</label>
                        <input type="text" class="form-control" id="updatedAt"
                            value="{{ $order->updated_at->format('Y-m-d H:i:s') }}" readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
