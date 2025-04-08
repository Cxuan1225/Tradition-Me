<button type="button" class="btn btn-danger mb-3" data-toggle="modal" data-target="#deleteModal{{ $product->id }}">
    Delete
</button>
<div class="modal fade" id="deleteModal{{ $product->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this product?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <a href="{{ route('admin.product.destroy', $product->id) }}" class="btn btn-danger"
                    onclick="event.preventDefault(); document.getElementById('delete-form-{{ $product->id }}').submit();">
                    Delete
                </a>
                <form id="delete-form-{{ $product->id }}" action="{{ route('admin.product.destroy', $product->id) }}"
                    method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>
    </div>
</div>
