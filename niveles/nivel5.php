<?php
require_once __DIR__ . '/../Añadidos/ayudas.php';

$titulo = 'Nivel 5 · Interruptores';
$subtitulo = 'Interruptores';
$mision = 'Ingresa un entero y mira cómo se encienden los bits del panel.';
$base = '../';
$claseNivel = 'nivel-5';
$nivelActual = 5;

const LIMITE_BINARIO = 1000000000;

$entrada = '';
$error = '';
$conversor = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $entrada = trim($_POST['numero'] ?? '');
    if (!preg_match('/^-?\d+$/', $entrada)) {
        $error = 'Ingresa un número entero (sin decimales).';
    } elseif (abs((int) $entrada) > LIMITE_BINARIO) {
        $error = 'Usa un número entre -' . number_format(LIMITE_BINARIO, 0, ',', '.') . ' y ' . number_format(LIMITE_BINARIO, 0, ',', '.') . '.';
    } else {
        $conversor = new ConversorBinario((int) $entrada);
    }
}

require __DIR__ . '/../Añadidos/cabecera.php';
?>
    <form class="panel-control" method="post" action="nivel5.php">
        <label for="numero">ENTERO DECIMAL</label>
        <input type="text" id="numero" name="numero" inputmode="numeric"
               value="<?= e($entrada) ?>" placeholder="42" autocomplete="off">
        <button class="boton" type="submit">ENCENDER</button>
    </form>

    <?php if ($error): ?>
        <p class="mensaje mensaje-error">! <?= e($error) ?></p>
    <?php endif; ?>

    <?php if ($conversor !== null): ?>
        <section class="tablero-leds">
            <p class="marcador-etiqueta"><?= e($entrada) ?> EN BINARIO</p>
            <p class="marcador marcador-binario"><?= e($conversor->binario()) ?></p>

            <div class="banco-leds">
                <?php foreach (array_chunk($conversor->bitsEnBytes(), 8) as $byte): ?>
                    <div class="byte">
                        <?php foreach ($byte as $bit): ?>
                            <span class="led <?= $bit ? 'led-encendido' : 'led-apagado' ?>"><?= $bit ?></span>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php if ($conversor->esNegativo()): ?>
                <p class="nota-leds">El panel muestra la magnitud; el signo menos va delante del resultado.</p>
            <?php endif; ?>

            <table class="tabla-pasos">
                <caption>DIVISIONES SUCESIVAS ENTRE 2</caption>
                <thead>
                    <tr><th>Dividendo</th><th>Cociente</th><th>Residuo</th></tr>
                </thead>
                <tbody>
                    <?php foreach ($conversor->pasos() as $paso): ?>
                        <tr>
                            <td><?= $paso['dividendo'] ?></td>
                            <td><?= $paso['cociente'] ?></td>
                            <td><?= $paso['residuo'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    <?php endif; ?>
<?php require __DIR__ . '/../Añadidos/pie.php'; ?>