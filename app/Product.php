<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMedia;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMediaConversions;

class Product extends Model implements SluggableInterface, HasMedia, HasMediaConversions
{
    use SluggableTrait;
    use HasMediaTrait;

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
        'meta_description',
        'billys_product_id'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function registerMediaConversions()
    {
        $this->addMediaConversion('large')
            ->setManipulations(['w' => 400, 'h' => 400]);
        $this->addMediaConversion('medium')
            ->setManipulations(['w' => 300, 'h' => 300]);
        $this->addMediaConversion('small')
            ->setManipulations(['w' => 200, 'h' => 200]);
    }
}
