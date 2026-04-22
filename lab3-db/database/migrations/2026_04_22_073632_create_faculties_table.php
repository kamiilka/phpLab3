<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    public function up(): void
    {
    Schema::create('faculties', function (Blueprint $table) {
        $table->id(); // Створює id (Primary Key)
        $table->string('name'); // Назва факультету
        $table->timestamps(); // Створює колонки created_at та updated_at
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faculties');
    }
};
