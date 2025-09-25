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
        //
        Schema::create("documents", function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('number');
            $table->string('title');
            $table->string('filename');
            $table->string('hash');
            $table->string('qr_code');
            $table->enum('status', ['valid', 'revoked'])->default('valid');
            $table->timestamp('uploaded_at')->useCurrent();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists("documents");
    }
};
