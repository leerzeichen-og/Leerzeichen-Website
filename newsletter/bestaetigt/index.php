<?php
// Newsletter: Seite nach der Double-Opt-in-Bestätigung.
// Text: „Website-Texte", Abschnitt Nach der Bestätigung.
require_once __DIR__ . '/../../teile/firma.php';

$titel        = 'Sie sind dabei — Empty Space | leerzeichen';
$beschreibung = 'Ihre Anmeldung zum Newsletter Empty Space ist bestätigt.';
$brotkrumen   = [['Newsletter', '/newsletter/bestaetigt/']];

$voll_breit   = true;

require __DIR__ . '/../../teile/kopf.php';
?>

<section class="seiten-kopf">
  <span class="chip">Empty Space</span>
  <h1 class="titel-seite">Sie sind dabei.</h1>
</section>
<section class="text-spalte">
  <p>Pro Quartal können Sie nun mit einer
    Ausgabe unseres Newsletters rechnen. Bis dahin:
    <a href="/referenzen/">Schauen Sie sich um, woran wir gerade arbeiten.</a></p>
</section>

<?php require __DIR__ . '/../../teile/fuss.php'; ?>
