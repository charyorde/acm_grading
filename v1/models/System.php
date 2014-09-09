<?php
class System extends Illuminate\Database\Eloquent\Model
{
	protected $table = 'grading_systems';
	
	public $timestamps = false;
	
	public function scales()
	{
		return $this->hasMany('Scale');
	}
}