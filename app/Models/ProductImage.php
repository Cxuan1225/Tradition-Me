<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ProductImage extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'image_path'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public static function storeImage($image, $product)
    {
        $imagePath = $image->store('product_images', 'public');
        self::create([
            'product_id' => $product->id,
            'image_path' => $imagePath,
        ]);
    }

    public function deleteImage()
    {
        if ($this->image_path !== 'product_images/default-image.jpg') {
            Storage::disk('public')->delete($this->image_path);
        }
        $this->delete();
    }
}
