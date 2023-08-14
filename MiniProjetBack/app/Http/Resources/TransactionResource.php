<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "montant"=>$this->montant,
            "DateHeure"=>$this->DateHeure,
            "Type"=>$this->Type,
            // "idExpediteur"=>new UserResource($this->user),
            "idDestinateur"=>new UserResource($this->user),
        ];
    }
}
