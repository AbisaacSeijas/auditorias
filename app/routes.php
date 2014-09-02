<?php

Route::group(array('before' => 'guest'), function()
{
	// Nos mostrará el formulario de login.
	Route::get('/', 'AuthController@showLogin');

	// Validamos los datos de inicio de sesión.
	Route::post('login', 'AuthController@postLogin');
});

// Nos indica que las rutas que están dentro de él sólo serán mostradas si antes el usuario se ha autenticado.
Route::group(array('before' => 'auth'), function()
{
    

});