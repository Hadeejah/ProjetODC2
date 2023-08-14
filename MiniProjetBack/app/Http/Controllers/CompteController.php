<?php

namespace App\Http\Controllers;

use App\Http\Resources\CompteReource;
use App\Models\User;
use App\Models\Compte;
use Illuminate\Http\Request;
use App\Http\Resources\TransactionResource;

class CompteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator=[
            "numero=>required",
            "Solde=>required",
            "fournisseur=>required"
        ];
        $numero = $request->numero;
        $solde = $request->Solde;
        $fournisseur = $request->fournisseur;
        $user = User::where("numero", $numero)->first();
        if (!$user) {
            return ["message" => "Numero existe pas"];
        }
        $num_compte = $fournisseur . "_" . $numero;

        $compte = Compte::where('num_compte', $num_compte)->first();
        if ($compte) {
            return response()->json([
                "message" => "Compte existe déjà",
            ]);
        }
        if ($fournisseur == "WR") {
            return response()->json([
                "message" => "Impossible de créer un compte Wari",
            ]);
        }
        try {
            $userCompte = Compte::create([
                "user_id" => $user->id,
                "Solde" => $solde,
                "fournisseur" => $fournisseur,
                "num_compte" => $num_compte,
            ]);

            return response()->json([
                "message" => "Compte créé avec succés",
                'compte' => $userCompte
            ]);
        } catch (\Throwable $th) {
          return ["message"=>$th->getMessage()];
        }

    }

    public function closeCompte($idCompte)
    {
        $compteCli = Compte::find($idCompte);
        if ($compteCli) {
            $compteCli->etat = 0;
            $compteCli->save();
            return [
                "message" => "Compte supprimé"
            ];
        } else {
            return [
                "message" => "Le compte n'a pas été trouvé"
            ];
        }

    }
    public function blockCompte($idCompte)
    {
        $compteCli = Compte::find($idCompte);
        if ($compteCli) {
            $compteCli->blocked = 2;
            $compteCli->save();
            return [
                "message" => "Le Compte a été bloqué"
            ];
        } else {
            return [
                "message" => "Le Compte n'a pas été trouvé"
            ];
        }

    }

    public function getCompte(Request $request)  {

       $userCompte=Compte::all();
       return CompteReource:: collection($userCompte);

    }


    /**
     * Display the specified resource.
     */
    public function show(Compte $compte)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Compte $compte)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Compte $compte)
    {
        //
    }
}