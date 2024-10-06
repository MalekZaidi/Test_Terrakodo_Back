<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::table('jardins', function (Blueprint $table) {
        $table->string('image')->nullable(); // Colonne pour stocker le chemin de l'image
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
{
    Schema::table('jardins', function (Blueprint $table) {
        $table->dropColumn('image');
    });
}
};
