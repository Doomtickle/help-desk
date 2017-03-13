<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subproject extends Model
{
    protected $guarded = [];


    public function company()
    {
        return $this->hasMany(Company::class);
    }


    public function projects()
    {
        return $this->belongsto(Project::class);
    }
    
}
