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
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->unique()->nullable()->after('name');
            $table->string('phone')->unique()->nullable()->after('email');
            $table->enum('status', ['active', 'inactive', 'suspended', 'blocked'])->default('active')->index()->after('password');
            $table->timestamp('phone_verified_at')->nullable()->after('email_verified_at');
            
            // Audit & Security
            $table->timestamp('last_login_at')->nullable()->after('updated_at');
            $table->string('last_login_ip', 45)->nullable()->after('last_login_at');
            
            // Extra
            $table->json('meta')->nullable()->after('last_login_ip');
            $table->softDeletes()->after('meta');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'username', 
                'phone', 
                'status', 
                'phone_verified_at', 
                'last_login_at', 
                'last_login_ip', 
                'meta',
                'deleted_at'
            ]);
        });
    }
};
