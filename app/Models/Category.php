<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table='category';
   protected $fillable=['category_name','category_description','category_slug','category_icon_link','category_status'];
}
