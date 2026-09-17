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

// Der lange Leerzeichen-Pfeil (assets/long-long-pfeil.svg) — inline, damit er
// die Schriftfarbe des Knopfs übernimmt.
$pfeil = '<svg viewBox="0 0 63.611 14.4" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">'
       . '<path fill="currentColor" d="M54.906,12.9l4.622-4.622H0V6.125H59.528L54.906,1.5,56.412,0l7.2,7.2-7.2,7.2Z"/></svg>';

// Die drei Fragen. Senkrechter Strich = fester Zeilenumbruch (dreizeilig auf
// jeder Bildschirmbreite, auch 27 Zoll).
$fragen = [
    'Wie wird aus Ihrem Projekt|ein Erlebnis, das neue|Besucher bringt?',
    'Wie wird aus Ihrem|Unternehmen ein Bild,|das man wiedererkennt?',
    'Und wie wird aus beidem|eine Geschichte, die man|weitererzählt?',
];

// Flugbahnen der Projekt-Objekte (aus Space, Bild-Slot „objekt"; höchstens acht).
$bahnen = [
    ['w' => 21, 'h' => 15, 'x' => 14, 'y' => 64,  'vx' => 0.9,   'vy' => -0.5],
    ['w' => 16, 'h' => 13, 'x' => 68, 'y' => 86,  'vx' => -0.7,  'vy' => -0.75],
    ['w' => 13, 'h' => 17, 'x' => 42, 'y' => 92,  'vx' => 0.65,  'vy' => -0.6],
    ['w' => 18, 'h' => 12, 'x' => 26, 'y' => 104, 'vx' => -0.85, 'vy' => -0.45],
    ['w' => 15, 'h' => 16, 'x' => 80, 'y' => 60,  'vx' => 0.5,   'vy' => -0.85],
    ['w' => 19, 'h' => 13, 'x' => 54, 'y' => 112, 'vx' => -0.55, 'vy' => -0.8],
    ['w' => 12, 'h' => 12, 'x' => 6,  'y' => 96,  'vx' => 0.8,   'vy' => -0.4],
    ['w' => 17, 'h' => 11, 'x' => 90, 'y' => 100, 'vx' => -0.6,  'vy' => -0.7],
];
$flieger = array_slice(
    array_values(array_filter(pj_index(), fn($p) => !empty($p['objekt']['quellen']))),
    0, count($bahnen)
);

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
           data-x="<?= $b['x'] ?>" data-y="<?= $b['y'] ?>"
           data-vx="<?= $b['vx'] ?>" data-vy="<?= $b['vy'] ?>"
           data-kat="<?= e(PJ_SAEULEN[$p['saeule'] ?? ''][0] ?? '') ?>"
           data-titel="<?= e((string) ($p['titel'] ?? '')) ?>"
           data-punchline="<?= e((string) ($p['punchline'] ?? '')) ?>"
           data-url="/referenzen/<?= e((string) ($p['slug'] ?? '')) ?>/"
           style="width:<?= $b['w'] ?>vw;height:<?= $b['h'] ?>vh;transform:translate3d(<?= $b['x'] ?>vw,<?= $b['y'] ?>vh,0)">
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
          <a class="knopf knopf-hell" href="/referenzen/">Referenzen <?= $pfeil ?></a>
          <a class="knopf knopf-umriss" href="/kontakt/">Kontakt <?= $pfeil ?></a>
        </div>
      </div>
      <?php // Splash-Akt: scrollt herein; darauf schwebt das Team-Foto im
            // Orbit, darunter zentriert Text und Knopf. ?>
      <div class="buehne-splash" style="transform:translateY(100vh)<?= $inkSplash ? ';background-image:url(' . e($inkSplash) . ')' : '' ?>">
        <div class="buehne-team">
          <?php if ($teamFoto): ?>
          <img class="buehne-team-foto" src="<?= e($teamFoto) ?>"
            alt="Das Team von leerzeichen bespricht Entwürfe an der Moodboard-Wand">
          <?php endif; ?>
          <div class="buehne-team-text">
            <h2 class="lz-h3">Wir sind Leerzeichen.</h2>
            <p><?= e($teamText) ?></p>
            <a class="knopf" href="/agentur/">Lernen Sie unser Team kennen <?= $pfeil ?></a>
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
    <a class="knopf" href="/referenzen/">Referenzen <?= $pfeil ?></a>
    <a class="knopf knopf-umriss-dunkel" href="/kontakt/">Kontakt <?= $pfeil ?></a>
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
        <a class="knopf" href="/agentur/">Lernen Sie unser Team kennen <?= $pfeil ?></a>
      </div>
    </div>
  </div>
</section>

<?php // ---- Die zwei Säulen (Variante über ?saeulen=…, bis entschieden) -------- ?>
<section id="handwerk" class="lz-sec">
  <h2 class="handwerk-titel">Gestaltung ist unser Handwerk.</h2>
  <div class="lz-saeulen">
    <?php foreach ($saeulen_boxen as $box): ?>
    <article id="<?= e($box['id']) ?>" class="lz-saeule">
      <h3 class="lz-saeule-titel"><?= e($box['titel']) ?></h3>
      <?php foreach ($box['text'] as $t): ?>
      <p class="lz-saeule-text"><?= e($t) ?></p>
      <?php endforeach; ?>
      <div class="lz-saeule-fuss">
        <a class="knopf" href="<?= e($box['url']) ?>">Mehr dazu <?= $pfeil ?></a>
      </div>
    </article>
    <?php endforeach; ?>
  </div>

  <?php // Die Leistungen beider Säulen: zwei gegenläufige Laufbänder, dezent.
        // Der Inhalt steht doppelt in der Spur (aria-hidden), damit die
        // Schleife nahtlos läuft; bei reduzierter Bewegung stehen die Bänder
        // als umbrechende Liste still. ?>
  <div class="laufbaender" aria-label="Unsere Leistungen">
    <?php foreach ($saeulen_boxen as $nr => $box): ?>
    <div class="laufband <?= $nr === 1 ? 'laufband-retour' : '' ?>">
      <div class="laufband-spur">
        <?php for ($kopie = 0; $kopie < 2; $kopie++): ?>
        <span class="laufband-teil"<?= $kopie ? ' aria-hidden="true"' : '' ?>>
          <?php foreach ($box['liste'] as $l): ?>
          <span><?= e($l) ?></span><i aria-hidden="true"></i>
          <?php endforeach; ?>
        </span>
        <?php endfor; ?>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</section>

<?php require __DIR__ . '/teile/newsletter.php'; ?>
<?php require __DIR__ . '/teile/cta.php'; ?>

<script src="<?= e(lz_asset('/assets/buehne.js')) ?>" defer></script>
<?php require __DIR__ . '/teile/fuss.php'; ?>
