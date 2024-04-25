<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('offres', function (Blueprint $table) {
            $table->id();
            $table->string('reference');
            $table->string('date_depart');
            $table->string('date_arrivee')->nullable();
            $table->string('heure_depart');
            $table->string('heure_arrivee')->nullable();
            $table->integer('place_disponible');
            $table->foreignId('trajet_id')->constrained('trajets')->onDelete('cascade');
            $table->foreignId('vehicule_id')->constrained('vehicules')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offres');
    }
};
