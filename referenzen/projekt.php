<?php
// Projektseite: /referenzen/{slug}/ — die .htaccess lenkt hierher (?slug=…).
// Daten kommen aus Space (docs/datenformat.md). Seit dem Modul-Format
// (7.10.2026) besteht die Seite aus frei angeordneten Inhalts-Modulen:
// das erste header-Modul trägt Headerbild und Lead, danach läuft der Rest
// in Reihenfolge (pj_modul in teile/projekte.php); Credits und Call to
// Action stehen IMMER ganz unten, dann weitere Projekte derselben Säule.
// Beiträge im alten Format (texte{} + feste Bildnamen) rendert der
// Fallback unten unverändert, bis Space alle Einträge neu gepusht hat.

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
$jsonld_extra = [array_filter([
    '@context'    => 'https://schema.org',
    '@type'       => 'CreativeWork',
    'name'        => $projekt['titel'] ?? '',
    'description' => trim(($projekt['punchline'] ?? '') . ' Ein Projekt für ' . ($projekt['kunde'] ?? '') . '.'),
    'about'       => implode(', ', $projekt['schlagworte'] ?? []),
    'dateCreated' => (string) ($projekt['jahr'] ?? ''),
    'creator'     => ['@type' => 'Organization', 'name' => FIRMA_NAME],
])];

// Häufige Fragen zum Projekt (12.10.2026): faq-Array im Beitrags-JSON
// (docs/datenformat.md), gepflegt in Space. Ohne Einträge entfällt der
// Block; mit Einträgen gibt es zusätzlich FAQPage-JSON-LD — laut
// Website-Briefing der wichtigste Einzelposten der Auffindbarkeit.
$faq = array_values(array_filter(
    is_array($projekt['faq'] ?? null) ? $projekt['faq'] : [],
    fn($f) => is_array($f)
        && trim((string) ($f['frage'] ?? '')) !== ''
        && trim((string) ($f['antwort'] ?? '')) !== ''
));
if ($faq) {
    $jsonld_extra[] = [
        '@context'   => 'https://schema.org',
        '@type'      => 'FAQPage',
        'mainEntity' => array_map(fn($f) => [
            '@type'          => 'Question',
            'name'           => (string) $f['frage'],
            'acceptedAnswer' => ['@type' => 'Answer', 'text' => (string) $f['antwort']],
        ], $faq),
    ];
}

// Modul-Format: das erste header-Modul trägt den Seitenkopf, der Rest
// läuft in Reihenfolge. Ohne module-Array greift unten der Alt-Fallback.
$module      = is_array($projekt['module'] ?? null) ? array_values($projekt['module']) : [];
$headerModul = null;
if ($module && (($module[0]['art'] ?? '') === 'header')) {
    $headerModul = array_shift($module);
}
$headerBild = $headerModul['bilder'][0] ?? ($projekt['bilder']['header'] ?? null);

// Share-Bild (og:image): der Quer-Teaser in der mittleren Größe — 1280 px
// reicht den Vorschaukarten, die größte Stufe wäre unnötig schwer.
foreach (($projekt['bilder']['teaser_quer']['quellen'] ?? []) as $q) {
    if (!empty($q['datei']) && (int) ($q['breite'] ?? 0) >= 1280) {
        $ogBild = (string) $q['datei'];
        break;
    }
}

