<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

spl_autoload_register(function (string $clase) {
    $ruta = __DIR__ . '/../Clases/' . $clase . '.php';
    if (is_file($ruta)) {
        require_once $ruta;
    }
});


function e($texto): string
{
    return htmlspecialchars((string) $texto, ENT_QUOTES, 'UTF-8');
}


function num(float $n, int $decimales = 4): string
{
    $txt = rtrim(rtrim(number_format($n, $decimales, '.', ''), '0'), '.');
    return ($txt === '' || $txt === '-0') ? '0' : $txt;
}


function conjunto(array $datos): string
{
    return empty($datos) ? '∅' : '{' . implode(', ', $datos) . '}';
}