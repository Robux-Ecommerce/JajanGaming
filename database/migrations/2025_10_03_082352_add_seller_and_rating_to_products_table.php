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
            $table->string('seller_name')->after('game_type');
            $table->string('seller_photo')->nullable()->after('seller_name');
            $table->decimal('rating', 3, 2)->default(0.00)->after('seller_photo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['seller_name', 'seller_photo', 'rating']);
        });
    }
};
