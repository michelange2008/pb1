<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    public $fillable = ['nom'];

    public function alertes()
    {
      return $this->hasMany(Alerte::class);
    }

}
