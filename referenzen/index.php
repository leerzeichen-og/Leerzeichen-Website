<?php
// Referenzen-Übersicht (Neufassung 19.11.2026, Roman — nach Rückmeldungen
// zur Gruppen-Fassung, Vorbild pentagram.com/work):
//   1. oben der Einleitungssatz (zugleich die h1),
//   2. darunter EINE Filterzeile: Säulen, dann die Kategorien; nach dem
//      Vorbeiscrollen schwebt sie am unteren Fensterrand mit,
//   3. ein dreispaltiges Raster, jedes Projekt genau einmal. Karten mit
//      "breit" (Schalter in Space) ziehen sich über zwei Spalten; Titel und
//      Punchline stehen unter dem Bild, die Kategorien erscheinen beim
//      Darüberfahren auf dem Bild.
// Reihenfolge = Reihenfolge in index.json (in Space unter Portfolio →
// „Reihenfolge auf der Website" gepflegt).
//
// Filtern geht ohne JavaScript über ?filter=…&kategorie=… (Neuladen); mit
// JavaScript ohne Neuladen, die Adresse wird mitgeführt.

require_once __DIR__ . '/../teile/firma.php';
require_once __DIR__ . '/../teile/projekte.php';

$titel        = 'Referenzen — Projekte von leerzeichen';
$beschreibung = 'Wir arbeiten mit Betrieben, Museen und Gemeinden — am Erscheinungsbild, '
              . 'an Büchern, Magazinen, Websites, Ausstellungen und Erlebniswegen.';
$brotkrumen   = [['Referenzen', '/referenzen/']];
$styles       = ['/assets/projekt.css'];
$voll_breit   = true;

$projekte = pj_index();

// Säulen-Filter: Adresswert → [Beschriftung, Säulen-Schlüssel in index.json].
$filterWahl = [
    'erlebnis'   => ['Erlebnis',   'erlebnisse'],
    'gestaltung' => ['Gestaltung', 'gestaltung'],
];

// Kategorie-Anker aus dem Namen (nur a-z, 0-9, Bindestrich) — für die
// Adresse (?kategorie=…) und die data-Attribute der Karten.
function pj_anker(string $name): string
{
    $s = strtr(mb_strtolower($name), ['ä' => 'ae', 'ö' => 'oe', 'ü' => 'ue', 'ß' => 'ss']);
    return trim(preg_replace('/[^a-z0-9]+/', '-', $s) ?? '', '-');
}

// Alle Kategorien des Bestands (Anker → Name), alphabetisch.
$kategorien = [];
foreach ($projekte as $p) {
    foreach ((array) ($p['schlagworte'] ?? []) as $t) {
        $kategorien[pj_anker((string) $t)] = (string) $t;
    }
}
uasort($kategorien, fn($a, $b) => strnatcasecmp($a, $b));

$filter = (string) ($_GET['filter'] ?? '');
if (!isset($filterWahl[$filter])) {
    $filter = '';
}
$kategorie = (string) ($_GET['kategorie'] ?? '');
if (!isset($kategorien[$kategorie])) {
    $kategorie = '';
}
$saeuleJetzt = $filter !== '' ? $filterWahl[$filter][1] : '';

/** Passt ein Projekt zu Säule und Kategorie? (Das Skript unten rechnet gleich.) */
function pj_passt(array $p, string $saeule, string $kategorie): bool
{
    if ($saeule !== '' && ($p['saeule'] ?? '') !== $saeule) {
        return false;
    }
    if ($kategorie !== '') {
        return in_array($kategorie, array_map(fn($t) => pj_anker((string) $t),
            (array) ($p['schlagworte'] ?? [])), true);
    }
    return true;
}

// Kategorien, die in der gewählten Säule vorkommen — die übrigen stehen
// versteckt in der Zeile (das Skript blendet sie beim Umschalten ein).
$kategorienDa = [];
foreach ($projekte as $p) {
    if (pj_passt($p, $saeuleJetzt, '')) {
        foreach ((array) ($p['schlagworte'] ?? []) as $t) {
            $kategorienDa[pj_anker((string) $t)] = true;
        }
    }
}

/** Adresse eines Filterzustands (für die Links ohne JavaScript). */
function pj_filter_url(string $filter, string $kategorie): string
{
    $q = http_build_query(array_filter(['filter' => $filter, 'kategorie' => $kategorie]));
    return '/referenzen/' . ($q !== '' ? '?' . $q : '');
}

$sichtbar = 0;

// Gruß an alle, die den Quellcode lesen (siehe teile/kopf.php).
$quellkunst = <<<'KUNST'
<!--
       .----------------------------------.
       |  [x] prompt_generator.sh    _ [] |
       |----------------------------------|
       |  > "Mach mal kurz preisgekröntes |
       |     Design & Raumkonzept..."     |
       |                                  |
       |  KI: [ RAUCH STEIGT AUF ]        |
       |  ERROR 404: Handwerk not found.  |
       '----------------------------------'
            \       \_______/        /
             \______________________/
                     |      |
                   __|______|_
                  (___________)

  "Das macht ja heute eh alles die KI."
  (Spoiler: Denken, Kuratieren & Schrauben müssen wir trotzdem selbst.)
