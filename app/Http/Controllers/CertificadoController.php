<?php

namespace App\Http\Controllers;

use App\Models\Certificado;
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
use Illuminate\Support\Facades\Log;

class CertificadoController extends Controller
{





    public function generarCertificado($id)
    {

        $inscritos = Inscritos::findOrFail($id);
        $progreso = $inscritos->progreso;
        $logoF = base64_encode(file_get_contents(base_path('public/assets/img/fund.png')));
        $logoEdin = base64_encode(file_get_contents(base_path('public/assets/img/cicstep.png')));
        $firma = base64_encode(file_get_contents(base_path('public/assets/img/firma digital.png')));

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
            'logoF'=> $logoF,
            'logoEdin'=> $logoEdin,
            'firma'=> $firma,
            'qrCode' => $qrCode
        ]);
    }


    public function generarCertificadoCongreso($id)
    {
        // Buscar el curso
        $curso = Cursos::findOrFail($id);

        // Obtener los inscritos que aún no tienen certificado
        $inscritos = Inscritos::where('cursos_id', $id)
            ->whereDoesntHave('certificado') // Verifica que no tengan un certificado aún
            ->with('estudiantes') // Cargar la relación estudiante
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

            // Guardar el código QR como archivo
            $qrPath = "certificados/{$id}/qrcode_{$inscrito->id}.png";
            Storage::put("public/$qrPath", $qrCode);

            // Crear PDF del certificado personalizado
            $pdf = Pdf::loadView('certificados.plantilla', [
                'curso' => $inscrito->cursos->nombreCurso,
                'inscrito' => $inscrito,
                'codigo_certificado' => $codigo_certificado,
                'firma' => 'storage/firmas/firmadigital.png', // Ruta de la firma digital
                'logo' => 'storage/logos/logo.png', // Ruta del logo
                'fecha_emision' => now()->format('d/m/Y'),
                'fecha_finalizacion' => Carbon::parse($curso->fecha_finalizacion)->format('d/m/Y'),
                'qr' => $qrPath, // Ruta del QR generado
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

            // Enviar notificación por correo electrónico al estudiante
            if ($inscrito->estudiantes && $inscrito->estudiantes->email) {
                $inscrito->estudiantes->notify(new CertificadoGeneradoNotification($inscrito, $codigo_certificado));
            } else {
                Log::warning("El estudiante con ID {$inscrito->estudiante_id} no tiene un correo electrónico registrado.");
            }
        }

        return back()->with('success', 'Certificados generados correctamente.');
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
