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
        // Gunakan Raw SQL untuk keamanan karena doctrine/dbal mungkin tidak terinstal
        DB::statement('ALTER TABLE ai_chat_history MODIFY question LONGTEXT');
        DB::statement('ALTER TABLE ai_chat_history MODIFY answer LONGTEXT');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('ALTER TABLE ai_chat_history MODIFY question TEXT');
        DB::statement('ALTER TABLE ai_chat_history MODIFY answer TEXT');
    }
};
