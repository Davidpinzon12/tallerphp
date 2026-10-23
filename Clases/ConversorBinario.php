<?php

class ConversorBinario
{
    private int $numero;

    public function __construct(int $numero)
    {
        $this->numero = $numero;
    }

    public function pasos(): array
    {
        $n = abs($this->numero);
        if ($n === 0) {
            return [['dividendo' => 0, 'cociente' => 0, 'residuo' => 0]];
        }
        $pasos = [];
        while ($n > 0) {
            $cociente = intdiv($n, 2);
            $pasos[] = ['dividendo' => $n, 'cociente' => $cociente, 'residuo' => $n % 2];
            $n = $cociente;
        }
        return $pasos;
    }

    public function bits(): array
    {
        $residuos = array_column($this->pasos(), 'residuo');
        return array_reverse($residuos);
    }

    public function binario(): string
    {
        $signo = $this->numero < 0 ? '-' : '';
        return $signo . implode('', $this->bits());
    }

    public function bitsEnBytes(): array
    {
        $bits = $this->bits();
        $relleno = (8 - count($bits) % 8) % 8;
        return array_merge(array_fill(0, $relleno, 0), $bits);
    }

    public function esNegativo(): bool
    {
        return $this->numero < 0;
    }
}