<?php
// Startseite. Dramaturgie der Bühne (Stand 17.9.2026, Beschluss Roman):
// Claim + fliegende Projekt-Objekte + drei Fragen → das Übergangsbild
// (weiß oben, schwarz unten) scrollt herein und trägt die Seite ins Schwarz
// (keine Einblendung) → Antwort zweizeilig mit zwei Pfeil-Knöpfen → der
// Splash scrollt herein, darauf schwebt das Team-Foto im Orbit, darunter
// zentriert Text und Knopf. Danach: die zwei Säulen (Fassung „frei") mit
// den Leistungs-Laufbändern darunter · Newsletter-Karte mit hineinragendem
// Kuvert · Abschluss-CTA.
// Ohne JavaScript oder bei reduzierter Bewegung steht die statische Fassung.

require_once __DIR__ . '/teile/firma.php';
require_once __DIR__ . '/teile/projekte.php';

$titel        = 'leerzeichen — Erlebnisse und Gestaltung | Neumarkt/Ybbs';
$beschreibung = 'Agentur für Ausstellungen, Erlebniswege und Corporate Design. '
              . 'Seit 2008 in Neumarkt an der Ybbs. Für Museen, Gemeinden und Unternehmen.';
$styles       = ['/assets/startseite.css'];
$voll_breit   = true;



// Die drei Fragen. Senkrechter Strich = fester Zeilenumbruch (dreizeilig auf
// jeder Bildschirmbreite, auch 27 Zoll).
$fragen = [
    'Wie wird aus Ihrem Projekt|ein Erlebnis, das neue|Besucher bringt?',
    'Wie wird aus Ihrem|Unternehmen ein Bild,|das man wiedererkennt?',
    'Und wie wird aus beidem|eine Geschichte, die man|weitererzählt?',
];

// Bahnen der Projekt-Objekte — IMMER acht (Beschluss Roman 17.9.2026).
// Die Objekte schweben nahezu am Stand (nur sanftes seitliches Treiben, vx)
// und wandern ans Scrollen gekoppelt nach oben: y0 = Startlage in vh,
// tiefe = wie viele vh sie über die ganze Bühnenstrecke zurücklegen —
// dadurch verteilen sie sich über die Fragen-Reise statt auf einen Schirm.
// tiefe ≈ Bühnenhöhe (980vh): die Objekte ziehen etwa im Seitentempo vorbei
// (kein Schwindel), leichte Unterschiede geben dezente Tiefe. y0 staffelt
// sie über die Strecke — es sind immer nur zwei, drei zugleich im Bild.
// Die Objekte laufen auf einer UMLAUFBAHN (buehne.js, Spanne 200 vh): Wer
// oben hinausfliegt, kommt unten wieder herein — die Dichte bleibt dadurch
// über die ganze Scrollstrecke gleich, und ständig fliegt eines von unten
// ins Bild (Roman, 24.9.2026). y0 verteilt die zehn gleichmäßig über die
// Spanne, die leicht unterschiedlichen Tiefen lassen sie gegeneinander
// wandern, damit die Verteilung lebendig bleibt.
$bahnen = [
    ['w' => 31, 'h' => 22, 'x' => 6,  'y0' => 8,   'tiefe' => 900, 'vx' => 0.28],
    ['w' => 24, 'h' => 19, 'x' => 62, 'y0' => 26,  'tiefe' => 870, 'vx' => -0.22],
    ['w' => 20, 'h' => 26, 'x' => 34, 'y0' => 46,  'tiefe' => 930, 'vx' => 0.20],
    ['w' => 27, 'h' => 18, 'x' => 80, 'y0' => 66,  'tiefe' => 850, 'vx' => -0.26],
    ['w' => 22, 'h' => 24, 'x' => 12, 'y0' => 88,  'tiefe' => 960, 'vx' => 0.18],
    ['w' => 28, 'h' => 19, 'x' => 52, 'y0' => 108, 'tiefe' => 890, 'vx' => -0.20],
    ['w' => 18, 'h' => 18, 'x' => 74, 'y0' => 128, 'tiefe' => 990, 'vx' => 0.24],
    ['w' => 25, 'h' => 16, 'x' => 28, 'y0' => 150, 'tiefe' => 920, 'vx' => -0.18],
    ['w' => 21, 'h' => 15, 'x' => 88, 'y0' => 168, 'tiefe' => 860, 'vx' => 0.22],
    ['w' => 26, 'h' => 17, 'x' => 44, 'y0' => 186, 'tiefe' => 940, 'vx' => -0.24],
];
// Immer zehn Flieger: gibt es weniger Projekte mit Objekt, wiederholen sie sich.
$objektProjekte = array_values(array_filter(pj_index(),
    fn($p) => !empty($p['objekt']['quellen'])));
