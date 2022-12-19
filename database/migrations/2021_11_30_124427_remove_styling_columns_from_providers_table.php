<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveStylingColumnsFromProvidersTable extends Migration
{
    public function up(): void
    {
        Schema::table('providers', function (Blueprint $table) {
            $table->dropColumn('logo_header')->nullable();
            $table->dropColumn('logo_body')->nullable();
            $table->dropColumn('logo_color')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('providers', function (Blueprint $table) {
            $table->string('logo_header')->nullable();
            $table->string('logo_body')->nullable();
            $table->string('logo_color')->nullable();
        });
    }
}
