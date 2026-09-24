<?php
// Projektseite: /referenzen/{slug}/ — die .htaccess lenkt hierher (?slug=…).
// Aufbau wie die frühere WordPress-Shortcode-Fassung: Header mit Bild und
// Titel · Kurzbeschreibung · Foto 1 · Aufgabenstellung · Foto 2 · Lösung ·
// Foto 4 · Details zweispaltig · Foto 5 · Zusammenfassung · CTA mit Credits ·
// weitere Projekte derselben Säule. Daten kommen aus Space (docs/datenformat.md).

require_once __DIR__ . '/../teile/firma.php';
require_once __DIR__ . '/../teile/projekte.php';

$projekt = null;
if (isset($_GET['slug'])) {
    $projekt = pj_projekt((string) $_GET['slug']);
}
if ($projekt === null) {
    require __DIR__ . '/../404.php';
    exit;
}

$saeule = PJ_SAEULEN[$projekt['saeule'] ?? ''] ?? null;

// Meta laut Briefing: Title aus Kunde + Titel, Description aus der Punchline.
$titel        = trim(($projekt['kunde'] ?? '') . ' — ' . ($projekt['titel'] ?? ''), ' —')
              . ' | leerzeichen';
$beschreibung = (string) ($projekt['punchline'] ?? '');
$brotkrumen   = [
    ['Referenzen', '/referenzen/'],
    [(string) ($projekt['titel'] ?? ''), '/referenzen/' . $projekt['slug'] . '/'],
];
$styles       = ['/assets/projekt.css'];
// CreativeWork fürs Projekt. Den Kunden nennt die description mit —
// schema.org hat kein eigenes Feld für Auftraggeber.
$jsonld_extra = array_filter([
    '@context'    => 'https://schema.org',
    '@type'       => 'CreativeWork',
    'name'        => $projekt['titel'] ?? '',
    'description' => trim(($projekt['punchline'] ?? '') . ' Ein Projekt für ' . ($projekt['kunde'] ?? '') . '.'),
    'about'       => implode(', ', $projekt['schlagworte'] ?? []),
    'dateCreated' => (string) ($projekt['jahr'] ?? ''),
    'creator'     => ['@type' => 'Organization', 'name' => FIRMA_NAME],
]);

require __DIR__ . '/../teile/kopf.php';
?>
<div class="pj">

  <?php if (!empty($projekt['bilder']['header']['quellen'])): ?>
  <header class="pj-header">
    <?= pj_bild($projekt['bilder']['header'], 'pj-header-bild', '100vw', true) ?>
    <div class="pj-header-inhalt">
      <?php if ($saeule): ?>
      <a class="pj-badge" href="<?= e($saeule[1]) ?>"><?= e($saeule[0]) ?></a>
      <?php endif; ?>
      <h1 class="pj-titel"><?= e((string) ($projekt['titel'] ?? '')) ?></h1>
      <span class="pj-runter" aria-hidden="true"><?= lz_pfeil() ?></span>
    </div>
  </header>
  <?php else: ?>
  <h1 class="pj-titel-ohne-bild"><?= e((string) ($projekt['titel'] ?? '')) ?></h1>
  <?php endif; ?>

  <?= pj_text($projekt, 'kurzbeschreibung', 'pj-lead') ?>

  <?= pj_bild($projekt['bilder']['foto_01'] ?? null, 'pj-foto', '100vw') ?>
  <?= pj_text($projekt, 'aufgabenstellung') ?>

  <?= pj_bild($projekt['bilder']['foto_02'] ?? null, 'pj-foto', '100vw') ?>
  <?= pj_text($projekt, 'loesung') ?>

  <?= pj_bild($projekt['bilder']['foto_04'] ?? null, 'pj-foto', '100vw') ?>
  <?php
  $d1 = pj_text($projekt, 'detail_01');
  $d2 = pj_text($projekt, 'detail_02');
  if ($d1 !== '' || $d2 !== '') {
      echo '<div class="pj-details">' . $d1 . $d2 . '</div>';
  }
  ?>

  <?= pj_bild($projekt['bilder']['foto_05'] ?? null, 'pj-foto', '100vw') ?>
  <?= pj_text($projekt, 'zusammenfassung') ?>

  <?php
  $cta     = pj_text($projekt, 'call_to_action', 'pj-cta-text');
  $credits = $projekt['credits'] ?? [];
  if ($cta !== '' || $credits): ?>
  <section class="pj-abschluss">
    <div class="pj-cta">
      <?= $cta ?>
      <a class="pj-knopf" href="/kontakt/">Kontaktieren Sie uns <span aria-hidden="true">&rarr;</span></a>
    </div>
    <?php if ($credits): ?>
    <dl class="pj-credits">
      <?php foreach ($credits as $c): if (empty($c['bereich']) && empty($c['person'])) continue; ?>
      <div class="pj-credit">
        <dt><?= e((string) ($c['bereich'] ?? '')) ?></dt>
        <dd><?= e((string) ($c['person'] ?? '')) ?></dd>
      </div>
      <?php endforeach; ?>
    </dl>
    <?php endif; ?>
  </section>
  <?php endif; ?>

  <?php
  // Weitere Projekte derselben Säule, neueste zuerst (Reihenfolge der index.json).
  $weitere = array_filter(pj_index(), fn($p) =>
      ($p['saeule'] ?? '') === ($projekt['saeule'] ?? '-') && ($p['slug'] ?? '') !== $projekt['slug']);
  $weitere = array_slice($weitere, 0, 3);
  if ($weitere): ?>
  <section class="pj-weitere">
    <h2>Weitere Projekte</h2>
    <div class="pj-weitere-liste">
      <?php foreach ($weitere as $w) { echo pj_karte($w); } ?>
    </div>
  </section>
  <?php endif; ?>

</div>
<?php require __DIR__ . '/../teile/fuss.php'; ?>
