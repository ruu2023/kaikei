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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->integer('amount');
            $table->string('type'); //income, or expense
            $table->text('memo')->nullable();

            $table->foreignId('category_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('payment_method_id')->nullable()->constrained();
            $table->foreignId('client_id')->nullable()->constrained();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
