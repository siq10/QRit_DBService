<?php

namespace App\Http\Controllers\API;

use App\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Order::all());
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
            'client_id'=>'required',
            'waiter_id'=> 'required',
            'table_id' => 'required',
            'status' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()],422);
        }
        $order = new Order;
        $order->client_id = $request->client_id;
        $order->table_id = $request->table_id;
        $order->status = $request->status;
        $order->waiter_id = $request->waiter_id;
        try {
            $order->save();
            return response()
                ->json()
                ->setStatusCode(201, "Resource created")
                ->withHeaders([
                    "Location" => $request->url().'/'.$order->id
                ]);
        } catch (\Illuminate\Database\QueryException $ex) {
//            dd($ex->getMessage());
            \Log::error('Encountered while trying to store an Order!', ['context' => $ex->getMessage()]);
            return response()
                ->json(["message" => "Unknown error occured while processing data!",
                    'reason' => "unknown"])
                ->setStatusCode(422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order $order
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::find($id);
        if(is_null($order))
        {
            return response()
                ->json()
                ->setStatusCode(404);
        }
        else
        {
            return response()
                ->json($order)
                ->setStatusCode(200);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [

        ]);
        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()],422);
        }

        $order = Order::find($id);
        if(is_null($order))
        {
            $order = new Order;
            $order->id = $id;
            $order->client_id = $request->client_id;
            $order->table_id = $request->table_id;
            $order->status = $request->status;
            $order->waiter_id = $request->waiter_id;
            try {
                $order->save();
                return response()
                    ->json()
                    ->setStatusCode(201);
//                 ->withHeaders([
//                "Location" => $request->url()
//                ]);
            }
            catch (\Illuminate\Database\QueryException $ex) {
//            dd($ex->getMessage());
                \Log::error('Encountered while trying to store an Order!', ['context' => $ex->getMessage()]);
                return response()
                    ->json(["message" => "Unknown error occured while processing data!",
                        'reason' => "unknown"])
                    ->setStatusCode(422);
            }
        }
        else
        {
            $order->client_id = $request->client_id;
            $order->table_id = $request->table_id;
            $order->status = $request->status;
            $order->waiter_id = $request->waiter_id;
            try {
                $order->save();
                return response()
                    ->json()
                    ->setStatusCode(200);
//                ->withHeaders([
//                    "Location" => $request->url()
//                ]);
            }
            catch (\Illuminate\Database\QueryException $ex) {
//            dd($ex->getMessage());
                \Log::error('Encountered while trying to store an Order!', ['context' => $ex->getMessage()]);
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
     * @param  \App\Order $order
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::find($id);
        if(is_null($order))
        {
            return response()
                ->json()
                ->setStatusCode(404);
        }
        else
        {
            $order->delete();
            return response()
                ->json()
                ->setStatusCode(204);
        }
    }
}
