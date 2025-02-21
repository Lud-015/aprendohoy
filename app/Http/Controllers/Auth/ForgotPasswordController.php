<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\ResetPasswordNotification;
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
           $request->validate([
               'email' => 'required|email|exists:users,email'
           ], [
               'email.required' => 'El correo es obligatorio.',
               'email.email' => 'Formato de correo inválido.',
               'email.exists' => 'No se encontró un usuario con ese correo.'
           ]);

           // Buscar el usuario
           $user = User::where('email', $request->email)->first();

           if (!$user) {
               return back()->withErrors(['email' => 'Usuario no encontrado.']);
           }

           // Generar el token
           $token = Password::getRepository()->create($user);

           // Enviar notificación personalizada
           $user->notify(new ResetPasswordNotification($token));

           return back()->with('status', 'Te hemos enviado un correo con el enlace para restablecer tu contraseña.');
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
