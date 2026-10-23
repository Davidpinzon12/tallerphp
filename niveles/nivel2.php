<?php
require_once __DIR__ . '/../Añadidos/ayudas.php';

$titulo = 'Nivel 2 · Secuencias';
$subtitulo = 'Secuencias';
$mision = 'Elige tu personaje, indica el número y recoge las monedas de la serie.';
$base = '../';
$claseNivel = 'nivel-2';
$nivelActual = 2;

$operacion = 'fibonacci';
$numero = '';
$error = '';
$serie = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $operacion = ($_POST['operacion'] ?? '') === 'factorial' ? 'factorial' : 'fibonacci';
    $numero = trim($_POST['numero'] ?? '');
    $maximo = $operacion === 'fibonacci' ? Secuencia::MAX_FIBONACCI : Secuencia::MAX_FACTORIAL;

    if ($numero === '' || !ctype_digit($numero)) {
        $error = 'Ingresa un número entero mayor o igual a 0.';
    } elseif ((int) $numero > $maximo) {
        $error = "Para esta operación el máximo es $maximo (más allá el número no cabe en el juego).";
    } else {
        $secuencia = new Secuencia();
        $serie = $operacion === 'fibonacci'
            ? $secuencia->fibonacci((int) $numero)
            : $secuencia->factorial((int) $numero);
    }
}

require __DIR__ . '/../Añadidos/cabecera.php';
?>
    <form class="seleccion-personaje" method="post" action="nivel2.php">
        <fieldset class="personajes">
            <legend>1. ELIGE TU PERSONAJE</legend>

            <input class="radio-oculto" type="radio" id="op-fibonacci" name="operacion" value="fibonacci"
                   <?= $operacion === 'fibonacci' ? 'checked' : '' ?>>
            <label class="tarjeta-personaje" for="op-fibonacci">
                <span class="zona-img zona-personaje personaje-1"></span>
                <span class="personaje-nombre">FIBONACCI</span>
                <span class="personaje-texto">Cada moneda suma las dos anteriores</span>
            </label>

            <input class="radio-oculto" type="radio" id="op-factorial" name="operacion" value="factorial"
                   <?= $operacion === 'factorial' ? 'checked' : '' ?>>
            <label class="tarjeta-personaje" for="op-factorial">
                <span class="zona-img zona-personaje personaje-2"></span>
                <span class="personaje-nombre">FACTORIAL</span>
                <span class="personaje-texto">Cada moneda multiplica por el siguiente</span>
            </label>
        </fieldset>

        <div class="campo-numero">
            <label for="numero">2. NÚMERO:</label>
            <input type="number" id="numero" name="numero" min="0" max="90" step="1"
                   value="<?= e($numero) ?>" placeholder="10">
            <button class="boton" type="submit">JUGAR</button>
        </div>
    </form>

    <?php if ($error): ?>
        <p class="mensaje mensaje-error">! <?= e($error) ?></p>
    <?php endif; ?>

    <?php if ($serie !== null): ?>
        <section class="pista">
            <h2 class="pista-titulo"><?= $operacion === 'fibonacci' ? 'SERIE DE FIBONACCI' : 'SERIE DE FACTORIALES' ?> · <?= count($serie) ?> MONEDAS</h2>
            <div class="monedas">
                <?php foreach ($serie as $moneda): ?>
                    <div class="moneda">
                        <span class="moneda-etiqueta"><?= e($moneda['etiqueta']) ?></span>
                        <span class="moneda-valor"><?= number_format($moneda['valor'], 0, ',', '.') ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endif; ?>
<?php require __DIR__ . '/../Añadidos/pie.php'; ?>