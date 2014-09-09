<?php
class Grade extends Illuminate\Database\Eloquent\Model
{
	protected $table = 'grades';
	
	public $timestamps = false;
	
	public function user()
	{
		return $this->belongsTo('User');
	}
}