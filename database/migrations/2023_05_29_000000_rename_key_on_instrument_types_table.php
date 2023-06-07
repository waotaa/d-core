<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameKeyOnInstrumentTypesTable extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('instrument_types', 'key')) {
            Schema::table('instrument_types', function (Blueprint $table) {
                $table->renameColumn('key', 'code');
            });
        }
    }

    public function down(): void
    {
        // don't rename to key
    }
}
