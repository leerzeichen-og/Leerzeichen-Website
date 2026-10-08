<?php
// Fehlerseite — von Apache über ErrorDocument in der .htaccess aufgerufen.
// Text: „Website-Texte", Abschnitt 404.
http_response_code(404);
$titel        = 'Seite nicht gefunden — leerzeichen';
$beschreibung = 'Die Seite, die Sie suchen, gibt es nicht mehr oder hat einen neuen Namen bekommen.';
$voll_breit   = true;
require __DIR__ . '/teile/kopf.php';
?>

<section class="seiten-kopf">
  <h1 class="titel-seite">Hier ist nichts. Nicht einmal ein Leerzeichen.</h1>
</section>
<section class="text-spalte">
  <p>Die Seite, die Sie suchen, gibt es nicht mehr oder hat einen
    neuen Namen bekommen.</p>
  <p><a class="text-link" href="/">Zur Startseite <?= lz_pfeil() ?></a><br>
    <a class="text-link" href="/referenzen/">Referenzen <?= lz_pfeil() ?></a><br>
    <a class="text-link" href="/kontakt/">Kontakt <?= lz_pfeil() ?></a></p>
</section>

<?php require __DIR__ . '/teile/fuss.php'; ?>
