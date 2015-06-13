<?php namespace App\Http\Middleware;

use Closure;

class ValidProductId {

    public function handle($request, Closure $next)
    {
    	if( ! isset($request->route()[2]['pid']))
    		return response()->json(array('status' => 'error', 'message' => 'Invalid product id'));

    	$id = $request->route()[2]['pid'];

    	if(is_null(\App\Product::find($id)))
    		return response()->json(array('status' => 'error', 'message' => 'Invalid product id'));

        return $next($request);
    }

}
