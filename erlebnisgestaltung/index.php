<?php
// Landingpage Säule „Erlebnisse" (Texte Roman, 8.10.2026) — Gestaltungsbasis
// ist die Leistungsseite: durchgehend schwarze Seite, Kontur-Boxen, große
// Light-Titel. Aufbau: Hero (mit Kreis-Video) · Was wir gestalten (fünf
// Kontur-Boxen) · Zwischen Haptik und Technik (drei Merkmale) · Ausgewählte
// Projekte (aus dem Space-Portfolio, Referenzen-Karten) · Wer mitbaut ·
// Häufige Fragen (<details> + FAQPage-JSON-LD) · Newsletter · CTA.
require_once __DIR__ . '/../teile/firma.php';
require_once __DIR__ . '/../teile/projekte.php';

$titel        = 'Ausstellungen, Erlebniswege & Escape-Rooms | leerzeichen';
$beschreibung = 'Wir gestalten Ausstellungen, Themenwege und Spielplätze mit eigener '
              . 'Geschichte — Orte, an denen Menschen stehen bleiben und staunen.';
$brotkrumen   = [['Leistungen', '/leistungen/'], ['Erlebnisse', '/erlebnisgestaltung/']];
$styles       = ['/assets/projekt.css'];
$voll_breit   = true;
$bodyKlasse   = 'seite-dunkel';

$felder = [
    ['Ausstellungen',
     'Wir entwickeln Ausstellungen vom Konzept bis zur Eröffnung: Kuration, Raumkonzept, Grafik, Leitsystem und die Stationen im Raum. Manche Ausstellungen übernehmen wir komplett, bei anderen bringen wir einen Teil ein — etwa die Kinderebene oder die Didaktik.'],
    ['Escape-Rooms und Treasure Trails',
     'Wir entwickeln Escape-Rooms und Treasure Trails vom Rätselkonzept bis zur fertigen Station: Geschichte, Rätsellogik, Gestaltung und Bau. Drinnen als Raum, draußen als Weg durch einen Ort — beide mit einem Spannungsbogen, der eine Gruppe von der ersten bis zur letzten Station bei der Sache hält.'],
    ['Spielplätze und Outdoor-Abenteuer',
     'Wir gestalten Themenspielplätze mit einer eigenen Geschichte, wie die High-Five-Reihe am Großglockner: fünf Spielplätze, ein Thema. Dazu Entdeckerpfade und Outdoor-Stationen, die eine Landschaft erklären, während man sie durchquert.'],
    ['Themenwege und Rundgänge',
     'Wir gestalten Rundwege und Themenpfade mit Stationen entlang von Kultur- und Naturräumen. Der Weg erzählt eine Geschichte, und jede Station bringt sie ein Stück weiter.'],
    ['Vermittlungsebenen für Familien',
     'Wir entwickeln Kinderbegleitebenen zu neuen und bestehenden Ausstellungen: Rätselhefte, Hörstationen und Mitmach-Elemente, die ein Thema für Kinder öffnen und die Erwachsenen mitnehmen.'],
];

$merkmale = [
    ['Analog und begreifbar.',
     'Wir bauen mit echtem Holz, mit Drehtrommeln, Klappen, Geruchs- und Taststationen. Was man angreifen kann, bleibt länger im Kopf — und hält im Betrieb länger durch als jeder Bildschirm.'],
    ['Digital mit Sinn.',
     'Audioguides, Screens und Medientechnik setzen wir ein, wenn sie etwas leisten, das analog nicht geht. Dann gehören sie dazu. Bis hin zu multimedial-immersiven Rauminstallationen.'],
    ['Für den Betrieb danach.',
     'Wir liefern Anleitungen für den laufenden Betrieb mit: Handbücher für die Technik, Handlungsanweisungen für das Team vor Ort und Inhaltssammlungen für Kulturvermittler. Damit funktioniert die Ausstellung auch dann, wenn wir nicht mehr dabei sind.'],
];

