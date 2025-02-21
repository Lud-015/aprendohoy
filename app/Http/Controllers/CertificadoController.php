<?php

namespace App\Http\Controllers;

use App\Models\Certificado;
use App\Models\CertificateTemplate;
use App\Models\Cursos;
use App\Models\Inscritos;
use App\Models\Progreso;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use App\Notifications\CertificadoGeneradoNotification;
use Illuminate\Support\Facades\Cache;
use Exception;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;


class CertificadoController extends Controller
{

    // // Mostrar lista de plantillas
    // public function index()
    // {
    //     $templates = CertificateTemplate::all();
    //     return view('certificates.index', compact('templates'));
    // }

    // Guardar una nueva plantilla
    public function store(Request $request, $id)
    {
        $request->validate([
            'template_front' => 'required|image|mimes:png,jpg,jpeg|max:2048',
            'template_back' => 'required|image|mimes:png,jpg,jpeg|max:2048',
        ]);


        $pathFront = $request->file('template_front')->store('certificates/templates', 'public');
        $pathBack = $request->file('template_back')->store('certificates/templates', 'public');

        // Guardar la imagen en storage

        // Crear el registro en la base de datos
    CertificateTemplate::create([
        'curso_id' => $id,
        'template_front_path' => $pathFront,
        'template_back_path' => $pathBack,
    ]);

        return back()->with('success', 'Plantilla subida correctamente');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'template_front' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'template_back' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        $certificateTemplate = CertificateTemplate::where('curso_id', $id)->firstOrFail();

        // Si se sube una nueva imagen frontal
        if ($request->hasFile('template_front')) {
            // Eliminar la imagen anterior
            Storage::disk('public')->delete($certificateTemplate->template_front_path);

            // Guardar la nueva imagen
            $pathFront = $request->file('template_front')->store('certificates/templates', 'public');

            // Actualizar el registro con la nueva imagen frontal
            $certificateTemplate->update([
                'template_front_path' => $pathFront,
            ]);
        }

        // Si se sube una nueva imagen trasera
        if ($request->hasFile('template_back')) {
            // Eliminar la imagen anterior
            Storage::disk('public')->delete($certificateTemplate->template_back_path);

            // Guardar la nueva imagen
            $pathBack = $request->file('template_back')->store('certificates/templates', 'public');

            // Actualizar el registro con la nueva imagen trasera
            $certificateTemplate->update([
                'template_back_path' => $pathBack,
            ]);
        }

        return back()->with('success', 'Plantilla actualizada correctamente');
    }



    // Eliminar una plantilla
    public function destroy($id)
    {
        $template = CertificateTemplate::findOrFail($id);

        // Eliminar el archivo físico
        Storage::disk('public')->delete($template->template_path);

        // Eliminar el registro
        $template->delete();

        return back()->with('success', 'Plantilla eliminada correctamente');
    }





    public function generarCertificado($id)
    {
        set_time_limit(300);
        $inscritos = Inscritos::findOrFail($id);
        $progreso = $inscritos->progreso;

        if (intval($progreso) == 0) {
            return response()->json(['error' => 'El curso no está completado'], 400);
        }

        $codigo = strtoupper(Str::random(10));
        $qrCodeSvg = QrCode::format('svg')->size(300)->generate($codigo);
        $qrCode = 'data:image/svg+xml;base64,' . base64_encode($qrCodeSvg);

        return view('certificados.plantilla', [
            'curso' => $inscritos->cursos,
            'estudiante' => $inscritos->estudiantes,
            'codigo' => $codigo,
            'fecha' => now()->format('d/m/Y'),
            'qrCode' => $qrCode
        ]);
    }

    public function generarCertificadoCongreso($id)
    {
        // Buscar el curso
        $curso = Cursos::findOrFail($id);

        if ($curso->tipo != 'congreso') {
            return back()->with('error', 'No se puede generar certificados.');
        }

        $plantilla = CertificateTemplate::where('curso_id', $id)->first();
        if (!$plantilla) {
            return back()->with('error', 'No se encontró la plantilla del certificado para este curso.');
        }

        // Obtener los inscritos que aún no tienen certificado
        $inscritos = Inscritos::where('cursos_id', $id)
            ->whereDoesntHave('certificado') // Verifica que no tengan un certificado aún
            ->with('estudiantes')
            ->get();

        // Verificar si hay inscritos sin certificado
        if ($inscritos->isEmpty()) {
            return back()->with('info', 'Todos los inscritos ya tienen su certificado.');
        }

        // Recorrer cada inscrito y generar su certificado
        foreach ($inscritos as $inscrito) {
            // Generar código único
            $codigo_certificado = Str::uuid();

            // Generar el código QR
            $qrCode = QrCode::format('png')->size(200)->generate(route('verificar.certificado', ['codigo' => $codigo_certificado]));
            $qrPath = "certificados/{$id}/qrcode_{$inscrito->id}.png";
            Storage::put("public/$qrPath", $qrCode);

            ini_set('max_execution_time', 300); // 300 segundos = 5 minutos

            // Crear PDF del certificado personalizado
            $pdf = Pdf::loadView('certificados.plantilla', [
                'curso' => $inscrito->cursos->nombreCurso,
                'inscrito' => $inscrito,
                'codigo_certificado' => $codigo_certificado,
                'firma' => public_path('storage/firmas/firmadigital.png'),
                'logo' => public_path('storage/logos/logo.png'),
                'fecha_emision' => now()->format('d/m/Y'),
                'fecha_finalizacion' => Carbon::parse($curso->fecha_finalizacion)->format('d/m/Y'),
                'qr' => $qrPath,
                'tipo' => 'Congreso',
                'plantillaf' => $plantilla->template_front_path,
                'plantillab' => $plantilla->template_back_path,
            ]);

            // Definir la ruta donde se guardará el certificado
            $ruta_certificado = "certificados/{$id}/{$inscrito->id}.pdf";

            // Guardar el archivo en el almacenamiento
            Storage::put("public/$ruta_certificado", $pdf->output());

            // Guardar los datos en la base de datos
            Certificado::create([
                'curso_id' => $curso->id,
                'inscrito_id' => $inscrito->id,
                'codigo_certificado' => $codigo_certificado,
                'ruta_certificado' => $ruta_certificado,
            ]);

            if ($inscrito->estudiantes && $inscrito->estudiantes->email) {
                $inscrito->estudiantes->notify(new CertificadoGeneradoNotification($inscrito, $codigo_certificado));
            } else {
                Log::warning("El estudiante con ID {$inscrito->estudiante_id} no tiene un correo electrónico registrado.");
            }
        }

        return back()->with('success', 'Certificados generados correctamente.');
    }


