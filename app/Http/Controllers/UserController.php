<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{

    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function authenticate(Request $request)
    {

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);



        if (Auth::attempt($credentials)) {

            return redirect()->intended('/Inicio');
        }

        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ])->onlyInput('email');
    }

    public function logout()
    {

        auth()->logout();
        return redirect()->route('login.signin');
    }

    public function Profile($id){
        $usuario = User::findOrFail($id);

              // ->with('atributosD', $atributosD)->with('atributosE', $atributosE)

              if (auth()->user()->role = "Docente" or auth()->user()->role = "Administrador") {


                $atributosD = DB::table('atributos_docentes')
                ->where('docente_id', '=', $id)// joining the contacts table , where user_id and contact_user_id are same
                ->select('atributos_docentes.*')
                ->get();

                // $atributosE = DB::table('tutor_representante_legals')
                // ->where('estudiante_id', '=', Auth::user()->id)// joining the contacts table , where user_id and contact_user_id are same
                // ->select('tutor_representante_legals.*')
                // ->get();

                return view('PerfilUsuario', ['atributosD' => $atributosD])->with('usuario', $usuario);

            }

            return view('PerfilUsuario')->with('usuario', $usuario);

    }

    public function UserProfile()
    {



        // ->with('atributosD', $atributosD)->with('atributosE', $atributosE)

        if (auth()->user()->role = "Docente" or auth()->user()->role = "Administrador") {


            $atributosD = DB::table('atributos_docentes')
            ->where('docente_id', '=', Auth::user()->id)// joining the contacts table , where user_id and contact_user_id are same
            ->select('atributos_docentes.*')
            ->get();

            // $atributosE = DB::table('tutor_representante_legals')
            // ->where('estudiante_id', '=', Auth::user()->id)// joining the contacts table , where user_id and contact_user_id are same
            // ->select('tutor_representante_legals.*')
            // ->get();

            return view('MiPerfilUsuario', ['atributosD' => $atributosD]);

        }


        if (auth()->user()->role = "Estudiante") {


            $atributosD = DB::table('atributos_docentes')
            ->where('estudiante_id', '=', Auth::user()->id)// joining the contacts table , where user_id and contact_user_id are same
            ->select('atributos_docentes.*')
            ->get();

            // $atributosE = DB::table('tutor_representante_legals')
            // ->where('estudiante_id', '=', Auth::user()->id)// joining the contacts table , where user_id and contact_user_id are same
            // ->select('tutor_representante_legals.*')
            // ->get();

            return view('MiPerfilUsuario', ['atributosD' => $atributosD]);

        }




        return view('MiPerfilUsuario');
    }

    public function UserProfileEdit(Request $request)
    {


        $request->validate([

            'Celular' => 'required',
            'fechadenac' => 'required',
            'confirmpassword' => 'required'

        ]);


        $user = User::findOrFail(Auth::user()->id);
        $user->Celular = $request->Celular;
        $user->fechadenac = $request->fechadenac;
        $user->PaisReside = $request->PaisReside;
        $user->CiudadReside = $request->CiudadReside;
        $user->updated_at = now();

        $confirmpassword =  $request->confirmpassword;


        $password = Auth::user()->password;



        if (auth()->user()->role = "Docente" or auth()->user()->role = "Administrador") {


            $request->validate([
                'formacion' => 'required',
                'Especializacion' => 'required',
                'ExperienciaL' => 'required',
            ]);


            if (Hash::check($confirmpassword, $password)) {


                DB::table('atributos_docentes')
                    ->where('docente_id', '=', Auth::user()->id) // joining the contacts table , where user_id and contact_user_id are same
                    ->update(['atributos_docentes.formacion' => $request->formacion]);
                DB::table('atributos_docentes')
                    ->where('docente_id', '=', Auth::user()->id) // joining the contacts table , where user_id and contact_user_id are same
                    ->update(['atributos_docentes.Especializacion' => $request->Especializacion]);
                DB::table('atributos_docentes')
                    ->where('docente_id', '=', Auth::user()->id) // joining the contacts table , where user_id and contact_user_id are same
                    ->update(['atributos_docentes.ExperienciaL'  => $request->ExperienciaL]);
                DB::table('atributos_docentes')
                    ->where('docente_id', '=', Auth::user()->id) // joining the contacts table , where user_id and contact_user_id are same
                    ->update(['atributos_docentes.updated_at'  => now()]);

                $user->save();
            }
            return redirect()->route('Miperfil');
        }

    }


    public function EditProfileIndex()
    {


        $atributosD = DB::table('atributos_docentes')
            ->where('docente_id', '=', Auth::user()->id)
            ->select('atributos_docentes.*')
            ->get();


        return view('EditarPerfil', ['atributosD' => $atributosD]);
    }



    public function EditContraseñaIndex()
    {


        $usuario = User::findOrFail(Auth::user()->id);

        return view('EditarContraseña', ['usuario' => $usuario]);
    }



    public function CambiarContraseña(Request $request)
    {

        $request->validate([

            'oldpassword' => 'required',
            'password' => 'required',
            'password_confirmation' => 'required_with:password|same:password'
        ]);
        $usuario = User::findOrFail(Auth::user()->id);
        $password = Auth::user()->password;
        $oldpassword = $request->oldpassword;


        if(Hash::check($oldpassword, $password) ){

            $usuario->password = bcrypt($request->password);
            $usuario->save();

            return redirect(route('Miperfil'));

        }else{
            return back()->withErrors([
                'password' => 'Error en la contraseña antigua.',
            ]);

        }





    }



}
