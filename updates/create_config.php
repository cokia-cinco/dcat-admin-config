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
            $table->string("name");
            $table->text("value");
            $table->text("help");
            $table->string("element");
            $table->tinyInteger("order");
            $table->text("rule");
            $table->json("options");
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
        Schema::dropIfExists(config('admin.database.config_table'));
    }
}
