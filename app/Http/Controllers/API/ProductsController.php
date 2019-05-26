<?php

namespace App\Http\Controllers\API;

use App\Product;
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
    public function index()
    {
        return response()
            ->json(['payload'=>Product::all(),'status'=>200])
            ->setStatusCode(200);
            //->setStatusCode(200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'places_id'=>'required',
            'name'=> 'required',
            'price' => 'required',
            'status' => 'required',
            'description' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors(),'status'=>422]);
        }
        $product = new Product;
//        dd($request->post());
        $product->place_id = $request->place_id;
        $product->name = $request->name;
        $product->price = $request->price;
        $product->status = $request->status;
        $product->description = $request->description;
        try {
            $product->save();
            return response()
                ->json(['status'=>201])
                ->setStatusCode(200)
                //->setStatusCode(201, "Resource created")
                ->withHeaders([
                    "Location" => $request->url().'/'.$product->id
                ]);
        } catch (\Illuminate\Database\QueryException $ex) {
//            dd($ex->getMessage());
            \Log::error('Encountered while trying to store a Product!', ['context' => $ex->getMessage()]);
            return response()
                ->json(["message" => "Unknown error occured while processing data!",
                    'reason' => "unknown",'status'=>422])
                ->setStatusCode(200);
                //->setStatusCode(422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        if(is_null($product))
        {
            return response()
                ->json(['status'=>404])
                ->setStatusCode(200);
                //->setStatusCode(404);
        }
        else
        {
            return response()
                ->json([$product,'status'=>200])
                ->setStatusCode(200);
                //->setStatusCode(200);
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
                    ->json(['status'=>201])
                    ->setStatusCode(200);
                    //->setStatusCode(201);
//                 ->withHeaders([
//                "Location" => $request->url()
//                ]);
            }
            catch (\Illuminate\Database\QueryException $ex) {
//            dd($ex->getMessage());
                \Log::error('Encountered while trying to store a Product!', ['context' => $ex->getMessage()]);
                return response()
                    ->json(["message" => "Unknown error occured while processing data!",
                        'reason' => "unknown",'status'=>422])
                    ->setStatusCode(200);
                    //->setStatusCode(422);
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
                    ->json(['status'=>200])
                    ->setStatusCode(200);
//                ->withHeaders([
//                    "Location" => $request->url()
//                ]);
            } catch (\Illuminate\Database\QueryException $ex) {
//            dd($ex->getMessage());
                \Log::error('Encountered while trying to store a Product!', ['context' => $ex->getMessage()]);
                return response()
                    ->json(["message" => "Unknown error occured while processing data!",
                        'reason' => "unknown",'status'=>422])
                    ->setStatusCode(200);
                    //->setStatusCode(422);
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
                ->json(['status'=>404])
                ->setStatusCode(200);
                //->setStatusCode(404);
        }
        else
        {
            $product ->delete();
            return response()
                ->json(['status'=>204])
                ->setStatusCode(200);
                //->setStatusCode(204);
        }
    }
}
