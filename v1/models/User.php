<?php
class User extends Illuminate\Database\Eloquent\Model
{
	protected $table = 'users';
	
	public $timestamps = false;
	
	public function grades()
	{
		return $this->hasMany('Grade');
	}
}