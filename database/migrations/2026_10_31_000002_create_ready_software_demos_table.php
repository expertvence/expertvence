<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ready_software_demos', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('icon', 30)->default('💻');
            $table->string('tag', 120);
            $table->string('title', 180);
            $table->text('description');
            $table->json('features');
            $table->string('demo_url', 2048)->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
        });

        $now = now();
        $demos = [
            ['Somiti Management', 'Somiti Software', 'Complete digital system for somiti, cooperatives, and associations.', ['Member registration & profile', 'Monthly deposit & loan management', 'Installment and fund ledger', 'Reports and SMS notice']],
            ['School Management', 'School Management System', 'Run admission, classes, and results from one dashboard for schools and coaching centers.', ['Student & teacher management', 'Attendance, exam & result', 'Fee collection and due list', 'Parent portal and notice board']],
            ['E-commerce', 'E-commerce Website', 'Launch your online shop with product catalog, payment, and order management.', ['Product, category & stock', 'Cart, checkout & bKash/Nagad payment', 'Order tracking and invoice', 'Powerful admin panel']],
        ];

        foreach ($demos as $index => [$tag, $title, $description, $features]) {
            DB::table('ready_software_demos')->insert([
                'id' => (string) Str::uuid(),
                'icon' => ['🤝', '🎓', '🛒'][$index],
                'tag' => $tag,
                'title' => $title,
                'description' => $description,
                'features' => json_encode($features),
                'demo_url' => null,
                'sort_order' => $index + 1,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('ready_software_demos');
    }
};
