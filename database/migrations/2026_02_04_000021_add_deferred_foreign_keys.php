<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * This migration adds foreign key constraints that couldn't be added earlier
     * due to table creation order dependencies.
     */
    public function up(): void
    {
        // Add order_id foreign key to enrollments
        Schema::table('enrollments', function (Blueprint $table) {
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('set null');
        });

        // Add best_answer_id foreign key to discussions
        Schema::table('discussions', function (Blueprint $table) {
            $table->foreign('best_answer_id')->references('id')->on('discussion_replies')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('discussions', function (Blueprint $table) {
            $table->dropForeign(['best_answer_id']);
        });

        Schema::table('enrollments', function (Blueprint $table) {
            $table->dropForeign(['order_id']);
        });
    }
};
