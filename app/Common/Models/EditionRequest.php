<?php
namespace App\Common\Models;

use Illuminate\Database\Eloquent\Model;

class EditionRequest extends Model
{
	protected $table = 'edition_requests';
	
	protected $casts = [
		'request' => 'array'
	];
	
	public function user()
	{
		return $this->belongsTo(User::class, 'user_id');
	}
}
