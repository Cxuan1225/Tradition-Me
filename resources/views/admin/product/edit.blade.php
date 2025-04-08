<!-- Edit Product Button -->
<button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#editProductModal{{ $product->id }}">
    Edit
</button>

<!-- Edit Product Modal -->
<div class="modal fade" id="editProductModal{{ $product->id }}" tabindex="-1" role="dialog"
    aria-labelledby="editProductModalLabel{{ $product->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="editProductModalLabel{{ $product->id }}">Edit Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.product.update', $product->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <!-- Product Name -->
                    <div class="form-group">
                        <label for="name">Product Name</label>
                        <input type="text" class="form-control" id="name" name="name"
                            value="{{ old('name', $product->name) }}" required>
                    </div>

                    <!-- Product Description -->
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" required>{{ old('description', $product->description) }}</textarea>
                    </div>

                    <!-- Product Category -->
                    <div class="form-group">
                        <label for="category">Category</label>
                        <select name="category" id="category" class="form-control" required>
                            <option value="" disabled>Select category</option>
                            @foreach (['Malay', 'Chinese', 'Indian'] as $category)
                                <option value="{{ $category }}"
                                    {{ old('category', $product->category) == $category ? 'selected' : '' }}>
                                    {{ $category }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Product Price -->
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="number" class="form-control" id="price" name="price" step="0.01"
                            value="{{ old('price', $product->price) }}" required>
                    </div>

                    <!-- Color Selection -->
                    <div class="form-group">
                        <label for="colors">Colors</label>
                        <div class="d-flex flex-wrap">
                            @foreach (['white', 'black', 'grey', 'red', 'green', 'blue', 'yellow'] as $color)
                                <div class="form-check form-check-inline">
                                    <input type="checkbox"
                                        class="form-check-input color-checkbox color-checkbox-edit{{ $product->id }}"
                                        id="color{{ $color }}{{ $product->id }}"
                                        name="colors[{{ $color }}]" value="{{ $color }}"
                                        {{ $product->hasColor($color) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="color{{ $color }}{{ $product->id }}">
                                        {{ ucfirst($color) }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Size Selection for Each Color -->
                    <div id="colorSizeSectionsForEdit{{ $product->id }}"></div>

                    <div class="form-group">
                        <label for="images">Images</label>
                        <input type="file" class="form-control" id="images" name="images[]" multiple>
                    </div>

                    <!-- Display Current Images -->
                    <div class="current-images">
                        <h6>Current Images:</h6>
                        @foreach ($product->images as $image)
                            <img src="{{ asset('storage/' . $image->image_path) }}" alt="Product Image"
                                class="img-fluid" style="max-width: 100px; margin-right: 10px;">
                        @endforeach
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

<script>
    $(document).ready(function() {
        const productId = '{{ $product->id }}';
        const $editModal = $(`#editProductModal${productId}`);
        const $colorCheckboxesForEdit = $editModal.find(`.color-checkbox-edit${productId}`);
        const $colorSizeSectionsForEdit = $editModal.find(`#colorSizeSectionsForEdit${productId}`);

        const productData = @json(
            $product->colors->mapWithKeys(function ($color) {
                return [
                    $color->color => $color->sizes->mapWithKeys(function ($size) {
                        return [$size->size => $size->quantity];
                    }),
                ];
            }));

        function isSizeChecked(color, size) {
            return productData[color] && productData[color][size] > 0;
        }

        function updateColorSizeSectionsForEdit() {
            $colorSizeSectionsForEdit.empty();

            $colorCheckboxesForEdit.each(function() {
                if ($(this).is(':checked')) {
                    const color = $(this).val();
                    const sizes = ['S', 'M', 'L', 'XL', 'XXL'];
                    const colorSection = `
                        <div class="color-section" id="colorSection_${color}${productId}">
                            <h5>${color.charAt(0).toUpperCase() + color.slice(1)} Sizes</h5>
                            <div class="form-group">
                                <div class="d-flex justify-content-between">
                                    ${sizes.map(size => `
                                        <div class="form-check form-check-inline">
                                            <input type="checkbox" class="form-check-input size-checkbox" id="size_${color}_${size}${productId}" name="colors[${color}][sizes][${size}][checked]" value="${size}" ${isSizeChecked(color, size) ? 'checked' : ''} />
                                            <label class="form-check-label" for="size_${color}_${size}${productId}">${size}</label>
                                        </div>
                                    `).join('')}
                                </div>
                            </div>
                            <div id="quantityInputs_${color}${productId}"></div>
                        </div>
                    `;

                    $colorSizeSectionsForEdit.append(colorSection);
                    updateQuantityInputsForEdit(color);
                }
            });
        }

        function updateQuantityInputsForEdit(color) {
            const $quantityInputs = $editModal.find(`#quantityInputs_${color}${productId}`);

            $editModal.find(`#colorSection_${color}${productId} .size-checkbox`).each(function() {
                const size = $(this).val();
                const quantity = productData[color] && productData[color][size] ? productData[color][
                    size
                ] : 0;

                if ($(this).is(':checked')) {
                    if (!$(`#quantity_${color}_${size}${productId}`).length) {
                        $quantityInputs.append(`
                            <div class="form-group">
                                <label for="quantity_${color}_${size}${productId}">${size} Size Quantity for ${color}</label>
                                <input type="number" class="form-control" name="colors[${color}][sizes][${size}][quantity]" id="quantity_${color}_${size}${productId}" min="0" value="${quantity}">
                            </div>
                        `);
                    }
                } else {
                    $(`#quantity_${color}_${size}${productId}`).parent().remove();
                }
            });
        }

        $colorCheckboxesForEdit.change(function() {
            updateColorSizeSectionsForEdit();
        });

        $editModal.on('change', '.size-checkbox', function() {
            const color = $(this).attr('id').split('_')[1];
            updateQuantityInputsForEdit(color);
        });

        updateColorSizeSectionsForEdit();
    });
</script>
