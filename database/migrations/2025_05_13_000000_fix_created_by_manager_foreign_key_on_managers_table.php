<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class FixCreatedByManagerForeignKeyOnManagersTable extends Migration
{
    public function up(): void
    {
        Schema::table('managers', function (Blueprint $table) {
            // Verwijder de foute foreign key
            $table->dropForeign(['created_by_manager_id']);
        });

        DB::table('managers')->update(['created_by_manager_id' => null]);

        Schema::table('managers', function (Blueprint $table) {
            // Voeg de juiste foreign key toe die verwijst naar de managers-tabel
            $table->foreign('created_by_manager_id')
                ->references('id')
                ->on('managers')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('managers', function (Blueprint $table) {
            $table->dropForeign(['created_by_manager_id']);
        });

        DB::table('managers')->update(['created_by_manager_id' => null]);

        Schema::table('managers', function (Blueprint $table) {
            // Herstel verwijzing naar de users-tabel zoals in de originele migratie
            $table->foreign('created_by_manager_id')
                ->references('id')
                ->on('users')
                ->nullOnDelete();
        });
    }
}

