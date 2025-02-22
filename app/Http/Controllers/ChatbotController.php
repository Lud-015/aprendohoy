<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\Messages\Incoming\Answer;


class ChatbotController extends Controller
{
    public function handle(Request $request)
    {
        $botman = app('botman');

        // Obtener el mensaje del usuario
        $userMessage = $request->input('message');

        // Definir respuestas del chatbot
        $botman->hears('Hola', function (BotMan $bot) {
            $bot->reply('¡Hola! ¿En qué puedo ayudarte?');
        });

        $botman->hears('Adiós', function (BotMan $bot) {
            $bot->reply('¡Adiós! Que tengas un buen día.');
        });

        $botman->hears('Como consigo mi certificado del congreso', function (BotMan $bot) {
            // Lógica para generar una respuesta
            $bot->reply('Para obtener tu certificado del congreso, debes estar inscrito en el mismo. Una vez que estés inscrito, visita la página principal del congreso y verifica que el estado esté en "Certificado Disponible". Podrás obtener el certificado a través del enlace proporcionado por el encargado. El certificado será enviado a tu correo electrónico.');
        });
        
        $botman->hears('Como vuelvo a descargar mi certificado obtenido', function (BotMan $bot) {
            // Lógica para generar una respuesta
            $bot->reply('Para volver a descargar tu certificado obtenido, puedes escanear el código QR presente en el certificado. Alternativamente, puedes acceder a tu perfil de usuario en nuestra plataforma, donde estará habilitada la opción para descargar el certificado nuevamente.');
        });
        
        // Respuesta por defecto si no se reconoce el mensaje
        $botman->fallback(function (BotMan $bot) use ($userMessage) {
            $bot->reply("Lo siento, no entendí: '$userMessage'.");
        });

        // Escuchar y responder
        $botman->listen();

        // Devolver la respuesta al frontend
        return response()->json(['reply' => $botman->getMessages()[0]->getText()]);
    }
}