// Häufige Fragen — die Antwort zur Projektdauer fehlt noch (Roman).
$fragen = [
    ['Können Sie eine Ausstellung komplett übernehmen?',
     'Ja, vom Konzept bis zur Eröffnung, mit allen Rollen im Prozess. Was wir nicht selbst machen, übernehmen Partner aus unserem Netzwerk.'],
    ['Wir haben schon ein Team. Kommen Sie trotzdem dazu?',
     'Gerne. Oft holt man uns für einen bestimmten Teil, etwa die Kinderebene oder die Ausstellungsdidaktik. Dann arbeiten wir mit allen Beteiligten zusammen.'],
    ['Gibt es Förderungen dafür?',
     'Meistens ja. Wir kennen die LEADER-Regionen und die Ansprechpartner für Förderungen und sagen Ihnen früh, was in Frage kommt.'],
    ['Ist das barrierefrei?',
     'Auf Wunsch, in der Stufe, die Sie brauchen. Wir denken es von Anfang an mit, bei Ausstellungen wie bei digitalen Projekten.'],
    ['Geht das auch mehrsprachig?',
     'Ja. Wir organisieren Übersetzungen und Audio-Einspieler in den Sprachen, die Sie brauchen.'],
    ['Wer wartet das nach der Eröffnung?',
     'Wir bauen so, dass möglichst nichts zu tun ist. Wo doch etwas anfällt, liefern wir eine Anleitung samt Checkliste mit. Erreichbar sind wir auch nach Projektabschluss.'],
    ['Was kostet das?',
     'Das hängt vom Umfang ab. Nach dem ersten Gespräch bekommen Sie ein Angebot, beides kostenlos.'],
];

// FAQPage-JSON-LD — laut Website-Briefing der wichtigste Einzelposten
// der Auffindbarkeit.
$jsonld_extra = [
    '@context'   => 'https://schema.org',
    '@type'      => 'FAQPage',
    'mainEntity' => array_map(fn($f) => [
        '@type'          => 'Question',
        'name'           => $f[0],
        'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f[1]],
    ], $fragen),
];

$referenzen = array_slice(array_values(array_filter(pj_index(),
    fn($p) => ($p['saeule'] ?? '') === 'erlebnisse')), 0, 4);

$ctaTitel = 'Planen Sie eine Ausstellung oder ein Ausflugsziel?';
$ctaText  = 'Erzählen Sie uns von Ihrem Ort und Ihrer Geschichte.';
$ctaKnopf = 'Reden wir darüber';

require __DIR__ . '/../teile/kopf.php';
?>

<?php // Hero im Leistungs-Muster: Film läuft einmal, dimmt ab, die zwei
      // Absätze wechseln beim Scrollen (Maschine: assets/hero-film.js). ?>
<section class="leistung-hero" id="l-hero">
  <div class="seiten-hero leistung-hero-leinwand">
    <video class="leistung-hero-video" src="/assets/videos/leerzeichen-abenteuer.mp4"
      autoplay muted playsinline aria-hidden="true"></video>
    <div class="leistung-hero-inhalt">
      <span class="chip">Erlebnisse &amp; Abenteuer</span>
      <h1 class="titel-gross">Inhalte<br>begehbar<br>machen.</h1>
      <div class="kopf-gross-zeile">
        <div class="kopf-gross-rechts">
      <p>Wir gestalten Ausstellungen, Themenwege und Spielplätze mit eigener
        Geschichte — Orte, an denen Menschen stehen bleiben, staunen und etwas
        mitnehmen.</p>
      <p>Wissen wirkt am stärksten dort, wo man es spürt. Wir kuratieren,
        inszenieren und gestalten Erlebnisse, die komplexe Themen begreifbar
        machen — für Familien, für Schulklassen, für alle, die am Sonntag einen
        Ausflug machen. Unsere Auftraggeber sind Museen, Gemeinden,
        Tourismusregionen und Ausflugsziele.</p>
    </div>
      </div>
    </div>
    <span class="pj-runter leistung-runter" aria-hidden="true"><?= lz_pfeil() ?></span>
  </div>
</section>

