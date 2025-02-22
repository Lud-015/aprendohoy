<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\BotMan\Messages\Incoming\Answer;

class BotManController extends Controller
{
    public function handle(Request $request)
    {
        // Inicializar BotMan con el driver web
        DriverManager::loadDriver(\BotMan\Drivers\Web\WebDriver::class);
        $botman = app('botman');

        // Define una respuesta simple
        $botman->hears('hola', function (BotMan $bot) {
            $bot->reply('¡Hola! ¿En qué puedo ayudarte?');
        });

        $botman->hears('certificado|certificados|congreso', function (BotMan $bot) {
            $bot->reply('Para obtener tu certificado del congreso, debes estar inscrito en el mismo. Una vez que estés inscrito, visita la página principal del congreso y verifica que el estado esté en "Certificado Disponible". Podrás obtener el certificado a través del enlace proporcionado por el encargado. El certificado será enviado a tu correo electrónico.');

        });

        $botman->hears('inscribo|inscribirme|inscripción|quiero inscribirme|registrarme', function (BotMan $bot) {
            $url = route('lista.cursos.congresos');
            $bot->reply("Para inscribirse a un congreso puedes ir a la lista de cursos y buscar el curso o congreso al que desees incribirte, <a href='$url'>haz clic aquí</a>.");
        });

        $botman->hears('iniciar sesion|', function (BotMan $bot) {
            $bot->reply('¡Hola! Para acceder a nuestros cursos y congresos, por favor, inicia sesión.');
        
            // Preguntar por el correo electrónico
            $bot->ask('Por favor, introduce tu correo electrónico:', function (Answer $answer, BotMan $bot) {
                $email = $answer->getText();
        
                // Guardar el correo electrónico en la sesión
                $bot->userStorage()->save([
                    'email' => $email,
                ]);
        
                // Preguntar por la contraseña
                $bot->ask('Ahora, introduce tu contraseña:', function (Answer $answer, BotMan $bot) {
                    $password = $answer->getText();
        
                    // Aquí puedes agregar la lógica para validar el correo y la contraseña
                    $user = $bot->userStorage()->find();
        
                    if ($this->validateCredentials($user['email'], $password)) {
                        $bot->reply('¡Inicio de sesión exitoso! Bienvenido.');
                    } else {
                        $bot->reply('Correo electrónico o contraseña incorrectos. Por favor, intenta de nuevo.');
                    }
                });
            });
        });

        $botman->hears('Como vuelvo a descargar mi certificado obtenido', function (BotMan $bot) {
            // Lógica para generar una respuesta
            $bot->reply('Para volver a descargar tu certificado obtenido, puedes escanear el código QR presente en el certificado. Alternativamente, puedes acceder a tu perfil de usuario en nuestra plataforma, donde estará habilitada la opción para descargar el certificado nuevamente.');
        });

        // Captura todas las demás entradas
        $botman->fallback(function(BotMan $bot) {
            $bot->reply('Lo siento, no entendí tu mensaje.');
        });

        // Ejecuta el bot
        $botman->listen();
    }
}
