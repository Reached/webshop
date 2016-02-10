<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class Category extends Model implements SluggableInterface
{

    use SluggableTrait;

    protected $sluggable = [
        'build_from' => 'category_name',
        'save_to'    => 'slug',
    ];

    protected $fillable = ['category_name', 'is_active'];

    public function products() {
        return $this->hasMany('App\Product');
    }

    protected $casts = [
        'is_active' => 'boolean'
    ];
}


