<?php
require_once __DIR__ . '/../Añadidos/ayudas.php';

$titulo = 'Nivel 6 · Bosque';
$subtitulo = 'Bosque';
$mision = 'Entrega al menos dos recorridos y planta el árbol binario. Si das los tres, usaré preorden + inorden.';
$base = '../';
$claseNivel = 'nivel-6';
$nivelActual = 6;

$textos = ['pre' => '', 'in' => '', 'post' => ''];
$error = '';
$arbol = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($textos as $clave => $_) {
        $textos[$clave] = trim($_POST[$clave] ?? '');
    }
    $pre = ArbolBinario::parsear($textos['pre']);
    $in = ArbolBinario::parsear($textos['in']);
    $post = ArbolBinario::parsear($textos['post']);

    try {
        $arbol = new ArbolBinario();
        $arbol->construir($pre, $in, $post);
    } catch (InvalidArgumentException $ex) {
        $error = $ex->getMessage();
        $arbol = null;
    }
}

require __DIR__ . '/../Añadidos/cabecera.php';
?>
    <form class="mapa-recorridos" method="post" action="nivel6.php">
        <div class="pergamino">
            <label for="pre">PREORDEN</label>
            <input type="text" id="pre" name="pre" value="<?= e($textos['pre']) ?>" placeholder="A → B → D → E → C" autocomplete="off">
        </div>
        <div class="pergamino">
            <label for="in">INORDEN</label>
            <input type="text" id="in" name="in" value="<?= e($textos['in']) ?>" placeholder="D → B → E → A → C" autocomplete="off">
        </div>
        <div class="pergamino">
            <label for="post">POSTORDEN</label>
            <input type="text" id="post" name="post" value="<?= e($textos['post']) ?>" placeholder="D → E → B → C → A" autocomplete="off">
        </div>
        <button class="boton boton-grande" type="submit">PLANTAR ÁRBOL</button>
        <p class="pista-formato">Separa los nodos con flechas, comas o espacios.</p>
    </form>

    <?php if ($error): ?>
        <p class="mensaje mensaje-error">! <?= e($error) ?></p>
    <?php endif; ?>

    <?php if ($arbol !== null): ?>
        <section class="claro">
            <p class="metodo-usado">Construido con: <strong><?= e($arbol->metodo()) ?></strong></p>
            <div class="arbol-contenedor">
                <?= $arbol->html() ?>
            </div>
            <?php if ($arbol->esAmbiguo()): ?>
                <p class="mensaje mensaje-aviso">Con preorden + postorden el árbol puede no ser único; cuando un nodo tenía un solo hijo lo puse a la izquierda.</p>
            <?php endif; ?>
            <ul class="recorridos-resultado">
                <li><strong>Preorden:</strong> <?= e(implode(' → ', $arbol->preorden())) ?></li>
                <li><strong>Inorden:</strong> <?= e(implode(' → ', $arbol->inorden())) ?></li>
                <li><strong>Postorden:</strong> <?= e(implode(' → ', $arbol->postorden())) ?></li>
            </ul>
        </section>
    <?php endif; ?>
<?php require __DIR__ . '/../Añadidos/pie.php'; ?>