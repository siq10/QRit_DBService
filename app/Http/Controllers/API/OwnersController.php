<?php

namespace App\Http\Controllers\API;

use App\Owner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class OwnersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()
            ->json(['payload'=>Owner::all(),'status'=>200])
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

        ]);
        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors(),'status'=422]);
        }
        $owner = new Owner;
//        dd($request->post());
        $owner->user_id = $request->user_id;
        try {
            $owner->save();
            return response()
                ->json(['status'=>201])
                //->setStatusCode(201, "Resource created")
                ->setStatusCode(200)
                ->withHeaders([
                    "Location" => $request->url().'/'.$owner->id
                ]);
        } catch (\Illuminate\Database\QueryException $ex) {
//            dd($ex->getMessage());
            \Log::error('Encountered while trying to store an Owner!', ['context' => $ex->getMessage()]);
            return response()
                ->json(["message" => "Provided user is incorrect. Most likely a server processing error while storing owner!",
                    'reason' => "user_id","status"=>422])
                //->setStatusCode(422);
                ->setStatusCode(200);
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
        $owner = Owner::find($id);
        if(is_null($owner))
        {
            return response()
                ->json(['status'=>404])
                //->setStatusCode(404);
                ->setStatusCode(200);
            }
        else
        {
            return response()
                ->json([$owner,'status'=>200])
                ->setStatusCode(200);
                //->setStatusCode(200);
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

        $owner = Owner::find($id);
        if(is_null($owner))
        {
            $owner = new Owner;
            $owner->id = $id;
            $owner->user_id = $request->user_id;
            try {
                $owner->save();
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
                \Log::error('Encountered while trying to store an Owner!', ['context' => $ex->getMessage()]);
                return response()
                    ->json(["message" => "Unknown error occured while processing data!",
                        'reason' => "unknown",'status'=>422])
                    ->setStatusCode(200);
                    //->setStatusCode(422);
            }
        }
        else
        {
            $owner->id = $id;
            $owner->user_id = $request->user_id;
            try{
                $owner->save();
                return response()
                    ->json(['status'=>200])
                    ->setStatusCode(200);
                    //->setStatusCode(200);
//                ->withHeaders([
//                    "Location" => $request->url()
//                ]);
            } catch (\Illuminate\Database\QueryException $ex) {
//            dd($ex->getMessage());
                \Log::error('Encountered while trying to store an Owner!', ['context' => $ex->getMessage()]);
                return response()
                    ->json(["message" => "Unknown error occured while processing data!",
                        'reason' => "unknown",'status'=>422])
                    ->setStatusCode(200)
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
        $owner = Owner::find($id);
        if(is_null($owner))
        {
            return response()
                ->json(['status'=>404])
                ->setStatusCode(200);
                //->setStatusCode(404);
        }
        else
        {
            $owner->delete();
            return response()
                ->json(['status'=>204])
                ->setStatusCode(200);
                //->setStatusCode(204);
        }
    }
}
