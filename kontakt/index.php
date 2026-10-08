<?php
// Kontaktseite — Fassung „Anfahrt & Büro" (Entscheidung Roman 24.9.2026):
// dunkler Hero mit dem Netzwerk-Motiv und großen Kontaktzeilen, darunter
// das Büro-Foto neben Adresse, Routenplaner und einer reduzierten
// Wegskizze (Marktplatz → erste Tür rechts).
// Text: „Website-Texte", Abschnitt Kontakt-Seite; Meta laut Briefing 5.3.
require_once __DIR__ . '/../teile/firma.php';

$titel        = 'Kontakt | leerzeichen multimedia og';
$beschreibung = 'Marktplatz 1, 3371 Neumarkt an der Ybbs. Telefon +43 7412 53638. '
              . 'Rufen Sie an, wir vereinbaren einen Termin.';
$brotkrumen   = [['Kontakt', '/kontakt/']];
$voll_breit   = true;

// Derselbe Routenplaner-Link wie im Fuß (dort definiert er sich selbst neu).
$routenplaner = 'https://www.google.com/maps/search/?api=1&query='
    . rawurlencode(FIRMA_NAME . ', ' . FIRMA_STRASSE . ', ' . FIRMA_PLZ . ' ' . FIRMA_ORT);

require __DIR__ . '/../teile/kopf.php';
?>

<?php // Kopf nach Romans DevTools-Fassung (8.10.2026): Headline in
      // Claim-Größe (Light) linksbündig am Logo-Rand; der Teaser darunter in
      // der rechten Spalte, deren Kante exakt mit dem Büro-Foto fluchtet
      // (gleiches Spaltenraster wie .kontakt-lage). ?>
<section class="kopf-gross">
  <h1 class="titel-gross">Am besten,<br>wir treffen uns.</h1>
  <div class="kopf-gross-zeile">
    <div class="kopf-gross-rechts">
      <p>Dann finden wir gemeinsam heraus, was Ihr Projekt
        braucht — bei Ihnen, oder bei uns im Rathaus in Neumarkt.</p>
      <div class="kontakt-wege">
        <a href="tel:<?= e(str_replace(' ', '', FIRMA_TELEFON)) ?>"><?= e(FIRMA_TELEFON) ?> <?= lz_pfeil() ?></a>
        <a href="mailto:<?= e(FIRMA_MAIL) ?>"><?= e(FIRMA_MAIL) ?> <?= lz_pfeil() ?></a>
      </div>
    </div>
  </div>
</section>

<section class="lz-sec kontakt-lage">
  <div class="kontakt-lage-text">
    <h2 class="kontakt-untertitel">So finden Sie uns.</h2>
    <p class="kontakt-adresse"><?= e(FIRMA_NAME) ?><br>
      <?= e(FIRMA_STRASSE) ?><br>
      <?= e(FIRMA_PLZ) ?> <?= e(FIRMA_ORT) ?></p>
    <p class="kontakt-hinweis">Unser Büro liegt im Rathaus, direkt am Marktplatz.
      Erdgeschoss. Erste Tür rechts.</p>
    <p><a class="knopf" href="<?= e($routenplaner) ?>" rel="noopener noreferrer" target="_blank">Routenplaner <?= lz_pfeil() ?></a></p>
  </div>

  <figure class="kontakt-foto">
    <img src="/assets/bilder/leerzeichen-buero-besprechung.webp" width="2200" height="1466"
      alt="Das Leerzeichen-Büro im historischen Rathaus von Neumarkt an der Ybbs" loading="lazy">
    <div class="buero-tag">
      <span class="chip">Rathaus Neumarkt</span>
      <span class="buero-untertitel">Erdgeschoss, erste Tür rechts</span>
    </div>
  </figure>
</section>

<?php require __DIR__ . '/../teile/fuss.php'; ?>
