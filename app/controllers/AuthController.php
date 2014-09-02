<?php

class AuthController extends BaseController 
{

    /**
    * Muestra el formulario para login.
    */
    public function showLogin()
    {
        if (Auth::check())
        {
            return Redirect::to('/');
        }

        return View::make('auth.login');
    }

    /**
     * Valida los datos del usuario.
     */
    public function postLogin()
    {
        
        $userdata = array(
            'username' => Input::get('username'),
            'password'=> Input::get('password')
        );

        #var_dump(Auth::attempt($userdata)); exit;
        
        if(Auth::attempt($userdata))
        {
            return Redirect::to('/');
        }
        
        return Redirect::to('login')
                    ->with('mensaje_error', 'Tus datos son incorrectos')
                    ->withInput();
    }

    /**
     * Muestra el formulario de login mostrando un mensaje de que cerró sesión.
     */
    public function logOut()
    {
        Auth::logout();
        return Redirect::to('login')->with('mensaje_error', 'Tu sesión ha sido cerrada.');
    }

}