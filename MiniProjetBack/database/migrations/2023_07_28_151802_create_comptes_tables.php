<?php

use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('comptes', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->cascadeOndelete();
            $table->enum('Fournisseur',['Wave','OrangeMoney','Wari','CompteBanquaire']);
            $table->float('Solde');
            $table->string('num_compte');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comptes_tables');
    }
};
