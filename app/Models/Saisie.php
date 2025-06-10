<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Saisie extends Model
{
    protected $table = 'saisies';

    public $timestamps = true;

    protected $fillable = ['user_id', 'espece_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function salertes()
    {
        return $this->hasMany(Salerte::class);
    }

    public function elevage()
    {
      return $this->belongsTo(Elevage::class);
    }

    public function espece()
    {
      return $this->belongsTo(Espece::class);
    }

    public function sorigine()
    {
      return $this->hasMany(Sorigine::class);
    }
}
