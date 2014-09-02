<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVisitaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('visita', function(Blueprint $table) {
			$table->increments('id');
			$table->string('condicion');
			$table->date('fecha');
			$table->text('obsercacion');
			$table->string('tipo');
			$table->time('hora');
			$table->string('tema');
			$table->string('publicacion');
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
		Schema::drop('visita');
	}

}
