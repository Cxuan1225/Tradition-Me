<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Product extends Model
{
    use HasFactory, Searchable;

    protected $table = 'products';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'name',
        'description',
        'price',
        'category',
        'stock_quantity',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'category' => 'string',
    ];

    public static function category($category)
    {
        return self::where('category', $category)->exists();
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function colors()
    {
        return $this->hasMany(ProductColor::class);
    }

    public function hasColor($color)
    {
        return $this->colors()->where('color', $color)->exists();
    }

    public static function getEmptyProductCategory()
    {
        $allCategories = ['Malay', 'Chinese', 'Indian', 'Other'];

        $categoriesWithProducts = self::select('category')
            ->groupBy('category')
            ->pluck('category')
            ->toArray();

        $emptyCategories = array_diff($allCategories, $categoriesWithProducts);

        return $emptyCategories;
    }

    public function getSizeQuantity($color, $size)
    {
        $colorModel = $this->colors()->where('color', $color)->first();

        if ($colorModel) {
            // Find the size and return its quantity
            $sizeModel = $colorModel->sizes()->where('size', $size)->first();

            return $sizeModel ? $sizeModel->quantity : 0;
        }

        return 0;
    }

    public function calculateStockQuantity(array $color)
    {
        $stockQuantity = 0;

        foreach ($color as $colorData) {
            foreach ($colorData['sizes'] as $sizeData) {
                $stockQuantity += $sizeData['quantity'];
            }
        }

        return $stockQuantity;
    }

    public function storeImages($images)
    {
        foreach ($images as $image) {
            ProductImage::storeImage($image, $this);
        }
    }

    public function deleteImages()
    {
        $images = $this->images;

        foreach ($images as $image) {
            $image->deleteImage();
        }
    }

    public function addColorsAndSizes(array $colors)
    {
        foreach ($colors as $color => $colorData) {
            $colorModel = $this->colors()->create([
                'color' => $color,
            ]);

            $colorModel->addSizes($colorData['sizes']);
        }
    }

    public function updateColorsAndSizes(array $colors)
    {
        $this->colors()->each(function ($color) {
            $color->sizes()->delete();
            $color->delete();
        });
        $this->addColorsAndSizes($colors);
    }
}
