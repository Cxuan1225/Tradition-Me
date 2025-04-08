<!-- Create Product Modal -->
<div class="modal fade" id="createProductModal" tabindex="-1" role="dialog" aria-labelledby="createProductModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="createProductModalLabel">Add New Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <!-- Existing Fields -->
                    <div class="form-group">
                        <label for="name">Product Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="category">Category</label>
                        <select name="category" id="category" class="form-control" required>
                            <option value="" disabled selected>Select category</option>
                            @foreach (['Malay', 'Chinese', 'Indian'] as $category)
                                <option value="{{ $category }}">{{ $category }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="number" class="form-control" id="price" name="price" step="0.01"
                            required>
                    </div>

                    <!-- Color Selection -->
                    <div class="form-group">
                        <label for="colors">Colors</label>
                        <div class="d-flex flex-wrap">
                            @foreach (['white', 'black', 'grey', 'red', 'green', 'blue', 'yellow'] as $color)
                                <div class="form-check form-check-inline">
                                    <input type="checkbox" class="form-check-input color-checkbox"
                                        id="color{{ $color }}" name="colors[{{ $color }}]"
                                        value="{{ $color }}">
                                    <label class="form-check-label"
                                        for="color{{ $color }}">{{ ucfirst($color) }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Size Selection for Each Color -->
                    <div id="colorSizeSections"></div>

                    <div class="form-group">
                        <label for="images">Images</label>
                        <input type="file" class="form-control" id="images" name="images[]" multiple>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        const $createModal = $(`#createProductModal`);
        const $colorCheckboxes = $createModal.find('.color-checkbox');
        const $colorSizeSections = $createModal.find('#colorSizeSections');

        function updateColorSizeSections() {
            $colorSizeSections.empty();

            $colorCheckboxes.each(function() {
                if ($(this).is(':checked')) {
                    const color = $(this).val();
                    const colorSection = `
                        <div class="color-section" id="colorSection_${color}">
                            <h5>${color.charAt(0).toUpperCase() + color.slice(1)} Sizes</h5>
                            <div class="form-group">
                                <div class="d-flex justify-content-between">
                                    ${['S', 'M', 'L', 'XL', 'XXL'].map(size => `
                                        <div class="form-check form-check-inline">
                                            <input type="checkbox" class="form-check-input size-checkbox" id="size_${color}_${size}" name="colors[${color}][sizes][${size}][checked]" value="${size}">
                                            <label class="form-check-label" for="size_${color}_${size}">${size}</label>
                                        </div>
                                    `).join('')}
                                </div>
                            </div>
                            <div id="quantityInputs_${color}"></div>
                        </div>
                    `;
                    $colorSizeSections.append(colorSection);
                }
            });
        }

        function updateQuantityInputs(color) {
            const $quantityInputs = $(`#quantityInputs_${color}`);

            $(`#colorSection_${color} .size-checkbox`).each(function() {
                const size = $(this).val();

                if ($(this).is(':checked')) {
                    if (!$(`#quantity_${color}_${size}`).length) {
                        $quantityInputs.append(`
                            <div class="form-group">
                                <label for="quantity_${color}_${size}">${size} Size Quantity for ${color}</label>
                                <input type="number" class="form-control" name="colors[${color}][sizes][${size}][quantity]" id="quantity_${color}_${size}" min="0" value="0">
                            </div>
                        `);
                    }
                } else {
                    $(`#quantity_${color}_${size}`).parent().remove();
                }
            });
        }

        $colorCheckboxes.change(function() {
            updateColorSizeSections();
        });

        $createModal.on('change', '.size-checkbox', function() {
            const color = $(this).attr('id').split('_')[1];
            updateQuantityInputs(color);
        });

        // Call updateColorSizeSections initially in case the user checks any colors before submitting the form
        updateColorSizeSections();
    });
</script>
