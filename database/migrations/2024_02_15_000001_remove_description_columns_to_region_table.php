<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveDescriptionColumnsToRegionTable extends Migration
{
    public function up(): void
    {
        Schema::table('regions', function (Blueprint $table) {
            $table->dropColumn('description');
            $table->dropColumn('cooperation_partners');
            $table->dropColumn('additional_information');
            $table->dropColumn('terminology');
        });
    }

    public function down(): void
    {
        Schema::table('regions', function (Blueprint $table) {
            $table->longText('description')->nullable();
            $table->longText('cooperation_partners')->nullable();
            $table->longText('additional_information')->nullable();
            $table->longText('terminology')->nullable();
        });
    }
}
