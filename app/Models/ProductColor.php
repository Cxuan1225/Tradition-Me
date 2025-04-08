<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductColor extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'color'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function sizes()
    {
        return $this->hasMany(Size::class);
    }

    public function addSizes(array $sizes)
    {
        foreach ($sizes as $size => $sizeData) {
            if ($sizeData['quantity'] > 0) {
                $this->sizes()->create([
                    'size' => $size,
                    'quantity' => $sizeData['quantity'],
                ]);
            }
        }
    }
}
