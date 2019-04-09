<?php

namespace App\Http\Controllers\API;

use App\Reservation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class ReservationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $res = Reservation::all();
        return response()->json($res)->setStatusCode(Response::HTTP_OK); //HTTP_OK=200;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)

    {


        $this->validate($request, [
            'places_id'=>'required',
            'status' => 'required',
            'client_id' => 'required',

        ]);

        $res = new Reservation;
        $res->places_id=$request->places_id;
        $res->client_id =$request->client_id;
        $res->status=$request->status;
        $res->save();

        return response()->json($res)->setStatusCode(Response::HTTP_CREATED);
        //$token = $this->authorizeUser($user);
        //return response()->json($token);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
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
