<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $guarded = [];


    /** 
     * A comment belongs to a User
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
    /** 
     * A comment belongs to a trouble ticket
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function troubleTicket()
    {
        return $this->belongsTo(TroubleTicket::class);
    }
}