$flieger = [];
if ($objektProjekte) {
    for ($i = 0; $i < count($bahnen); $i++) {
        $flieger[] = $objektProjekte[$i % count($objektProjekte)];
    }
}

// Die zwei Säulen (Texte: „Website-Texte"). Der erste Absatz ist der Lead.
$saeulen_boxen = [
    [
        'id' => 'erlebnis', 'url' => '/erlebnisgestaltung/', 'eyebrow' => 'Säule 1 · Erlebnisse',
        'titel' => 'Wir schaffen Erlebnisse — und bringen Neues in die Welt.',
        'text' => [
            'Erlebnisse haben viele Formen: Ausstellungen, Escape-Rooms und Treasure Trails, Rundwege mit interaktiven Stationen, Outdoor-Abenteuer, Spielplätze mit ihrer eigenen Geschichte, Kinderebenen, die eine Ausstellung für Familien öffnen. Am Ende steht immer dieselbe Frage: Was bringt Besucher zum Staunen?',
            'Wir arbeiten für Museen, Gemeinden, Ausflugsziele und Tourismusregionen. Oft an Kinder und ihre Familien gerichtet. Analog und begreifbar. Digital dort, wo es Sinn stiftet.',
        ],
        'liste' => ['Ausstellungen und Ausstellungsgestaltung', 'Kinderbegleitebenen', 'Escape-Rooms',
                    'Treasure Trails', 'Rundwege mit interaktiven Stationen', 'Outdoor-Abenteuer',
                    'Spielplatzkonzepte', 'Leitsysteme und Beschilderung', 'Interaktive Stationen'],
    ],
    [
        'id' => 'marke', 'url' => '/grafikdesign/', 'eyebrow' => 'Säule 2 · Gestaltung für Unternehmen',
        'titel' => 'Wir machen sichtbar, was Ihr Unternehmen ausmacht.',
        'text' => [
            'Zuerst das klare Bild: Logo, Farben, Schrift und Bildwelt. Daran erkennt man Sie auf den ersten Blick, auf Papier wie am Screen.',
            'Dann beginnt Ihre Marke zu agieren: ein Mitarbeitermagazin, das gelesen wird. Ein Buch, das im Regal bleibt. Eine Microsite, die Ihre neue Produktlinie in die Auslage stellt.',
            'Unsere Kunden sind meist regional, aber ihre Geschichten wirken (Europa)weit.',
        ],
        'liste' => ['Corporate Design und Redesign', 'Logoentwicklung', 'Mitarbeitermagazine',
                    'Kundenmagazine', 'Bücher und Publikationen', 'Kataloge und Prospekte',
                    'Geschäftsausstattung', 'Microsites und Landingpages', 'Screendesign'],
    ],
];
// Säulen-Gestaltung: Variante „frei" (Beschluss Roman 17.9.2026) —
// offene, schmale Spalten mit kräftiger Oberlinie, viel Weißraum.

// Team-Text (Kurzfassung „Über uns") — steht jetzt im Splash-Akt der Bühne.
$teamText = 'Ohne Leerzeichen wäre dieser Satz kaum zu lesen. Der kleinste Eingriff '
          . 'entscheidet darüber, ob etwas ankommt. Und der Abstand ist es, der den '
          . 'Blick lenkt und das Wichtige stehen lässt. Dem folgend begleiten wir seit '
          . FIRMA_GEGRUENDET . ' Projekte von der ersten Skizze bis zur Übergabe.';

