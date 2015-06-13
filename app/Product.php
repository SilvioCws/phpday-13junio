<?php namespace App;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Product extends Model {

	protected $fillable = array('title', 'description');
	protected $hidden = array('store_id', 'created_at', 'updated_at');
	protected $appends = array('slug', 'endpoint', 'last_update');

	public function Store(){
		return $this->belongsTo('\App\Store');
	}

	public function getSlugAttribute(){
		return Str::slug($this->title);
	}

	public function getLastUpdateAttribute(){
		return $this->updated_at->toDateTimeString();
	}

	public function getEndpointAttribute(){
		return url('/stores/' . $this->id . '/products/' . $this->id);
	}

}