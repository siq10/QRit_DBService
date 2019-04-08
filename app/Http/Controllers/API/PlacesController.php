<?php

namespace App\Http\Controllers\API;

use App\Place;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use DB;



class PlacesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
       $places = Place::all();


       //return response()->json(['name'=>'stef'],201);
       return response()->json($places)->setStatusCode(Response::HTTP_OK); //HTTP_OK=200;



    }

/*

    public function tables()
    {
        
       $places = Place::all();
       $data = DB::table('places')->where('availableSlots', '=', 30)->get();
        //$data = DB::table('places')->where('name', '=', "{$name}")->get();
        return response()->json($data)->setStatusCode(Response::HTTP_OK); 

    }

*/


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

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
            'owners_id'=>'required',
            'type'=> 'required',
            'name' => 'required',
            'address' => 'required',
            'city' => 'required',
            'country' => 'required',
            'totalSlots' => 'required',          
            'availableSlots' => 'required',     
            'status' => 'required',
            'zipcode' => 'required',
            'availableTables' => 'required',

        ]);

        $place = new Place;
        $place->owners_id=$request->owners_id;
        $place->type=$request->type;
        $place->name=$request->name;
        $place->address=$request->address;
        $place->city=$request->city;
        $place->country=$request->country;
        $place->totalSlots =$request->totalSlots;
        $place->availableSlots=$request->availableSlots;
        $place->status=$request->status;
        $place->zipcode=$request->zipcode;
        $place->availableTables=$request->availableTables;
        $place->save();

        return response()->json($place)->setStatusCode(Response::HTTP_CREATED); 

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) // $name
    {
       
       /*
        if ($request->user()->hasRole('client-NOTauth')) {
           // do smth ONLY FOR registered CLIENTS
        }

        if ($request->user()->hasRole('client-auth')) {
            // do smth for unregistered clients
        }
    */
        $places= Place::find($id);
        $data = DB::table('places')->where('id', '=', "{$id}")->get();
        //$data = DB::table('places')->where('name', '=', "{$name}")->get();
        return response()->json($data)->setStatusCode(Response::HTTP_OK); 
    
        //return view('electronice.show')->with('product',$product)->with('notif',$notify);


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        
        $request->validate([
        'availableSlots'=>'required',
        //'availableTables'=> 'required',
      ]);

      $place = Place::find($id);
      //$place->availableTables = $request->get('availableTables');
      //$place->availableSlots = $request->get('availableSlots');
      $place->availableSlots = $request->get('availableSlots');
      $place->save();

       return response()->json($place)->setStatusCode(Response::HTTP_OK);  //200

    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
