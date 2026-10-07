<?php
// Referenzen-Übersicht in ZWEI Ansichten (Vergleich für Roman, 7.10.2026):
//   /referenzen/                 Collage mit Kundenstimmen (Stand 24.9.)
//   /referenzen/?ansicht=filter  Vorschlag im Stil wearemucho.com/work:
//                                großes ruhiges Raster, gefiltert über die
//                                Schlagworte der Beiträge (?tag=…).
// Beide Filter ohne JavaScript — die Pillen sind schlichte Links.

require_once __DIR__ . '/../teile/firma.php';
require_once __DIR__ . '/../teile/projekte.php';

$titel        = 'Referenzen — Projekte von leerzeichen';
$beschreibung = 'Ausgewählte Projekte aus Ausstellungsgestaltung, Erlebnisplanung und Corporate Design.';
$brotkrumen   = [['Referenzen', '/referenzen/']];
$styles       = ['/assets/projekt.css'];
$voll_breit   = true;

$ansicht  = ($_GET['ansicht'] ?? '') === 'filter' ? 'filter' : 'collage';
$projekte = pj_index();

// Säulen-Filter (Collage-Ansicht).
$filter = (string) ($_GET['saeule'] ?? '');
$filter = isset(PJ_SAEULEN[$filter]) ? $filter : '';

// Schlagwort-Filter (Filter-Ansicht): alle Schlagworte aus dem Index sammeln.
$alleTags = [];
foreach ($projekte as $p) {
    foreach ((array) ($p['schlagworte'] ?? []) as $t) {
        $alleTags[$t] = ($alleTags[$t] ?? 0) + 1;
    }
}
ksort($alleTags, SORT_NATURAL | SORT_FLAG_CASE);
$tag = (string) ($_GET['tag'] ?? '');
$tag = isset($alleTags[$tag]) ? $tag : '';

if ($ansicht === 'filter') {
    if ($tag !== '') {
        $projekte = array_filter($projekte,
            fn($p) => in_array($tag, (array) ($p['schlagworte'] ?? []), true));
    }
} elseif ($filter !== '') {
    $projekte = array_filter($projekte, fn($p) => ($p['saeule'] ?? '') === $filter);
}

require __DIR__ . '/../teile/kopf.php';
?>

<section class="seiten-kopf">
<h1 class="titel-seite">Referenzen</h1>

<?php if ($ansicht === 'filter'): ?>
<nav class="pj-pillen" aria-label="Nach Schlagwort filtern">
  <a class="pj-pille" href="/referenzen/?ansicht=filter" <?= $tag === '' ? 'aria-current="true"' : '' ?>>Alle</a>
  <?php foreach ($alleTags as $t => $anzahl): ?>
  <a class="pj-pille" href="/referenzen/?ansicht=filter&amp;tag=<?= e(rawurlencode($t)) ?>"
     <?= $tag === $t ? 'aria-current="true"' : '' ?>><?= e($t) ?></a>
  <?php endforeach; ?>
</nav>
<?php else: ?>
<nav class="pj-pillen" aria-label="Nach Säule filtern">
  <a class="pj-pille" href="/referenzen/" <?= $filter === '' ? 'aria-current="true"' : '' ?>>Alle</a>
  <?php foreach (PJ_SAEULEN as $schluessel => [$label, $url]): ?>
  <a class="pj-pille" href="/referenzen/?saeule=<?= e($schluessel) ?>"
     <?= $filter === $schluessel ? 'aria-current="true"' : '' ?>><?= e($label) ?></a>
  <?php endforeach; ?>
</nav>
<?php endif; ?>
</section>

<section class="lz-sec" style="padding-top:0">
<?php if (!$projekte): ?>
<p class="platzhalter">Hier erscheinen die Projekte, sobald Space sie veröffentlicht hat.</p>

<?php elseif ($ansicht === 'filter'): ?>
<?php // Großes, ruhiges Zweierraster: Quer-Teaser, großer Titel, Schlagwort-Zeile. ?>
<div class="pj-filterraster">
  <?php foreach ($projekte as $p): ?>
  <a class="pj-karte pj-fr-karte" href="/referenzen/<?= e($p['slug'] ?? '') ?>/">
    <span class="pj-karte-bildwrap">
      <?= pj_bild($p['teaser_quer'] ?? null, 'pj-karte-bild', '(max-width: 900px) 100vw, 50vw') ?>
    </span>
    <span class="pj-fr-titel"><?= e((string) ($p['titel'] ?? '')) ?></span>
    <?php if (!empty($p['schlagworte'])): ?>
    <span class="pj-fr-tags"><?= e(implode(' · ', (array) $p['schlagworte'])) ?></span>
    <?php endif; ?>
  </a>
  <?php endforeach; ?>
</div>

<?php else: ?>
<div class="pj-collage">
  <?php
  // Collage mit ausgerichteten Zeilen (Roman, 24.9.2026): je Fünfergruppe
  // drei Hochformate, dann groß + hoch (fast gleiche Bildhöhen); nach der
  // dritten Karte jeder Gruppe erscheint die nächste Kundenstimme.
  $muster = ['hoch', 'hoch', 'hoch', 'gross', 'hoch'];
  $zitate = array_values(array_filter($projekte,
      fn($p) => trim((string) ($p['zitat'] ?? '')) !== ''));
  $n = 0;
  foreach ($projekte as $p) {
      echo pj_karte($p, $muster[$n % count($muster)]);
      $n++;
      if ($n % count($muster) === 3 && $zitate) {
          echo pj_zitat(array_shift($zitate));
      }
  }
  ?>
</div>
<?php endif; ?>

</section>

<?php require __DIR__ . '/../teile/newsletter.php'; ?>
<?php require __DIR__ . '/../teile/cta.php'; ?>

<?php require __DIR__ . '/../teile/fuss.php'; ?>
