<?php

namespace App\Http\Controllers\API\orders;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use DB;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($order_id)
    {
       $products = Product::all();
       return response()->json($products)->setStatusCode(Response::HTTP_OK); //HTTP_OK=200;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$order_id)
    {
        dd("it here");
        $product = new Product;
        $product->places_id=$request->places_id;
        $product->order_id=$order_id;
        $product->name=$request->$request->name;
        $product->price=$request->price;
        $product->status=$request->status;
        $product->description=$request->description;


        $product->save();
        

        return response()->json($product)->setStatusCode(Response::HTTP_CREATED); 

        //$token = $this->authorizeUser($user);
        //return response()->json($token);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id,$order_id)
    {
         $product= Product::find($id);
        //$table->place()->associate($place);
        $data = DB::table('products')->where('id', '=', "{$id}")->get();
        //$data = DB::table('places')->where('name', '=', "{$name}")->get();
        
        return response()->json($data)->setStatusCode(Response::HTTP_OK); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //return $this->login($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        //
    }
}
