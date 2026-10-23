<?php

class Nodo
{
    public string $valor;
    public ?Nodo $izq = null;
    public ?Nodo $der = null;

    public function __construct(string $valor)
    {
        $this->valor = $valor;
    }
}