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

// Je Person: Bild-Slug, Name, Rolle, Mail-Benutzerteil, Telefon (Anzeige).
// Die Adressen setzt erst das kleine Skript am Seitenende zusammen —
// so stehen sie nirgends vollständig im Quelltext (SPAM-Schutz).
$team = [
    ['roman-dachsberger',  'Roman Dachsberger',  'Gestalter',    'roman',   '0664 / 619 58 22'],
    ['johanna-eder',       'Johanna Eder',       'Gestalterin',  'johanna', '07412 / 53 638'],
    ['susanne-pichelmann', 'Susanne Pichelmann', 'Gestalterin',  'susanne', '07412 / 53 638'],
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

<section class="seiten-kopf">
  <span class="chip">Agentur</span>
  <h1 class="titel-seite">Ohne Leerzeichen wäre dieser Satz
    kaum zu lesen.</h1>
</section>
<section class="text-spalte">
  <p>Der kleinste
    Eingriff entscheidet darüber, ob etwas ankommt. Und der Abstand ist es, der den
    Blick lenkt und das Wichtige stehen lässt. Dem folgend begleiten wir seit
    <?= e(FIRMA_GEGRUENDET) ?> Projekte von der ersten Skizze bis zur Übergabe —
    <?= e(FIRMA_NAME) ?> aus <?= e(FIRMA_ORT) ?>.</p>
</section>

<section class="lz-sec">
  <h2 class="lz-h2">Wir sind Leerzeichen.</h2>
  <div class="portraits">
    <?php foreach ($team as [$slug, $name, $rolle, $postName, $telefon]): $bild = agentur_portrait($slug, $portraitVariante); ?>
    <figure class="portrait">
      <?php if ($bild): ?>
      <img src="<?= e($bild) ?>" alt="Portrait von <?= e($name) ?>" loading="lazy">
      <?php endif; ?>
      <figcaption><strong><?= e($name) ?></strong><br><?= e($rolle) ?></figcaption>
      <span class="portrait-kontakt">
        <a data-post="<?= e($postName) ?>" aria-label="E-Mail an <?= e($name) ?>">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><rect x="2.5" y="5" width="19" height="14" rx="1.5"/><path d="m3.5 6.5 8.5 7 8.5-7"/></svg>
        </a>
        <a data-ruf="<?= e($telefon) ?>" aria-label="<?= e($name) ?> anrufen: <?= e($telefon) ?>">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M5 3.5h4l1.5 4.5-2.3 1.7a13 13 0 0 0 6.1 6.1l1.7-2.3 4.5 1.5v4a1.5 1.5 0 0 1-1.6 1.5C10.4 20 4 13.6 3.5 5.1A1.5 1.5 0 0 1 5 3.5Z"/></svg>
        </a>
      </span>
    </figure>
    <?php endforeach; ?>
  </div>
</section>

<section class="lz-sec">
  <h2 class="lz-h2" style="max-width:22ch">Stärken, die wir für Sie einsetzen.</h2>
  <div class="prinzipien staerken">
    <?php foreach ($prinzipien as $nr => [$kopf, $text]): ?>
    <div class="prinzip">
      <span class="staerke-nr">0<?= $nr + 1 ?></span>
      <h3><?= e($kopf) ?></h3>
      <p><?= e($text) ?></p>
    </div>
    <?php endforeach; ?>
  </div>
</section>

<section class="lz-sec">
  <div class="buero-galerie">
    <figure class="buero-kachel buero-gross">
      <img src="/assets/bilder/leerzeichen-buero-besprechung.webp" width="2200" height="1466"
        alt="Besprechung im Leerzeichen-Büro im historischen Rathaus von Neumarkt an der Ybbs" loading="lazy">
      <div class="buero-tag">
        <span class="chip">Das Leerzeichen-Büro</span>
        <span class="buero-untertitel">Zeitlose Ideen in historischer Architektur</span>
      </div>
    </figure>
    <figure class="buero-kachel buero-hoch">
      <img src="/assets/bilder/leerzeichen-buero-kreativarbeitsplaetze.webp"
        alt="Kreativarbeitsplätze im Leerzeichen-Büro" loading="lazy">
    </figure>
    <figure class="buero-kachel buero-quad">
      <img src="/assets/bilder/leerzeichen-buero-detail-lampe.webp"
        alt="Detail im Büro: historische Lampe" loading="lazy">
    </figure>
    <figure class="buero-kachel buero-quad">
      <img src="/assets/bilder/leerzeichen-buero-detail-buecher.webp"
        alt="Detail im Büro: Bücherregal" loading="lazy">
    </figure>
    <?php // Das sechste Feld bleibt frei — wir heißen Leerzeichen. ?>
  </div>
  <div class="buero-text">
    <h3 class="lz-h3">Zeitlose Ideen in historischer Architektur.</h3>
    <p>Wir arbeiten im
      altehrwürdigen Rathaus von <?= e(FIRMA_ORT) ?>, erbaut im 16. Jahrhundert. Es
      wurde schon als Mauthaus, Gefängnis, Volksschule, Post, Kindergarten und
      Musikschule genutzt. Wir sind also in guter Gesellschaft, was wechselnde
      Aufgaben angeht.</p>
  </div>
</section>

<?php require __DIR__ . '/../teile/newsletter.php'; ?>
<?php require __DIR__ . '/../teile/cta.php'; ?>

<script>
// SPAM-Schutz: Mail- und Telefon-Adressen entstehen erst hier im Browser —
// Erntemaschinen lesen den Quelltext, führen aber selten JavaScript aus.
document.querySelectorAll('[data-post]').forEach(function (a) {
    a.href = 'mailto:' + a.dataset.post + '@' + ['leerzeichen', 'at'].join('.');
});
document.querySelectorAll('[data-ruf]').forEach(function (a) {
    // 0664 / … → +43664…, 07412 / … → +437412…
    a.href = 'tel:' + a.dataset.ruf.replace(/[^\d]/g, '').replace(/^0/, '+43');
});
</script>

<?php require __DIR__ . '/../teile/fuss.php'; ?>
