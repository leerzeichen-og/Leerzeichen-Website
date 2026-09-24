<?php
// Impressum — zusammengestellt aus den Firmendaten (teile/firma.php) und den
// Angaben aus dem AGB-PDF (FN, UID; 24.9.2026). ACHTUNG, von Roman zu
// prüfen: Firmenbuchgericht (angenommen: LG St. Pölten), Gewerbebehörde
// (angenommen: BH Melk) und Kammer-Zugehörigkeit — hochwahrscheinlich
// richtig für den Standort, aber nicht belegt.
require_once __DIR__ . '/../../teile/firma.php';

$titel        = 'Impressum | leerzeichen multimedia og';
$beschreibung = 'Impressum der Leerzeichen Multimedia OG, Marktplatz 1, 3371 Neumarkt an der Ybbs.';
$brotkrumen   = [['Kontakt', '/kontakt/'], ['Impressum', '/kontakt/impressum/']];
$voll_breit   = true;

require __DIR__ . '/../../teile/kopf.php';
?>

<section class="seiten-kopf">
  <span class="chip">Rechtliches</span>
  <h1 class="titel-seite">Impressum</h1>
</section>
<section class="rechtstext">
  <p>Angaben gemäß §&nbsp;5 E-Commerce-Gesetz (ECG), §&nbsp;14 UGB und
    §&nbsp;25 Mediengesetz.</p>

  <h2>Medieninhaber und Diensteanbieter</h2>
  <p><strong><?= e(FIRMA_NAME) ?></strong><br>
    <?= e(FIRMA_STRASSE) ?><br>
    <?= e(FIRMA_PLZ) ?> <?= e(FIRMA_ORT) ?>, Österreich</p>
  <p>Telefon: <a href="tel:<?= e(str_replace(' ', '', FIRMA_TELEFON)) ?>"><?= e(FIRMA_TELEFON) ?></a><br>
    E-Mail: <a href="mailto:<?= e(FIRMA_MAIL) ?>"><?= e(FIRMA_MAIL) ?></a></p>

  <h2>Unternehmensdaten</h2>
  <p>Rechtsform: Offene Gesellschaft (OG)<br>
    Firmenbuchnummer: FN 411366a<br>
    Firmenbuchgericht: Landesgericht St.&nbsp;Pölten<br>
    UID-Nummer: ATU68723429<br>
    Sitz: <?= e(FIRMA_PLZ) ?> <?= e(FIRMA_ORT) ?></p>
  <p>Unternehmensgegenstand: Werbeagentur — Gestaltung, Erlebnisgestaltung
    und Kommunikation.<br>
    Mitglied der Wirtschaftskammer Niederösterreich, Fachgruppe Werbung und
    Marktkommunikation.<br>
    Gewerbebehörde: Bezirkshauptmannschaft Melk.<br>
    Berufsrechtliche Vorschriften: Gewerbeordnung 1994, abrufbar unter
    <a href="https://www.ris.bka.gv.at/" rel="noopener noreferrer" target="_blank">ris.bka.gv.at</a>.</p>

  <h2>Blattlinie</h2>
  <p>Diese Website informiert über das Unternehmen, seine Leistungen und
    Projekte.</p>

  <h2>Urheberrecht</h2>
  <p>Alle Inhalte dieser Website (Texte, Fotografien, Grafiken, Gestaltung)
    sind urheberrechtlich geschützt. Jede Verwendung außerhalb der Grenzen
    des Urheberrechts bedarf der vorherigen schriftlichen Zustimmung der
    <?= e(FIRMA_NAME) ?>.</p>

  <h2>Haftung für Links</h2>
  <p>Diese Website enthält Links zu externen Websites Dritter, auf deren
    Inhalte wir keinen Einfluss haben. Für diese fremden Inhalte übernehmen
    wir keine Gewähr; verantwortlich ist stets der jeweilige Anbieter oder
    Betreiber. Werden uns Rechtsverletzungen bekannt, entfernen wir
    betroffene Links umgehend.</p>
</section>

<?php require __DIR__ . '/../../teile/fuss.php'; ?>
