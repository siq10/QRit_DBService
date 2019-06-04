<?php

namespace App\Http\Controllers\API;

use App\Table;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;


class TablesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tables = Table::all();
        foreach ($tables as $table)
         {  $table->qr= base64_encode(file_get_contents(storage_path('/Qr/'.$table->qr.'.png')));
           // return response()->json(["payload"=>$table,"status"=>200]);
        }
    
        return response()->json(["payload"=>$tables,'status'=>200]);
        
        //->setStatusCode(Response::HTTP_OK); //HTTP_OK=200;

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $table = new Table;
        $table->places_id=$request->places_id;
        $table->slots=$request->slots;
        $table->idQR=$request->idQR;
        $table->status=$request->status;
        $table->tableNumber=$request->tableNumber;

        $table->save();

        return response()->json([$table,'status'=>201])
        ->setStatusCode(Response::HTTP_OK);
        //->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tables= Table::find($id);
        $data = DB::table('tables')->where('id', '=', "{$id}")->get();
        //$data = DB::table('places')->where('name', '=', "{$name}")->get();
        return response()->json([$data,'status'=>200])
        ->setStatusCode(Response::HTTP_OK);
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
