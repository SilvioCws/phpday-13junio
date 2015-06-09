<?php namespace App\Http\Middleware;

use Closure;

class ValidStoreSecret {

    public function handle($request, Closure $next)
    {
    	if( ! isset($request->route()[2]['id']))
    		return response()->json(array('status' => 'error', 'message' => 'Invalid store id'));

    	$id = $request->route()[2]['id'];

    	$store = \App\Store::findByPublicId($id);

    	if(is_null($store))
    		return response()->json(array('status' => 'error', 'message' => 'Invalid store id'));

    	if($store->secret !== $request->get('secret'))
    		return response()->json(array('status' => 'error', 'message' => 'Invalid store secret'));

        return $next($request);
    }

}
