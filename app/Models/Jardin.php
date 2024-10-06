<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jardin extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'description', 'adresse','image'];

    public function evenements()
    {
        return $this->hasMany(Evenement::class);
    }
}
