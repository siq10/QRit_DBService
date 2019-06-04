<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Validator;
use App\Place;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PlacesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()
            ->json(Place::all())
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
            'owner_id'=>'required',
            'type'=> 'required',
            'name' => 'required',
            'address' => 'required',
            'city' => 'required',
            'country' => 'required',
            'totalSlots' => 'required',
//            'status' => 'required',
            'zipcode' => 'required',
//            'availableTables' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()],422);
        }
        $place = new Place;
//        dd($request->post());
        $place->owner_id = $request->owner_id;
        $place->type = $request->type;
        $place->name = $request->name;
        $place->address = $request->address;
        $place->city = $request->city;
        $place->country = $request->country;
        $place->zipcode = $request->zipcode;
        $place->totalSlots = $request->totalSlots;
        $place->availableSlots = $request->totalSlots;
        $place->rating = $request->rating;
        $place->image = $request->image;
        try {
            $place->save();
            return response()
                ->json()
                ->setStatusCode(201, "Resource created")
                ->withHeaders([
                "Location" => $request->url().'/'.$place->id
                ]);
        } catch (\Illuminate\Database\QueryException $ex) {
//            dd($ex->getMessage());
            \Log::error('Encountered while trying to store a Place!', ['context' => $ex->getMessage()]);
            return response()
                ->json(["message" => "Unknown error occured while processing data!",
                    'reason' => "unknown"])
                ->setStatusCode(422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $place = Place::find($id);
        if(is_null($place))
        {
            return response()
                ->json()
                ->setStatusCode(404);
        }
        else
        {
            return response()
                ->json($place)
                ->setStatusCode(200);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [

        ]);
        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()],422);
        }

        $place = Place::find($id);
        if(is_null($place))
        {
            $place = new Place;
            $place->id = $id;
            $place->owner_id = $request->owner_id;
            $place->type = $request->type;
            $place->name = $request->name;
            $place->address = $request->address;
            $place->city = $request->city;
            $place->country = $request->country;
            $place->zipcode = $request->zipcode;
            $place->totalSlots = $request->totalSlots;
            $place->availableSlots = $request->totalSlots;
            try {
                $place->save();
                return response()
                    ->json()
                    ->setStatusCode(201);
//                 ->withHeaders([
//                "Location" => $request->url()
//                ]);
            }
            catch (\Illuminate\Database\QueryException $ex) {
//            dd($ex->getMessage());
                \Log::error('Encountered while trying to store a Place!', ['context' => $ex->getMessage()]);
                return response()
                    ->json(["message" => "Unknown error occured while processing data!",
                        'reason' => "unknown"])
                    ->setStatusCode(422);
            }
        }
        else
        {
            $place->id = $id;
            $place->owner_id = $request->owner_id;
            $place->type = $request->type;
            $place->name = $request->name;
            $place->address = $request->address;
            $place->city = $request->city;
            $place->country = $request->country;
            $place->zipcode = $request->zipcode;
            $place->totalSlots = $request->totalSlots;
            $place->availableSlots = $request->totalSlots;
            try{
                $place->save();
                return response()
                    ->json()
                    ->setStatusCode(200);
//                ->withHeaders([
//                    "Location" => $request->url()
//                ]);
            } catch (\Illuminate\Database\QueryException $ex) {
//            dd($ex->getMessage());
                \Log::error('Encountered while trying to store a Place!', ['context' => $ex->getMessage()]);
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
     * @param  \App\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $place = Place::find($id);
        if(is_null($place))
        {
            return response()
                ->json()
                ->setStatusCode(404);
        }
        else
        {
            $place->delete();
            return response()
                ->json()
                ->setStatusCode(204);
        }
    }
}
