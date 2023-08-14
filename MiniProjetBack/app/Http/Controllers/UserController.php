<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $numero=$request->numero;
         $userExist=User::where('numero',$numero)->first();
        if (!$userExist) {
            $user=User::Create([
              "nomComplet" => $request->nomComplet,
              "numero" => $request->numero,
           ]);
           return response()->json(["message" => "Client créé avec succés", "data" =>  $user]);
        }
        return response()->json(["message" => "Client existe déjà"]);

    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
