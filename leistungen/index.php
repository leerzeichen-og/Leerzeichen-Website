<?php
// Leistungen (Fassung Roman, 8.10.2026): durchgehend schwarze Seite.
// Hero mit dem Schiff-Film (läuft EINMAL, bleibt dann stehen — kein loop)
// und dem Statement „Information braucht Form."; die drei Hero-Absätze
// blenden beim Scrollen einzeln ein und aus (Muster der Startseiten-
// Fragen, Mechanik unten im Skript). Danach die zwei Säulen als
// Kontur-Boxen ohne Bildmotiv, der Stärken-Block, der Ablauf als
// Zeitstrahl und der Abschluss-CTA. Texte: Roman, 8.10.2026.
require_once __DIR__ . '/../teile/firma.php';

$titel        = 'Leistungen — Erlebnisse und Gestaltung | leerzeichen';
$beschreibung = 'Jede Gestaltungsaufgabe beginnt mit einer Information, die vermittelt '
              . 'werden soll. Grafikdesign und Erlebnisgestaltung aus einer Hand.';
$brotkrumen   = [['Leistungen', '/leistungen/']];
$voll_breit   = true;
$bodyKlasse   = 'seite-dunkel';

$saeulen = [
    [
        'chip'   => 'Gestaltung für Unternehmen',
        'titel'  => 'Identität sichtbar machen.',
        'text'   => 'Wir entwickeln Corporate Designs, Websites, Publikationen und '
                  . 'Werbemittel. Unsere Kunden sind Betriebe, die zeigen wollen, was '
                  . 'sie können. Die Frage dahinter: Wie wird aus Ihrem Betrieb eine '
                  . 'Marke, die im Kopf bleibt?',
        'liste'  => ['Corporate Design und Redesign', 'Logoentwicklung',
                     'Geschäftsausstattung', 'Mitarbeiter- und Kundenmagazine',
                     'Bücher und Chroniken', 'Zeitungen',
                     'Kataloge, Prospekte und Folder', 'Datenblätter',
                     'Plakate und Inserate', 'Etiketten und Verpackungen',
                     'Fahrzeug- und Schaufensterbeschriftung', 'Messeauftritte',
                     'Microsites und Landingpages', 'Screendesign und LED-Screens'],
        'url'    => '/grafikdesign/',
        'knopf'  => 'Zum Grafikdesign',
    ],
    [
        'chip'   => 'Erlebnisse & Abenteuer',
        'titel'  => 'Inhalte zugänglich machen.',
        'text'   => 'Wir gestalten Ausstellungen, Erlebniswege, Spielplätze mit '
                  . 'Geschichte und interaktive Stationen. Unsere Auftraggeber sind '
                  . 'Museen, Gemeinden, Tourismusregionen und Ausflugsziele. Die Frage '
                  . 'dahinter ist immer dieselbe: Was bringt Besucher zum Staunen und '
                  . 'zum Bleiben?',
        'liste'  => ['Ausstellungen und Ausstellungsgestaltung', 'Kinderbegleitebenen',
                     'Escape-Rooms', 'Treasure Trails',
                     'Rundwege mit interaktiven Stationen', 'Outdoor-Abenteuer',
                     'Spielplatzkonzepte', 'Leitsysteme und Beschilderung',
                     'Audio- und Printstationen im Raum'],
        'url'    => '/erlebnisgestaltung/',
        'knopf'  => 'Zur Erlebnisgestaltung',
    ],
];

$ablauf = [
    ['Persönliches Gespräch',
     'Wir hören zu, fragen nach und klären, worum es im Kern geht.'],
    ['Angebot und Budgetrahmen',
     'Sie bekommen ein Angebot mit klarer Leistungsabgrenzung. Gespräch und Angebot kosten nichts, aber bringen viel.'],
    ['Recherche und Konzeption',
     'Wir arbeiten uns in das Thema ein und entwickeln den roten Faden.'],
    ['Konzeptfreigabe',
     'Wir besprechen das Konzept gemeinsam und legen die Richtung fest, bevor es weitergeht.'],
    ['Gestaltung und Ausarbeitung',
     'Das Konzept bekommt Form: im Raum, am Screen oder auf Papier.'],
    ['Präsentation und Freigabe',
     'Wir stellen die Entwürfe vor, besprechen Details und holen Ihre Freigabe ein.'],
    ['Produktion und Umsetzung',
     'Wir überwachen den Druck, begleiten die Montage vor Ort und koordinieren alle Beteiligten.'],
    ['Übergabe',
     'Eröffnung, Livegang oder Auslieferung. Danach bleiben wir erreichbar.'],
];

require __DIR__ . '/../teile/kopf.php';
?>

<?php // Hero im Kontakt-Kopf-Muster. Die „Leinwand" trägt den Film und den
      // Text; mit JavaScript bekommt die Sektion eine Scrollstrecke, die
      // Leinwand bleibt stehen (sticky) und die Absätze wechseln einzeln —
      // ohne JavaScript stehen alle drei normal untereinander. ?>
