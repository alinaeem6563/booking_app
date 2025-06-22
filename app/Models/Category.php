<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
   protected $fillable=['category_name','category_description','category_slug','category_icon_link','category_status'];
    public function services()
    {
        return $this->hasMany(Service::class, 'category_id');
    }
}
