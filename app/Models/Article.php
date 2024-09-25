<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    public function getCategory(){
        return $this->hasOne(Category::class,'id','category');

    }
}
