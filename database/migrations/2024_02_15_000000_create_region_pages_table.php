<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegionPagesTable extends Migration
{
    public function up(): void
    {
        Schema::create('region_pages', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();

            $table->longText('description')->nullable();
            $table->longText('cooperation_partners')->nullable();
            $table->longText('additional_information')->nullable();
            $table->longText('terminology')->nullable();

            $table->foreignId('region_id')->constrained()->cascadeOnDelete();
            $table->foreignId('regional_party_id')->nullable()->constrained()->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('region_pages');
    }
}
