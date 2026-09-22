<?php
// Impressum — Gerüst; der Rechtstext kommt von Roman und wird hier eingesetzt.
require_once __DIR__ . '/../../teile/firma.php';

$titel        = 'Impressum | leerzeichen multimedia og';
$beschreibung = 'Impressum der leerzeichen multimedia og, Neumarkt an der Ybbs.';
$brotkrumen   = [['Kontakt', '/kontakt/'], ['Impressum', '/kontakt/impressum/']];

$voll_breit   = true;

require __DIR__ . '/../../teile/kopf.php';
?>

<section class="seiten-kopf">
  <span class="chip">Rechtliches</span>
  <h1 class="titel-seite">Impressum</h1>
</section>
<section class="text-spalte">
  <p class="platzhalter">Der Text folgt — hier einsetzen, sobald er vorliegt.</p>
</section>

<?php require __DIR__ . '/../../teile/fuss.php'; ?>
