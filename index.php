<?php
// Startseite. Umsetzung des Claude-Design-Entwurfs „Startseite" (16.9.2026):
// Scroll-Bühne (Claim, fliegende Projekt-Objekte, drei Fragen, dunkles Finale
// mit Astronaut) · zwei Leistungsblöcke · Team · Newsletter · Kontakt-CTA.
// Ohne JavaScript oder bei reduzierter Bewegung steht statt der Bühne die
// statische Fassung (#buehne-statisch) — gleiche Inhalte, ruhig gesetzt.

require_once __DIR__ . '/teile/firma.php';
require_once __DIR__ . '/teile/projekte.php';

$titel        = 'leerzeichen — Erlebnisse und Gestaltung | Neumarkt/Ybbs';
$beschreibung = 'Agentur für Ausstellungen, Erlebniswege und Corporate Design. '
              . 'Seit 2008 in Neumarkt an der Ybbs. Für Museen, Gemeinden und Unternehmen.';
$styles       = ['/assets/startseite.css'];
$voll_breit   = true;

// Die drei Fragen der Bühne — das Skript zerlegt sie wortweise.
$fragen = [
    'Wie wird aus Ihrem Projekt ein Erlebnis, das neue Besucher bringt?',
    'Wie wird aus Ihrem Unternehmen ein Bild, das man wiedererkennt?',
    'Und wie wird aus beidem eine Geschichte, die man weitererzählt?',
];

// Flugbahnen aus dem Design (Breite/Höhe in vw/vh, Start x/y, Richtung vx/vy).
// Die Projekte kommen aus Space (index.json, Bild-Slot „objekt"), die Bahnen
// bleiben Gestaltung — Projekt i bekommt Bahn i, höchstens acht.
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

// Die beiden Leistungsblöcke (Texte aus dem Design-Entwurf).
$bloecke = [
    [
        'id' => 'erlebnis', 'url' => '/erlebnisgestaltung/',
        'titel' => 'Wir schaffen Erlebnisse — und bringen Neues in die Welt.',
        'text' => [
            'Erlebnisräume wie Ausstellungen, Escape-Rooms und Info-Pfade entstehen bei uns aus einer Frage: Was soll jemand mitnehmen, der wieder hinausgeht?',
            'Wir entwickeln die Idee, gestalten sie und begleiten den Bau bis zur Eröffnung — analog, digital oder beides.',
        ],
        'liste' => ['Ausstellungen', 'Escape-Rooms', 'Info-Pfade', 'Story-Spielplätze', 'Spiele', 'Apps'],
    ],
    [
        'id' => 'marke', 'url' => '/grafikdesign/',
        'titel' => 'Wir machen sichtbar, was Ihr Unternehmen ausmacht — und geben Ihrer Geschichte eine Form.',
        'text' => [
            'Ein Bild, Logo, Farben, Schrift und Blick fürs Detail: Daran erkennen Sie uns, und daran erkennt man Sie.',
            'Dann beginnt Ihre Marke zu arbeiten — in Drucksachen, auf der Website, in der Kampagne und im Gespräch.',
        ],
        'liste' => ['Corporate Design', 'Bücher', 'Zeitungen', 'Broschüren', 'Orientierungssysteme', 'Verpackungen', 'Websites', 'Kampagnen'],
    ],
];

// Motive, die erst noch eingecheckt werden: greifen automatisch, sobald die
// Datei unter assets/bilder/ liegt (jpg, webp oder png — erste gewinnt).
function startseite_bild(string $name): ?string
{
    foreach (['webp', 'jpg', 'png'] as $ext) {
        if (is_file(__DIR__ . '/assets/bilder/' . $name . '.' . $ext)) {
            return '/assets/bilder/' . $name . '.' . $ext;
        }
    }
    return null;
}
$inkSplash = startseite_bild('ink-splash');
$teamFoto  = startseite_bild('team');

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
      <p class="buehne-frage"><?= e($f) ?></p>
      <?php endforeach; ?>
    </div>

    <div class="buehne-finale lz-dark" style="opacity:0;pointer-events:none<?= $inkSplash ? ';background-image:url(' . e($inkSplash) . ')' : '' ?>">
      <div class="buehne-astro" style="opacity:0">
        <img src="/assets/bilder/astronaut.webp" alt="" width="640" height="900">
      </div>
      <div class="buehne-antwort" style="opacity:0">
        <h2>Darauf finden wir gemeinsam Antworten.</h2>
        <p>Seit <?= e(FIRMA_GEGRUENDET) ?>.<br>gedruckt · gebaut · digital</p>
      </div>
    </div>
  </div>

  <div class="buehne-claimblock">
    <h1 class="lz-claim">Gemeinsam<br>Zeichen setzen.</h1>
  </div>
</section>

<?php // ---- Statische Fassung: ohne JavaScript ist DAS die Startseite -------- ?>
<section id="buehne-statisch" class="buehne-statisch">
  <h1 class="lz-claim">Gemeinsam<br>Zeichen setzen.</h1>
  <?php foreach ($fragen as $f): ?>
  <p class="buehne-statisch-frage"><?= e($f) ?></p>
  <?php endforeach; ?>
  <p class="lz-lead buehne-statisch-antwort">Darauf finden wir gemeinsam Antworten.
    Seit <?= e(FIRMA_GEGRUENDET) ?> — gedruckt · gebaut · digital.</p>
  <a class="knopf" href="/referenzen/">Unsere Projekte ansehen</a>
