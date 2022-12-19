<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveUserGroupsTable extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('user_groups');
    }

    public function down(): void
    {
        Schema::create('user_groups', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();

            $table->string('name');
        });
    }
}
