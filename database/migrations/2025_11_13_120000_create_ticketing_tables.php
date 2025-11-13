<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('visit_dates', function (Blueprint $table) {
            $table->id();
            $table->date('visit_date')->unique();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('ticket_types', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50)->unique();
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->unsignedInteger('base_price');
            $table->string('stripe_product_id', 64);
            $table->index('stripe_product_id', 'ticket_types_stripe_product_id_index');
            $table->string('stripe_price_id', 64)->nullable();
            $table->timestamps();
        });

        Schema::create('addon_products', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50)->unique();
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->unsignedInteger('price');
            $table->string('stripe_product_id', 64)->unique();
            $table->string('stripe_price_id', 64)->nullable();
            $table->timestamps();
        });

        Schema::create('ticket_orders', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('visit_date_id')->constrained('visit_dates');
            $table->string('status', 30)->default('pending');
            $table->string('stripe_session_id', 120)->nullable()->unique();
            $table->text('stripe_client_secret')->nullable();
            $table->string('stripe_payment_intent_id', 120)->nullable()->unique();
            $table->unsignedBigInteger('total_amount')->default(0);
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('failed_at')->nullable();
            $table->string('qr_code_path')->nullable();
            $table->string('qr_code_token', 64)->nullable()->unique();
            $table->timestamps();
        });

        Schema::create('ticket_order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_order_id')->constrained('ticket_orders')->cascadeOnDelete();
            $table->enum('item_type', ['ticket', 'addon']);
            $table->unsignedBigInteger('item_id');
            $table->string('name');
            $table->unsignedInteger('quantity');
            $table->unsignedInteger('unit_amount');
            $table->boolean('is_primary')->default(false);
            $table->timestamps();

            $table->index(['item_type', 'item_id']);
        });

        Schema::create('visit_check_ins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_order_id')->constrained('ticket_orders')->cascadeOnDelete();
            $table->string('uploaded_qr_path');
            $table->time('visit_hour');
            $table->timestamp('submitted_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visit_check_ins');
        Schema::dropIfExists('ticket_order_items');
        Schema::dropIfExists('ticket_orders');
        Schema::dropIfExists('addon_products');
        Schema::dropIfExists('ticket_types');
        Schema::dropIfExists('visit_dates');
    }
};
