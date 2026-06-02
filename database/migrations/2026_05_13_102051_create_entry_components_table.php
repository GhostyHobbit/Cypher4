<?php

use App\Domain\Entries\Enums\ComponentType;
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
        Schema::create('entry_components', function (Blueprint $table) {
            $table->id();
            $table->enum('type', array_column(ComponentType::cases(), 'value'))->default(ComponentType::Text->value);
            $table->text('text')->nullable();
            $table->string('image_src')->nullable();
            $table->foreignId('entry_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entry_components');
    }
};
