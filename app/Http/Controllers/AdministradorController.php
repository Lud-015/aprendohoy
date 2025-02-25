<?php

namespace App\Http\Controllers;

use App\Events\CursoEvent;
use App\Events\DocenteEvent;
use App\Events\EstudianteEvent;
use App\Events\UsuarioEvent;
use App\Mail\NuevoUsuarioRegistrado;
use App\Models\atributosDocente;
use App\Models\Cursos;
use App\Models\Docente;
use App\Models\Estudiante;
use App\Models\TutorRepresentanteLegal;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Services\TwilioService;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;
use App\Models\Horario;
use Illuminate\Validation\Rule;

class AdministradorController extends Controller
{



    public function storeEstudiante(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'lastname1' => 'required',
            'lastname2' => 'required',
            'CI' => 'required|unique:users,CI,except,id',
            'Celular' => 'required|integer',
            'email' => 'required|unique:users,email',
            'fechadenac' => 'required|date|before_or_equal:' . now()->subYears(12)->format('Y-m-d'),
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'lastname1.required' => 'El primer apellido es obligatorio.',
            'lastname2.required' => 'El segundo apellido es obligatorio.',
            'CI.required' => 'El campo de identificación es obligatorio.',
            'CI.unique' => 'Esta identificación ya está en uso.',
            'Celular.required' => 'El número de celular es obligatorio.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.unique' => 'Este correo electrónico ya está en uso.',
            'fechadenac.required' => 'La fecha de nacimiento es obligatoria.',
            'fechadenac.date' => 'La fecha de nacimiento debe ser una fecha válida.',
            'fechadenac.before_or_equal' => 'Debes ser mayor de 12 años para registrarte.',
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

        $estudiante =  $user;

        // event(new EstudianteEvent($estudiante,'', 'registro'));

        $user->save();
        $user->assignRole('Estudiante');



        return redirect()->route('ListaEstudiantes')->with('success', 'Editado exitosamente!');

        // }







    }



    public function storeEstudianteMenor(Request $request)
    {


        $request->validate([
            'name' => 'required',
            'lastname1' => 'required',
            'lastname2' => 'required',
            'CI' => 'required|unique:users,CI',
            'nombreT' => 'required',
            'appT' => 'required',
            'apmT' => 'required',
            'CIT' => 'required',
            'CelularT' => 'required|integer',
            'fechadenac' => 'required|date|before_or_equal:' . now()->subYears(5)->format('Y-m-d'),

        ], [
            'name.required' => 'El nombre es obligatorio.',
            'lastname1.required' => 'El primer apellido es obligatorio.',
            'lastname2.required' => 'El segundo apellido es obligatorio.',
            'CI.required' => 'El campo de identificación es obligatorio.',
            'CI.unique' => 'Esta identificación ya está en uso.',
            'nombreT.required' => 'El nombre del tutor es obligatorio.',
            'appT.required' => 'El primer apellido del tutor es obligatorio.',
            'apmT.required' => 'El segundo apellido del tutor es obligatorio.',
            'CIT.required' => 'La identificación del tutor es obligatoria.',
            'CelularT.required' => 'El número de celular del tutor es obligatorio.',
            'fechadenac.required' => 'La fecha de nacimiento es obligatoria.',
            'fechadenac.date' => 'La fecha de nacimiento debe ser una fecha válida.',
            'fechadenac.before_or_equal' => 'El estudiante debe tener al menos 10 años.',
        ]);


        $user = new User();

        $user->name = $request->name;
        $user->lastname1 = $request->lastname1;
        $user->lastname2 = $request->lastname2;
        $user->Celular = $request->CelularT;
        $user->email = substr($request->nombreT,0,1).substr($request->appT,0,1).substr($request->appM,0,1).$request->CIT.'@fundvida.com';
        $user->CI = $request->CI;
        $orgDate = $request->fechadenac;



        $newDate = date("Y-m-d", strtotime($orgDate));

        $user->fechadenac = $newDate;
        $user->CiudadReside = $request->CiudadReside;
        $user->PaisReside = $request->PaisReside;
        $user->password = bcrypt(substr($request->nombreT,0,1).substr($request->appT,0,1).substr($request->appM,0,1).$request->CIT);

        $estudiante = $user;



        $tutor = new TutorRepresentanteLegal();

        $tutor->nombreTutor = $request->nombreT;
        $tutor->appaternoTutor = $request->appT;
        $tutor->apmaternoTutor = $request->apmT;
        $tutor->CI = $request->CIT;
        $tutor->Direccion = "";
        $tutor->Celular = $request->CelularT;
        $tutor->CorreoElectronicoTutor = $request->email;
        $tutor->estudiante_id = User::latest('id')->first()->id;


        // event(new EstudianteEvent($estudiante, $tutor, 'registro'));
        $user->save();
        $tutor->save();

        $user->assignRole('Estudiante');



        return redirect()->route('ListaEstudiantes')->with('success', 'Estudiante registrado exitosamente!');


    }




