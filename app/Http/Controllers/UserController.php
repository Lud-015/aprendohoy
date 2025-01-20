<?php

namespace App\Http\Controllers;

use App\Events\UsuarioEvent;
use App\Models\atributosDocente;
use App\Models\DocentesTrabajos;
use App\Models\TutorRepresentanteLegal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{

    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    //  public function authenticate(Request $request)
    //  {
    //      $credentials = $request->validate([
    //          'email' => ['required', 'email'],
    //          'password' => ['required'],
    //      ]);

    //      if (Auth::attempt($credentials)) {
    //          // Autenticación exitosa
    //          $user = auth()->user();
    //          $token = $user->createToken('API Token')->plainTextToken;

    //          // Devolver una respuesta JSON en lugar de redirigir
    //         //  return response()->json([
    //         //      'token' => $token,
    //         //      'user' => $user
    //         //  ]);

    //      }

    //      // Si la autenticación falla, devolver una respuesta JSON de error
    //      return response()->json([
    //          'error' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
    //      ], 401);
    //  }
    public function authenticate(Request $request)
    {

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);



        if (Auth::attempt($credentials)) {
            event(new UsuarioEvent(auth()->user(), 'login'));
            return redirect()->intended('/Inicio');
        }

        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ])->onlyInput('email');
    }


    public function getUser(Request $request)
    {
        return response()->json(Auth::user());
    }
    public function logout()
    {

        auth()->logout();
        return redirect()->route('login.signin');
    }

    public function Profile($id)
    {
        $usuario = User::findOrFail($id);

        // ->with('atributosD', $atributosD)->with('atributosE', $atributosE)

        $trabajos = DocentesTrabajos::where('docente_id', $id)->get();
        $tutor = TutorRepresentanteLegal::where('estudiante_id', $id)->get();

        $atributosD = atributosDocente::where('docente_id', $id)->get();


        return view('PerfilUsuario')->with('usuario', $usuario)->with('atributosD', $atributosD)->with('trabajos', $trabajos)->with('tutor', $tutor);
    }

    public function UserProfile()
    {


        $atributosD = atributosDocente::where('docente_id', Auth::user()->id)->get();
        $trabajos = DocentesTrabajos::where('docente_id', Auth::user()->id)->get();
        $tutor = TutorRepresentanteLegal::where('estudiante_id', Auth::user()->id)->get();


        return view('MiPerfilUsuario')->with('atributosD', $atributosD)->with('tutor', $tutor)->with('trabajos', $trabajos);
    }

    public function UserProfileEdit(Request $request)
    {
        $request->validate([
            'Celular' => 'required',
            'confirmpassword' => 'required'
        ], [
            'Celular.required' => 'El campo Celular es obligatorio.',
            'confirmpassword.required' => 'Confirma la contraseña para realizar los cambios.'
        ]);

        $user = User::findOrFail(Auth::user()->id);

        $this->updateUserData($request, $user);

        $confirmpassword = $request->confirmpassword;

        if ($this->validatePassword($confirmpassword)) {
            if (Auth::user()->hasRole('Administrador') || Auth::user()->hasRole('Estudiante')) {
                event(new UsuarioEvent($user, 'modificacion'));
                $this->saveUser($user);
                return back()->with('success', 'Editado Correctamente');
            }

            if (Auth::user()->hasRole('Docente')) {
                event(new UsuarioEvent($user, 'modificacion'));

                $this->updateDocenteData($request, $user);
                return back()->with('success', 'Editado Correctamente');
            }
        }

        return back()->with('error', 'Contraseña incorrecta');
    }

    protected function updateUserData(Request $request, User $user)
    {
        $user->Celular = $request->Celular;
        $user->PaisReside = $request->PaisReside ?? '';
        $user->CiudadReside = $request->CiudadReside ?? '';
        $user->updated_at = now();

        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $avatarPath;
        }
    }


    protected function updateUserAvatar(Request $request)
    {
        $user = User::findOrFail(Auth::user()->id);


        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $avatarPath;
        }

        $user->save();

        return redirect(route('Miperfil'));

    }






    protected function validatePassword($confirmpassword)
    {
        $password = Auth::user()->password;
        return Hash::check($confirmpassword, $password);
    }

    protected function saveUser(User $user)
    {
        $user->save();
    }

    protected function updateDocenteData(Request $request, User $user)
    {

        $this->updateAtributosDocentes($request);

        $user->save();
    }

    protected function updateAtributosDocentes(Request $request)
    {
        DB::table('atributos_docentes')
            ->where('docente_id', '=', Auth::user()->id)
            ->update([
                'atributos_docentes.formacion' => $request->formacion ?? '',
                'atributos_docentes.Especializacion' => $request->Especializacion ?? '',
                'atributos_docentes.ExperienciaL' => $request->ExperienciaL ?? '',
                'atributos_docentes.updated_at' => now()
            ]);

        $trabajos = $request->input('trabajos');

        foreach ($trabajos as $trabajosItem) {

            if (isset($trabajosItem['id'])) {
                $trabajoid = $trabajosItem['id'];
                $trabajo = DocentesTrabajos::findOrFail($trabajoid);

                $trabajo->update([
                    'empresa' => $trabajosItem['empresa'] ?? '',
                    'cargo' => $trabajosItem['cargo'] ?? '',
                    'fecha_inicio' => date("Y-m-d", strtotime($trabajosItem['fechain'])) ?? '',
                    'fecha_fin' => date("Y-m-d", strtotime($trabajosItem['fechasal'])) ?? '',
                    'contacto_ref' => $trabajosItem['contacto'] ?? '',
                ]);
            } elseif ($trabajosItem['id'] = 'null') {
                DocentesTrabajos::create([
                    'docente_id' => Auth::user()->id,
                    'empresa' => $trabajosItem['empresa'] ?? '',
                    'cargo' => $trabajosItem['cargo'] ?? '',
                    'fecha_inicio' => date("Y-m-d", strtotime($trabajosItem['fechain'])) ?? '',
                    'fecha_fin' => date("Y-m-d", strtotime($trabajosItem['fechasal'])) ?? '',
                    'contacto_ref' => $trabajosItem['contacto'] ?? '',
                ]);
            }
        }
    }


    public function EditProfileIndex()
    {


        $atributosD = atributosDocente::where('docente_id', Auth::user()->id)->get();
        $ultimosTrabajos = DocentesTrabajos::where('docente_id', Auth::user()->id)->get();


        return view('EditarPerfil')->with('ultimosTrabajos', $ultimosTrabajos)->with('atributosD', $atributosD);
    }



    public function EditPasswordIndex($id)
    {


        $usuario = User::findOrFail($id);

        if (auth()->user()->id == $id) {
            return view('EditarContrasena')->with('usuario', $usuario);
        } else {

            abort(403);
        }
    }



    public function CambiarContrasena(Request $request)
    {

        $request->validate([
            'oldpassword' => 'required',
            'password' => 'required|min:8|regex:/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d!$%@#£€*?&]{8,}$/',
            'password_confirmation' => 'required_with:password|same:password'
        ], [
            'oldpassword.required' => 'La contraseña actual es obligatoria.',
            'password.required' => 'La nueva contraseña es obligatoria.',
            'password.min' => 'La nueva contraseña debe tener al menos :min caracteres.',
            'password.regex' => 'La nueva contraseña debe contener al menos una letra mayúscula, una letra minúscula y un número.',
            'password_confirmation.required_with' => 'Debes confirmar la nueva contraseña.',
            'password_confirmation.same' => 'La confirmación de la contraseña no coincide con la nueva contraseña.',
        ]);
        $usuario = User::findOrFail(Auth::user()->id);
        $password = Auth::user()->password;
        $oldpassword = $request->oldpassword;


        if (Hash::check($oldpassword, $password)) {

            $usuario->password = bcrypt($request->password);
            event(new UsuarioEvent($usuario, 'modificacion'));
            $usuario->save();

            return back()->with('success', 'Se ha cambiado la contraseña correctamente');
        } else {
            return back()->withErrors([
                'password' => 'Error en la contraseña antigua.',
            ]);
        }
    }

    public function eliminarUsuario($id)
    {

        $usuario = User::find($id);
        event(new UsuarioEvent($usuario, 'eliminacion'));
        $usuario->delete();

        return back()->with('success', 'Usuario Dado de Baja');
    }
    public function restaurarUsuario($id)
    {

        $usuarioEliminado = User::onlyTrashed()->find($id);
        event(new UsuarioEvent($usuarioEliminado, 'restaurar'));

        $usuarioEliminado->restore();

        return back()->with('success', 'Usuario dado de baja');
        ;
    }

    public function notificaciones()
    {
        return view('notificaciones');
    }
}
