<?php
require_once __DIR__ . '/../Añadidos/ayudas.php';

$titulo = 'Nivel 3 · Inventario';
$subtitulo = 'Inventario';
$mision = 'Primero dime cuántas casillas necesitas, luego llénalas con números reales.';
$base = '../';
$claseNivel = 'nivel-3';
$nivelActual = 3;

const MAX_CASILLAS = 30;

$cantidad = null;
$valores = [];
$error = '';
$estadistica = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['valores']) && is_array($_POST['valores'])) {
        // Paso 2: llegaron los números.
        $valores = array_map(fn($v) => trim((string) $v), $_POST['valores']);
        $cantidad = count($valores);
        $numeros = [];

        if ($cantidad < 1 || $cantidad > MAX_CASILLAS) {
            $error = 'Cantidad de casillas no válida.';
        } else {
            foreach ($valores as $indice => $valor) {
                $limpio = str_replace(',', '.', $valor);
                if ($limpio === '' || !is_numeric($limpio)) {
                    $error = 'La casilla ' . ($indice + 1) . ' no tiene un número válido.';
                    break;
                }
                $numeros[] = (float) $limpio;
            }
            if ($error === '') {
                $estadistica = new Estadistica($numeros);
            }
        }
    } else {
        // Paso 1: llegó la cantidad.
        $texto = trim($_POST['cantidad'] ?? '');
        if (ctype_digit($texto) && (int) $texto >= 1 && (int) $texto <= MAX_CASILLAS) {
            $cantidad = (int) $texto;
        } else {
            $error = 'Elige una cantidad entre 1 y ' . MAX_CASILLAS . '.';
        }
    }
}

require __DIR__ . '/../Añadidos/cabecera.php';
?>
    <section class="panel-juego">
        <form class="fila-cantidad" method="post" action="nivel3.php">
            <label for="cantidad">CASILLAS (1-<?= MAX_CASILLAS ?>):</label>
            <input type="number" id="cantidad" name="cantidad" min="1" max="<?= MAX_CASILLAS ?>"
                   value="<?= $cantidad ? (int) $cantidad : '' ?>" placeholder="5">
            <button class="boton" type="submit">ABRIR INVENTARIO</button>
        </form>

        <?php if ($error): ?>
            <p class="mensaje mensaje-error">! <?= e($error) ?></p>
        <?php endif; ?>
    </section>

    <?php if ($cantidad && $estadistica === null && ($error === '' || $valores)): ?>
        <form class="inventario" method="post" action="nivel3.php">
            <h2 class="inventario-titulo">TU INVENTARIO</h2>
            <div class="casillas">
                <?php for ($i = 0; $i < $cantidad; $i++): ?>
                    <div class="casilla">
                        <label for="v<?= $i ?>"><?= $i + 1 ?></label>
                        <input type="text" id="v<?= $i ?>" name="valores[]" inputmode="decimal"
                               value="<?= e($valores[$i] ?? '') ?>" placeholder="0.0">
                    </div>
                <?php endfor; ?>
            </div>
            <button class="boton boton-grande" type="submit">CALCULAR</button>
        </form>
    <?php endif; ?>

    <?php if ($estadistica !== null): ?>
        <section class="inventario">
            <h2 class="inventario-titulo">BOTÍN FINAL</h2>
            <div class="casillas casillas-llenas">
                <?php foreach ($estadistica->datos() as $i => $dato): ?>
                    <div class="casilla casilla-llena">
                        <span class="casilla-indice"><?= $i + 1 ?></span>
                        <span class="casilla-dato"><?= e(num($dato)) ?></span>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="trofeos">
                <article class="trofeo">
                    <h3>PROMEDIO</h3>
                    <p class="trofeo-valor"><?= e(num($estadistica->promedio())) ?></p>
                    <p class="trofeo-nota">media aritmética</p>
                </article>
                <article class="trofeo">
                    <h3>MEDIANA</h3>
                    <p class="trofeo-valor"><?= e(num($estadistica->mediana())) ?></p>
                    <p class="trofeo-nota">valor central ordenado</p>
                </article>
                <article class="trofeo">
                    <h3>MODA</h3>
                    <?php $modas = $estadistica->moda(); ?>
                    <?php if ($modas): ?>
                        <p class="trofeo-valor"><?= e(implode(' · ', array_map('num', $modas))) ?></p>
                        <p class="trofeo-nota">el que más se repite</p>
                    <?php else: ?>
                        <p class="trofeo-valor">—</p>
                        <p class="trofeo-nota">ningún valor se repite</p>
                    <?php endif; ?>
                </article>
            </div>
            <p class="trofeo-resumen">
                <?= $estadistica->cantidad() ?> datos · mínimo <?= e(num($estadistica->minimo())) ?> · máximo <?= e(num($estadistica->maximo())) ?>
            </p>
        </section>
    <?php endif; ?>
<?php require __DIR__ . '/../Añadidos/pie.php'; ?>