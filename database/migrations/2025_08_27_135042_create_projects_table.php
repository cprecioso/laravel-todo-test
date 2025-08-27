<?php

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('task_projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignIdFor(User::class, 'owner_id')->constrained();
            $table->timestamps();
        });

        Schema::table('tasks', function (Blueprint $table) {
            $table->dropConstrainedForeignIdFor(User::class);
            $table->foreignIdFor(Project::class)->constrained()->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_projects');
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropConstrainedForeignIdFor(Project::class);
            $table->foreignIdFor(User::class, 'user_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
        });
    }
};
