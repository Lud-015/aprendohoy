<?php

namespace App\Services;

use BotMan\BotMan\BotMan;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class BotManService
{
    protected $botman;

    public function __construct(BotMan $botman)
    {
        $this->botman = $botman;
    }

    public function handle()
    {
        $this->registerCommands();
        $this->botman->listen();
    }

    protected function registerCommands()
    {
        $this->botman->hears('(hola|buenos días|buenas tardes|buenas noches|saludos|hey)', function (BotMan $bot) {
            $this->handleGreeting($bot);
        });

        $this->botman->hears('(certificado|certificados|congreso|diploma|constancia|acreditación)', function (BotMan $bot) {
            $this->handleCertificates($bot);
        });

        $this->botman->hears('(iniciar sesion|acceder|mi cuenta)', function (BotMan $bot) {
            $this->handleLogin($bot);
        });

        // Agregar más comandos aquí...
    }

    protected function handleGreeting(BotMan $bot)
    {
        $bot->reply('¡Hola! Soy el asistente virtual de la plataforma. ¿En qué puedo ayudarte hoy?');
        $bot->reply('Puedes preguntarme sobre: certificados, inscripciones, pagos, programación de eventos, o soporte técnico.');
    }

    protected function handleCertificates(BotMan $bot)
    {
        $bot->reply('Sobre los certificados de congresos:');
        $bot->reply('1️⃣ Debes estar inscrito y haber completado los requisitos de asistencia.');
        $bot->reply('2️⃣ Los certificados se habilitan cuando el estado cambia a "Certificado Disponible" en la página del congreso.');
        $bot->reply('3️⃣ Recibirás una notificación por correo electrónico cuando esté listo.');
        $bot->reply('4️⃣ ¿Necesitas ayuda adicional con algún certificado específico?');
    }

    protected function handleLogin(BotMan $bot)
    {
        $loginUrl = route('login');
        $bot->reply('Para acceder a tu cuenta:');
        $bot->reply("1️⃣ Puedes iniciar sesión directamente <a href='$loginUrl'>aquí</a>.");
        $bot->reply("2️⃣ O si prefieres, puedo ayudarte con el proceso paso a paso.");

        $question = Question::create('¿Cómo prefieres continuar?')
            ->fallback('No se pudo mostrar las opciones')
            ->callbackId('login_options')
            ->addButtons([
                Button::create('Ir a la página de login')->value('redirect'),
                Button::create('Ayúdame con el proceso')->value('help'),
            ]);

        $bot->ask($question, function (Answer $answer, BotMan $bot) use ($loginUrl) {
            if ($answer->isInteractiveMessageReply()) {
                if ($answer->getValue() === 'redirect') {
                    $bot->reply("Te redirijo a la página de inicio de sesión: <a href='$loginUrl'>Iniciar sesión</a>");
                } else {
                    $bot->ask('Por favor, introduce tu correo electrónico:', function (Answer $answer, BotMan $bot) {
                        $email = $answer->getText();

                        $bot->userStorage()->save([
                            'email' => $email,
                        ]);

                        $bot->ask('Ahora, introduce tu contraseña:', function (Answer $answer, BotMan $bot) {
                            $password = $answer->getText();

                            try {
                                if ($this->validateCredentials($bot->userStorage()->find()['email'], $password)) {
                                    $bot->reply('¡Inicio de sesión exitoso! Bienvenido.');
                                    $bot->reply('¿En qué más puedo ayudarte hoy?');
                                } else {
                                    $bot->reply('Correo electrónico o contraseña incorrectos. Por favor, intenta de nuevo o usa la opción "Olvidé mi contraseña" en la página de inicio de sesión.');
                                }
                            } catch (\Exception $e) {
                                $bot->reply('Lo siento, ocurrió un error al intentar iniciar sesión. Por favor, intenta más tarde o contacta a soporte técnico.');
                                Log::error('Error en inicio de sesión del bot: ' . $e->getMessage());
                            }
                        });
                    });
                }
            }
        });
    }

    protected function validateCredentials($email, $password)
    {
        try {
            // Implementación de la autenticación
            // Por ejemplo, usando Auth::attempt() de Laravel
            return Auth::attempt([
                'email' => $email,
                'password' => $password
            ]);
        } catch (\Exception $e) {
            Log::error('Error validando credenciales: ' . $e->getMessage());
            return false;
        }
    }
    // Agregar más métodos para manejar otros comandos...
}