// Motive: greifen automatisch, sobald die Datei unter assets/bilder/ liegt.
function startseite_bild(string $name): ?string
{
    foreach (['webp', 'jpg', 'png'] as $ext) {
        if (is_file(__DIR__ . '/assets/bilder/' . $name . '.' . $ext)) {
            return '/assets/bilder/' . $name . '.' . $ext;
        }
    }
    return null;
}
$inkSplash  = startseite_bild('ink-splash');
$uebergang  = startseite_bild('leerzeichen-design-abenteuer-erfolg-breiter_start_bg');
$teamFoto   = startseite_bild('team');

require __DIR__ . '/teile/kopf.php';
?>

<?php // ---- Scroll-Bühne (Skript schaltet um; hidden = die bekannte Regel) ---- ?>
<section id="buehne" class="buehne" hidden>
  <div class="buehne-blick">
    <div class="buehne-objekte">
      <?php foreach ($flieger as $i => $p): $b = $bahnen[$i]; ?>
      <div class="buehne-obj"
           data-w="<?= $b['w'] ?>" data-h="<?= $b['h'] ?>"
           data-x="<?= $b['x'] ?>" data-y0="<?= $b['y0'] ?>"
           data-tiefe="<?= $b['tiefe'] ?>" data-vx="<?= $b['vx'] ?>"
           data-kat="<?= e(PJ_SAEULEN[$p['saeule'] ?? ''][0] ?? '') ?>"
           data-titel="<?= e((string) ($p['titel'] ?? '')) ?>"
           data-punchline="<?= e((string) ($p['punchline'] ?? '')) ?>"
           data-url="/referenzen/<?= e((string) ($p['slug'] ?? '')) ?>/"
           style="width:<?= $b['w'] ?>vw;height:<?= $b['h'] ?>vh;transform:translate3d(<?= $b['x'] ?>vw,<?= $b['y0'] ?>vh,0)">
        <button type="button" aria-label="<?= e((string) ($p['titel'] ?? '')) ?>">
          <?= pj_bild($p['objekt'], '', '22vw') ?>
        </button>
      </div>
      <?php endforeach; ?>
    </div>

    <div class="buehne-fragen">
      <?php foreach ($fragen as $f): ?>
      <p class="buehne-frage"><?php foreach (explode('|', $f) as $zeile): ?><span class="buehne-zeile"><?= e($zeile) ?></span><?php endforeach; ?></p>
      <?php endforeach; ?>
    </div>

    <?php // Schwarzer Akt: liegt unter dem Übergangsbild, wird von ihm
          // zugedeckt aufgedeckt — keine Einblendung nötig. ?>
    <div class="buehne-finale" style="opacity:0;pointer-events:none">
      <div class="buehne-antwort" style="opacity:0">
        <h2><span class="buehne-zeile">Darauf finden wir</span><span class="buehne-zeile">gemeinsam Antworten.</span></h2>
        <p>Seit <?= e(FIRMA_GEGRUENDET) ?>.<br>gedruckt • gebaut • digital</p>
        <div class="buehne-knoepfe">
          <a class="knopf knopf-hell" href="/referenzen/">Referenzen <?= lz_pfeil() ?></a>
          <a class="knopf knopf-umriss" href="/kontakt/">Kontakt <?= lz_pfeil() ?></a>
        </div>
      </div>
      <?php // Splash-Akt: scrollt herein; darauf schwebt das Team-Foto im
            // Orbit, darunter zentriert Text und Knopf. ?>
      <div class="buehne-splash" style="transform:translateY(100vh)<?= $inkSplash ? ';background-image:url(' . e($inkSplash) . ')' : '' ?>">
        <div class="buehne-team">
          <?php if ($teamFoto): ?>
          <div class="buehne-team-halter">
            <img class="buehne-team-foto" src="<?= e($teamFoto) ?>" width="2500" height="1667"
              alt="Das Team von leerzeichen bespricht Entwürfe an der Moodboard-Wand">
          </div>
          <?php endif; ?>
          <div class="buehne-team-text">
            <h2 class="lz-h3">Wir sind Leerzeichen.</h2>
            <p><?= e($teamText) ?></p>
            <a class="knopf" href="/agentur/">Lernen Sie unser Team kennen <?= lz_pfeil() ?></a>
          </div>
        </div>
      </div>
    </div>

    <?php // Übergangsbild (weiß oben, schwarz unten): scrollt über die weiße
          // Bühne herein und trägt sie ins Schwarz — liegt ÜBER dem Finale. ?>
    <?php if ($uebergang): ?>
    <div class="buehne-uebergang" style="transform:translateY(100vh);background-image:url(<?= e($uebergang) ?>)"></div>
    <?php endif; ?>
  </div>

  <div class="buehne-claimblock">
    <h1 class="lz-claim">Gemeinsam<br>Zeichen setzen.</h1>
  </div>
