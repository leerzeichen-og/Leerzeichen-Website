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

// Team: seit 17.11.2026 aus Space — das Personal-Modul schreibt
// daten/team.json und bilder/team/… (Format: docs/datenformat.md; nur
// Personen mit Häkchen „Auf der Website zeigen"). Fehlt die Datei —
// lokal oder bis zum ersten Push —, gilt die eingebaute Liste mit den
// Porträts aus assets/bilder. Mail und Telefon setzt erst das kleine
// Skript am Seitenende zusammen, so stehen sie nirgends vollständig
// im Quelltext (SPAM-Schutz): data-post = Teil vor dem @, data-bei =
// Domain, data-ruf = Telefon in Anzeigeschreibweise.
$team = [];
$teamRoh  = @file_get_contents(__DIR__ . '/../daten/team.json');
$personen = $teamRoh !== false ? (json_decode($teamRoh, true)['personen'] ?? null) : null;
if (is_array($personen) && $personen) {
    foreach ($personen as $p) {
        $mail = trim((string) ($p['mail'] ?? ''));
        [$post, $bei] = str_contains($mail, '@') ? explode('@', $mail, 2) : ['', ''];
        $team[] = [
            'name'     => (string) ($p['name'] ?? ''),
            'funktion' => (string) ($p['funktion'] ?? ''),
            'text'     => trim((string) ($p['text'] ?? '')),
            'post'     => $post,
            'bei'      => $bei,
            'telefon'  => trim((string) ($p['telefon'] ?? '')),
            'foto'     => is_array($p['foto'] ?? null) ? $p['foto'] : null,
            'slug'     => '',
        ];
    }
} else {
    foreach ([
        ['roman-dachsberger',  'Roman Dachsberger',  'Gestalter',   'roman',   '0664 / 619 58 22'],
        ['johanna-eder',       'Johanna Eder',       'Gestalterin', 'johanna', '07412 / 53 638'],
        ['susanne-pichelmann', 'Susanne Pichelmann', 'Gestalterin', 'susanne', '07412 / 53 638'],
    ] as [$slug, $name, $rolle, $post, $telefon]) {
        $team[] = [
            'name' => $name, 'funktion' => $rolle, 'text' => '',
            'post' => $post, 'bei' => 'leerzeichen.at', 'telefon' => $telefon,
            'foto' => null, 'slug' => $slug,
        ];
    }
}
// Zwei Portrait-Fassungen der eingebauten Liste; Vergleich über ?portraits=…
// (nur Rückfall — Fotos aus Space bringen ihre Fassung selbst mit).
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
// Porträt aus Space als <img> mit srcset (Breitenstufen aus team.json).
function agentur_foto_html(array $foto, string $name): string
{
    $quellen = $foto['quellen'] ?? [];
    if (!$quellen) {
        return '';
    }
    usort($quellen, fn($a, $b) => ($a['breite'] ?? 0) <=> ($b['breite'] ?? 0));
    $srcset  = implode(', ', array_map(
        fn($q) => e((string) $q['datei']) . ' ' . (int) ($q['breite'] ?? 0) . 'w', $quellen));
    $gross   = end($quellen);
    $masse   = (!empty($foto['breite']) && !empty($foto['hoehe']))
        ? ' width="' . (int) $foto['breite'] . '" height="' . (int) $foto['hoehe'] . '"'
        : '';
    $alt = trim((string) ($foto['alt'] ?? '')) !== '' ? (string) $foto['alt'] : 'Portrait von ' . $name;
    return '<img src="' . e((string) $gross['datei']) . '" srcset="' . $srcset . '"'
         . ' sizes="(max-width: 640px) 100vw, 420px" alt="' . e($alt) . '"' . $masse . ' loading="lazy">';
}

$prinzipien = [
    ['Ansatz',
     'Form follows Function, wörtlich genommen. Was wir gestalten, funktioniert: im Druck, am Screen, in einer Ausstellung, die jahrelang von Kindern benutzt wird. Zeitlose Gestaltung ist unser Anspruch. Unsere Konzepte und Gestaltungen sollen langlebig ihre Wirkung entfalten.'],
    ['Technik',
     'Vom Screendesign fürs Handydisplay über Bücher mit mehreren hundert Seiten bis zum 30-Meter-Print haben wir alles schon produziert. Technologisch legen wir uns nicht fest, analog wie digital. KI setzen wir dort ein, wo sie Arbeit abnimmt und Ihren Nutzen vergrößert.'],
    ['Netzwerk',
     'Für die Produktion holen wir Leute dazu, mit denen wir seit Jahren arbeiten: Experten und Unternehmen, die außergewöhnliche Projekte mit uns umsetzen. Medientechniker, Motion Designer, Druckereien, Werbetechniker, Lektorinnen, Illustratoren, Architekten. Wir nutzen unser Netzwerk und bleiben verantwortlich, bis das Projekt steht.'],
];

