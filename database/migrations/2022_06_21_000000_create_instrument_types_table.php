<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstrumentTypesTable extends Migration
{
    public function up(): void
    {
        Schema::create('instrument_types', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
//            Altered since key is a reserved word
//            $table->string('key')->unique();
            $table->string('code')->unique();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('instrument_types');
    }
}
