<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstrumentSectorTable extends Migration
{
    public function up(): void
    {
        Schema::create('instrument_sector', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignId('sector_id')->constrained()->cascadeOnDelete();
            $table->foreignId('instrument_id')->constrained()->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('instrument_sector');
    }
}
