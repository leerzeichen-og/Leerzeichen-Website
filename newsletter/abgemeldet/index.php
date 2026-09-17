<?php
// Newsletter: Seite nach der Abmeldung.
// Text: „Website-Texte", Abschnitt Abmeldung.
require_once __DIR__ . '/../../teile/firma.php';

$titel        = 'Abgemeldet — Empty Space | leerzeichen';
$beschreibung = 'Sie sind vom Newsletter Empty Space abgemeldet.';
$brotkrumen   = [['Newsletter', '/newsletter/abgemeldet/']];

require __DIR__ . '/../../teile/kopf.php';
?>

<section class="abschnitt">
  <h1 class="titel-seite" style="margin-bottom:var(--space-5)">Erledigt.</h1>
  <p class="lz-lead" style="max-width:52ch">Sie bekommen keine Post mehr von uns.
    Wenn Sie es sich anders überlegen, finden Sie die Anmeldung auf unserer
    <a href="/">Startseite</a>.</p>
</section>

<?php require __DIR__ . '/../../teile/fuss.php'; ?>
