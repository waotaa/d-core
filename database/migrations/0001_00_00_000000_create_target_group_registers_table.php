<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTargetGroupRegistersTable extends Migration
{
    public function up(): void
    {
        Schema::create('target_group_registers', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();

            $table->string('description');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('target_group_registers');
    }
}