</section>

<?php // ---- Statische Fassung: ohne JavaScript ist DAS die Startseite -------- ?>
<section id="buehne-statisch" class="buehne-statisch">
  <h1 class="lz-claim">Gemeinsam<br>Zeichen setzen.</h1>
  <?php foreach ($fragen as $f): ?>
  <p class="buehne-statisch-frage"><?= e(str_replace('|', ' ', $f)) ?></p>
  <?php endforeach; ?>
  <p class="lz-lead buehne-statisch-antwort">Darauf finden wir gemeinsam Antworten.
    Seit <?= e(FIRMA_GEGRUENDET) ?> — gedruckt • gebaut • digital.</p>
  <div class="buehne-knoepfe">
    <a class="knopf" href="/referenzen/">Referenzen <?= lz_pfeil() ?></a>
    <a class="knopf knopf-umriss-dunkel" href="/kontakt/">Kontakt <?= lz_pfeil() ?></a>
  </div>
  <div class="lz-teamgrid" style="margin-top:var(--space-9)">
    <?php if ($teamFoto): ?>
    <img class="team-foto-bild" src="<?= e($teamFoto) ?>"
      alt="Das Team von leerzeichen bespricht Entwürfe an der Moodboard-Wand" loading="lazy">
    <?php endif; ?>
    <div>
      <h2 class="lz-h2">Wir sind Leerzeichen.</h2>
      <p class="lz-lead" style="margin-top:var(--space-5);max-width:min(44ch,100%)"><?= e($teamText) ?></p>
      <div style="margin-top:var(--space-6)">
        <a class="knopf" href="/agentur/">Lernen Sie unser Team kennen <?= lz_pfeil() ?></a>
      </div>
    </div>
  </div>
</section>

<?php // ---- Die zwei Säulen (Variante über ?saeulen=…, bis entschieden) -------- ?>


<section id="handwerk" class="lz-sec">
  <?= lz_laufband($saeulen_boxen[0]['liste'], 'kipp-a') ?>
  <h2 class="handwerk-titel"><span class="buehne-zeile">Gestaltung ist</span><span class="buehne-zeile">unser Handwerk.</span></h2>
  <div class="lz-saeulen">
    <?php foreach ($saeulen_boxen as $box): ?>
    <article id="<?= e($box['id']) ?>" class="lz-saeule">
      <h3 class="lz-saeule-titel"><?= e($box['titel']) ?></h3>
      <?php foreach ($box['text'] as $t): ?>
      <p class="lz-saeule-text"><?= e($t) ?></p>
      <?php endforeach; ?>
      <div class="lz-saeule-fuss">
        <a class="knopf" href="<?= e($box['url']) ?>">Mehr dazu <?= lz_pfeil() ?></a>
      </div>
    </article>
    <?php endforeach; ?>
  </div>

  <?php // 100 px Luft zwischen Säulen-Texten und dem zweiten Band (Roman, 24.9.2026). ?>
  <div style="margin-top:100px">
    <?= lz_laufband($saeulen_boxen[1]['liste'], 'laufband-retour kipp-b') ?>
  </div>
</section>

<?php require __DIR__ . '/teile/newsletter.php'; ?>
<?php require __DIR__ . '/teile/cta.php'; ?>

<script src="<?= e(lz_asset('/assets/buehne.js')) ?>" defer></script>
<?php require __DIR__ . '/teile/fuss.php'; ?>
