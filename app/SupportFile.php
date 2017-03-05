<?php

namespace App;

use Illuminate\Http\UploadedFile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class SupportFile extends Model
{
	protected $guarded = [];


	public function troubleTicket()
	{
		return $this->belongsTo(TroubleTicket::class, 'trouble_ticket_id');
	}

}
