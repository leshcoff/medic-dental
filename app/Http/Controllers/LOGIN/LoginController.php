<?php

namespace App\Http\Controllers\LOGIN;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


use App\Models\USUARIO\EMToken;
use App\Models\USUARIO\EMUsuario;

use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller
{

    /**
     * Index of login
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(){

        // Verificamos si hay sesión activa
        if (Auth::check())
        {
            // Si tenemos sesión activa mostrará la página de inicio
            return Redirect::to('/')->with('user', Auth::user());
        }
        // Si no hay sesión activa mostramos el formulario
        return \View::make('LOGIN.login');

    }


    /**
     * Recibe los datos escritos en el login y los procesa
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function signin(Request $request){


        // Obtenemos los datos del formulario
        $remember = ($request->has('rememberme')) ? true : false;
        $data = array(
            'email'         => $request->get('email'),
            'password'      => \Request::get('password')
        );


        // Verificamos los datos
        if (Auth::attempt($data, $remember)) // Como segundo parámetro pasámos el checkbox para sabes si queremos recordar la contraseña
        {
            $user       = Auth::user();

            $user->last_login = new \DateTime();
            $user->save();

            // Si nuestros datos son correctos mostramos la página de inicio
            return Redirect::intended('/')->with('user', $user);
        }

        // Si los datos no son los correctos volvemos al login y mostramos un error
        return Redirect::back()->with('error_message', 'El usuario y/o la contraseña no son correctos')->withInput();


    }


    /**
     * Logout
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout(){

        Auth::logout();
        return redirect('login')->with('message', 'Logging out');
    }



}
