<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Origine extends Model
{

    protected $table = 'origines';
    public $timestamps = false;
    protected $fillable = array('alerte_id', 'question', 'reponse');

    public function alerte()
    {
        return $this->belongsTo(Alerte::class);
    }

    public function sorigines()
    {
        return $this->hasMany(Sorigine::class);
    }

}
