<?php

namespace App\Http\Controllers\API;


use DB;
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
       // $orders = Order::all();
        $orders = DB::table('orders')
            ->join('waiters', 'orders.waiter_id', '=', 'waiters.id') 
            ->join('tables', 'orders.table_id', '=', 'tables.id')
            ->join('clients', 'orders.client_id', '=', 'clients.id')
            //->join('users',function ($join) {
            //$join->on ('waiters.user_id', '=', 'users.id')->orOn('clients.user_id', '=', 'users.id');})
            ->join('users as u1','clients.user_id', '=', 'u1.id' )
            ->join ('users as u2','waiters.user_id', '=', 'u2.id')
            -> where ('waiters.user_id','<>','clients.user_id')
            ->select( "orders.id",'tables.tableNumber', 'u2.username','u1.firstname','u1.lastname')
            ->get();
        return response()->json(["payload"=>$orders,'status'=>200]);
        //->setStatusCode(Response::HTTP_OK);
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
            return response()->json(['errors'=>$validator->errors(),'status'=>422]);
            //->setStatusCode(200);
        }
        $order = new Order;
        $order->client_id = $request->client_id;
        $order->table_id = $request->table_id;
        $order->status = $request->status;
        $order->waiter_id = $request->waiter_id;
        try {
            $order->save();
            return response()
                ->json(['status'=>201])
                //->setStatusCode(201, "Resource created")
                ->setStatusCode(200)
                ->withHeaders([
                    "Location" => $request->url().'/'.$order->id
                ]);
        } catch (\Illuminate\Database\QueryException $ex) {
//            dd($ex->getMessage());
            \Log::error('Encountered while trying to store an Order!', ['context' => $ex->getMessage()]);
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
     * @param  \App\Order $order
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::find($id);
        if(is_null($order))
        {
            return response()
                ->json(['status'=>404])
                ->setStatusCode(200);
                //->setStatusCode(404);
        }
        else
        {
            return response()
                ->json([$order,'status'=>200])
                ->setStatusCode(200);
                //->setStatusCode(200);
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
                    ->json(['status'=>201])
                    ->setStatusCode(200);
                    //->setStatusCode(201);
//                 ->withHeaders([
//                "Location" => $request->url()
//                ]);
            }
            catch (\Illuminate\Database\QueryException $ex) {
//            dd($ex->getMessage());
                \Log::error('Encountered while trying to store an Order!', ['context' => $ex->getMessage()]);
                return response()
                    ->json(["message" => "Unknown error occured while processing data!",
                        'reason' => "unknown",'status'=>422])
                    ->setStatusCode(200);
                    //->setStatusCode(422);
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
                    ->json(['status'=>200])
                    ->setStatusCode(200);
                    //->setStatusCode(200);
//                ->withHeaders([
//                    "Location" => $request->url()
//                ]);
            }
            catch (\Illuminate\Database\QueryException $ex) {
//            dd($ex->getMessage());
                \Log::error('Encountered while trying to store an Order!', ['context' => $ex->getMessage()]);
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
     * @param  \App\Order $order
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::find($id);
        if(is_null($order))
        {
            return response()
                ->json(['status'=>404])
                ->setStatusCode(200);
                //->setStatusCode(404);
        }
        else
        {
            $order->delete();
            return response()
                ->json(['status'=>204])
                ->setStatusCode(200);
                //->setStatusCode(204);

        }
    }
}
