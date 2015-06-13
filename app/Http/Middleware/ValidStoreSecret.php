<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ValidStoreSecret {

    public function handle(Request $request, Closure $next)
    {
        if( ! isset($request->route()[2]['id']))
            return response()->json(array('status' => 'error', 'message' => 'Invalid store id'));

        $id = $request->route()[2]['id'];
        $secret = $request->input('secret');

    	$store = \App\Store::findByPublicId($id);

    	if(is_null($store))
    		return response()->json(array('status' => 'error', 'message' => 'Invalid store id'));

    	if($store->secret !== $secret)
    		return response()->json(array('status' => 'error', 'message' => 'Invalid store secret'));

        return $next($request);
    }

}
