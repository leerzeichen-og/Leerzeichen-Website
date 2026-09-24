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

<section class="seiten-hero" style="background-image:linear-gradient(180deg, rgba(0,0,0,.3) 0%, rgba(0,0,0,.62) 100%), url(/assets/bilder/leerzeichen-connected.webp)">
  <span class="chip">Kontakt</span>
  <h1 class="titel-seite">Am besten, wir treffen uns.</h1>
  <p class="lz-lead" style="margin-top:var(--space-5);max-width:52ch">Rufen Sie an, und
    wir vereinbaren einen Termin. Dann finden wir gemeinsam heraus, was Ihr Projekt
    braucht — bei Ihnen, oder bei uns im Rathaus in Neumarkt.</p>
  <div class="kontakt-wege">
    <a href="tel:<?= e(str_replace(' ', '', FIRMA_TELEFON)) ?>"><?= e(FIRMA_TELEFON) ?> <?= lz_pfeil() ?></a>
    <a href="mailto:<?= e(FIRMA_MAIL) ?>"><?= e(FIRMA_MAIL) ?> <?= lz_pfeil() ?></a>
  </div>
</section>

<section class="lz-sec kontakt-lage">
  <div class="kontakt-lage-text">
    <h2 class="lz-h3">So finden Sie uns.</h2>
    <p><?= e(FIRMA_NAME) ?><br>
      <?= e(FIRMA_STRASSE) ?>, <?= e(FIRMA_PLZ) ?> <?= e(FIRMA_ORT) ?><br>
      Erdgeschoss, erste Tür rechts.</p>
    <p>Unser Büro liegt im historischen Rathaus, direkt am Marktplatz.</p>
    <p><a class="knopf" href="<?= e($routenplaner) ?>" rel="noopener noreferrer" target="_blank">Routenplaner <?= lz_pfeil() ?></a></p>

    <?php // Reduzierte Wegskizze: Marktplatz, Rathaus, der Weg zur Tür. ?>
    <svg class="kontakt-skizze" viewBox="0 0 520 300" xmlns="http://www.w3.org/2000/svg"
      role="img" aria-label="Wegskizze: Über den Marktplatz zum Rathaus, Erdgeschoss, erste Tür rechts">
      <!-- Marktplatz: offene Fläche -->
      <rect x="40" y="120" width="300" height="150" fill="none" stroke="currentColor" stroke-width="2"/>
      <text x="60" y="250" class="skizze-wort">MARKTPLATZ</text>
      <!-- Rathaus: der schwarze Block an der Nordseite -->
      <rect x="300" y="30" width="180" height="90" fill="currentColor"/>
      <text x="322" y="82" class="skizze-wort skizze-hell">RATHAUS</text>
      <!-- Weg: gestrichelt über den Platz zur Tür -->
      <path d="M 70 200 C 180 190, 280 175, 356 132" fill="none" stroke="currentColor"
        stroke-width="2" stroke-dasharray="2 8" stroke-linecap="round"/>
      <path d="M 348 143 L 356 132 L 342 130" fill="none" stroke="currentColor" stroke-width="2"/>
      <!-- Die Tür -->
      <circle cx="358" cy="126" r="5" fill="currentColor"/>
      <text x="374" y="140" class="skizze-wort">ERSTE TÜR RECHTS</text>
    </svg>
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
