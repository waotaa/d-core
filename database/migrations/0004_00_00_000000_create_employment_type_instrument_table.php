<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmploymentTypeInstrumentTable extends Migration
{
    public function up(): void
    {
        Schema::create('employment_type_instrument', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignId('employment_type_id')->constrained()->cascadeOnDelete();
            $table->foreignId('instrument_id')->constrained()->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employment_type_instrument');
    }
}
