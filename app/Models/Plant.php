<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plant extends Model
{
    use HasFactory;

    protected $fillable = [
        'scientific_name',
        'common_name',
        'origin',
        'description',
        'category_id', // Make sure category_id is here

    ];

    public function advices()
    {
        return $this->hasMany(Advice::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}