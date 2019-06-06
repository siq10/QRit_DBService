<?php

namespace App\Http\Controllers\API;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()
            ->json(['payload'=>User::all(),'status'=>200])
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
            $user = new User;
            $user->email = $request->email;
            $user->firstname = $request->firstname;
            $user->lastname = $request->lastname;
            $user->username = $request->username;
            $user->password = $request->password;
        try{
            $user->save();
            return response()
                ->json([$user->only('id','email','firstname','lastname', 'username'),'status'=>201])
                ->setStatusCode(200);
                //->setStatusCode(201,"Resource created");
         } catch(\Illuminate\Database\QueryException $ex){
            \Log::error('Encountered while trying to store an User!', ['context' => $ex->getMessage()]);
			//dd($ex->getMessage());
            return response()
                ->json(["message" => "Email must be unique!",
                        'reason' => "email",'status'=>422])
                ->setStatusCode(200);
                //->setStatusCode(422);
        }
//        $token = $this->authorizeUser($user);
//        return response()->json($token);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
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
    public function update(Request $request, User $user)
    {
//        return $this->login($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
