<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Photo;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class Product extends Model implements SluggableInterface
{
    use SluggableTrait;

    protected $sluggable = [
        'build_from' => 'product_name',
        'save_to'    => 'slug',
    ];

    protected $fillable = [
        'product_name',
        'long_description',
        'short_description',
        'product_image',
        'product_price',
        'category_id',
        'is_active',
        'meta_description'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function photos() {
        return $this->hasMany('App\Photo');
    }

    public function addPhoto(Photo $photo) {
        return $this->photos()->save($photo);
    }
}
