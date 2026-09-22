<?php
// Referenzen-Übersicht: alle veröffentlichten Projekte, filterbar nach den
// zwei Säulen (?saeule=erlebnisse|gestaltung) — Filter ohne JavaScript,
// die Pillen sind schlichte Links. Kein eigener Fließtext (Briefing 3).

require_once __DIR__ . '/../teile/firma.php';
require_once __DIR__ . '/../teile/projekte.php';

$titel        = 'Referenzen — Projekte von leerzeichen';
$beschreibung = 'Ausgewählte Projekte aus Ausstellungsgestaltung, Erlebnisplanung und Corporate Design.';
$brotkrumen   = [['Referenzen', '/referenzen/']];
$styles       = ['/assets/projekt.css'];
$voll_breit   = true;

$filter   = (string) ($_GET['saeule'] ?? '');
$filter   = isset(PJ_SAEULEN[$filter]) ? $filter : '';
$projekte = pj_index();
if ($filter !== '') {
    $projekte = array_filter($projekte, fn($p) => ($p['saeule'] ?? '') === $filter);
}

require __DIR__ . '/../teile/kopf.php';
?>

<section class="seiten-kopf">
<h1 class="titel-seite">Referenzen</h1>

<nav class="pj-pillen" aria-label="Nach Säule filtern">
  <a class="pj-pille" href="/referenzen/" <?= $filter === '' ? 'aria-current="true"' : '' ?>>Alle</a>
  <?php foreach (PJ_SAEULEN as $schluessel => [$label, $url]): ?>
  <a class="pj-pille" href="/referenzen/?saeule=<?= e($schluessel) ?>"
     <?= $filter === $schluessel ? 'aria-current="true"' : '' ?>><?= e($label) ?></a>
  <?php endforeach; ?>
</nav>
</section>

<section class="lz-sec" style="padding-top:0">
<?php if ($projekte): ?>
<div class="pj-collage">
  <?php
  // Collage statt gleichmäßigem Raster (Schema-Grafik 21.9.2026): je
  // Fünfergruppe hoch · hoch (versetzt) · quer · groß · hoch; nach der
  // dritten Karte jeder Gruppe erscheint die nächste Kundenstimme.
  $muster = ['hoch', 'hoch-tief', 'quer', 'gross', 'hoch'];
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
<?php else: ?>
<p class="platzhalter">Hier erscheinen die Projekte, sobald Space sie veröffentlicht hat.</p>
<?php endif; ?>

</section>

<?php require __DIR__ . '/../teile/newsletter.php'; ?>
<?php require __DIR__ . '/../teile/cta.php'; ?>

<?php require __DIR__ . '/../teile/fuss.php'; ?>
