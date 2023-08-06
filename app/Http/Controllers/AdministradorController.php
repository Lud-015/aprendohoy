<?php

namespace App\Http\Controllers;

use App\Models\Cursos;
use App\Models\User;



use Illuminate\Http\Request;

class AdministradorController extends Controller
{
    
    public function index(){

    

    }


    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function storeDocente(Request $request)
    {
    
        $user = new User;
        $user->name = $request->name;
        $user->lastname1 = $request->lastname1;
        $user->lastname2 = $request->lastname2;
        $user->CI = $request->CI;
        $user->Celular = $request->Celular;
        $user->email = $request->email;
        $user->fechadenac = $request->fechadenac;
        $user->password = bcrypt(substr($request->name,0,1).substr($request->lastname1,0,1).substr($request->lastname2,0,1).$request->CI);
        $user->save();
        $user->assignRole('Docente');



        return redirect()->route('Inicio');
        

    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function storeCurso(Request $request)
    {
    
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

        return redirect()->route('ListadeCursos');
        

    }



}
