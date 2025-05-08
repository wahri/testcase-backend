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
        Schema::create('stock_issues', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('company_id');
            $table->foreign('company_id')->references('id')->on('companies')->cascadeOnDelete();
            $table->string('company_name');
            $table->string('code');
            $table->date('date');
            $table->uuid('account_id');
            $table->foreign('account_id')->references('id')->on('accounts')->cascadeOnDelete();
            $table->string('account_name');
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_issues');
    }
};
