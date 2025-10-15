<?php

namespace App\Models;

use App\Models\Blog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{

    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function blogs(){
        return $this->hasMany(Blog::class);
    }
}
