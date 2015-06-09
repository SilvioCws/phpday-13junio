<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon as Carbon;

class Store extends Model {

	protected $fillable = array('email', 'title', 'description');
	protected $hidden = array('secret', 'public', 'created_at', 'updated_at', 'featured_until');
	protected $appends = array('slug', 'is_featured', 'last_update');
	protected $dates = array('featured_until');

	public static function boot(){
		self::creating(function($model){
			$model->public = str_random(32);
			$model->secret = str_random(32);
			$model->featured_until = Carbon::now()->subMinutes(5)->toDateTimeString();
		});

		self::created(function($model){
			event('store.created', $model);	
		});
	}

	public static function findByPublicId($id){
		return self::where('public', $id)->first();
	}

	public function getSlugAttribute(){
		return Str::slug($this->title);
	}

	public function getIsFeaturedAttribute(){
		return $this->featured_until !== '0000-00-00' && $this->featured_until->gt(Carbon::now()) ? true : false;
	}

	public function getLastUpdateAttribute(){
		return $this->updated_at->toDateTimeString();
	}

}