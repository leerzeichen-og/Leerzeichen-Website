<?php
// Datenschutzerklärung — Gerüst; der Rechtstext kommt von Roman und wird hier eingesetzt.
require_once __DIR__ . '/../../teile/firma.php';

$titel        = 'Datenschutzerklärung | leerzeichen multimedia og';
$beschreibung = 'Datenschutzerklärung der leerzeichen multimedia og, Neumarkt an der Ybbs.';
$brotkrumen   = [['Kontakt', '/kontakt/'], ['Datenschutzerklärung', '/kontakt/datenschutzerklaerung/']];

$voll_breit   = true;

require __DIR__ . '/../../teile/kopf.php';
?>

<section class="seiten-kopf">
  <span class="chip">Rechtliches</span>
  <h1 class="titel-seite">Datenschutzerklärung</h1>
</section>
<section class="text-spalte">
  <p class="platzhalter">Der Text folgt — hier einsetzen, sobald er vorliegt.</p>
</section>

<?php require __DIR__ . '/../../teile/fuss.php'; ?>
