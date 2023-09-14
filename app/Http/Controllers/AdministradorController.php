<?php

namespace App\Http\Controllers;

use App\Models\atributosDocente;
use App\Models\Cursos;
use App\Models\Docente;
use App\Models\Estudiante;
use App\Models\TutorRepresentanteLegal;
use App\Models\User;
use Illuminate\Support\Facades\DB;

use App\Services\TwilioService;

use Illuminate\Http\Request;

class AdministradorController extends Controller
{



    public function storeEstudiante(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'lastname1' => 'required',
            'lastname2' => 'required',
            'CI' => 'required|unique:users,CI,except,id',
            'Celular' => 'required',
            'email' => 'required|unique:users,email',
            'fechadenac' => 'required',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->lastname1 = $request->lastname1;
        $user->lastname2 = $request->lastname2;
        $user->CI = $request->CI;
        $user->Celular = $request->Celular;
        $user->email = $request->email;
        $check = $request->representante;

        $orgDate = $request->fechadenac;
        $newDate = date("Y-m-d", strtotime($orgDate));

        $user->fechadenac = $newDate;
        $user->CiudadReside = $request->CiudadReside;
        $user->PaisReside = $request->PaisReside;
        $user->password = bcrypt(substr($request->name,0,1).substr($request->lastname1,0,1).substr($request->lastname2,0,1).$request->CI);


        // if ($check == "1") {

        // $user->save();
        // $user->assignRole('Estudiante');

        // $request->validate([
        //     'nombreT' => 'required',
        //     'appT' => 'required',
        //     'apmT' => 'required',
        //     'CIT' => 'required',
        //     'CelularT' => 'required',
        // ]);

        // $tutor = new TutorRepresentanteLegal();

        // $tutor->nombreTutor = $request->nombreT;
        // $tutor->appaternoTutor = $request->appT;
        // $tutor->apmaternoTutor = $request->apmT;
        // $tutor->CI = $request->CIT;
        // $tutor->Direccion = "";
        // $tutor->Celular = $request->CelularT;
        // $tutor->estudiante_id = User::latest('id')->first()->id;

        // return redirect()->route('Inicio');


        // }elseif($check == ""){


        $user->save();
        $user->assignRole('Estudiante');



        return redirect()->route('Inicio');

        // }







    }



    public function storeEstudianteMenor(Request $request)
    {


        $request->validate([
            'name' => 'required',
            'lastname1' => 'required',
            'lastname2' => 'required',
            'CI' => 'required|unique:users,CI',
            'Celular' => 'required',
            'email' => 'required|unique:users,email',
            'nombreT' => 'required',
            'appT' => 'required',
            'apmT' => 'required',
            'CIT' => 'required',
            'CelularT' => 'required',
        ]);


        $user = new User();

        $user->name = $request->name;
        $user->lastname1 = $request->lastname1;
        $user->lastname2 = $request->lastname2;
        $user->Celular = $request->CelularT;
        $user->email = $request->email;
        $user->CI = $request->CI;
        $orgDate = $request->fechadenac;



        $newDate = date("Y-m-d", strtotime($orgDate));

        $user->fechadenac = $newDate;
        $user->CiudadReside = $request->CiudadReside;
        $user->PaisReside = $request->PaisReside;
        $user->password = bcrypt(substr($request->nombreT,0,1).substr($request->appT,0,1).substr($request->appM,0,1).$request->CIT);

        $user->save();

        $tutor = new TutorRepresentanteLegal();

        $tutor->nombreTutor = $request->nombreT;
        $tutor->appaternoTutor = $request->appT;
        $tutor->apmaternoTutor = $request->apmT;
        $tutor->CI = $request->CIT;
        $tutor->Direccion = "";
        $tutor->Celular = $request->CelularT;
        $tutor->estudiante_id = User::latest('id')->first()->id;

        $tutor->save();

        $user->assignRole('Estudiante');



        return redirect()->route('Inicio');


    }




