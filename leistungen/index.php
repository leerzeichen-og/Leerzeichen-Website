<?php
// Leistungen — Brückenseite (Fassung Roman, 7.10.2026): KEIN Seitenkopf,
// die zwei Säulen stehen direkt nebeneinander. Hintergrund je Kachel ein
// Video (assets/videos/, 16:9, startet automatisch und bleibt am letzten
// Frame stehen — darum bewusst KEIN loop-Attribut); liegt das Video (noch)
// nicht im Repo, trägt die bisherige Grafik die Kachel. Das
// Leistungsverzeichnis steht als echte zweispaltige Liste.
require_once __DIR__ . '/../teile/firma.php';

$titel        = 'Leistungen — Erlebnisse und Gestaltung | leerzeichen';
$beschreibung = 'Zwei Säulen tragen unsere Arbeit: Erlebnisse für Museen, Gemeinden und '
              . 'Ausflugsziele — und Gestaltung für Unternehmen.';
$brotkrumen   = [['Leistungen', '/leistungen/']];
$voll_breit   = true;

// Video nur anbieten, wenn die Datei wirklich liegt (Roman lädt sie hoch).
function leistung_video(string $name): ?string
{
    return is_file(__DIR__ . '/../assets/videos/' . $name) ? '/assets/videos/' . $name : null;
}

$saeulen = [
    [
        'chip'   => 'Erlebnisse & Abenteuer',
        'titel'  => 'Wir schaffen Erlebnisse — und bringen Neues in die Welt.',
        'text'   => 'Für Museen, Gemeinden, Ausflugsziele und Tourismusregionen.',
        'liste'  => ['Ausstellungen', 'Kinderbegleitebenen', 'Escape-Rooms', 'Treasure Trails',
                     'Rundwege', 'Outdoor-Abenteuer', 'Spielplatzkonzepte', 'Leitsysteme'],
        'url'    => '/erlebnisgestaltung/',
        'knopf'  => 'Mehr zu Erlebnissen',
        'video'  => leistung_video('leerzeichen-abenteuer.mp4'),
        'bild'   => '/assets/bilder/leerzeichen-adventure.webp',
    ],
    [
        'chip'   => 'Gestaltung für Unternehmen',
        'titel'  => 'Wir machen sichtbar, was Ihr Unternehmen ausmacht.',
        'text'   => 'Das klare Bild — auf Papier, am Screen und auf der Messe.',
        'liste'  => ['Corporate Design', 'Logoentwicklung', 'Mitarbeitermagazine',
                     'Kundenmagazine', 'Bücher und Publikationen', 'Kataloge',
                     'Microsites und Landingpages', 'Screendesign'],
        'url'    => '/grafikdesign/',
        'knopf'  => 'Mehr zur Gestaltung',
        'video'  => leistung_video('leerzeichen-vernetzte-gestaltung.mp4'),
        'bild'   => '/assets/bilder/leerzeichen-gestalterisch.webp',
    ],
];

require __DIR__ . '/../teile/kopf.php';
?>

<h1 class="nur-vorleser">Leistungen</h1>

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
    document.querySelectorAll('.leistung-video').forEach(function (v) {
        v.pause();
        v.removeAttribute('autoplay');
    });
}
</script>

<?php require __DIR__ . '/../teile/newsletter.php'; ?>
<?php require __DIR__ . '/../teile/cta.php'; ?>

<?php require __DIR__ . '/../teile/fuss.php'; ?>
