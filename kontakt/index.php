<?php
// Kontaktseite. Text: „Website-Texte", Abschnitt Kontakt-Seite;
// Meta laut Briefing 5.3.
require_once __DIR__ . '/../teile/firma.php';

$titel        = 'Kontakt | leerzeichen multimedia og';
$beschreibung = 'Marktplatz 1, 3371 Neumarkt an der Ybbs. Telefon +43 7412 53638. '
              . 'Rufen Sie an, wir vereinbaren einen Termin.';
$brotkrumen   = [['Kontakt', '/kontakt/']];

require __DIR__ . '/../teile/kopf.php';
?>

<section class="abschnitt">
  <h1>Am besten, wir treffen uns.</h1>
  <p class="lz-lead" style="max-width:52ch">Rufen Sie an, und wir vereinbaren einen
    Termin. Dann finden wir gemeinsam heraus, was Ihr Projekt braucht — bei Ihnen,
    oder bei uns im Rathaus in Neumarkt.</p>

  <p class="lz-lead" style="margin-top:var(--space-6)">
    <a href="tel:<?= e(str_replace(' ', '', FIRMA_TELEFON)) ?>"><?= e(FIRMA_TELEFON) ?></a><br>
    <a href="mailto:<?= e(FIRMA_MAIL) ?>"><?= e(FIRMA_MAIL) ?></a>
  </p>

  <p style="color:var(--text-body)">
    <?= e(FIRMA_STRASSE) ?>, <?= e(FIRMA_PLZ) ?> <?= e(FIRMA_ORT) ?><br>
    Erdgeschoss, erste Tür rechts.
  </p>
</section>

<?php require __DIR__ . '/../teile/fuss.php'; ?>
