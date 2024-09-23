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
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('author');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            // $table->string('link_url')->nullable();
            $table->string('image');
            $table->longText('description');
            $table->longText('group_id')->nullable();
            $table->longText('polis_id')->nullable();
            $table->longText('member_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};
