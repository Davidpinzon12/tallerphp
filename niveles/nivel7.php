<?php
require_once __DIR__ . '/../Añadidos/ayudas.php';

$titulo = 'Nivel 7 · Calculadora';
$subtitulo = 'Calculadora';
$mision = 'Dos números, una operación y una bitácora que recuerda cada jugada.';
$base = '../';
$claseNivel = 'nivel-7';
$nivelActual = 7;

$calculadora = new Calculadora();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'] ?? '';

    if ($accion === 'limpiar') {
        $calculadora->limpiar();
        $_SESSION['mensaje_calc'] = ['tipo' => 'aviso', 'texto' => 'Historial borrado.'];
    } else {
        try {
            $a = Calculadora::leerNumero($_POST['a'] ?? '');
            $b = Calculadora::leerNumero($_POST['b'] ?? '');
            $resultado = $calculadora->operar($a, $b, $_POST['operacion'] ?? '');
            $_SESSION['mensaje_calc'] = ['tipo' => 'ok', 'texto' => $resultado['texto'], 'valor' => Calculadora::formato($resultado['resultado'])];
        } catch (InvalidArgumentException $ex) {
            $_SESSION['mensaje_calc'] = ['tipo' => 'error', 'texto' => $ex->getMessage()];
        }
    }

   
    header('Location: nivel7.php');
    exit;
}

$mensaje = $_SESSION['mensaje_calc'] ?? null;
unset($_SESSION['mensaje_calc']);
$historial = $calculadora->historial();

$teclas = [
    'suma' => '+',
    'resta' => '−',
    'multiplicacion' => '×',
    'division' => '÷',
    'porcentaje' => '%',
];

require __DIR__ . '/../Añadidos/cabecera.php';
?>
    <div class="consola-calc">
        <form class="calc" method="post" action="nivel7.php">
            <div class="pantalla-calc">
                <?php if ($mensaje && $mensaje['tipo'] === 'ok'): ?>
                    <span class="pantalla-linea"><?= e($mensaje['texto']) ?></span>
                    <span class="pantalla-valor"><?= e($mensaje['valor']) ?></span>
                <?php elseif ($mensaje): ?>
                    <span class="pantalla-mensaje pantalla-<?= e($mensaje['tipo']) ?>"><?= e($mensaje['texto']) ?></span>
                <?php else: ?>
                    <span class="pantalla-linea">LISTO PARA JUGAR</span>
                    <span class="pantalla-valor">0</span>
                <?php endif; ?>
            </div>

            <div class="calc-numeros">
                <div>
                    <label for="a">A</label>
                    <input type="text" id="a" name="a" inputmode="decimal" placeholder="0" autocomplete="off">
                </div>
                <div>
                    <label for="b">B</label>
                    <input type="text" id="b" name="b" inputmode="decimal" placeholder="0" autocomplete="off">
                </div>
            </div>

            <div class="teclado">
                <?php foreach ($teclas as $valor => $simbolo): ?>
                    <input class="radio-oculto" type="radio" id="op-<?= $valor ?>" name="operacion" value="<?= $valor ?>"
                           <?= $valor === 'suma' ? 'checked' : '' ?>>
                    <label class="tecla" for="op-<?= $valor ?>" title="<?= e(ucfirst($valor)) ?>"><?= $simbolo ?></label>
                <?php endforeach; ?>
            </div>
            <p class="calc-nota">El porcentaje calcula el A% de B.</p>

            <div class="calc-acciones">
                <button class="boton boton-grande" type="submit" name="accion" value="calcular">= CALCULAR</button>
                <button class="boton boton-peligro" type="submit" name="accion" value="limpiar" formnovalidate>BORRAR HISTORIAL</button>
            </div>
        </form>

        <aside class="bitacora">
            <h2>BITÁCORA</h2>
            <?php if ($historial): ?>
                <ol class="bitacora-lista">
                    <?php foreach ($historial as $linea): ?>
                        <li><?= e($linea) ?></li>
                    <?php endforeach; ?>
                </ol>
            <?php else: ?>
                <p class="bitacora-vacia">Aún no hay jugadas.</p>
            <?php endif; ?>
        </aside>
    </div>
<?php require __DIR__ . '/../Añadidos/pie.php'; ?>