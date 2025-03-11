<?php


use BotMan\BotMan\BotMan;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\Drivers\Web\WebDriver;

DriverManager::loadDriver(WebDriver::class);

$botman = resolve('botman');

$botman->hears('redirect', function (BotMan $bot) {
    $bot->reply("Te redirijo a la página de inicio de sesión: <a href='/login'>Iniciar sesión</a>");
});

$botman->hears('help', function (BotMan $bot) {
    $bot->reply("Vamos a iniciar el proceso de ayuda paso a paso...");
});
