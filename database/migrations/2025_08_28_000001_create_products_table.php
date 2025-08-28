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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('quantity', 8, 2);
            $table->decimal('unit_price', 8, 2);
            $table->decimal('total_price', 8, 2);
            $table->text('description')->nullable();

            // Add category_id foreign key
            $table->foreignId('category_id')
                ->constrained('categories')   // links to categories.id
                ->cascadeOnUpdate()
                ->restrictOnDelete();         // Update or restrict deletion behavior

            // Add supplier_id foreign key
            $table->foreignId('supplier_id')
                ->constrained('suppliers')   // links to suppliers.id
                ->cascadeOnUpdate()
                ->restrictOnDelete();        // Update or restrict deletion behavior

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