</section>

<?php // ---- Zwei Leistungsblöcke ---------------------------------------------- ?>
<?php foreach ($bloecke as $block): ?>
<section id="<?= e($block['id']) ?>" class="lz-sec" style="padding-top:var(--space-10);padding-bottom:var(--space-10)">
  <h2 class="lz-h2" style="max-width:26ch"><?= e($block['titel']) ?></h2>
  <div class="lz-blockgrid">
    <div class="lz-blocktext">
      <?php foreach ($block['text'] as $t): ?>
      <p class="lz-lead"><?= e($t) ?></p>
      <?php endforeach; ?>
      <a class="knopf" href="<?= e($block['url']) ?>">Mehr dazu</a>
    </div>
    <ul class="lz-svc">
      <?php foreach ($block['liste'] as $l): ?>
      <li><?= e($l) ?></li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>
<?php endforeach; ?>

<?php // ---- Team (dunkel) ------------------------------------------------------ ?>
<section id="team" class="lz-dark lz-sec">
  <div class="lz-teamgrid">
    <?php if ($teamFoto): ?>
    <img class="team-foto-bild" src="<?= e($teamFoto) ?>"
      alt="Das Team von leerzeichen bespricht Entwürfe an der Moodboard-Wand" loading="lazy">
    <?php else: ?>
    <div class="team-foto">Foto folgt: Team an der Wand mit Entwürfen</div>
    <?php endif; ?>
    <div>
      <h2 class="lz-h2">Wir sind Leerzeichen.</h2>
      <p class="lz-lead" style="margin-top:var(--space-5);max-width:min(40ch,100%)">
        Ohne Leerzeichen wäre dieser Satz nur zu lesen. Wir arbeiten an genau diesem
        Zwischenraum: dort, wo etwas Platz bekommt, verständlich wird und Aufmerksamkeit
        findet. Ein kleines Team in <?= e(FIRMA_ORT) ?>, seit <?= e(FIRMA_GEGRUENDET) ?>
        für Wirtschaft, Tourismus und öffentliche Auftraggeber.
      </p>
      <div style="margin-top:var(--space-6)">
        <a class="knopf knopf-hell" href="/agentur/">Team kennenlernen</a>
      </div>
    </div>
  </div>
</section>

<?php // ---- Newsletter „Empty Space" ------------------------------------------- ?>
<section id="newsletter" class="lz-sec">
  <div class="nl-baum">
    <img src="/assets/bilder/newsletter-baum.webp" alt="" width="1356" height="1164" loading="lazy">
  </div>
  <div class="lz-nlcard">
    <div>
      <h2 class="lz-h3" style="font-weight:700">Empty Space</h2>
      <p class="lz-lead" style="margin:6px 0 var(--space-6);font-size:var(--text-base)">
        Der Newsletter von leerzeichen. Viermal im Jahr.</p>
      <ul class="lz-nllist">
        <li><strong>Ein Fokus-Thema</strong><span>Von Leerraum über Typografie bis zu den Details, die man sonst übersieht.</span></li>
        <li><strong>Projekt-Schnipsel</strong><span>Erlebnisse und Drucksachen, kurz gezeigt.</span></li>
        <li><strong>Designbegriffe erklärt</strong><span>Damit Sie wissen, wovon wir reden.</span></li>
      </ul>
    </div>
    <?php // Anmeldestrecke folgt mit der Newsletter-Entscheidung (voraussichtlich
          // Brevo) — bis dahin führt der Knopf zur Mail, damit nichts ins Leere geht. ?>
    <form class="nl-form" action="mailto:<?= e(FIRMA_MAIL) ?>?subject=Empty%20Space%20Anmeldung" method="get">
      <label class="lz-field"><span class="lz-label">E-Mail-Adresse</span><input class="lz-input" type="email" name="email"></label>
      <label class="lz-field"><span class="lz-label">Vorname</span><input class="lz-input" type="text" name="vorname"></label>
      <label class="lz-field"><span class="lz-label">Nachname</span><input class="lz-input" type="text" name="nachname"></label>
      <label class="nl-zustimmung">
        <input type="checkbox" required>
        <span>Ich bin damit einverstanden, dass leerzeichen mir den Newsletter zusendet.
          Eine Abmeldung ist jederzeit möglich.</span>
      </label>
      <div><button class="knopf" type="submit">Jetzt anmelden</button></div>
    </form>
  </div>
</section>

<?php // ---- Abschluss-CTA -------------------------------------------------------- ?>
<section id="kontakt-cta" class="lz-dark lz-sec kontakt-cta">
  <h2 class="lz-h2">Gemeinsam bringen wir Neues in Ihre Welt.</h2>
  <div class="knopf-wrap">
    <a class="knopf knopf-hell" href="/kontakt/">Reden wir darüber</a>
  </div>
</section>

<script src="/assets/buehne.js" defer></script>
<?php require __DIR__ . '/teile/fuss.php'; ?>
