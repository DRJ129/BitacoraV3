<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rutina_completions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rutina_id')->constrained('rutinas')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->date('date')->index();
            $table->timestamps();
            $table->unique(['rutina_id','date','user_id'], 'rutina_date_user_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rutina_completions');
    }
};
