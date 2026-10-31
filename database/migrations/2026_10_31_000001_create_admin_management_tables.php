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
        // 1. Projects Table
        if (!Schema::hasTable('projects')) {
            Schema::create('projects', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('name');
                $table->string('client_name');
                $table->text('client_address')->nullable();
                $table->string('client_phone')->nullable();
                $table->string('project_url')->nullable();
                $table->decimal('budget', 12, 2)->default(0);
                $table->string('status')->default('active'); // active, completed, on_hold
                $table->timestamps();
            });
        }

        // 2. Project Transactions Table (Income & Expense)
        if (!Schema::hasTable('project_transactions')) {
            Schema::create('project_transactions', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->uuid('project_id')->nullable()->index();
                $table->enum('type', ['income', 'expense']);
                $table->decimal('amount', 12, 2);
                $table->date('transaction_date');
                $table->text('description')->nullable();
                $table->timestamps();
            });
        }

        // 3. Share Members Table (Partners / Share owners)
        if (!Schema::hasTable('share_members')) {
            Schema::create('share_members', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('name');
                $table->string('designation');
                $table->string('image')->nullable();
                $table->string('phone')->nullable();
                $table->string('email')->nullable();
                $table->timestamps();
            });
        }

        // 4. Profit Distributions Table
        if (!Schema::hasTable('profit_distributions')) {
            Schema::create('profit_distributions', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->uuid('member_id')->index();
                $table->decimal('amount', 12, 2);
                $table->date('distribution_date');
                $table->text('comment')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profit_distributions');
        Schema::dropIfExists('share_members');
        Schema::dropIfExists('project_transactions');
        Schema::dropIfExists('projects');
    }
};
