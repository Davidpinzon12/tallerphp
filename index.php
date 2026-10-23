<?php
require_once __DIR__ . '/Añadidos/ayudas.php';

$titulo = 'Menú principal';
$base = '';
$claseNivel = 'pagina-menu';
$nivelActual = null;

$listaNiveles = require __DIR__ . '/Añadidos/niveles.php';

require __DIR__ . '/Añadidos/cabecera.php';
?>
    <section class="hero">
        <div class="zona-img zona-hero"></div>
        <h1 class="hero-titulo">ELIGE TU CARTUCHO</h1>
        <p class="hero-texto">Siete niveles, siete algoritmos. Entra a uno y empieza a jugar.</p>
    </section>

    <section class="estante">
        <?php foreach ($listaNiveles as $numero => $nivel): ?>
            <a class="cartucho cartucho-<?= $numero ?>" href="niveles/nivel<?= $numero ?>.php">
                <span class="cartucho-numero">LVL <?= $numero ?></span>
                <span class="zona-img zona-icono"></span>
                <span class="cartucho-nombre"><?= e($nivel['nombre']) ?></span>
                <span class="cartucho-texto"><?= e($nivel['texto']) ?></span>
                <span class="cartucho-jugar">▶ JUGAR</span>
            </a>
        <?php endforeach; ?>
    </section>
<?php require __DIR__ . '/Añadidos/pie.php'; ?>