<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RolesPermisosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
                app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

                Permission::create(['name' => 'Crear Curso']);
                Permission::create(['name' => 'Realizar Tareas']);
                Permission::create(['name' => 'Publicar Tareas']);
                Permission::create(['name' => 'Añadir Estudiantes']);
                Permission::create(['name' => 'Añadir Docentes']);
                Permission::create(['name' => 'Realizar Aportes']);
                Permission::create(['name' => 'Responder Foro']);
                Permission::create(['name' => 'Realizar Asistencias']);
                Permission::create(['name' => 'Personalizar Curso']);
        
                $role = Role::create(['name' => 'En Espera']);

                $role = Role::create(['name' => 'Estudiante']);
                $role->givePermissionTo('Responder Foro');
                $role->givePermissionTo('Realizar Tareas');
                $role->givePermissionTo('Realizar Aportes');
                $role->givePermissionTo('Realizar Asistencias');
        
                $role = Role::create(['name' => 'Docente']);
                $role ->givePermissionTo(['Publicar Tareas']);
                $role ->givePermissionTo(['Añadir Estudiantes']);
                $role ->givePermissionTo(['Personalizar Curso']);
                
                $role = Role::create(['name' => 'Coordinador']);
                $role = Role::create(['name' => 'Administrador']);
                $role->givePermissionTo(Permission::all());


    }
}
