<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstrumentProviderTable extends Migration
{
    public function up(): void
    {
        Schema::create('instrument_provider', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignId('provider_id')->constrained()->cascadeOnDelete();
            $table->foreignId('instrument_id')->constrained()->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('instrument_provider');
    }
}
