<?php
// Leistungen — Brückenseite (Struktur-Beschluss Roman, 7.10.2026, Vorbild
// bildwerk.tv/leistungen): Basisinfos zu beiden Säulen als große dunkle
// Kacheln (Hintergründe: leerzeichen-adventure / leerzeichen-gestalterisch),
// je mit Leistungs-Stichliste und Knopf zur Vertiefung auf der Säulen-Seite.
// Die Kurztexte sind aus den vorhandenen Säulen-Formulierungen verdichtet —
// Feinschliff gern über Roman („Website-Texte").
require_once __DIR__ . '/../teile/firma.php';

$titel        = 'Leistungen — Erlebnisse und Gestaltung | leerzeichen';
$beschreibung = 'Zwei Säulen tragen unsere Arbeit: Erlebnisse für Museen, Gemeinden und '
              . 'Ausflugsziele — und Gestaltung für Unternehmen.';
$brotkrumen   = [['Leistungen', '/leistungen/']];
$voll_breit   = true;

$saeulen = [
    [
        'chip'   => 'Säule 1 · Erlebnisse',
        'titel'  => 'Wir schaffen Erlebnisse — und bringen Neues in die Welt.',
        'text'   => 'Ausstellungen, Escape-Rooms und Treasure Trails, Rundwege mit '
                  . 'interaktiven Stationen, Outdoor-Abenteuer, Spielplätze und '
                  . 'Kinderebenen — für Museen, Gemeinden, Ausflugsziele und '
                  . 'Tourismusregionen.',
        'liste'  => ['Ausstellungen', 'Kinderbegleitebenen', 'Escape-Rooms', 'Treasure Trails',
                     'Rundwege', 'Outdoor-Abenteuer', 'Spielplatzkonzepte', 'Leitsysteme'],
        'url'    => '/erlebnisgestaltung/',
        'knopf'  => 'Mehr zu Erlebnissen',
        'bild'   => '/assets/bilder/leerzeichen-adventure.webp',
    ],
    [
        'chip'   => 'Säule 2 · Gestaltung für Unternehmen',
        'titel'  => 'Wir machen sichtbar, was Ihr Unternehmen ausmacht.',
        'text'   => 'Zuerst das klare Bild: Logo, Farben, Schrift und Bildwelt. Dann '
                  . 'beginnt Ihre Marke zu agieren — in Magazinen, Büchern, Katalogen '
                  . 'und Microsites, die jemand freiwillig in die Hand nimmt.',
        'liste'  => ['Corporate Design', 'Logoentwicklung', 'Mitarbeitermagazine',
                     'Kundenmagazine', 'Bücher und Publikationen', 'Kataloge',
                     'Microsites und Landingpages', 'Screendesign'],
        'url'    => '/grafikdesign/',
        'knopf'  => 'Mehr zur Gestaltung',
        'bild'   => '/assets/bilder/leerzeichen-gestalterisch.webp',
    ],
];

require __DIR__ . '/../teile/kopf.php';
?>

<section class="seiten-kopf">
  <span class="chip">Leistungen</span>
  <h1 class="titel-seite">Was wir gestalten.</h1>
</section>
<section class="text-spalte" style="padding-bottom:var(--space-7)">
  <p>Zwei Säulen tragen unsere Arbeit: Erlebnisse für Museen, Gemeinden und
    Ausflugsziele — und Gestaltung für Unternehmen. Hier der Überblick,
    dahinter jeweils die Vertiefung.</p>
</section>

<section class="lz-sec leistungs-kacheln" style="padding-top:0">
  <?php foreach ($saeulen as $s): ?>
  <a class="leistung-kachel" href="<?= e($s['url']) ?>"
     style="background-image:linear-gradient(180deg, rgba(0,0,0,.2) 0%, rgba(0,0,0,.78) 78%), url(<?= e($s['bild']) ?>)">
    <span class="chip"><?= e($s['chip']) ?></span>
    <h2><?= e($s['titel']) ?></h2>
    <p class="leistung-text"><?= e($s['text']) ?></p>
    <p class="leistung-liste"><?= e(implode(' · ', $s['liste'])) ?></p>
    <span class="knopf knopf-hell"><?= e($s['knopf']) ?> <?= lz_pfeil() ?></span>
  </a>
  <?php endforeach; ?>
</section>

<?php require __DIR__ . '/../teile/newsletter.php'; ?>
<?php require __DIR__ . '/../teile/cta.php'; ?>

<?php require __DIR__ . '/../teile/fuss.php'; ?>
