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
        Schema::table('products', function (Blueprint $table) {
            $table->string('brand')->nullable()->after('name');
            $table->string('size_text')->nullable()->after('brand');
            $table->string('color')->nullable()->after('size_text');
            $table->string('condition')->nullable()->after('color');
            $table->string('measurements')->nullable()->after('condition');
            $table->string('status')->default('available')->after('featured'); // 'available', 'sold', 'hidden'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['brand', 'size_text', 'color', 'condition', 'measurements', 'status']);
        });
    }
};
