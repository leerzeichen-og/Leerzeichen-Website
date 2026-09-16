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

$filter   = (string) ($_GET['saeule'] ?? '');
$filter   = isset(PJ_SAEULEN[$filter]) ? $filter : '';
$projekte = pj_index();
if ($filter !== '') {
    $projekte = array_filter($projekte, fn($p) => ($p['saeule'] ?? '') === $filter);
}

require __DIR__ . '/../teile/kopf.php';
?>

<h1>Referenzen</h1>

<nav class="pj-pillen" aria-label="Nach Säule filtern">
  <a class="pj-pille" href="/referenzen/" <?= $filter === '' ? 'aria-current="true"' : '' ?>>Alle</a>
  <?php foreach (PJ_SAEULEN as $schluessel => [$label, $url]): ?>
  <a class="pj-pille" href="/referenzen/?saeule=<?= e($schluessel) ?>"
     <?= $filter === $schluessel ? 'aria-current="true"' : '' ?>><?= e($label) ?></a>
  <?php endforeach; ?>
</nav>

<?php if ($projekte): ?>
<div class="pj-liste">
  <?php foreach ($projekte as $p) { echo pj_karte($p); } ?>
</div>
<?php else: ?>
<p class="platzhalter">Hier erscheinen die Projekte, sobald Space sie veröffentlicht hat.</p>
<?php endif; ?>

<?php require __DIR__ . '/../teile/fuss.php'; ?>
