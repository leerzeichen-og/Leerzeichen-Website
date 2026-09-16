<?php
// Fehlerseite — von Apache über ErrorDocument in der .htaccess aufgerufen.
http_response_code(404);
$titel        = 'Seite nicht gefunden — leerzeichen';
$beschreibung = 'Diese Seite gibt es nicht (mehr).';
require __DIR__ . '/teile/kopf.php';
?>

<section class="abschnitt">
  <h1>Diese Seite gibt es nicht</h1>
  <p>Vielleicht hilft eine dieser Abzweigungen:</p>
  <ul>
    <li><a href="/referenzen/">Unsere Projekte</a></li>
    <li><a href="/erlebnisgestaltung/">Erlebnisse</a> · <a href="/grafikdesign/">Gestaltung</a></li>
    <li><a href="/kontakt/">Kontakt</a></li>
  </ul>
</section>

<?php require __DIR__ . '/teile/fuss.php'; ?>
