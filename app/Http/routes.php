<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

$app->get('/', function() use ($app) {
	return 'Hola PHP Day!';
});

/**
 * Prefijos para agrupar rutas facilmente!
 */
$app->group(['prefix' => '/stores'], function($app){

	$app->get('/', function(){
		return App\Store::all()->toJson();
	});

	$app->post('/', function(){
		$input = Request::only('title', 'description', 'email');

		$validation = Validator::make($input, array(
			'title' => 'required',
			'description' => '',
			'email' => 'required|email|unique:stores'
			));

		if($validation->fails())
			return response()->json(array(
				'status' => 'error',
				'messages' => $validation->messages()
				));

		$store = App\Store::create(array(
			'email' => $input['email'],
			'title' => $input['title'],
			'description' => $input['description']
			));

		return response()->json(array(
			'status' => 'success',
			'data' => $store->toArray(),
			));
	});

});

/*

$app->group([ 'prefix' => '/stores/{id}', 'middleware' => 'valid_store_id', 'namespace' => 'App\Http\Controllers' ],
	function($app){
		$app->get('/', 'StoresController@get_store');

		$app->group([ 'middleware' => 'valid_store_secret' ], function(){
			$app->post('/', 'StoresController@post_product');
			$app->patch('/', 'StoresController@patch_store');
			$app->delete('/', 'StoresController@delete_store');
		});
	});

*/

// /stores/:id
$app->group([ 'prefix' => '/stores/{id}', 'middleware' => 'valid_store_id' ], 
	function($app){
		$app->get('/', function($id){
			return App\Store::findByPublicId($id)->toJson();
		});
	});

$app->group([ 'prefix' => '/stores/{id}', 'middleware' => 'valid_store_secret' ],
	function($app){
		// /stores/:id POST nuevo producto
		$app->post('/', function($id){
			$store = App\Store::findByPublicId($id);

			$input = Request::only('title', 'description');

			$validation = Validator::make($input, array(
				'title' => 'required',
				'description' => ''
				));

			if($validation->fails())
				return response()->json(array(
					'status' => 'error',
					'messages' => $validation->messages()
					));

			$product = $store->products()->create(array(
				'title' => $input['title'],
				'description' => $input['description']
				));

			return response()->json(array(
				'status' => 'success',
				'data' => $product->toArray()
				));
		});

		// /stores/:id/ PATCH actualizar info tienda
		$app->patch('/', function($id){
			$store = App\Store::findByPublicId($id);

			$input = Request::only('title', 'description');

			$validation = Validator::make($input, array(
				'title' => 'required',
				'description' => '',
				));

			if($validation->fails())
				return response()->json(array(
					'status' => 'error',
					'messages' => $validation->messages()
					));

			$store->update(array(
				'title' => $input['title'],
				'description' => $input['description']
				));

			return response()->json(array(
				'status' => 'success',
				'data' => $store->toArray(),
				));
		});

		// /stores/:id/ DELETE
		$app->delete('/', function($id){
			$store = App\Store::findByPublicId($id);
			$store->delete();

			return response()->json(array('status' => 'success'));
		});
	});

$app->group([ 'prefix' => '/stores/{id}/products/{pid}', 'middleware' => 'valid_product_id'], 
	function($app){

		$app->get('/', function($id, $pid){
			return App\Product::find($pid)->toJson();
		});

		$app->patch('/', function($id, $pid){
			$product = App\Product::find($pid);

			$input = Request::only('title', 'description');

			$validation = Validator::make($input, array(
				'title' => 'required',
				'description' => '',
				));

			if($validation->fails())
				return response()->json(array(
					'status' => 'error',
					'messages' => $validation->messages()
					));

			$product->update(array(
				'title' => $input['title'],
				'description' => $input['description']
				));

			return response()->json(array(
				'status' => 'success',
				'data' => $product->toArray(),
				));
		});

		// /products/:id/ DELETE
		$app->delete('/', function($id, $pid){
			$product = App\Product::find($pid);
			$product->delete();

			return response()->json(array('status' => 'success'));
		});

	});