<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Models\User;

class CheckinController extends Controller
{
    //Usuarios Autenticados
    // public function store(Request $request)
    // {
    //     $user = Auth::user();
    //     $input = $request->validate([
    //         'user_id' => 'required|exists:users,id'
    //     ]);
    //     if ($user->id == $input['user_id']) {
    //         return redirect()->back()->with('error', 'No puedes hacer check-in por ti mismo.');
    //     }
    //     $user_to_checkin = User::findOrFail($input['user_id']);
    //     if ($user_to_checkin->status) {
    //         return redirect()->back()->with('error', 'El usuario ya hizo check-in previamente.');
    //     }
    //     $user_to_checkin->status = true;
    //     $user_to_checkin->save();
    //     return redirect()->back()->with('success', 'Check-in registrado exitosamente.');
    // }
    
    //usuarios sin autenticar
    public function store(Request $request)
    {
        $input = $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);
    
        $user_to_checkin = User::findOrFail($input['user_id']);
    
        // Verificar si el usuario ya ha realizado el check-in
        if ($user_to_checkin->status) {
            return redirect()->back()->with('error', 'Este usuario ya ha realizado el check-in anteriormente.');
        }
    
        // Actualizar el estado del usuario a "registrado"
        $user_to_checkin->status = true;
        $user_to_checkin->save();
    
        // Obtener los datos del usuario actualizado
        $user = User::findOrFail($user_to_checkin->id);
    
        // Mostrar un mensaje de éxito y los datos del usuario
        return view('check', compact('user'))->with('success', 'Check-in registrado exitosamente.');
    }
    
}
