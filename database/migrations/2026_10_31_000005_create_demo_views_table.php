<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Recover the table left behind if MySQL created its columns but rejected the UUID user foreign key.
        if (Schema::hasTable('demo_views')) {
            if (Schema::hasColumn('demo_views', 'user_id')) {
                Schema::table('demo_views', function (Blueprint $table) {
                    $table->dropColumn('user_id');
                });
            }

            Schema::table('demo_views', function (Blueprint $table) {
                $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            });

            return;
        }

        Schema::create('demo_views', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('ready_software_demo_id')->nullable()->constrained('ready_software_demos')->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('visitor_ip', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('demo_views');
    }
};