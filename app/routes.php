<?php

Route::get('1', function(){

	$taxpayer = Taxpayer::with('taxes')->find(13218);

	$tax = Tax::with(['taxpayer', 'taxClassifier'])->find(108753);

	d($tax->toArray(), $tax->taxpayer->rif);

});

Route::group(array('before' => 'guest'), function()
{
	// Nos mostrará el formulario de login.
	Route::get('/', 'AuthController@showLogin');
	// Nos mostrará la vista de la orden
    Route::get('/auditorias/orden', 'AuditoriasController@orden');
    // Guardará la orden
    Route::post('/auditorias/orden', 'AuditoriasController@save_orden');
    // Nos mostrará la vista de las actas
 	Route::get('/auditorias/acta', 'AuditoriasController@acta');
	// Validamos los datos de inicio de sesión.
	Route::post('login', 'AuthController@postLogin');
	Route::get('/auditorias/ajax_tax', 'AuditoriasController@ajax_tax');
});

// Nos indica que las rutas que están dentro de él sólo serán mostradas si antes el usuario se ha autenticado.
Route::group(array('before' => 'auth'), function()
{
    

});