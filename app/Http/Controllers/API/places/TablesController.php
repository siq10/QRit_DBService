<?php

namespace App\Http\Controllers\API\places;

use App\Table;
use App\Place;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use DB;

class TablesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($places_id)
    {
       $tables = Table::all();
       return response()->json($tables)->setStatusCode(Response::HTTP_OK); //HTTP_OK=200;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show( $places_id, $tableNumber)
    {
        $tables= Table::find($tableNumber);
        //$table->place()->associate($place);
        $data = DB::table('tables')->where('tableNumber', '=', "{$tableNumber}")->get();
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
