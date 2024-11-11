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
        Schema::table('faqs', function (Blueprint $table) {
            $table->string('question_en')->nullable();
            $table->text('answer_en')->nullable();
        });
        Schema::table('terms', function (Blueprint $table) {
            $table->string('type_en')->nullable();
            $table->text('description_en')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('faqs', function (Blueprint $table) {
            $table->dropColumn('question_en');
            $table->dropColumn('answer_en');
        });
        Schema::table('terms', function (Blueprint $table) {
            $table->dropColumn('type_en');
            $table->dropColumn('description_en');
        });
    }
};
