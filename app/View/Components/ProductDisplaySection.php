<?php

namespace App\View\Components;

use App\Models\Product;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ProductDisplaySection extends Component
{
    public $id;

    public $title;

    public $products;

    public $emptyProductCategory;

    /**
     * Create a new component instance.
     */
    public function __construct($id, $title, $products)
    {
        $this->id = $id;
        $this->title = $title;
        $this->products = $products->take(4);
        $this->emptyProductCategory = Product::getEmptyProductCategory();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.product-display-section');
    }
}