<section class="leistung-hero" id="l-hero">
  <div class="seiten-hero leistung-hero-leinwand">
    <video class="leistung-hero-video" src="/assets/videos/leerzeichen-abenteuer.mp4"
      autoplay muted playsinline aria-hidden="true"></video>
    <div class="leistung-hero-inhalt">
      <h1 class="titel-gross">Information<br>braucht Form.</h1>
      <div class="kopf-gross-zeile">
        <div class="kopf-gross-rechts">
        <p>Jede Gestaltungsaufgabe beginnt mit einer Information, die vermittelt
          werden soll. Ein Unternehmen braucht ein Erscheinungsbild. Eine
          Organisation eine Website. Eine Stadt ein Buch. Ein Museum eine
          Ausstellung.</p>
        <p>Diese Projekte wirken grundsätzlich verschieden, haben aber dasselbe
          Ziel: Die Information soll bei der richtigen Zielgruppe ankommen. Genau
          das können wir. Was zählt, ist das Zusammenspiel aus Inhalt, Didaktik
          und Form, und wir beherrschen die Werkzeuge dafür.</p>
        <p>Was sich ändert, sind die Mittel. Papier verhält sich anders als ein
          Screen, ein Raum anders als ein Waldweg. Wir kennen diese Unterschiede
          aus vielen Jahren Praxis. Und wo unsere Spezialisierung endet, beginnt
          unser Netzwerk.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<?php // Die zwei Säulen als Kontur-Boxen: schwarzer Grund, starke weiße
      // Linie — kein Bildmotiv mehr (Roman, 8.10.2026). ?>
<section class="lz-sec leistungs-kacheln">
  <?php foreach ($saeulen as $s): ?>
  <a class="leistung-kachel" href="<?= e($s['url']) ?>">
    <span class="leistung-inhalt">
      <span class="chip"><?= e($s['chip']) ?></span>
      <h2><?= e($s['titel']) ?></h2>
      <span class="leistung-text"><?= e($s['text']) ?></span>
      <ul class="leistung-liste">
        <?php foreach ($s['liste'] as $l): ?>
        <li><?= e($l) ?></li>
        <?php endforeach; ?>
      </ul>
      <span class="knopf knopf-hell"><?= e($s['knopf']) ?> <?= lz_pfeil() ?></span>
    </span>
  </a>
  <?php endforeach; ?>
</section>

<script>
(function () {
    // Bei reduzierter Bewegung bleibt der Hero-Film auf dem ersten Bild,
    // und die Absätze stehen statisch untereinander (kein Scroll-Wechsel).
    var ruhig = matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (ruhig) {
        document.querySelectorAll('.leistung-hero-video').forEach(function (v) {
            v.pause();
            v.removeAttribute('autoplay');
        });
        return;
    }

    // Hero-Absätze wechseln beim Scrollen (Muster der Startseiten-Fragen):
    // die Sektion bekommt eine Scrollstrecke, die Leinwand bleibt stehen,
    // je Scrollfortschritt ist genau ein Absatz sichtbar. Der dritte bleibt
    // am Ende stehen, damit der Übergang zu den Säulen nicht leer ist.
    var hero = document.getElementById('l-hero');
    if (!hero) { return; }
    var abs = hero.querySelectorAll('.kopf-gross-rechts p');
    if (abs.length < 2) { return; }
    var FENSTER = [[0.04, 0.34], [0.40, 0.68], [0.74, 1.10]];
    var BLENDE = 0.08;   // Breite der Ein-/Ausblendzone im Fortschritt
    hero.classList.add('rollt');
    function zeichnen() {
        var r = hero.getBoundingClientRect();
        var strecke = r.height - innerHeight;
        var p = strecke > 0 ? Math.min(1, Math.max(0, -r.top / strecke)) : 1;
        abs.forEach(function (el, i) {
            var f = FENSTER[Math.min(i, FENSTER.length - 1)];
            var o = Math.min((p - f[0]) / BLENDE, (f[1] - p) / BLENDE);
            el.style.opacity = String(Math.max(0, Math.min(1, o)));
        });
    }
    addEventListener('scroll', zeichnen, { passive: true });
    addEventListener('resize', zeichnen);
    zeichnen();
})();
</script>

<?php // Stärken-Block: Überschrift links am Rand, Text versetzt rechts —
      // dieselbe Sprache wie die Seitenköpfe. ?>
<section class="lz-sec">
  <h2>Das ist unsere Stärke.</h2>
  <div class="kopf-gross-zeile">
    <div class="kopf-gross-rechts">
      <p>Die meisten Vorhaben bleiben nicht bei einem Format. Wir entwickeln
        eine Ausstellung und gestalten danach die Plakate, den Folder und die
        Website dazu. Oder wir schärfen das Erscheinungsbild eines Betriebs und
        übersetzen es in einen Messestand oder eine interaktive Station.</p>
      <p>Das können wir, weil wir beide Seiten kennen. Weil wir wissen, wie
        Drucksachen produziert werden, wie Websites ihre Ziele erreichen und
        was eine Station im Freien jahrelang aushält. Wir gestalten auf Papier
        und im Raum. Wir bauen interaktive Tools analog und digital.</p>
    </div>
  </div>
</section>

<?php // Der Ablauf als Zeitstrahl: Überschrift links, rechts die acht
      // Stationen an einer durchgehenden Linie. ?>
<section class="lz-sec ablauf">
  <h2>So gehen wir das an.</h2>
  <div class="kopf-gross-zeile">
    <div class="kopf-gross-rechts">
      <p>Jedes Projekt ist anders. Der Ablauf sieht aber meistens so aus:</p>
      <ol class="ablauf-liste">
        <?php foreach ($ablauf as $i => [$schritt, $text]): ?>
        <li class="ablauf-schritt">
          <span class="ablauf-nr" aria-hidden="true"><?= str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT) ?></span>
          <div>
            <h3><?= e($schritt) ?></h3>
            <p><?= e($text) ?></p>
          </div>
        </li>
        <?php endforeach; ?>
      </ol>
    </div>
  </div>
</section>

<?php require __DIR__ . '/../teile/newsletter.php'; ?>
<?php require __DIR__ . '/../teile/cta.php'; ?>

<?php require __DIR__ . '/../teile/fuss.php'; ?>
