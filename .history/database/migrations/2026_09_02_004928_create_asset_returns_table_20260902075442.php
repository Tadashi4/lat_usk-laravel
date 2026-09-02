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
        Schema::create('asset_returns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->constrained()->cascadeOnDeleteonDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDeleteonDelete();
            $table->foreignId('asset_id')->constrained()->cascadeOnDeleteonDelete();
            $table->integer('qty')->default(1);
            $table->enum('condition', ['good', 'damaged', 'lost'])->default('good');
            $table->timestamps('returned_at');
$table->
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_returns');
    }
};
