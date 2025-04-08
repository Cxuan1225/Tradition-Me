<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;

class ProductSearch extends Component
{
    public $search = '';
    public $category;

    public function render()
    {
        $query = Product::query();

        if ($this->category) {
            $query->where('category', $this->category);
        }

        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        $products = $query->get();

        return view('livewire.product-search', [
            'products' => $products,
        ]);
    }
}
