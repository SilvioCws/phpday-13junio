<?php namespace App\Http\Controllers;

use App\Store;
use App\Http\Controllers\Controller;

class StoresController extends Controller {

    function get_index(){
        return Store::all()->toJson();
    }

    function get_store($id){
        return Store::findByPublicId($id)->toJson();
    }

    function post_store(){
        return Store::findByPublicId($id)->toJson();
    }

    function post_product($id){
        $store = Store::findByPublicId($id);

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
    }

    // /stores/:id/ PATCH actualizar info tienda
    function patch_store($id){
        $store = Store::findByPublicId($id);

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
    }

    // /stores/:id/ DELETE
    function delete_store($id){
        $store = Store::findByPublicId($id);
        $store->delete();

        return response()->json(array('status' => 'success'));
    }

}