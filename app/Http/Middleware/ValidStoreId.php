<?php namespace App\Http\Middleware;

use Closure;

class ValidStoreId {

    public function handle($request, Closure $next)
    {
    	if( ! isset($request->route()[2]['id']))
    		return response()->json(array('status' => 'error', 'message' => 'Invalid store id'));

    	$id = $request->route()[2]['id'];

    	if(is_null(\App\Store::findByPublicId($id)))
    		return response()->json(array('status' => 'error', 'message' => 'Invalid store id'));

        return $next($request);
    }

}
