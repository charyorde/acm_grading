<?php
class Scale extends Illuminate\Database\Eloquent\Model
{
	protected $table = 'grading_scales';
	
	public $timestamps = false;
	
	public function system()
	{
		return $this->belongsTo('Post');	
	}
}