<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\Drivers\DriverManager;

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

        // Captura todas las demás entradas
        $botman->fallback(function(BotMan $bot) {
            $bot->reply('Lo siento, no entendí tu mensaje.');
        });

        // Ejecuta el bot
        $botman->listen();
    }
}
