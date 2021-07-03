<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function edit(){
        $user = User::findOrFail(\Auth::user()->id);
        return view('perfil.miperfil', compact('user'));
    }

    public function modificarLogin(Request $request){
        $user = User::findOrFail($request->id);
        $user->login = $request->login; 
        $user->email = $request->email;
        $user->save();

        $notificacion = 'Actualizado correctamente.';
        return redirect('/user/perfil')->with(compact('notificacion'));
    }

    public function modificarPassword(Request $request){
        $notification='';

        $user = User::findOrFail($request->id);
        $password = $request->password;
        if ($password){
            $user->password = bcrypt($password);
        }        
        $user->save();

        $notification = 'Actualizado correctamente.';
        return redirect('/user/perfil')->with(compact('notification'));
    }
}
