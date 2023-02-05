<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProductImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'image_path',
    ];

    public function products()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    public function getImageUrlAttribute()
    {
        return url(Storage::url($this->image_path));
    }

    /**
     * @param UploadedFile|null $files
     * @return false|string
     */
    public static function uploadImage(?UploadedFile $files) : false|string
    {
        return $files->store("public/images");
    }
}
