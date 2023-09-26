<?php

use App\Models\Publication;
use App\Models\Subscription;
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
        Schema::create('publication_subscription', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Publication::class)
                ->constrained()
                ->cascadeOnDelete()
                ->restrictOnUpdate();
            $table->foreignIdFor(Subscription::class)
                ->constrained()
                ->cascadeOnDelete()
                ->restrictOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('publication_subscription');
    }
};
