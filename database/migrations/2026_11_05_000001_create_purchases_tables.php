<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->string('phone', 16)->index();
            $table->string('receipt_no')->nullable()->unique();
            $table->string('branch')->nullable();
            $table->unsignedInteger('total');
            $table->unsignedInteger('bonus_spent')->default(0);
            $table->unsignedInteger('bonus_earned')->default(0);
            $table->timestamp('purchased_at');
            $table->timestamps();
        });

        Schema::create('purchase_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->unsignedInteger('qty')->default(1);
            $table->unsignedInteger('price');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchase_items');
        Schema::dropIfExists('purchases');
    }
};
