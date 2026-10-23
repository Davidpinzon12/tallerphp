<?php

class Estadistica
{
    private array $datos;

    public function __construct(array $datos)
    {
        $this->datos = array_values(array_map('floatval', $datos));
    }

    public function cantidad(): int
    {
        return count($this->datos);
    }

    public function datos(): array
    {
        return $this->datos;
    }

    public function promedio(): float
    {
        return array_sum($this->datos) / $this->cantidad();
    }

    public function mediana(): float
    {
        $orden = $this->datos;
        sort($orden);
        $n = count($orden);
        $mitad = intdiv($n, 2);
        return $n % 2 === 1 ? $orden[$mitad] : ($orden[$mitad - 1] + $orden[$mitad]) / 2;
    }

    public function moda(): array
    {
        $conteo = array_count_values(array_map('strval', $this->datos));
        $max = max($conteo);
        if ($max === 1) {
            return [];
        }
        $modas = [];
        foreach ($conteo as $valor => $veces) {
            if ($veces === $max) {
                $modas[] = (float) $valor;
            }
        }
        sort($modas);
        return $modas;
    }

    public function minimo(): float
    {
        return min($this->datos);
    }

    public function maximo(): float
    {
        return max($this->datos);
    }
}