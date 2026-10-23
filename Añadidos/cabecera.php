<?php

$titulo      = isset($titulo) ? $titulo : 'Arcade de Algoritmos';
$base        = isset($base) ? $base : '';
$claseNivel  = isset($claseNivel) ? $claseNivel : 'pagina-menu';
$nivelActual = isset($nivelActual) ? $nivelActual : null;
$subtitulo   = isset($subtitulo) ? $subtitulo : '';
$mision      = isset($mision) ? $mision : '';

$prefijoNiveles = $base === '' ? 'niveles/' : '';

$listaNiveles = require __DIR__ . '/niveles.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($titulo) ?> | Arcade de Algoritmos</title>
    <link rel="stylesheet" href="<?= $base ?>css/diseno.css">
</head>
<body class="<?= e($claseNivel) ?>">

<header class="barra-superior">
    <div class="zona-img zona-logo"></div>
    <a class="titulo-juego" href="<?= $base ?>index.php">ARCADE <span>ALGORITMOS</span></a>
    <nav class="selector-niveles" aria-label="Menú de niveles">
        <a class="boton-menu" href="<?= $base ?>index.php">MENÚ</a>
        <?php foreach ($listaNiveles as $numero => $nivel): ?>
            <a class="boton-nivel<?= $numero === $nivelActual ? ' activo' : '' ?>"
               href="<?= $prefijoNiveles ?>nivel<?= $numero ?>.php"
               title="<?= e($nivel['nombre']) ?>"><?= $numero ?></a>
        <?php endforeach; ?>
    </nav>
</header>

<main class="escenario">
    <div class="zona-img zona-lateral-izq"></div>
    <div class="zona-img zona-lateral-der"></div>

<?php if ($nivelActual): ?>
    <section class="encabezado-nivel">
        <div class="zona-img zona-mascota"></div>
        <div class="encabezado-texto">
            <p class="etiqueta-nivel">NIVEL <?= (int) $nivelActual ?></p>
            <h1><?= e($subtitulo) ?></h1>
            <p class="mision"><?= e($mision) ?></p>
        </div>
    </section>
<?php endif; ?>