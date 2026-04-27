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
    Schema::create('attendance_logs', function (Blueprint $table) {
        $table->id();

        $table->string('organization_number', 20);
        $table->string('attendance_code', 50);

        $table->string('shift')->nullable();
        $table->string('gate')->nullable();

        $table->date('date');
        $table->time('time');

        $table->enum('log', ['in', 'out']);

        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_logs');
    }
};
