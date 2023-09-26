<?php

use App\Models\Role;
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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignIdFor(Subscription::class)->nullable()->after('id')->constrained();
            $table->foreignIdFor(Role::class)->after('id')->constrained();
        });
    }
};
