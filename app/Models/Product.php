<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'price','desc','image'
    ];

    public function setImageAttribute($image)
    {
        if (!$image) {
            return;
        }
        $path = storage_path("app/public/product");
        $image = str_replace('data:image/jpeg;base64,', '', $image);
        $image = str_replace(' ', '+', $image);
        $imageName = md5(rand(11111, 99999)) . '_' . time() . '.png';
        $path = $path . '/'  . $imageName;
        $input = \File::put($path, base64_decode($image));
        $this->attributes['image'] = $imageName;
    }


    public function Ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function avgRating()
    {
        return $this->ratings()->avg('rate');
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }
}
