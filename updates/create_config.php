<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfigTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('admin.database.config_table'), function (Blueprint $table) {
            $table->id();
            $table->string("tab");
            $table->string("key");
            $table->string("name")->nullable();
            $table->string("value")->nullable();
            $table->text("help")->nullable();
            $table->string("element")->nullable();
            $table->tinyInteger("order",0);
            $table->text("rule")->nullable();
            $table->json("options")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('config');
    }
}
