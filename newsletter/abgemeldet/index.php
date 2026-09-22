<?php
// Newsletter: Seite nach der Abmeldung.
// Text: „Website-Texte", Abschnitt Abmeldung.
require_once __DIR__ . '/../../teile/firma.php';

$titel        = 'Abgemeldet — Empty Space | leerzeichen';
$beschreibung = 'Sie sind vom Newsletter Empty Space abgemeldet.';
$brotkrumen   = [['Newsletter', '/newsletter/abgemeldet/']];

$voll_breit   = true;

require __DIR__ . '/../../teile/kopf.php';
?>

<section class="seiten-kopf">
  <span class="chip">Empty Space</span>
  <h1 class="titel-seite">Erledigt.</h1>
</section>
<section class="text-spalte">
  <p>Sie bekommen keine Post mehr von uns.
    Wenn Sie es sich anders überlegen, finden Sie die Anmeldung auf unserer
    <a href="/">Startseite</a>.</p>
</section>

<?php require __DIR__ . '/../../teile/fuss.php'; ?>
