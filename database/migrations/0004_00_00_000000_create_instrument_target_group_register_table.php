<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstrumentTargetGroupRegisterTable extends Migration
{
    public function up(): void
    {
        Schema::create('instrument_target_group_register', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignId('target_group_register_id')->constrained()->index('tg_register_id_foreign')->cascadeOnDelete();
            $table->foreignId('instrument_id')->constrained()->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('instrument_target_group_register');
    }
}
