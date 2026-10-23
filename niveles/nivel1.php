<?php
require_once __DIR__ . '/../Añadidos/ayudas.php';

$titulo = 'Nivel 1 · Acrónimos';
$subtitulo = 'Acrónimos';
$mision = 'Escribe un nombre largo y la terminal lo convierte en siglas. Los guiones separan palabras.';
$base = '../';
$claseNivel = 'nivel-1';
$nivelActual = 1;

$frase = '';
$error = '';
$pares = [];
$sigla = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $frase = trim($_POST['frase'] ?? '');
    if ($frase === '') {
        $error = 'Escribe una frase para convertir.';
    } else {
        $acronimo = new Acronimo($frase);
        $pares = $acronimo->pares();
        $sigla = $acronimo->generar();
        if ($sigla === '') {
            $error = 'No encontré palabras en esa frase.';
        }
    }
}

require __DIR__ . '/../Añadidos/cabecera.php';
?>
    <section class="terminal">
        <div class="terminal-barra">
            <span class="terminal-luz"></span>
            <span class="terminal-luz"></span>
            <span class="terminal-luz"></span>
            <span class="terminal-nombre">ACRONIMO.EXE</span>
        </div>

        <form class="terminal-form" method="post" action="nivel1.php">
            <label class="terminal-prompt" for="frase">&gt; FRASE:</label>
            <input class="terminal-entrada" type="text" id="frase" name="frase"
                   value="<?= e($frase) ?>" placeholder="Portable Network Graphics" autocomplete="off">
            <button class="boton" type="submit">EJECUTAR</button>
        </form>

        <?php if ($error): ?>
            <p class="mensaje mensaje-error">! <?= e($error) ?></p>
        <?php endif; ?>

        <?php if ($sigla !== ''): ?>
            <div class="fichas">
                <?php foreach ($pares as $par): ?>
                    <div class="ficha">
                        <span class="ficha-letra"><?= e($par[0]) ?></span>
                        <span class="ficha-palabra"><?= e($par[1]) ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
            <p class="marcador-etiqueta">RESULTADO</p>
            <p class="marcador"><?= e($sigla) ?></p>
        <?php endif; ?>

        <ul class="terminal-ayuda">
            <li>As Soon As Possible → ASAP</li>
            <li>Liquid-crystal display → LCD</li>
            <li>Thank George It's Friday! → TGIF</li>
        </ul>
    </section>
<?php require __DIR__ . '/../Añadidos/pie.php'; ?>