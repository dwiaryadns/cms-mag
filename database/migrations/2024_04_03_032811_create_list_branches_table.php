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
        Schema::create('list_branches', function (Blueprint $table) {
            $table->id();
            $table->string('category')->nullable();
            $table->text('domicile')->nullable();
            $table->text('address');
            $table->string('lat')->nullable();
            $table->string('long')->nullable();
            $table->string('telp');
            $table->string('fax')->nullable();
            $table->string('email');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('list_branches');
    }
};