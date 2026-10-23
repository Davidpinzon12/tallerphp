<?php

class ArbolBinario
{
    private ?Nodo $raiz = null;
    private bool $ambiguo = false;
    private string $metodo = '';

    public static function parsear(string $texto): array
    {
        $texto = str_replace(['→', '-', '>'], ' ', $texto);
        return preg_split('/[\s,;]+/u', trim($texto), -1, PREG_SPLIT_NO_EMPTY);
    }

    public function construir(array $pre, array $in, array $post): void
    {
        if ($pre && $in) {
            $this->validar($pre, $in);
            $this->metodo = 'preorden + inorden';
            $this->raiz = $this->desdePreIn($pre, $in);
        } elseif ($in && $post) {
            $this->validar($in, $post);
            $this->metodo = 'inorden + postorden';
            $this->raiz = $this->desdePostIn($post, $in);
        } elseif ($pre && $post) {
            $this->validar($pre, $post);
            $this->metodo = 'preorden + postorden';
            $this->raiz = $this->desdePrePost($pre, $post);
        } else {
            throw new InvalidArgumentException('Ingresa al menos dos recorridos.');
        }

        if (($pre && $this->preorden() !== $pre)
            || ($in && $this->inorden() !== $in)
            || ($post && $this->postorden() !== $post)) {
            throw new InvalidArgumentException('Esos recorridos no pertenecen al mismo árbol.');
        }
    }

    private function validar(array $a, array $b): void
    {
        if (count($a) !== count($b)) {
            throw new InvalidArgumentException('Los recorridos deben tener la misma cantidad de nodos.');
        }
        if (count(array_unique($a)) !== count($a) || count(array_unique($b)) !== count($b)) {
            throw new InvalidArgumentException('Los nodos no pueden repetirse dentro de un recorrido.');
        }
        $x = $a;
        $y = $b;
        sort($x);
        sort($y);
        if ($x !== $y) {
            throw new InvalidArgumentException('Los recorridos deben usar exactamente los mismos nodos.');
        }
    }

    private function desdePreIn(array $pre, array $in): ?Nodo
    {
        if (!$pre) {
            return null;
        }
        $nodo = new Nodo($pre[0]);
        $pos = array_search($pre[0], $in, true);
        $izqIn = array_slice($in, 0, $pos);
        $derIn = array_slice($in, $pos + 1);
        $nodo->izq = $this->desdePreIn(array_slice($pre, 1, count($izqIn)), $izqIn);
        $nodo->der = $this->desdePreIn(array_slice($pre, 1 + count($izqIn)), $derIn);
        return $nodo;
    }

    private function desdePostIn(array $post, array $in): ?Nodo
    {
        if (!$post) {
            return null;
        }
        $raiz = $post[count($post) - 1];
        $nodo = new Nodo($raiz);
        $pos = array_search($raiz, $in, true);
        $izqIn = array_slice($in, 0, $pos);
        $derIn = array_slice($in, $pos + 1);
        $nodo->izq = $this->desdePostIn(array_slice($post, 0, count($izqIn)), $izqIn);
        $nodo->der = $this->desdePostIn(array_slice($post, count($izqIn), count($derIn)), $derIn);
        return $nodo;
    }

    private function desdePrePost(array $pre, array $post): ?Nodo
    {
        if (!$pre) {
            return null;
        }
        $nodo = new Nodo($pre[0]);
        if (count($pre) === 1) {
            return $nodo;
        }
        $tamIzq = array_search($pre[1], $post, true) + 1;
        $tamDer = count($pre) - 1 - $tamIzq;
        if ($tamDer === 0) {
            $this->ambiguo = true;
        }
        $nodo->izq = $this->desdePrePost(array_slice($pre, 1, $tamIzq), array_slice($post, 0, $tamIzq));
        $nodo->der = $this->desdePrePost(array_slice($pre, 1 + $tamIzq), array_slice($post, $tamIzq, $tamDer));
        return $nodo;
    }

    public function preorden(): array
    {
        $salida = [];
        $this->recorrer($this->raiz, 'pre', $salida);
        return $salida;
    }

    public function inorden(): array
    {
        $salida = [];
        $this->recorrer($this->raiz, 'in', $salida);
        return $salida;
    }

    public function postorden(): array
    {
        $salida = [];
        $this->recorrer($this->raiz, 'post', $salida);
        return $salida;
    }

    private function recorrer(?Nodo $nodo, string $tipo, array &$salida): void
    {
        if ($nodo === null) {
            return;
        }
        if ($tipo === 'pre') {
            $salida[] = $nodo->valor;
        }
        $this->recorrer($nodo->izq, $tipo, $salida);
        if ($tipo === 'in') {
            $salida[] = $nodo->valor;
        }
        $this->recorrer($nodo->der, $tipo, $salida);
        if ($tipo === 'post') {
            $salida[] = $nodo->valor;
        }
    }

    public function metodo(): string
    {
        return $this->metodo;
    }

    public function esAmbiguo(): bool
    {
        return $this->ambiguo;
    }

    public function html(): string
    {
        if ($this->raiz === null) {
            return '';
        }
        return '<ul class="arbol">' . $this->htmlNodo($this->raiz) . '</ul>';
    }

    private function htmlNodo(Nodo $nodo): string
    {
        $h = '<li><span class="nodo-arbol">' . htmlspecialchars($nodo->valor, ENT_QUOTES, 'UTF-8') . '</span>';
        if ($nodo->izq || $nodo->der) {
            $h .= '<ul>';
            $h .= $nodo->izq ? $this->htmlNodo($nodo->izq) : '<li class="hueco"></li>';
            $h .= $nodo->der ? $this->htmlNodo($nodo->der) : '<li class="hueco"></li>';
            $h .= '</ul>';
        }
        return $h . '</li>';
    }
}