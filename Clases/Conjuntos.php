<?php

class Conjuntos
{
    private array $a;
    private array $b;

    public function __construct(array $a, array $b)
    {
        $this->a = self::depurar($a);
        $this->b = self::depurar($b);
    }

    private static function depurar(array $datos): array
    {
        $datos = array_values(array_unique($datos));
        sort($datos);
        return $datos;
    }

    public static function desdeTexto(string $texto): ?array
    {
        $texto = trim(str_replace(['{', '}'], '', $texto));
        if ($texto === '') {
            return [];
        }
        if (!preg_match('/^[\s,;\d-]+$/', $texto)) {
            return null;
        }
        preg_match_all('/-?\d+/', $texto, $coincidencias);
        return array_map('intval', $coincidencias[0]);
    }

    public function a(): array
    {
        return $this->a;
    }

    public function b(): array
    {
        return $this->b;
    }

    public function union(): array
    {
        return self::depurar(array_merge($this->a, $this->b));
    }

    public function interseccion(): array
    {
        return array_values(array_intersect($this->a, $this->b));
    }

    public function diferenciaAB(): array
    {
        return array_values(array_diff($this->a, $this->b));
    }

    public function diferenciaBA(): array
    {
        return array_values(array_diff($this->b, $this->a));
    }
}