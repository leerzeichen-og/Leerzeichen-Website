<?php
// Referenzen-Übersicht im Mucho-Stil (Entscheidung Roman, 7.10.2026):
// oben links der Einleitungssatz (zugleich die h1), rechts daneben die
// Kategorien als zweispaltige Pillen-Liste (Sprungmarken, kein Filter) —
// darunter je Kategorie eine Gruppe: Überschrift, daneben und darunter
// die Beiträge. Ein Beitrag erscheint in JEDER seiner Kategorien.
// Kategorien = Schlagworte der Beiträge (index.json).

require_once __DIR__ . '/../teile/firma.php';
require_once __DIR__ . '/../teile/projekte.php';

$titel        = 'Referenzen — Projekte von leerzeichen';
$beschreibung = 'Wir arbeiten mit Betrieben, Museen und Gemeinden — am Erscheinungsbild, '
              . 'an Büchern, Magazinen, Websites, Ausstellungen und Erlebniswegen.';
$brotkrumen   = [['Referenzen', '/referenzen/']];
$styles       = ['/assets/projekt.css'];
$voll_breit   = true;

$projekte = pj_index();

// Übergeordnete Filter (Roman, 8.10.2026): die zwei Säulen als echte
// Auswahl über ?filter=… — serverseitig, ohne JavaScript. Die Kategorien
// und Gruppen bauen sich dann nur aus den Projekten der Säule.
$filterWahl = [
    'erlebnis'   => ['Erlebnis',   'erlebnisse'],
    'gestaltung' => ['Gestaltung', 'gestaltung'],
];
$filter = (string) ($_GET['filter'] ?? '');
if (!isset($filterWahl[$filter])) {
    $filter = '';
}
if ($filter !== '') {
    $projekte = array_values(array_filter($projekte,
        fn($p) => ($p['saeule'] ?? '') === $filterWahl[$filter][1]));
}

// Gruppen: Kategorie → Beiträge (ein Beitrag steht in jeder seiner Kategorien).
$gruppen = [];
foreach ($projekte as $p) {
    foreach ((array) ($p['schlagworte'] ?? []) as $t) {
        $gruppen[$t][] = $p;
    }
}
ksort($gruppen, SORT_NATURAL | SORT_FLAG_CASE);

// Sprungmarken-Anker aus dem Kategorienamen (nur a-z, 0-9, Bindestrich).
function pj_anker(string $name): string
{
    $s = strtr(mb_strtolower($name), ['ä' => 'ae', 'ö' => 'oe', 'ü' => 'ue', 'ß' => 'ss']);
    return trim(preg_replace('/[^a-z0-9]+/', '-', $s) ?? '', '-');
}

require __DIR__ . '/../teile/kopf.php';
?>

<section class="pj-intro">
  <h1 class="pj-intro-satz">Wir arbeiten mit Betrieben, Museen und Gemeinden —
    am Erscheinungsbild, an Büchern und Magazinen, an Verpackungen und Websites,
    an Ausstellungen und Erlebniswegen.</h1>
  <div class="pj-filterblock">
    <nav class="pj-filter" aria-label="Bereiche">
      <a class="pj-filter-pille" href="/referenzen/"<?= $filter === '' ? ' aria-current="true"' : '' ?>>Alle</a>
      <?php foreach ($filterWahl as $schluessel => [$label, $saeule]): ?>
      <a class="pj-filter-pille" href="/referenzen/?filter=<?= e($schluessel) ?>"<?= $filter === $schluessel ? ' aria-current="true"' : '' ?>><?= e($label) ?></a>
      <?php endforeach; ?>
    </nav>
    <?php if ($gruppen): ?>
    <nav class="pj-kategorien" aria-label="Kategorien">
      <?php foreach ($gruppen as $name => $liste): ?>
      <a class="pj-pille" href="#<?= e(pj_anker($name)) ?>"><?= e($name) ?></a>
      <?php endforeach; ?>
    </nav>
    <?php endif; ?>
  </div>
</section>

<?php if (!$gruppen): ?>
<section class="lz-sec">
  <p class="platzhalter"><?= $filter !== ''
      ? 'In diesem Bereich sind noch keine Projekte veröffentlicht — „Alle“ zeigt den ganzen Bestand.'
      : 'Hier erscheinen die Projekte, sobald Space sie veröffentlicht hat.' ?></p>
</section>
<?php else: ?>
<section class="lz-sec" style="padding-top:0">
  <?php foreach ($gruppen as $name => $liste): ?>
  <div class="pj-gruppe" id="<?= e(pj_anker($name)) ?>">
    <h2 class="pj-gruppe-titel"><?= e($name) ?></h2>
    <?php foreach ($liste as $p): ?>
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
  <?php endforeach; ?>
</section>
<?php endif; ?>

<?php require __DIR__ . '/../teile/newsletter.php'; ?>
<?php require __DIR__ . '/../teile/cta.php'; ?>

<?php require __DIR__ . '/../teile/fuss.php'; ?>
