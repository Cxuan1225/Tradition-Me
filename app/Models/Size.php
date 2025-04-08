<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    use HasFactory;

    protected $fillable = ['product_color_id', 'size', 'quantity'];

    public function color()
    {
        return $this->belongsTo(ProductColor::class);
    }
}
