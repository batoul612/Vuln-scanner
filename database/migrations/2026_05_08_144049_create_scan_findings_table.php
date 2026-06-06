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
    Schema::create('scan_findings', function (Blueprint $table) {
        $table->id();
        $table->foreignId('scan_id')->constrained()->onDelete('cascade');
        $table->string('category'); // port, header, ssl, dns
        $table->string('title');
        $table->text('description')->nullable();
        $table->enum('severity', ['critical', 'high', 'medium', 'low', 'info']);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scan_findings');
    }
};