$ctaTitel = 'Unser Büro ist einen Besuch wert.';
$ctaKnopf = 'Kommen Sie vorbei';

// Gruß an alle, die den Quellcode lesen (siehe teile/kopf.php).
$quellkunst = <<<'KUNST'
<!--
          (  )   (   )  )
           ) (   )  (  (
          ( )  (    ) )
          _____________
         |             |===|
         | LEERZEICHEN |   |  < Treibstoff für Neugier
         |  SEIT 2008  |===|    und Genauigkeit.
         \_____________/
       ~~~~~~~~~~~~~~~~~~~

   Perspektiven wechseln. Freundlich hinterfragen.
   Und Quellcodes nach Easter Eggs durchsuchen.
-->
KUNST;

require __DIR__ . '/../teile/kopf.php';
?>

<?php // Kopf im Kontakt-Muster (8.10.2026): Headline in Claim-Größe (Light)
      // am Logo-Rand, der Teaser versetzt in der rechten Spalte. ?>
<section class="kopf-gross">
  <h1 class="titel-gross">Wir gestalten.</h1>
  <div class="kopf-gross-zeile">
    <div class="kopf-gross-rechts">
      <p>Genau zuhören. Den Blickwinkel drehen. Freundlich hinterfragen, worum es
        wirklich geht. Und die Vorstellungskraft besitzen für das, was erst noch
        entstehen muss.</p>
      <p>Unsere Arbeit lebt von Neugier. Unsere Gestaltung von
        Präzision. Unser Antrieb ist die Wirkung.</p>
      <p>Seit <?= e(FIRMA_GEGRUENDET) ?> setzen wir gemeinsam Zeichen.</p>
    </div>
  </div>
</section>

<section class="lz-sec">
  <h2>Wir sind Leerzeichen.</h2>
  <div class="portraits">
    <?php foreach ($team as $p): ?>
    <figure class="portrait">
      <?php if ($p['foto']): ?>
      <?= agentur_foto_html($p['foto'], $p['name']) ?>
      <?php elseif ($p['slug'] !== '' && ($bild = agentur_portrait($p['slug'], $portraitVariante))): ?>
      <img src="<?= e($bild) ?>" alt="Portrait von <?= e($p['name']) ?>" loading="lazy">
      <?php endif; ?>
      <figcaption><strong><?= e($p['name']) ?></strong><br><?= e($p['funktion']) ?></figcaption>
      <?php if ($p['text'] !== ''): ?>
      <p class="portrait-text"><?= e($p['text']) ?></p>
      <?php endif; ?>
      <span class="portrait-kontakt">
        <?php if ($p['post'] !== ''): ?>
        <a data-post="<?= e($p['post']) ?>" data-bei="<?= e($p['bei']) ?>" aria-label="E-Mail an <?= e($p['name']) ?>">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><rect x="2.5" y="5" width="19" height="14" rx="1.5"/><path d="m3.5 6.5 8.5 7 8.5-7"/></svg>
        </a>
        <?php endif; ?>
        <?php if ($p['telefon'] !== ''): ?>
        <a data-ruf="<?= e($p['telefon']) ?>" aria-label="<?= e($p['name']) ?> anrufen: <?= e($p['telefon']) ?>">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M5 3.5h4l1.5 4.5-2.3 1.7a13 13 0 0 0 6.1 6.1l1.7-2.3 4.5 1.5v4a1.5 1.5 0 0 1-1.6 1.5C10.4 20 4 13.6 3.5 5.1A1.5 1.5 0 0 1 5 3.5Z"/></svg>
        </a>
        <?php endif; ?>
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
    a.href = 'mailto:' + a.dataset.post + '@' + (a.dataset.bei || ['leerzeichen', 'at'].join('.'));
});
document.querySelectorAll('[data-ruf]').forEach(function (a) {
    // 0664 / … → +43664…, 07412 / … → +437412…
    a.href = 'tel:' + a.dataset.ruf.replace(/[^\d]/g, '').replace(/^0/, '+43');
});
</script>

<?php require __DIR__ . '/../teile/fuss.php'; ?>
