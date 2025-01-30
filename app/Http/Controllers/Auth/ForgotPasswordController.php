<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{

       // Muestra el formulario para solicitar el restablecimiento de contraseña
       public function showLinkRequestForm()
       {
           return view('auth.forgot-password');
       }

       // Procesa la solicitud de restablecimiento de contraseña
       public function sendResetLinkEmail(Request $request)
       {
           // Validar el correo electrónico
           $request->validate(['email' => 'required|email']);

           // Enviar el enlace de restablecimiento
           $status = Password::sendResetLink(
               $request->only('email')
           );

           // Redireccionar con un mensaje de éxito o error
           return $status === Password::RESET_LINK_SENT
               ? back()->with(['status' => __($status)])
               : back()->withErrors(['email' => __($status)]);
       }

       // Muestra el formulario para restablecer la contraseña
       public function showResetForm(Request $request, $token = null)
       {
           return view('auth.reset-password', [
               'token' => $token,
               'email' => $request->email,
           ]);
       }

       // Procesa el restablecimiento de la contraseña
       public function reset(Request $request)
       {
           // Validar los datos del formulario
           $request->validate([
               'token' => 'required',
               'email' => 'required|email',
               'password' => 'required|confirmed|min:8',
           ]);

           // Restablecer la contraseña
           $status = Password::reset(
               $request->only('email', 'password', 'password_confirmation', 'token'),
               function ($user, $password) {
                   // Actualizar la contraseña del usuario
                   $user->forceFill([
                       'password' => Hash::make($password),
                   ])->save();

                   // Disparar el evento de restablecimiento de contraseña
                   event(new PasswordReset($user));
               }
           );

           // Redireccionar con un mensaje de éxito o error
           return $status == Password::PASSWORD_RESET
               ? redirect()->route('login.signin')->with('status', __($status))
               : back()->withErrors(['email' => [__($status)]]);
       }
}
