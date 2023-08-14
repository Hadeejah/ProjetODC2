<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\TransactionResource;
use Illuminate\Http\Resources\Json\JsonResource;

class TransacUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=>$this->id,
            "nomComplet"=>$this->nomComplet,
            "numero"=>$this->numero,
            "transac_ex"=> TransactionResource::collection($this->transacEx),
            // "transac_des"=>TransactionResource::collection($this->transacDes)
        ];
    }
}
