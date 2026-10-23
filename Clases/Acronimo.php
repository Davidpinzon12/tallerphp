<?php

class Acronimo
{
    private string $frase;

    public function __construct(string $frase)
    {
        $this->frase = $frase;
    }

    public function palabras(): array
    {
        $limpia = str_replace(['-', '–', '—'], ' ', $this->frase);
        $limpia = preg_replace('/[^\p{L}\p{N}\s]/u', '', $limpia);
        return preg_split('/\s+/u', trim($limpia), -1, PREG_SPLIT_NO_EMPTY);
    }

    public function pares(): array
    {
        $pares = [];
        foreach ($this->palabras() as $palabra) {
            $pares[] = [mb_strtoupper(mb_substr($palabra, 0, 1)), $palabra];
        }
        return $pares;
    }

    public function generar(): string
    {
        $letras = '';
        foreach ($this->pares() as $par) {
            $letras .= $par[0];
        }
        return $letras;
    }
}