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
        $qrCode = base64_encode(QrCode::format('png')->size(100)->generate($codigo));

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


    public function validarCertificado($codigo)
    {
        $certificado = Certificado::where('codigo_certificado', $codigo)->first();

        if (!$certificado) {
            return response()->json(['error' => 'Certificado no válido'], 404);
        }

        return response()->json([
            'curso' => $certificado->curso->titulo,
            'estudiante' => $certificado->estudiante->name,
            'fecha_emision' => $certificado->fecha_emision,
        ]);
    }
}
