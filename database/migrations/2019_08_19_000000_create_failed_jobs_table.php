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
        if (!Schema::hasTable('failed_jobs')) {
            Schema::create('failed_jobs', function (Blueprint $table) {
                $table->id(); // Creates an auto-incrementing ID
                $table->string('uuid')->unique(); // Unique UUID for the failed job
                $table->text('connection'); // The connection used to process the job
                $table->text('queue'); // The name of the queue the job was in
                $table->longText('payload'); // The job's payload
                $table->longText('exception'); // The exception message if the job failed
                $table->timestamp('failed_at')->useCurrent(); // Timestamp when the job failed
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('failed_jobs');
    }
};