-->
KUNST;

require __DIR__ . '/../teile/kopf.php';
?>

<section class="seiten-kopf pj-ref-kopf">
  <h1 class="pj-intro-satz">Wir arbeiten mit Betrieben, Museen und Gemeinden —
    am Erscheinungsbild, an Büchern und Magazinen, an Verpackungen und Websites,
    an Ausstellungen und Erlebniswegen.</h1>
</section>

<?php if (!$projekte): ?>
<section class="lz-sec">
  <p class="platzhalter">Hier erscheinen die Projekte, sobald Space sie veröffentlicht hat.</p>
</section>
<?php else: ?>
<section class="lz-sec pj-ref">
  <?php // Platzhalter: hält die Höhe der Filterzeile, wenn sie unten schwebt. ?>
  <div class="pj-ref-filterplatz">
    <nav class="pj-ref-filter" aria-label="Projekte filtern"><div class="pj-ref-filter-zeile">
      <a class="pj-ref-pille" href="<?= e(pj_filter_url('', '')) ?>" data-saeule=""
        <?= $filter === '' && $kategorie === '' ? ' aria-current="true"' : '' ?>>Alle</a>
      <?php foreach ($filterWahl as $schluessel => [$label, $saeule]): ?>
      <a class="pj-ref-pille" href="<?= e(pj_filter_url($schluessel, '')) ?>" data-saeule="<?= e($saeule) ?>"
        data-filter="<?= e($schluessel) ?>"<?= $filter === $schluessel ? ' aria-current="true"' : '' ?>><?= e($label) ?></a>
      <?php endforeach; ?>
      <?php if ($kategorien): ?>
      <span class="pj-ref-trenner" aria-hidden="true"></span>
      <?php foreach ($kategorien as $anker => $name): ?>
      <a class="pj-ref-pille pj-ref-pille-kat" href="<?= e(pj_filter_url($filter, $kategorie === $anker ? '' : $anker)) ?>"
        data-kategorie="<?= e($anker) ?>"<?= $kategorie === $anker ? ' aria-current="true"' : '' ?><?=
        isset($kategorienDa[$anker]) ? '' : ' hidden' ?>><?= e($name) ?></a>
      <?php endforeach; ?>
      <?php endif; ?>
    </div></nav>
  </div>

  <div class="pj-ref-raster">
    <?php foreach ($projekte as $p):
        $passt = pj_passt($p, $saeuleJetzt, $kategorie);
        $sichtbar += $passt ? 1 : 0;
        $tags  = array_values(array_filter(array_map('strval', (array) ($p['schlagworte'] ?? []))));
        $breit = !empty($p['breit']);
    ?>
    <a class="pj-ref-karte<?= $breit ? ' is-breit' : '' ?>" href="/referenzen/<?= e($p['slug'] ?? '') ?>/"
      data-saeule="<?= e((string) ($p['saeule'] ?? '')) ?>"
      data-kategorien="<?= e(implode(' ', array_map('pj_anker', $tags))) ?>"<?= $passt ? '' : ' hidden' ?>>
      <span class="pj-ref-bild">
        <?= pj_bild($p['teaser_quer'] ?? null, 'pj-ref-img', $breit
            ? '(max-width: 560px) 100vw, (max-width: 900px) 100vw, 66vw'
            : '(max-width: 560px) 100vw, (max-width: 900px) 50vw, 33vw') ?>
        <?php if ($tags): ?>
        <span class="pj-ref-kats">
          <?php foreach ($tags as $t): ?><span class="chip"><?= e($t) ?></span><?php endforeach; ?>
        </span>
        <?php endif; ?>
      </span>
      <span class="pj-ref-titel"><?= e((string) ($p['titel'] ?? '')) ?></span>
      <?php if (!empty($p['punchline'])): ?>
      <span class="pj-ref-punchline"><?= e((string) $p['punchline']) ?></span>
      <?php endif; ?>
    </a>
    <?php endforeach; ?>
  </div>
  <p class="platzhalter pj-ref-leer"<?= $sichtbar ? ' hidden' : '' ?>>In dieser Auswahl sind noch keine
    Projekte veröffentlicht — <a href="/referenzen/">alle zeigen</a>.</p>
  <?php // Ende des Rasters: Ab hier schwebt die Filterzeile nicht mehr mit. ?>
  <span class="pj-ref-ende" aria-hidden="true"></span>
</section>
<?php endif; ?>

