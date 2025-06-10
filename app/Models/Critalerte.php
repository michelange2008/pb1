<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Critalerte extends Model
{

    protected $table = 'critalertes';
    public $timestamps = true;
    protected $fillable = array('alerte_id', 'nom');

    public function alerte()
    {
        return $this->belongsTo(Alerte::class);
    }

}