    public function storeDocente(Request $request)
    {


        $request->validate([
            'name' => 'required',
            'lastname1' => 'required',
            'lastname2' => 'required',
            'CI' => 'required|unique:users,CI',
            'Celular' => 'required|integer',
            'email' => 'required|unique:users,email',
            'fechadenac' => 'required|date|before_or_equal:' . now()->subYears(18)->format('Y-m-d'),
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'lastname1.required' => 'El primer apellido es obligatorio.',
            'lastname2.required' => 'El segundo apellido es obligatorio.',
            'CI.required' => 'El campo de identificación es obligatorio.',
            'CI.unique' => 'Esta identificación ya está en uso.',
            'Celular.required' => 'El número de celular es obligatorio.',
            'Celular.integer' => 'Debe ser un numero valido.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.unique' => 'Este correo electrónico ya está en uso.',
            'fechadenac.required' => 'La fecha de nacimiento es obligatoria.',
            'fechadenac.date' => 'La fecha de nacimiento debe ser una fecha válida.',
            'fechadenac.before_or_equal' => 'Debes ser mayor de 18 años para registrarte.',
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

        $docente = $user;

        // event(new DocenteEvent($docente, 'registro'));
        $user->save();
        $user->assignRole('Docente');

        $atributosDocentes = new atributosDocente();

        $atributosDocentes->formacion = "";
        $atributosDocentes->Especializacion = "";
        $atributosDocentes->ExperienciaL = "";
        $atributosDocentes->docente_id = User::latest('id')->first()->id;
        $atributosDocentes->save();


        // Mensaje a Correo No funciona
        // Mail::to($request->email)->send(new NuevoUsuarioRegistrado($request->all()));




        return redirect()->route('ListaDocentes')->with('success', 'Docente registrado exitosamente!');


    }




    public function storeCurso(Request $request)
    {



        $request->validate([
            'nombre' => 'required|string',
            'docente_id' => 'required|integer',
            'fecha_ini' => 'required|date|date_format:Y-m-d',
            'fecha_fin' => 'required|date|date_format:Y-m-d|after_or_equal:fecha_ini',

        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'docente_id.required' => 'El ID del docente es obligatorio.',
            'docente_id.integer' => 'El ID del docente debe ser un número entero.',
            'fecha_ini.required' => 'La fecha de inicio es obligatoria.',
            'fecha_ini.date' => 'La fecha de inicio debe ser una fecha válida.',
            'fecha_ini.date_format' => 'El formato de fecha de inicio no es válido (YYYY-MM-DD).',
            'fecha_fin.required' => 'La fecha de finalización es obligatoria.',
            'fecha_fin.date' => 'La fecha de finalización debe ser una fecha válida.',
            'fecha_fin.date_format' => 'El formato de fecha de finalización no es válido (YYYY-MM-DD).',
            'fecha_fin.after_or_equal' => 'La fecha de finalización debe ser después o igual a la fecha de inicio.',
            'formato.required' => 'El formato es obligatorio.',
            'formato.string' => 'El formato debe ser una cadena de texto.',
        ]);







        $curso = new Cursos;
        $curso->nombreCurso = $request->nombre;
        $curso->codigoCurso = $request->nombre . '_' . $request->docente_id . '_' . date("Ymd", strtotime($request->fecha_ini));
        $curso->descripcionC = $request->descripcion ?? '';
        $curso->fecha_ini = date("Y-m-d", strtotime($request->fecha_ini));
        $curso->fecha_fin = date("Y-m-d", strtotime($request->fecha_fin));
        $curso->formato = $request->formato;
        $curso->tipo = $request->tipo;
        $curso->docente_id = $request->docente_id;
        $curso->edad_dirigida = $request->edad_id;
        $curso->nivel = $request->nivel_id;
        $curso->notaAprobacion = 51;
        $curso->estado = ($curso->fecha_fin < now()) ? 'Finalizado' : 'Activo';


        event(new CursoEvent($curso, 'crear'));

        $curso->save();





        return redirect(route('Inicio'))->with('success', 'Curso registrado exitosamente!');





    }

    public function EditUserIndex($id)
    {

        $usuario = User::findOrFail($id);

        $atributosD = DB::table('atributos_docentes')
        ->where('docente_id', '=', $id) // joining the contacts table , where user_id and contact_user_id are same
        ->select('atributos_docentes.*')
        ->get();

        $atributosTutor = DB::table('tutor_representante_legals')
            ->where('estudiante_id', '=', $id) // joining the contacts table , where user_id and contact_user_id are same
            ->select('tutor_representante_legals.*')
            ->get();



        return view('EditarUsuario', ['atributosD' => $atributosD], ['atributosTutor' => $atributosTutor])->with('usuario', $usuario)->with('success', 'Editado exitosamente!');



    }

    public function EditUser($id ,Request $request)
    {


        $request->validate([
            'name' => 'required',
            'lastname1' => 'required',
            'Celular' => 'required',
            'email' => 'required|unique:users,email,'.$id,
            'fechadenac' => 'required|date|before_or_equal:today',
        ], [
            'name.required' => 'El campo nombre es obligatorio.',
            'lastname1.required' => 'El campo primer apellido es obligatorio.',
            'Celular.required' => 'El campo celular es obligatorio.',
            'email.required' => 'El campo correo electrónico es obligatorio.',
            'email.unique' => 'El correo electrónico ya está registrado.',
            'fechadenac.required' => 'El campo fecha de nacimiento es obligatorio.',
            'fechadenac.before_or_equal' => 'El campo fecha de nacimiento debe ser valido.',
        ]);


        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->lastname1 = $request->lastname1;
        $user->lastname2 = $request->lastname2 ?? '';
        $user->CI = $request->CI;
        $user->email = $request->email;
        $user->Celular = $request->Celular;
        $user->fechadenac = $request->fechadenac;
        $user->PaisReside = $request->PaisReside ?? '';
        $user->CiudadReside = $request->CiudadReside ?? '';
        $user->updated_at = now();






        if ($user->hasRole('Docente') || $user->hasRole('Administrador')) {


            $atributosDocentes = [
                'formacion' => $request->formacion ?? '',
                'Especializacion' => $request->Especializacion ?? '',
                'ExperienciaL' => $request->ExperienciaL ?? '',
                'updated_at' => now(),
            ];

            DB::table('atributos_docentes')
                ->where('docente_id', '=', $id)
                ->update($atributosDocentes);

            event(new UsuarioEvent($user, 'modificacion'));

            $user->save();
        } elseif($user->tutor) {

            $request->validate([
                'nombreT' => 'required|string|max:255',
                'appT' => 'required|string|max:255',
                'apmT' => 'required|string|max:255',  // Puede ser nulo
                'Direccion' => 'nullable|string|max:255',  // Puede ser nulo
            ],[
                'nombreT.required' => 'El campo nombre del tutor es obligatorio.',
                'nombreT.string' => 'El campo nombre del tutor debe ser una cadena de texto.',
                'nombreT.max' => 'El campo nombre del tutor no debe exceder los :max caracteres.',

                'appT.required' => 'El campo apellido paterno del tutor es obligatorio.',
                'appT.string' => 'El campo apellido paterno del tutor debe ser una cadena de texto.',
                'appT.max' => 'El campo apellido paterno del tutor no debe exceder los :max caracteres.',

                'apmT.string' => 'El campo apellido materno del tutor debe ser una cadena de texto.',
                'apmT.max' => 'El campo apellido materno del tutor no debe exceder los :max caracteres.',



                'direccion.string' => 'El campo dirección del tutor debe ser una cadena de texto.',
                'direccion.max' => 'El campo dirección del tutor no debe exceder los :max caracteres.',
            ]);

            $tutor = [
                'nombreTutor' => $request->nombreT,
                'appaternoTutor' => $request->appT,
                'apmaternoTutor' => $request->apmT,
                'CI' => $request->CIT,
                'Celular' => $request->Celular,
                'Direccion' => $request->direccion ?? '',
                'updated_at' => now(),
            ];

            DB::table('tutor_representante_legals')
                ->where('estudiante_id', '=', $id)
                ->update($tutor);

            event(new UsuarioEvent($user, 'modificacion'));

            $user->save();
        }else{

            event(new UsuarioEvent($user, 'modificacion'));

            $user->save();

        }

        return redirect()->route('Inicio')->with('success', 'Editado exitosamente!');

}
}



