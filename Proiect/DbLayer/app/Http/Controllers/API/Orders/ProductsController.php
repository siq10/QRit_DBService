<?php

namespace App\Http\Controllers\API\Orders;

use App\Product;
use App\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $order = Order::find($id);
        return response()
            ->json($order->products())
            ->setStatusCode(200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$order_id)
    {
        $validator = Validator::make($request->all(), [
        ]);
        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()],422);
        }
        $order = Order::find($order_id);
        if(is_null($order))
        {
            return response()->json(NULL,404);
        }
        else
        {
            $order->products()->attach($request->product_id);
            return response()
                ->json()
                ->setStatusCode(201, "Resource created")
                ->withHeaders([
                    "Location" => $request->url().'/'.$request->product_id
                ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($order_id,$product_id)
    {
        $order = Order::find($order_id);
        if(is_null($order))
        {
            return response()
                ->json()
                ->setStatusCode(404);
        }
        $products = $order->products()
            ->where('product_id',$product_id)
            ->get();
        foreach($products as $item)
        {
            unset($item["pivot"]);
        }
//        dd($products);
        if(count($products))
        {
            return response()
                ->json($products)
                ->setStatusCode(200);
        }
        else
        {
            return response()
                ->json()
                ->setStatusCode(404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [

        ]);
        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()],422);
        }

        $product = Product::find($id);
        if(is_null($product))
        {
            $product = new Product;
            $product->id = $id;
            $product->place_id = $request->place_id;
            $product->name = $request->name;
            $product->price = $request->price;
            $product->status = $request->status;
            $product->description = $request->description;
            try {
                $product->save();
                return response()
                    ->json()
                    ->setStatusCode(201);
//                 ->withHeaders([
//                "Location" => $request->url()
//                ]);
            }
            catch (\Illuminate\Database\QueryException $ex) {
//            dd($ex->getMessage());
                \Log::error('Encountered while trying to store a Product!', ['context' => $ex->getMessage()]);
                return response()
                    ->json(["message" => "Unknown error occured while processing data!",
                        'reason' => "unknown"])
                    ->setStatusCode(422);
            }
        }
        else
        {
            $product->id = $id;
            $product->place_id = $request->place_id;
            $product->name = $request->name;
            $product->price = $request->price;
            $product->status = $request->status;
            $product->description = $request->description;
            try{
                $product->save();
                return response()
                    ->json()
                    ->setStatusCode(200);
//                ->withHeaders([
//                    "Location" => $request->url()
//                ]);
            } catch (\Illuminate\Database\QueryException $ex) {
//            dd($ex->getMessage());
                \Log::error('Encountered while trying to store a Product!', ['context' => $ex->getMessage()]);
                return response()
                    ->json(["message" => "Unknown error occured while processing data!",
                        'reason' => "unknown"])
                    ->setStatusCode(422);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        if(is_null($product ))
        {
            return response()
                ->json()
                ->setStatusCode(404);
        }
        else
        {
            $product ->delete();
            return response()
                ->json()
                ->setStatusCode(204);
        }
    }
}
