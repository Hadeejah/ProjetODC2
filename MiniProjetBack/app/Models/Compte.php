<?php

namespace App\Models;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Compte extends Model
{
    use HasFactory;
    protected $guarded=[
        'id'
    ];
//   public function transactions() :HasMany {
//     return $this->hasMany(Transaction::class);
//   }
}
