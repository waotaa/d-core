<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstrumentsTable extends Migration
{
    public function up(): void
    {
        Schema::create('instruments', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();

//            UUID && DID were once used. Might come back in some form
//            Used to generate uuid's: (string) Uuid::generate(4);
            $table->char('uuid', 36);
            $table->string('did')->unique()->nullable();

            $table->string('name');
            $table->boolean('is_active')->default(true);
            $table->boolean('is_nationally_available')->default(false);

            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->longText('applications')->nullable();
            $table->longText('conditions')->nullable();

            // info section
//            $table->string('duration')->nullable();
//            $table->enum('duration_unit', DurationUnitEnum::keys())->nullable();
//            $table->decimal('costs')->nullable();
//            $table->enum('costs_unit', CostsUnitEnum::keys())->nullable();
//            $table->enum('location', LocationEnum::keys())->nullable();
//            $table->string('location_description')->nullable();

            $table->string('import_mark')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('instruments');
    }
}
