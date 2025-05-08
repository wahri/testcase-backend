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
        Schema::create('items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('code')->unique();
            $table->string('label');
            $table->uuid('company_id');
            $table->foreign('company_id')->references('id')->on('companies')->cascadeOnDelete();
            $table->uuid('item_group_id');
            $table->foreign('item_group_id')->references('id')->on('item_groups')->cascadeOnDelete();
            $table->uuid('item_type_id');
            $table->foreign('item_type_id')->references('id')->on('item_types')->cascadeOnDelete();
            $table->uuid('item_account_group_id');
            $table->foreign('item_account_group_id')->references('id')->on('item_account_groups')->cascadeOnDelete();
            $table->uuid('item_unit_id');
            $table->foreign('item_unit_id')->references('id')->on('item_units')->cascadeOnDelete();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
