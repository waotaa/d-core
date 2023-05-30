<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCodeToEmploymentTypesTable extends Migration
{
    public function up(): void
    {
        Schema::table('employment_types', function (Blueprint $table) {
            $table->string('code')->nullable();
//            $table->string('code')->unique();
        });
    }

    public function down(): void
    {
        Schema::table('employment_types', function (Blueprint $table) {
            $table->dropColumn('code');
        });
    }
}
