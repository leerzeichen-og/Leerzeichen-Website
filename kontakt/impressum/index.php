<?php
// Impressum — Gerüst; der Rechtstext kommt von Roman und wird hier eingesetzt.
require_once __DIR__ . '/../../teile/firma.php';

$titel        = 'Impressum | leerzeichen multimedia og';
$beschreibung = 'Impressum der leerzeichen multimedia og, Neumarkt an der Ybbs.';
$brotkrumen   = [['Kontakt', '/kontakt/'], ['Impressum', '/kontakt/impressum/']];

require __DIR__ . '/../../teile/kopf.php';
?>

<section class="abschnitt">
  <h1 class="titel-seite" style="margin-bottom:var(--space-5)">Impressum</h1>
  <p class="platzhalter">Der Text folgt — hier einsetzen, sobald er vorliegt.</p>
</section>

<?php require __DIR__ . '/../../teile/fuss.php'; ?>
