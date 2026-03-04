<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('users', function (Blueprint $table) {
        // 1. Renommer 'name' en 'prenom'
        $table->renameColumn('name', 'prenom');
        
        // 2. Ajouter 'nom' après 'prenom'
        $table->string('nom')->after('prenom');
        
        // 3. Ajouter 'telephone' après 'nom'
        $table->string('telephone')->after('nom')->nullable();
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->renameColumn('prenom', 'name');
        $table->dropColumn(['nom', 'telephone']);
    });
}
};
