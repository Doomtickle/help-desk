<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $guarded = [];

    public function agendas()
    {
        return $this->belongsToMany(Agenda::class);
    }

}
