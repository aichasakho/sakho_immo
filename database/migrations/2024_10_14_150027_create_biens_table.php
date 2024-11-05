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
        Schema::create('biens', function (Blueprint $table) {
            $table->id();
<<<<<<< HEAD
            $table->string('imagePath')->nullable(); // Modifiez pour correspondre à l'utilisation dans le contrôleur
=======
            $table->string('image');
>>>>>>> 7a929f142c0fa72b7766e2ace77cb68096b6e904
            $table->string('titre');
            $table->text('description');
            $table->decimal('prix', 10, 2);
            $table->boolean('disponible')->default(true);
<<<<<<< HEAD
            $table->string('type')->default('appartement'); // Exemple de valeur par défaut
=======
            $table->string('type');
>>>>>>> 7a929f142c0fa72b7766e2ace77cb68096b6e904
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('biens');
    }
};
