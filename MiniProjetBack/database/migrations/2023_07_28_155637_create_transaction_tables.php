<?php

use App\Models\Compte;
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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->enum('Type',['Depot','Retrait','Trans_CompteVersComptes','Trans_ViaCode',]);
            $table->foreignIdFor(Compte::class)->constrained();
            $table->foreignId('idDestinataire')->constrained('users');
            $table->foreignId('idExpediteur')->constrained('users');
            $table->dateTime('DateHeure');
            $table->integer('montant');
            $table->integer('Code')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_tables');
    }
};
