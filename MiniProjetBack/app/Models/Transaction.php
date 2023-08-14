<?php

namespace App\Models;

use App\Models\Compte;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;
    protected $guarded = [
        'id'
    ];
    public function compte() :BelongsTo {
        return $this->belongsTo(Compte::class);
    }
    public function user() :BelongsTo {
        return $this->belongsTo(User::class, "idDestinataire");
    }
  
}
