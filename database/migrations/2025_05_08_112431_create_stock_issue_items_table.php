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
        Schema::create('stock_issue_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('item_id');
            $table->foreign('item_id')->references('id')->on('items')->cascadeOnDelete();
            $table->string('item_name');
            $table->integer('quantity');
            $table->uuid('item_unit_id');
            $table->foreign('item_unit_id')->references('id')->on('item_units')->cascadeOnDelete();
            $table->string('item_unit_name');
            $table->uuid('stock_issue_id');
            $table->foreign('stock_issue_id')->references('id')->on('stock_issues')->cascadeOnDelete();
            $table->text('note');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_issue_items');
    }
};