require __DIR__ . '/../teile/kopf.php';
?>
<div class="pj">

  <?php if (!empty($headerBild['quellen'])): ?>
  <header class="pj-header">
    <?= pj_medium($headerBild, 'pj-header-bild', '100vw', true) ?>
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

  <?php if ($headerModul || $module): ?>

  <?php // Der Text des header-Moduls ist der Lead der Seite. ?>
  <?php foreach (($headerModul['texte'] ?? []) as $t): if (trim((string) $t) === '') continue; ?>
  <div class="pj-text pj-lead"><?= pj_absaetze((string) $t) ?></div>
  <?php endforeach; ?>

  <?php foreach ($module as $m) { echo pj_modul($m); } ?>

  <?php else: ?>

  <?php // ---- Alt-Fallback (Format vor dem 7.10.2026) ---- ?>
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

  <?php endif; ?>

  <?php
  // Credits und Call to Action: immer ganz unten, kein Modul. Im neuen
  // Format ist cta ein Klartext-Feld, im alten ein texte-Eintrag.
  $ctaRoh = trim((string) ($projekt['cta'] ?? ($projekt['texte']['call_to_action'] ?? '')));
  $cta    = $ctaRoh !== '' ? '<div class="pj-text pj-cta-text">' . pj_absaetze($ctaRoh) . '</div>' : '';
  $credits = $projekt['credits'] ?? [];
  if ($cta !== '' || $credits): ?>
  <section class="pj-abschluss">
    <div class="pj-cta">
      <?= $cta ?>
      <a class="knopf" href="/kontakt/">Kontaktieren Sie uns <?= lz_pfeil() ?></a>
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

  <?php // Häufige Fragen zum Projekt — unterhalb von CTA und Credits
        // (Roman, 12.10.2026); gleicher Baustein wie auf den Säulen-Seiten. ?>
  <?php if ($faq): ?>
  <section class="pj-faq">
    <h2>Häufige Fragen</h2>
    <div class="faq">
      <?php foreach ($faq as $f): ?>
      <details>
        <summary><?= e((string) $f['frage']) ?></summary>
        <p><?= e((string) $f['antwort']) ?></p>
      </details>
      <?php endforeach; ?>
    </div>
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

<script>
// Wechselnde Kopfzeile (8.10.2026): Die Pixel-Differenz machte die
// Navigation über den Fotos grau und unlesbar. Stattdessen schaltet sie
// hart um — weiß, solange ein dunkles Element (Headerbild, Foto, Zitat)
// unter ihr liegt, sonst schwarz (CSS: html.navi-wechsel/.navi-ink).
// Ohne JavaScript bleibt die Differenz-Kopfzeile wie bisher.
(function () {
    var kopf = document.querySelector('.lz-header');
    var dunkle = document.querySelectorAll('.pj-header, .pj .pj-foto, .pj-zitat, .pj-doppel, .pj-scroller');
    if (!kopf || !dunkle.length) { return; }
    document.documentElement.classList.add('navi-wechsel');
    function pruefen() {
        var hoehe = kopf.offsetHeight;
        var hell = true;
        dunkle.forEach(function (el) {
            var r = el.getBoundingClientRect();
            if (r.top < hoehe && r.bottom > 0) { hell = false; }
        });
        document.documentElement.classList.toggle('navi-ink', hell);
    }
    addEventListener('scroll', pruefen, { passive: true });
    addEventListener('resize', pruefen);
    pruefen();
})();

// Scroller-Module: die Bildreihe wandert quer mit dem Seiten-Scroll —
// kein Scroll-Hijacking, die Seite läuft normal weiter. Ohne JavaScript
// (oder bei reduzierter Bewegung) bleibt die Reihe von Hand wischbar
// (overflow-x: auto); Modul-Videos stehen dann auf dem ersten Bild.
(function () {
    var ruhig = matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (ruhig) {
        document.querySelectorAll('.pj video').forEach(function (v) {
            v.pause();
            v.removeAttribute('autoplay');
        });
        return;
    }
    var scroller = document.querySelectorAll('.pj-scroller');
    if (!scroller.length) { return; }
    document.documentElement.classList.add('pj-rollt');
    function lauf() {
        scroller.forEach(function (sc) {
            var spur = sc.firstElementChild;
            var r = sc.getBoundingClientRect();
            // 0 = Modul tritt unten ein, 1 = es verlässt den Schirm oben.
            var p = Math.min(1, Math.max(0, 1 - r.bottom / (innerHeight + r.height)));
            var weg = spur.scrollWidth - sc.clientWidth;
            if (weg > 0) {
                spur.style.transform = 'translateX(' + (-weg * p).toFixed(1) + 'px)';
            }
        });
        requestAnimationFrame(lauf);
    }
    requestAnimationFrame(lauf);
})();
</script>

<?php require __DIR__ . '/../teile/fuss.php'; ?>
