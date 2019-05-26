<?php

namespace App\Http\Controllers\API;

use App\Waiter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class WaitersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()
            ->json(["payload"=>Waiter::all(),'status'=>200])
            ->setStatusCode(200);
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

        ]);
        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors(),'status'=>422]);
        }

        $waiter = new Waiter;
//        dd($request->post());
        $waiter->user_id = $request->user_id;
        $waiter->place_id = $request->place_id;
        try {
            $waiter->save();
            return response()
                ->json(['status'=>201])
                ->setStatusCode(200)
                //->setStatusCode(201, "Resource created")
                ->withHeaders([
                    "Location" => $request->url().'/'.$waiter->id
                ]);
        } catch (\Illuminate\Database\QueryException $ex) {
//            dd($ex->getMessage());
            \Log::error('Encountered while trying to store a Waiter!', ['context' => $ex->getMessage()]);
            return response()
                ->json(["message" => "Provided user is incorrect. Most likely a server processing error while storing waiter!",
                    'reason' => "user_id",'status'=>422])
                ->setStatusCode(200);
                //->setStatusCode(422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $waiter = Waiter::find($id);
        if(is_null($waiter))
        {
            return response()
                ->json(['status'=>404])
                ->setStatusCode(200);
                //->setStatusCode(404);
        }
        else
        {
            return response()
                ->json([$waiter,'status'=>200])
                ->setStatusCode(200);
        }
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [

        ]);
        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors(),'status'=>422]);
        }

        $waiter = Waiter::find($id);
        if(is_null($waiter))
        {
            $waiter = new Waiter;
            $waiter->id = $id;
            $waiter->user_id = $request->user_id;
            $waiter->place_id = $request->place_id;
            try {
                $waiter->save();
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
                \Log::error('Encountered while trying to store a Waiter!', ['context' => $ex->getMessage()]);
                return response()
                    ->json(["message" => "Unknown error occured while processing data!",
                        'reason' => "unknown",'status'=>422])
                    ->setStatusCode(200);
                    //->setStatusCode(422);
            }
        }
        else
        {
            $waiter->id = $id;
            $waiter->user_id = $request->user_id;
            $waiter->place_id = $request->place_id;
            try{
                $waiter->save();
                return response()
                    ->json(['status'=>200])
                    ->setStatusCode(200);
//                ->withHeaders([
//                    "Location" => $request->url()
//                ]);
            } catch (\Illuminate\Database\QueryException $ex) {
//            dd($ex->getMessage());
                \Log::error('Encountered while trying to store a Waiter!', ['context' => $ex->getMessage()]);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $waiter = Waiter::find($id);
        if(is_null($waiter))
        {
            return response()
                ->json(['status'=>404])
                ->setStatusCode(200);
                //->setStatusCode(404);
        }
        else
        {
            $waiter->delete();
            return response()
                ->json(['status'=>204])
                ->setStatusCode(200);
                //->setStatusCode(204);
        }
    }
}
