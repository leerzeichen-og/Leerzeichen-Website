<?php
// Agenturseite („Über uns"). Gestaltungsbasis der Startseite, Aufbau angelehnt
// an Romans Agentur-Schema: großes Light-Statement · Portraits · Prinzipien
// mit Chips · das Büro in Bildern · Newsletter · CTA „Unser Büro ist einen
// Besuch wert". Texte: „Website-Texte", Abschnitt 5 (Langfassung).
// Portrait-Varianten vergleichbar über ?portraits=quer|hoch (bis entschieden).
require_once __DIR__ . '/../teile/firma.php';

$titel        = 'Agentur — drei Gestalter in Neumarkt an der Ybbs';
$beschreibung = 'Wer wir sind, wie wir arbeiten, was wir machen. leerzeichen multimedia og, '
              . 'seit 2008 im Rathaus von Neumarkt an der Ybbs.';
$brotkrumen   = [['Agentur', '/agentur/']];
$voll_breit   = true;

$team = [
    ['roman-dachsberger',   'Roman Dachsberger',   'Gestalter'],
    ['johanna-eder',        'Johanna Eder',        'Gestalterin'],
    ['susanne-pichelmann',  'Susanne Pichelmann',  'Gestalterin'],
];
// Zwei Portrait-Fassungen liegen bereit; Vergleich über ?portraits=…
// (fehlt eine Fassung für eine Person, nimmt sie die vorhandene).
$portraitVariante = ($_GET['portraits'] ?? 'quer') === 'hoch' ? 'hoch' : 'quer';
function agentur_portrait(string $slug, string $variante): ?string
{
    $reihen = $variante === 'hoch'
        ? ["$slug-hoch", $slug, "$slug-quer"]
        : [$slug, "$slug-quer", "$slug-hoch"];
    foreach ($reihen as $name) {
        if (is_file(__DIR__ . '/../assets/bilder/' . $name . '.webp')) {
            return '/assets/bilder/' . $name . '.webp';
        }
    }
    return null;
}

$prinzipien = [
    ['Ansatz',
     'Form follows Function, wörtlich genommen. Was wir gestalten, funktioniert: im Druck, am Screen, in einer Ausstellung, die jahrelang von Kindern benutzt wird. Zeitlose Gestaltung ist unser Anspruch. Unsere Konzepte und Gestaltungen sollen langlebig ihre Wirkung entfalten.'],
    ['Netzwerk',
     'Für die Produktion holen wir Leute dazu, mit denen wir seit Jahren arbeiten: Experten und Unternehmen, die außergewöhnliche Projekte mit uns umsetzen. Medientechniker, Motion Designer, Druckereien, Werbetechniker, Lektorinnen, Illustratoren, Architekten. Wir nutzen unser Netzwerk und bleiben verantwortlich, bis das Projekt steht.'],
    ['Technik',
     'Vom Screendesign fürs Handydisplay über Bücher mit mehreren hundert Seiten bis zum 30-Meter-Print haben wir alles schon produziert. Technologisch legen wir uns nicht fest, analog wie digital. KI setzen wir dort ein, wo sie Arbeit abnimmt und Ihren Nutzen vergrößert.'],
];

$ctaTitel = 'Unser Büro ist einen Besuch wert.';
$ctaKnopf = 'Kommen Sie vorbei';

require __DIR__ . '/../teile/kopf.php';
?>

<section class="lz-sec" style="padding-top:calc(90px + var(--space-8))">
  <h1 class="titel-seite" style="max-width:24ch">Ohne Leerzeichen wäre dieser Satz
    kaum zu lesen.</h1>
  <p class="lz-lead" style="margin-top:var(--space-6);max-width:52ch">Der kleinste
    Eingriff entscheidet darüber, ob etwas ankommt. Und der Abstand ist es, der den
    Blick lenkt und das Wichtige stehen lässt. Dem folgend begleiten wir seit
    <?= e(FIRMA_GEGRUENDET) ?> Projekte von der ersten Skizze bis zur Übergabe —
    <?= e(FIRMA_NAME) ?> aus <?= e(FIRMA_ORT) ?>.</p>
</section>

<section class="lz-sec">
  <h2 class="lz-h2">Wir sind Leerzeichen.</h2>
  <div class="portraits">
    <?php foreach ($team as [$slug, $name, $rolle]): $bild = agentur_portrait($slug, $portraitVariante); ?>
    <figure class="portrait">
      <?php if ($bild): ?>
      <img src="<?= e($bild) ?>" alt="Portrait von <?= e($name) ?>" loading="lazy">
      <?php endif; ?>
      <figcaption><strong><?= e($name) ?></strong><br><?= e($rolle) ?></figcaption>
    </figure>
    <?php endforeach; ?>
  </div>
</section>

<section class="lz-sec">
  <h2 class="lz-h2" style="max-width:22ch">Stärken, die wir für Sie einsetzen.</h2>
  <div class="prinzipien">
    <?php foreach ($prinzipien as [$kopf, $text]): ?>
    <div class="prinzip">
      <span class="chip"><?= e($kopf) ?></span>
      <p style="margin-top:var(--space-4)"><?= e($text) ?></p>
    </div>
    <?php endforeach; ?>
  </div>
</section>

<section class="lz-sec">
  <div class="buero-bild">
    <img src="/assets/bilder/leerzeichen-buero-besprechung.webp" width="2200" height="1466"
      alt="Besprechung im Leerzeichen-Büro im historischen Rathaus von Neumarkt an der Ybbs" loading="lazy">
    <div class="buero-tag">
      <span class="chip">Das Leerzeichen-Büro</span>
      <span class="buero-untertitel">Zeitlose Ideen in historischer Architektur</span>
    </div>
  </div>
  <p class="lz-lead" style="margin-top:var(--space-6);max-width:52ch">Wir arbeiten im
    altehrwürdigen Rathaus von <?= e(FIRMA_ORT) ?>, erbaut im 16. Jahrhundert. Es
    wurde schon als Mauthaus, Gefängnis, Volksschule, Post, Kindergarten und
    Musikschule genutzt. Wir sind also in guter Gesellschaft, was wechselnde
    Aufgaben angeht.</p>
  <div class="buero-details">
    <img src="/assets/bilder/leerzeichen-buero-kreativarbeitsplaetze.webp" alt="Kreativarbeitsplätze im Leerzeichen-Büro" loading="lazy">
    <img src="/assets/bilder/leerzeichen-buero-detail-lampe.webp" alt="Detail im Büro: historische Lampe" loading="lazy">
    <img src="/assets/bilder/leerzeichen-buero-detail-buecher.webp" alt="Detail im Büro: Bücherregal" loading="lazy">
  </div>
</section>

<?php require __DIR__ . '/../teile/newsletter.php'; ?>
<?php require __DIR__ . '/../teile/cta.php'; ?>

<?php require __DIR__ . '/../teile/fuss.php'; ?>
