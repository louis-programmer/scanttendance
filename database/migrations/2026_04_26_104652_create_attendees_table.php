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
    Schema::create('attendees', function (Blueprint $table) {
        $table->id(); // primary key

        $table->string('first_name');
        $table->string('last_name');

        // Organization-issued ID (human reference number)
        $table->string('organization_number', 20)->unique();

        // Scanning identifier (barcode / RFID / NFC / QR future-proof)
        $table->string('attendance_code', 50)->unique();

        // Shift assignment (can be: morning, afternoon, night, etc.)
        $table->string('shift')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendees');
    }
};
