<?php

class Calculadora
{
    private const CLAVE = 'historial_calculadora';

    public function __construct()
    {
        if (!isset($_SESSION[self::CLAVE])) {
            $_SESSION[self::CLAVE] = [];
        }
    }

    public static function leerNumero(string $texto): float
    {
        $texto = trim(str_replace(',', '.', $texto));
        if ($texto === '' || !is_numeric($texto)) {
            throw new InvalidArgumentException('Ingresa números válidos (enteros o decimales).');
        }
        return (float) $texto;
    }

    public function operar(float $a, float $b, string $operacion): array
    {
        switch ($operacion) {
            case 'suma':
                $resultado = $a + $b;
                $texto = self::formato($a) . ' + ' . self::formato($b);
                break;
            case 'resta':
                $resultado = $a - $b;
                $texto = self::formato($a) . ' − ' . self::formato($b);
                break;
            case 'multiplicacion':
                $resultado = $a * $b;
                $texto = self::formato($a) . ' × ' . self::formato($b);
                break;
            case 'division':
                if ($b == 0) {
                    throw new InvalidArgumentException('No se puede dividir entre cero.');
                }
                $resultado = $a / $b;
                $texto = self::formato($a) . ' ÷ ' . self::formato($b);
                break;
            case 'porcentaje':
                $resultado = $a / 100 * $b;
                $texto = self::formato($a) . '% de ' . self::formato($b);
                break;
            default:
                throw new InvalidArgumentException('Elige una operación.');
        }

        $resultado = round($resultado, 10);
        $texto .= ' = ' . self::formato($resultado);
        $_SESSION[self::CLAVE][] = $texto;
        return ['resultado' => $resultado, 'texto' => $texto];
    }

    public function historial(): array
    {
        return array_reverse($_SESSION[self::CLAVE]);
    }

    public function limpiar(): void
    {
        $_SESSION[self::CLAVE] = [];
    }

    public static function formato(float $n): string
    {
        $s = rtrim(rtrim(number_format($n, 8, '.', ''), '0'), '.');
        return ($s === '' || $s === '-0') ? '0' : $s;
    }
}