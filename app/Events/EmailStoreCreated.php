<?php namespace App\Events;

use App\Store;
use Mail;

class EmailStoreCreated {

    public function handle(Store $store){
    	Mail::send('emails.store_created', array('store' => $store), function($msg) use($store){
    		$msg->to($store->email)
    			->subject('Store created ' . $store->public);
    	});
    }

}