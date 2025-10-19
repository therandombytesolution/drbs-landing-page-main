<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->string('registration_number')->unique();

            // Personal Information
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('phone');
            $table->string('alternate_phone')->nullable();

            // Location Information
            $table->string('building');
            $table->string('floor');
            $table->string('unit');
            $table->string('tower')->nullable();
            $table->text('full_address');

            // Plan Selection
            $table->string('plan'); // 10mbps, 25mbps, 50mbps
            $table->date('preferred_date');

            // Additional Information
            $table->string('referral_code')->nullable();
            $table->text('notes')->nullable();
            $table->json('documents')->nullable();

            // Terms & Conditions
            $table->boolean('agree_terms')->default(false);
            $table->boolean('agree_marketing')->default(false);

            // Status Tracking
            $table->enum('status', ['pending', 'contacted', 'scheduled', 'installed', 'active', 'cancelled'])->default('pending');
            $table->timestamp('contacted_at')->nullable();
            $table->timestamp('scheduled_at')->nullable();
            $table->timestamp('installed_at')->nullable();
            $table->text('admin_notes')->nullable();

            $table->timestamps();

            // Indexes for better performance
            $table->index('registration_number');
            $table->index('email');
            $table->index('phone');
            $table->index('status');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('registrations');
    }
};
