<?php
require_once __DIR__ . '/../Añadidos/ayudas.php';

$titulo = 'Nivel 4 · Conjuntos';
$subtitulo = 'Conjuntos';
$mision = 'Dos equipos, dos listas de enteros. Mira qué comparten y qué los diferencia.';
$base = '../';
$claseNivel = 'nivel-4';
$nivelActual = 4;

$textoA = '';
$textoB = '';
$error = '';
$conjuntos = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $textoA = trim($_POST['conjunto_a'] ?? '');
    $textoB = trim($_POST['conjunto_b'] ?? '');
    $a = Conjuntos::desdeTexto($textoA);
    $b = Conjuntos::desdeTexto($textoB);

    if ($a === null || $b === null) {
        $error = 'Solo se permiten números enteros separados por comas o espacios.';
    } elseif (!$a && !$b) {
        $error = 'Escribe números en al menos un conjunto.';
    } else {
        $conjuntos = new Conjuntos($a, $b);
    }
}

require __DIR__ . '/../Añadidos/cabecera.php';
?>
    <form class="arena" method="post" action="nivel4.php">
        <div class="equipo equipo-a">
            <label for="conjunto_a">EQUIPO A</label>
            <textarea id="conjunto_a" name="conjunto_a" rows="4" placeholder="1, 2, 3, 4, 5"><?= e($textoA) ?></textarea>
        </div>

        <div class="arena-centro">
            <span class="versus">VS</span>
            <button class="boton boton-grande" type="submit">COMPARAR</button>
        </div>

        <div class="equipo equipo-b">
            <label for="conjunto_b">EQUIPO B</label>
            <textarea id="conjunto_b" name="conjunto_b" rows="4" placeholder="4, 5, 6, 7"><?= e($textoB) ?></textarea>
        </div>
    </form>

    <?php if ($error): ?>
        <p class="mensaje mensaje-error">! <?= e($error) ?></p>
    <?php endif; ?>

    <?php if ($conjuntos !== null): ?>
        <section class="marcador-conjuntos">
            <p class="conjunto-lectura">A = <?= e(conjunto($conjuntos->a())) ?></p>
            <p class="conjunto-lectura">B = <?= e(conjunto($conjuntos->b())) ?></p>
        </section>

        <section class="resultados-conjuntos">
            <article class="resultado resultado-union">
                <h3>UNIÓN <small>A ∪ B</small></h3>
                <p><?= e(conjunto($conjuntos->union())) ?></p>
            </article>
            <article class="resultado resultado-inter">
                <h3>INTERSECCIÓN <small>A ∩ B</small></h3>
                <p><?= e(conjunto($conjuntos->interseccion())) ?></p>
            </article>
            <article class="resultado resultado-ab">
                <h3>DIFERENCIA <small>A − B</small></h3>
                <p><?= e(conjunto($conjuntos->diferenciaAB())) ?></p>
            </article>
            <article class="resultado resultado-ba">
                <h3>DIFERENCIA <small>B − A</small></h3>
                <p><?= e(conjunto($conjuntos->diferenciaBA())) ?></p>
            </article>
        </section>
    <?php endif; ?>
<?php require __DIR__ . '/../Añadidos/pie.php'; ?>