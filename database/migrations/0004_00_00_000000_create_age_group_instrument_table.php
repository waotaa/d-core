<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgeGroupInstrumentTable extends Migration
{
    public function up(): void
    {
        Schema::create('age_group_instrument', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignId('age_group_id')->constrained()->cascadeOnDelete();
            $table->foreignId('instrument_id')->constrained()->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('age_group_instrument');
    }
}