    public function obtenerCertificado($Cursoid)
    {
        // Verificar si el usuario está autenticado
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para generar el certificado.');
        }
        $Cursoid = decrypt($Cursoid);
        // Buscar el curso
        $curso = Cursos::findOrFail($Cursoid);




        // Verificar que el curso sea de tipo "congreso"
        if ($curso->tipo != 'congreso') {
            return back()->with('error', 'No se puede generar certificados para este tipo de curso.');
        }

        if ($curso->estado != 'Certificado Disponible') {
            return back()->with('error', 'El certificado no esta Disponible.');
        }

        // Verificar que el usuario esté inscrito en el curso
        $inscrito = Inscritos::where('cursos_id', $Cursoid)
            ->where('estudiante_id', auth()->user()->id)
            ->first();

        if (!$inscrito) {
            return back()->with('error', 'No estás inscrito en este curso.');
        }

        // Verificar que el usuario no haya generado un certificado previamente
        $certificadoExistente = Certificado::where('curso_id', $Cursoid)
            ->where('inscrito_id', $inscrito->id)
            ->first();

        if ($certificadoExistente) {
            return back()->with('error', 'Ya has generado un certificado para este curso.');
        }

        // Verificar que exista una plantilla de certificado
        $plantilla = CertificateTemplate::where('curso_id', $Cursoid)->first();
        if (!$plantilla) {
            return back()->with('error', 'No se encontró la plantilla del certificado para este curso.');
        }

        // Generar código único
        $codigo_certificado = Str::uuid();

        // Generar el código QR
        $qrCode = QrCode::format('png')->size(200)->generate(route('verificar.certificado', ['codigo' => $codigo_certificado]));
        $qrPath = "certificados/{$Cursoid}/qrcode_{$inscrito->id}.png";
        Storage::put("public/$qrPath", $qrCode);

        // Crear PDF del certificado personalizado
        $pdf = Pdf::loadView('certificados.plantilla', [
            'curso' => $curso->nombreCurso,
            'inscrito' => $inscrito,
            'codigo_certificado' => $codigo_certificado,
            'firma' => public_path('storage/firmas/firmadigital.png'),
            'logo' => public_path('storage/logos/logo.png'),
            'fecha_emision' => now()->format('d/m/Y'),
            'fecha_finalizacion' => Carbon::parse($curso->fecha_finalizacion)->format('d/m/Y'),
            'qr' => $qrPath,
            'tipo' => 'Congreso',
            'plantillaf' => $plantilla->template_front_path,
            'plantillab' => $plantilla->template_back_path,
        ]);
        $pdf->setOption('dpi', 300);

        // Definir la ruta donde se guardará el certificado
        $ruta_certificado = "certificados/{$Cursoid}/{$inscrito->id}.pdf";

        // Guardar el archivo en el almacenamiento
        Storage::put("public/$ruta_certificado", $pdf->output());

        // Guardar los datos en la base de datos
        Certificado::create([
            'curso_id' => $curso->id,
            'inscrito_id' => $inscrito->id,
            'codigo_certificado' => $codigo_certificado,
            'ruta_certificado' => $ruta_certificado,
        ]);

        // Notificar al estudiante
        if ($inscrito->estudiantes && $inscrito->estudiantes->email) {
            $inscrito->estudiantes->notify(new CertificadoGeneradoNotification($inscrito, $codigo_certificado));
        } else {
            Log::warning("El estudiante con ID {$inscrito->estudiante_id} no tiene un correo electrónico registrado.");
        }

        return back()->with('success', 'Certificado generado correctamente.');
    }



    public function verificarCertificado($codigo)
    {
        // Buscar el certificado por su código único
        $certificado = Certificado::where('codigo_certificado', $codigo)->first();

        // Verificar si el certificado existe
        if (!$certificado) {
            return response()->json(['error' => 'Certificado no válido'], 404);
        }

        // Obtener la ruta del archivo PDF
        $ruta_certificado = storage_path('app/public/' . $certificado->ruta_certificado);

        // Verificar si el archivo existe
        if (!file_exists($ruta_certificado)) {
            return response()->json(['error' => 'El archivo del certificado no existe'], 404);
        }

        // Descargar el archivo PDF
        return response()->download($ruta_certificado, 'certificado.pdf');
    }
}
