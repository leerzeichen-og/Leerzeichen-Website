<?php
// Leistungen (Fassung Roman, 8.10.2026): Hero mit Hintergrundfilm „Schiff"
// und dem Statement „Information braucht Form." — danach die zwei Säulen
// als Split-Teaser mit Video, der Stärken-Block, der Ablauf als Zeitstrahl
// und der Abschluss-CTA. Hintergrund je Kachel ein Video (assets/videos/,
// startet automatisch und bleibt am letzten Frame stehen — darum bewusst
// KEIN loop-Attribut); liegt ein Video (noch) nicht im Repo, trägt die
// Grafik bzw. das Ink-Motiv die Fläche. Texte: Roman, 8.10.2026.
require_once __DIR__ . '/../teile/firma.php';

$titel        = 'Leistungen — Erlebnisse und Gestaltung | leerzeichen';
$beschreibung = 'Jede Gestaltungsaufgabe beginnt mit einer Information, die vermittelt '
              . 'werden soll. Grafikdesign und Erlebnisgestaltung aus einer Hand.';
$brotkrumen   = [['Leistungen', '/leistungen/']];
$voll_breit   = true;

// Video nur anbieten, wenn die Datei wirklich liegt (Roman lädt sie hoch).
function leistung_video(string $name): ?string
{
    return is_file(__DIR__ . '/../assets/videos/' . $name) ? '/assets/videos/' . $name : null;
}

// Hero-Film: das Schiff. Fehlt die Datei, trägt das Ink-Motiv den Hero.
$heroVideo = leistung_video('leerzeichen-schiff.mp4');

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
        'video'  => leistung_video('leerzeichen-vernetzte-gestaltung.mp4'),
        'bild'   => '/assets/bilder/leerzeichen-gestalterisch.webp',
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
        'video'  => leistung_video('leerzeichen-abenteuer.mp4'),
        'bild'   => '/assets/bilder/leerzeichen-adventure.webp',
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

<?php // Hero im Kontakt-Kopf-Muster, darunter liegt der Film (abgedunkelt,
      // damit der weiße Text trägt). ?>
<section class="seiten-hero leistung-hero"<?= $heroVideo ? '' : ' style="background-image:linear-gradient(180deg, rgba(0,0,0,0) 30%, rgba(0,0,0,.9) 72%), url(/assets/bilder/ink-splash.webp)"' ?>>
  <?php if ($heroVideo): ?>
  <video class="leistung-hero-video" src="<?= e($heroVideo) ?>"
    autoplay muted loop playsinline aria-hidden="true"></video>
  <?php endif; ?>
  <div class="leistung-hero-inhalt">
    <h1 class="titel-gross">Information braucht Form.</h1>
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
</section>

<section class="lz-sec leistungs-kacheln">
  <?php foreach ($saeulen as $s): ?>
  <a class="leistung-kachel" href="<?= e($s['url']) ?>"
     <?= $s['video'] ? '' : 'style="background-image:url(' . e($s['bild']) . ')"' ?>>
    <?php if ($s['video']): ?>
    <video class="leistung-video" src="<?= e($s['video']) ?>"
      autoplay muted playsinline aria-hidden="true"></video>
    <?php endif; ?>
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
// Bei reduzierter Bewegung bleiben die Hintergrund-Videos auf dem ersten Bild.
if (matchMedia('(prefers-reduced-motion: reduce)').matches) {
    document.querySelectorAll('.leistung-video, .leistung-hero-video').forEach(function (v) {
        v.pause();
        v.removeAttribute('autoplay');
    });
}
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
