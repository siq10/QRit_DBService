<?php

namespace App\Http\Controllers\API;

use App\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ClientsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()
            ->json(Client::all())
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
            return response()->json(['errors'=>$validator->errors()],422);
        }
        $client = new Client;
//        dd($request->post());
        $client->user_id = $request->user_id;
        try{
            $client->save();
            return response()
                ->json()
                ->setStatusCode(201,"Resource created")
                ->withHeaders([
                    "Location" => $request->url().'/'.$client->id
                ]);
        } catch(\Illuminate\Database\QueryException $ex){
            \Log::error('Encountered while trying to store a Client!', ['context' => $ex->getMessage()]);
            return response()
                ->json(["message" => "Provided user is incorrect. Most likely a server processing error while storing client!",
                    'reason' => "user_id"])
                ->setStatusCode(422);
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
        $client = Client::find($id);
        if(is_null($client))
        {
            return response()
                ->json()
                ->setStatusCode(404);
        }
        else
        {
            return response()
                ->json($client)
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
            return response()->json(['errors'=>$validator->errors()],422);
        }
        $client = Client::find($id);
        if(is_null($client))
        {
            $client = new Client;
            $client->id = $id;
            $client->user_id = $request->user_id;
            try {
                $client->save();
                return response()
                    ->json()
                    ->setStatusCode(201);
//                 ->withHeaders([
//                "Location" => $request->url()
//                ]);
            }
            catch (\Illuminate\Database\QueryException $ex) {
//            dd($ex->getMessage());
                \Log::error('Encountered while trying to store a Client!', ['context' => $ex->getMessage()]);
                return response()
                    ->json(["message" => "Unknown error occured while processing data!",
                        'reason' => "unknown"])
                    ->setStatusCode(422);
            }
        }
        else
        {
            $client->id = $id;
            $client->user_id = $request->user_id;
            try{
                $client->save();
                return response()
                    ->json()
                    ->setStatusCode(200);
//                ->withHeaders([
//                    "Location" => $request->url()
//                ]);
             } catch (\Illuminate\Database\QueryException $ex) {
//            dd($ex->getMessage());
                \Log::error('Encountered while trying to store a Client!', ['context' => $ex->getMessage()]);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $client = Client::find($id);
        if(is_null($client))
        {
            return response()
                ->json()
                ->setStatusCode(404);
        }
        else
        {
            $client->delete();
            return response()
                ->json()
                ->setStatusCode(204);
        }
    }
}
