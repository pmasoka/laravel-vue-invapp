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
        Schema::connection('pgsql')->table('products', function (Blueprint $table) {
            // only add if it doesn’t exist already
            if (!Schema::connection('pgsql')->hasColumn('products', 'supplier_id')) {
                $table->foreignId('supplier_id')
                      ->constrained('suppliers')   // links to suppliers.id
                      ->cascadeOnUpdate()
                      ->restrictOnDelete();         // or ->cascadeOnDelete() if you prefer
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('pgsql')->table('products', function (Blueprint $table) {
            if (Schema::connection('pgsql')->hasColumn('products', 'supplier_id')) {
                $table->dropConstrainedForeignId('supplier_id');
            }
        });
    }
};
