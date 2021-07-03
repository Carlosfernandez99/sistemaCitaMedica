<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Validator;
use App\Http\Traits\ValidateAndCreatePaciente;
use Auth;
use JWTAuth;

class AuthController extends Controller
{
    use ValidateAndCreatePaciente;
    public function login(Request $request){
        $credentials = $request->only('email', 'password');
        $jwt = null;
        if ($jwt = JWTAuth::attempt($credentials)) {
            $user = auth()->user();
            $success = true;
            return compact('success', 'user', 'jwt');
        }
        else{
            $success = false;
			$message = 'Credenciales Incorrectas';
			return compact('success', 'message');
        }
    }

    public function logout(){
        auth()->logout();
    	$success = true;
    	return compact('success');
    }

    public function register(Request $request){
    	$this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));
        $jwt = auth()->login($user);
	    $success = true;
	    
	    return compact('success', 'user', 'jwt');
    }
}
