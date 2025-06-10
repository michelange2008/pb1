<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alerte extends Model
{

    protected $table = 'alertes';
    public $timestamps = false;
    protected $fillable = array('nom', 'type', 'unite', 'niveau', 'modalite', 'theme_id', 'espece_id');

    public function theme()
    {
        return $this->belongsTo(Theme::class);
    }

    public function critalertes()
    {
        return $this->hasMany(Critalerte::class, 'alerte_id');
    }

    public function origines()
    {
        return $this->hasMany(Origine::class, 'alerte_id');
    }

    public function espece()
    {
        return $this->belongsTo(Espece::class, 'id');
    }

    public function salertes()
    {
        return $this->hasMany(Salerte::class, 'alerte_id');
    }

    public function categorie()
    {
      return $this->belongsTo(Categorie::class);
    }

}
