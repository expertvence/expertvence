<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ready_software_demos', function (Blueprint $table) {
            $table->string('admin_demo_url', 2048)->nullable();
            $table->string('admin_demo_email')->nullable();
            $table->string('admin_demo_password')->nullable();
            $table->string('user_demo_url', 2048)->nullable();
            $table->string('user_demo_email')->nullable();
            $table->string('user_demo_password')->nullable();
            $table->string('website_url', 2048)->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('ready_software_demos', function (Blueprint $table) {
            $table->dropColumn([
                'admin_demo_url', 'admin_demo_email', 'admin_demo_password',
                'user_demo_url', 'user_demo_email', 'user_demo_password', 'website_url',
            ]);
        });
    }
};
