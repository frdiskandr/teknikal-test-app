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
        Schema::create('ebooks', function (Blueprint $table) {
            // data ebook
            $table->id();
            $table->string("title",255);
            $table->string("author", 255)->nullable();
            $table->text("description")->nullable();
            $table->decimal("price", 512)->default(0);

            //file
            $table->string("filepath", 512)->comment('path file pdf di dalam storage');
            $table->foreignId("user_id")->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ebooks');
    }
};