<section class="lz-sec">
  <h2>Was wir gestalten.</h2>
  <?php // Luftiger Fluss: je Leistungsfeld ein frei schwebendes Bild, das
        // reihum auf eines der Säulen-Projekte verlinkt. ?>
  <div class="feld-fluss">
    <?php foreach ($felder as $i => [$feldTitel, $feldText]): ?>
    <?php $feldProjekt = $referenzen ? $referenzen[$i % count($referenzen)] : null; ?>
    <div class="feld-eintrag<?= $i % 2 ? ' feld-dreh' : '' ?>">
      <div class="feld-text">
        <h3><?= e($feldTitel) ?></h3>
        <p><?= e($feldText) ?></p>
      </div>
      <?php if ($feldProjekt): ?>
      <a class="feld-bild" href="/referenzen/<?= e($feldProjekt['slug'] ?? '') ?>/"
         aria-label="Zum Projekt <?= e((string) ($feldProjekt['titel'] ?? '')) ?>">
        <?= pj_bild($feldProjekt['teaser_quer'] ?? null, '', '(max-width: 900px) 100vw, 32vw') ?>
      </a>
      <?php endif; ?>
    </div>
    <?php endforeach; ?>
  </div>
</section>

<section class="lz-sec viel-luft">
  <h2 class="titel-gross">Zwischen Haptik und<br>Technik.</h2>
  <div class="merkmale">
    <?php foreach ($merkmale as [$mTitel, $mText]): ?>
    <div class="merkmal">
      <h3><?= e($mTitel) ?></h3>
      <p><?= e($mText) ?></p>
    </div>
    <?php endforeach; ?>
  </div>
</section>

<?php if ($referenzen): ?>
<section class="lz-sec">
  <h2>Ausgewählte Projekte.</h2>
  <div class="saeulen-projekte">
    <?php foreach ($referenzen as $p): ?>
    <a class="pj-karte pj-fr-karte" href="/referenzen/<?= e($p['slug'] ?? '') ?>/">
      <span class="pj-karte-bildwrap">
        <?= pj_bild($p['teaser_quer'] ?? null, 'pj-karte-bild', '(max-width: 900px) 100vw, 50vw') ?>
      </span>
      <span class="pj-fr-titel"><?= e((string) ($p['titel'] ?? '')) ?></span>
      <?php if (!empty($p['punchline'])): ?>
      <span class="pj-karte-punchline"><?= e($p['punchline']) ?></span>
      <?php endif; ?>
    </a>
    <?php endforeach; ?>
  </div>
  <p style="margin:var(--space-8) 0 0">
    <a class="knopf knopf-hell" href="/referenzen/?filter=erlebnis">Alle Erlebnis-Projekte <?= lz_pfeil() ?></a>
  </p>
</section>
<?php endif; ?>

<?php // „Wer mitbaut.": zwei Absätze nebeneinander im Teaser-Format —
      // das Stärke-Muster der Leistungsseite. ?>
<section class="lz-sec staerke">
  <h2>Wer mitbaut.</h2>
  <div class="staerke-spalten">
    <p>Für die Produktion arbeiten wir mit Tischlereien, Holzbauern,
      Medientechnikern und Werbetechnikern zusammen, die wir seit Jahren
      kennen. Wir koordinieren alle Beteiligten, begleiten die Montage vor
      Ort und bleiben verantwortlich, bis das Projekt eröffnet ist.</p>
    <p>Bei Förderungen helfen wir weiter. Wir haben Kontakte zu
      LEADER-Regionen und zu Ansprechpartnern für Förderungen und sagen
      früh, was für Ihr Projekt in Frage kommt.</p>
  </div>
</section>

<section class="lz-sec">
  <h2>Häufige Fragen.</h2>
  <div class="faq">
    <?php foreach ($fragen as [$frage, $antwort]): ?>
    <details>
      <summary><?= e($frage) ?></summary>
      <p><?= e($antwort) ?></p>
    </details>
    <?php endforeach; ?>
    <?php // Offen (Roman): „Wie lange dauert eine Ausstellung vom Auftrag
          // bis zur Eröffnung?" — Antwort fehlt noch. ?>
  </div>
</section>


<script src="<?= e(lz_asset('/assets/hero-film.js')) ?>" defer></script>

<?php // CTA oberhalb des Newsletters (Beschluss Roman, 8.10.2026). ?>
<?php require __DIR__ . '/../teile/cta.php'; ?>
<?php require __DIR__ . '/../teile/newsletter.php'; ?>

<?php require __DIR__ . '/../teile/fuss.php'; ?>
