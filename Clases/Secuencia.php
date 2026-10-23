<?php

class Secuencia
{
    public const MAX_FIBONACCI = 90;
    public const MAX_FACTORIAL = 20;

    public function fibonacci(int $n): array
    {
        $serie = [];
        $anterior = 0;
        $actual = 1;
        for ($i = 0; $i <= $n; $i++) {
            $serie[] = ['etiqueta' => "F($i)", 'valor' => $anterior];
            [$anterior, $actual] = [$actual, $anterior + $actual];
        }
        return $serie;
    }

    public function factorial(int $n): array
    {
        $serie = [];
        $acumulado = 1;
        for ($i = 0; $i <= $n; $i++) {
            if ($i > 1) {
                $acumulado *= $i;
            }
            $serie[] = ['etiqueta' => "$i!", 'valor' => $acumulado];
        }
        return $serie;
    }
}