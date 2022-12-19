<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocalPartiesTable extends Migration
{
    public function up(): void
    {
        Schema::create('local_parties', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();

            $table->foreignId('organisation_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('township_id')->constrained()->cascadeOnDelete();

            $table->string('name');
            $table->string('slug')->unique();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('local_parties');
    }
}