    public function storeDocente(Request $request)
    {


        $request->validate([
            'name' => 'required',
            'lastname1' => 'required',
            'lastname2' => 'required',
            'CI' => 'required|unique:users,CI',
            'Celular' => 'required',
            'email' => 'required|unique:users,email',
            'fechadenac' => 'required',
        ]);


        $user = new User();
        $user->name = $request->name;
        $user->lastname1 = $request->lastname1;
        $user->lastname2 = $request->lastname2;
        $user->CI = $request->CI;
        $user->Celular = $request->Celular;
        $user->email = $request->email;
        $orgDate = $request->fechadenac;
        $newDate = date("Y-m-d", strtotime($orgDate));


        $user->fechadenac = $newDate;
        $user->CiudadReside = $request->CiudadReside;
        $user->PaisReside = $request->PaisReside;
        $user->password = bcrypt(substr($request->name,0,1).substr($request->lastname1,0,1).substr($request->lastname2,0,1).$request->CI);
        $user->save();
        $user->assignRole('Docente');

        $atributosDocentes = new atributosDocente();

        $atributosDocentes->formacion = "";
        $atributosDocentes->Especializacion = "";
        $atributosDocentes->ExperienciaL = "";
        $atributosDocentes->docente_id = User::latest('id')->first()->id;
        $atributosDocentes->save();

      

        return redirect()->route('Inicio');


    }




    public function storeCurso(Request $request)
    {


        $request->validate([
            'nombre' => 'required',
            'descripcion' => 'required',
            'fecha_ini' => 'required',
            'fecha_fin' => 'required',
            'formato' => 'required',
            'docente_id ' => 'required',
            'edad_id ' => 'required',
            'nivel_id ' => 'required',
            'horario_id ' => 'required',
        ]);


        $curso = new Cursos;
        $curso->nombreCurso = $request->nombre;
        $curso->descripcionC = $request->descripcion;
        $curso->fecha_ini = $request->fecha_ini;
        $curso->fecha_fin = $request->fecha_fin;
        $curso->formato = $request->formato;
        $curso->docente_id = $request->docente_id ;
        $curso->edadDir_id = $request->edad_id;
        $curso->niveles_id = $request->nivel_id;
        $curso->horario_id = $request->horario_id;

        $curso->save();

        return redirect()->route('Inicio');


    }

    public function EditUserIndex($id)
    {

        $usuario = User::findOrFail($id);

        $atributosD = DB::table('atributos_docentes')
            ->where('docente_id', '=', $id) // joining the contacts table , where user_id and contact_user_id are same
            ->select('atributos_docentes.*')
            ->get();



        return view('EditarUsuario', ['atributosD' => $atributosD])->with('usuario', $usuario);



    }

    public function EditUser($id ,Request $request)
    {


        $request->validate([

            'name' => 'required',
            'lastname1' => 'required',
            'lastname2' => 'required',
            'Celular' => 'required',
            'CI' => 'required|unique:users,CI,'.$id,
            'email' => 'required|unique:users,email,'.$id,
            'fechadenac' => 'required',
            'password' => 'required'

        ]);


        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->lastname1 = $request->lastname1;
        $user->lastname2 = $request->lastname2;
        $user->CI = $request->CI;
        $user->email = $request->email;
        $user->Celular = $request->Celular;
        $user->fechadenac = $request->fechadenac;
        $user->PaisReside = $request->PaisReside;
        $user->CiudadReside = $request->CiudadReside;
        $user->password = bcrypt($request->password);
        $user->updated_at = now();






        if ($user->hasRole('Docente') or $user->hasRole('Administrador')) {


            $request->validate([
                'formacion' => 'required',
                'Especializacion' => 'required',
                'ExperienciaL' => 'required',
            ]);





                DB::table('atributos_docentes')
                    ->where('docente_id', '=', $id)
                    ->update(['atributos_docentes.formacion' => $request->formacion]);
                DB::table('atributos_docentes')
                    ->where('docente_id', '=', $id)
                    ->update(['atributos_docentes.Especializacion' => $request->Especializacion]);
                DB::table('atributos_docentes')
                    ->where('docente_id', '=', $id)
                    ->update(['atributos_docentes.ExperienciaL'  => $request->ExperienciaL]);
                DB::table('atributos_docentes')
                    ->where('docente_id', '=', $id)
                    ->update(['atributos_docentes.updated_at'  => now()]);

                $user->save();


                return redirect()->route('Inicio');
            }else{

                $user->save();
                return redirect()->route('Inicio');

            }

        }

}