<script>
// Filtern ohne Neuladen und die schwebende Filterzeile. Ohne Skript
// funktionieren die Links mit Neuladen, und die Zeile bleibt oben stehen.
(function () {
    var nav = document.querySelector('.pj-ref-filter');
    if (!nav) { return; }
    var platz  = document.querySelector('.pj-ref-filterplatz');
    var karten = [].slice.call(document.querySelectorAll('.pj-ref-karte'));
    var leer   = document.querySelector('.pj-ref-leer');
    var saeulenPillen = [].slice.call(nav.querySelectorAll('[data-saeule]'));
    var katPillen     = [].slice.call(nav.querySelectorAll('[data-kategorie]'));

    var stand = { filter: '', saeule: '', kategorie: '' };
    saeulenPillen.forEach(function (a) {
        if (a.getAttribute('aria-current') === 'true') {
            stand.filter = a.dataset.filter || '';
            stand.saeule = a.dataset.saeule;
        }
    });
    katPillen.forEach(function (a) {
        if (a.getAttribute('aria-current') === 'true') { stand.kategorie = a.dataset.kategorie; }
    });

    function passt(k, saeule, kategorie) {
        if (saeule && k.dataset.saeule !== saeule) { return false; }
        if (kategorie && (' ' + k.dataset.kategorien + ' ').indexOf(' ' + kategorie + ' ') < 0) { return false; }
        return true;
    }

    function markieren(a, an) {
        if (an) { a.setAttribute('aria-current', 'true'); } else { a.removeAttribute('aria-current'); }
    }

    function anwenden() {
        var n = 0, da = {};
        karten.forEach(function (k) {
            var ja = passt(k, stand.saeule, stand.kategorie);
            k.hidden = !ja;
            n += ja ? 1 : 0;
            if (passt(k, stand.saeule, '')) {
                k.dataset.kategorien.split(' ').forEach(function (t) { if (t) { da[t] = true; } });
            }
        });
        leer.hidden = n > 0;
        saeulenPillen.forEach(function (a) {
            // „Alle" leuchtet nur, wenn gar nichts gefiltert ist.
            markieren(a, a.dataset.saeule === stand.saeule && (a.dataset.saeule !== '' || !stand.kategorie));
        });
        katPillen.forEach(function (a) {
            a.hidden = !da[a.dataset.kategorie] && a.dataset.kategorie !== stand.kategorie;
            markieren(a, a.dataset.kategorie === stand.kategorie);
        });
        var q = [];
        if (stand.filter) { q.push('filter=' + encodeURIComponent(stand.filter)); }
        if (stand.kategorie) { q.push('kategorie=' + encodeURIComponent(stand.kategorie)); }
        history.replaceState(null, '', '/referenzen/' + (q.length ? '?' + q.join('&') : ''));
    }

    // Auslaufen am Rand, solange die Zeile seitlich weitergeht.
    var zeile = nav.querySelector('.pj-ref-filter-zeile');
    function rand() {
        var max = zeile.scrollWidth - zeile.clientWidth;
        zeile.classList.toggle('mehr-links', zeile.scrollLeft > 4);
        zeile.classList.toggle('mehr-rechts', max > 4 && zeile.scrollLeft < max - 4);
    }
    zeile.addEventListener('scroll', rand, { passive: true });
    window.addEventListener('resize', rand);
    rand();

    nav.addEventListener('click', function (ev) {
        var a = ev.target.closest('a');
        if (!a || ev.metaKey || ev.ctrlKey || ev.shiftKey) { return; }
        ev.preventDefault();
        if (a.hasAttribute('data-kategorie')) {
            stand.kategorie = stand.kategorie === a.dataset.kategorie ? '' : a.dataset.kategorie;
        } else {
            stand.filter = a.dataset.filter || '';
            stand.saeule = a.dataset.saeule;
            stand.kategorie = '';
        }
        anwenden();
        rand();
        // Schwebt die Zeile, geht es zurück an den Rasteranfang — sonst
        // stünde man nach dem Filtern mitten in einer kürzeren Liste.
        if (nav.classList.contains('is-schwebend')) {
            platz.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    });

    // Schweben: sobald die Zeile oben aus dem Fenster ist und solange das
    // Rasterende noch unter dem Fensterrand liegt (über Newsletter und Fuß
    // soll sie nicht liegen). Der Platzhalter hält dabei die Höhe.
    var ende = document.querySelector('.pj-ref-ende');
    if (!('IntersectionObserver' in window) || !platz || !ende) { return; }
    function hoehe() { platz.style.minHeight = nav.offsetHeight + 'px'; }
    hoehe();
    window.addEventListener('resize', function () {
        if (!nav.classList.contains('is-schwebend')) { platz.style.minHeight = ''; hoehe(); }
    });
    var oben = false, endeSicht = false;
    function schweben() {
        nav.classList.toggle('is-schwebend', oben && !endeSicht);
        rand();
    }
    new IntersectionObserver(function (e) {
        oben = !e[0].isIntersecting && e[0].boundingClientRect.top < 0;
        schweben();
    }).observe(platz);
    new IntersectionObserver(function (e) {
        endeSicht = e[0].isIntersecting || e[0].boundingClientRect.top < 0;
        schweben();
    }).observe(ende);
})();
</script>

<?php require __DIR__ . '/../teile/newsletter.php'; ?>
<?php require __DIR__ . '/../teile/cta.php'; ?>

<?php require __DIR__ . '/../teile/fuss.php'; ?>
