<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NewFormatCreateAvailableNeighbourhoodInstrumentTable extends Migration
{
    public function up(): void
    {
        Schema::create('available_neighbourhood_instrument', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('neighbourhood_id')->constrained()->cascadeOnDelete();
            $table->foreignId('instrument_id')->constrained()->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('available_neighbourhood_instrument');
    }
}
