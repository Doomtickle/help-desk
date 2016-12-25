<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

/**
 * @property mixed id
 */
class TroubleTicket extends Model
{
    protected $fillable = [
        'title',
        'user_id',
        'description',
        'priority',
        'status',
        'complete',
        'website',
    ];
    public function user()
    {
       return $this->belongsTo(User::class);     
    }

    public static function ticketInfo($id)
    {
        return static::where(compact('id'))->with('user')->first();

    }
    
}
