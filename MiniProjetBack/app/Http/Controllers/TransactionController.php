<?php

namespace App\Http\Controllers;

use App\Http\Resources\TransacUserResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\Compte;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return Transaction::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 
    }


    public function depotArgent(Request $request)
    {
        $expedi = $request->idExpediteur;
        $montant = $request->input('montant');

        // $etat=$request->etat;
        // dd($etat);
        // on recherche le client par rapport au numero dans table users
        // si le numero existe 
        // if ($expedi) {
        // on recherche le client par rapport à l'id dans table comptes

        $compte = Compte::where("user_id", $expedi)->first();
        if (!$compte) {
            return ["message" => "existe pas"];
        }
        if ($montant >= 500) {
            $soldeActuel = $compte->Solde;
            $nouveauSolde = $soldeActuel += $montant;
            $compte->Solde = $nouveauSolde;
            $compte->save();
            Transaction::firstOrCreate([
                "montant" => $request->montant,
                "Type" => $request->Type,
                // "fournisseur" => $request->fournisseur,
                "idDestinataire" => $request->idDestinataire,
                "idExpediteur" => $request->idExpediteur,
                "DateHeure" => now()
            ]);
            return ["message" => "Depot reussi avec succés"];
        } else {
            return ["message" => " Montant inférieur à 500fcf"];
        }


    }
    public function retraitArgent(Request $request)
    {
        $expedi = $request->idExpediteur;
        // $num = $request->input(numero');
        $montant = $request->input('montant');

        // $client = User::where("numero", $num)->first();
        if ($expedi) {
            $compte = Compte::where("user_id", $expedi)->first();
            if ($montant < 500 || $montant > $compte->Solde) {
                return ["message" => "VOTRE SOLDE EST INSUFFISANT"];
            } else {
                $soldeActuel = $compte->Solde;
                $nouveauSolde = $soldeActuel -= $montant;
                $compte->Solde = $nouveauSolde;
                $compte->save();
                Transaction::firstOrCreate([
                    "montant" => $request->montant,
                    "Type" => $request->Type,
                    // "fournisseur" => $request->fournisseur,
                    "idDestinataire" => $request->idDestinataire,
                    "idExpediteur" => $request->idExpediteur,
                    "DateHeure" => now()
                ]);
                return ["message" => "Retrait reussi avec succés"];
            }
        } else {
            return ["message" => "existe pas"];
        }
    }
    public function transfertArgent(Request $request)
    {
        $expedi = $request->idExpediteur;
        $desti = $request->idDestinataire;
        $montant = $request->montant;

        if ($expedi && $desti) {
            $expediCompte = Compte::where('num_compte', $expedi)->first();
            // return $expediCompte;
            $destiCompte = Compte::where('num_compte', $desti)->first();
            
            if ($expediCompte-> close == 0) {
                return response()->json([
                    "message"=>"Votre Compte n\'existe plus",
                ]);
            }
            if ($expediCompte-> blocked == 2) {
                return response()->json([
                    "message"=>"Compte bloqué, ne peu pas faire de transfert",
                ]);
            }
            if ($destiCompte-> close == 0) {
                return response()->json([
                    "message"=>"Ce Compte ne peu pas recevoir d'argent",
                ]);
            }
            
            if ($expediCompte->Solde >= $montant && $montant >= 500) {
                $expediCompte->Solde -= $montant;
                $destiCompte->Solde += $montant;
                $expediCompte->save();
                $destiCompte->save();
                $trans = Transaction::Create([
                    "montant" => $request->montant,
                    "Type" => $request->Type,
                    // "fournisseur" => $request->fournisseur,
                    "idDestinataire" => $request->idDestinataire,
                    "idExpediteur" => $request->idExpediteur,
                    "DateHeure" => now()
                ]);
                return response()->json(["message" => "Transfert réussi", "data" => $trans]);
            } else {
                return ["message" => "Impossible de faire un transfert"];
            }
        } else {
            return ["message" => "Expediteur n'existe pas"];
        }
    }

    /**
     * Display the specified resource.
     */

    public function getClient($num)
    {
        return User::where('numero', $num)->first();
    }

    public function transViaCode(Request $request)
    { {

            $validate = $request->validate([
                "montant" => "required|numeric|min:500",
                "fournisseur" => "required|in:Wari,OrangeMOney"
            ]);
            $montant = $request->input('montant');
            $desti = $request->idDestinataire;

            $codeDestinataire = md5($desti . $montant . time());

            $trans = Transaction::firstOrCreate([
                "montant" => $request->montant,
                "Type" => $request->Type,
                "fournisseur" => $request->fournisseur,
                "idDestinataire" => $desti,
                "idExpediteur" => $request->idExpediteur,
                "Code" => $codeDestinataire,
                "DateHeure" => now()
            ]);
            return ["message" => "Dépôt réussi avec succès", "data" => $trans];
        }
    }

    public function retraitCode(Request $request)
    {
        $validate = $request->validate([
            "montant" => "required",
            "idExpediteur" => "required",
            "Code" => "required",
            "Type" => "required"
        ]);
        $verifRetrait = Transaction::where('Code', $request->Code)
            ->where('montant', $request->montant)
            ->where('idDestinataire', $request->idExpediteur)->first();
        // return $verifRetrait;

        if (!$verifRetrait) {
            return response()->json(["message" => "Retrait Impossible"]);
        }
        return response()->json(["message" => "Retrait réussi avec succès", "data" => $verifRetrait]);

    }



    public function getTransac($tel)
    {
            $userTrans=User::where('numero',$tel)->with(['transacEx'])->first();
       return new TransacUserResource($userTrans);

    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}