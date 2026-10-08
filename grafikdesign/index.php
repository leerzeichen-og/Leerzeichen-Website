<?php
// Landingpage Säule „Gestaltung" (Texte Roman, 8.10.2026) — exakt dieselbe
// Gestaltung wie die Erlebnis-Seite (erlebnisgestaltung/index.php):
// durchgehend schwarze Seite nach dem Vorbild der Leistungsseite.
// Gestaltungsänderungen bitte immer auf BEIDEN Säulen-Seiten gleich anwenden.
// Aufbau: Hero (mit Kreis-Video) · Was wir gestalten (fünf Kontur-Boxen) ·
// Unser Ansatz (vier Merkmale) · Ausgewählte Projekte (Space-Portfolio,
// Referenzen-Karten) · Zusammenarbeit · Häufige Fragen (<details> +
// FAQPage-JSON-LD) · Newsletter · CTA.
require_once __DIR__ . '/../teile/firma.php';
require_once __DIR__ . '/../teile/projekte.php';

$titel        = 'Corporate Design, Publikationen & Websites | leerzeichen';
$beschreibung = 'Wir gestalten Corporate Designs, Publikationen und digitale Auftritte — '
              . 'vom Logo bis zur Gemeindechronik, vom Plakat bis zur Website.';
$brotkrumen   = [['Leistungen', '/leistungen/'], ['Gestaltung', '/grafikdesign/']];
$styles       = ['/assets/projekt.css'];
$voll_breit   = true;
$bodyKlasse   = 'seite-dunkel';

$felder = [
    ['Corporate Design und Markenentwicklung',
     'Wir entwickeln Logos, Farb- und Schriftwelten, Bildsprache und Gestaltungsprinzipien — für Betriebe, Institutionen und Gemeinden. Dazu alles, was Ihre Kommunikation braucht: Geschäftsdrucksorten, Social-Media-Vorlagen, Mappen und Roll-ups. Sie haben schon ein gutes Corporate Design? Dann arbeiten wir damit und entwickeln daraus die passenden Anwendungen.'],
    ['Magazine, Bücher und Chroniken',
     'Wir gestalten Mitarbeiter- und Kundenmagazine, Festschriften, Jubiläumsbücher, Chroniken und Bildbände. Große Textmengen bringen wir in eine Form, die man gerne liest, und übernehmen Satz, Bildbearbeitung und die Druckabwicklung. Wo Inhalte erst entstehen müssen, organisieren wir, wer schreibt und wer liefert.'],
    ['Websites und digitale Auftritte',
     'Wir bauen Unternehmens-Websites, Gemeindeportale, Microsites und Landingpages. Sie sind so gebaut, dass Ihr Team sie selbst pflegen kann.'],
    ['Verpackungen',
     'Die richtige Form für Ihr Produkt. Wir beraten gerne bei der Wahl des Verpackungsmaterials und bei den Produktions- und Veredelungsmöglichkeiten. Wir gestalten Etiketten, Verpackungskartons und POS-Material.'],
    ['Werbemittel',
     'Kataloge, Prospekte, Datenblätter, Plakate und Inserate, Messeauftritte, Beschriftungen für Fahrzeuge und Schaufenster — alles im selben Erscheinungsbild.'],
];

$merkmale = [
    ['Zuerst zuhören.',
     'Bevor wir gestalten, verstehen wir, was Sie tun und für wen. Eine Gestaltung, die die Sache nicht trifft, ist auch dann falsch, wenn sie gut aussieht.'],
    ['Vom Charakter abgeleitet.',
     'Wir arbeiten mit dem, was da ist: der gewachsenen Geschichte eines Ortes, der Präzision eines Industriebetriebs, dem Handwerk eines Familienunternehmens. Daraus entsteht ein Auftritt, der zu Ihnen gehört und zu niemand anderem.'],
    ['Verständlich aufbereitet.',
     'Verwaltungstexte, Chroniken und technische Dokumentation bereiten wir so auf, dass man sie liest: Rhythmus über hunderte Seiten, Bilder an der richtigen Stelle, eine Typografie, die den Inhalt trägt.'],
    ['Verlässlich bis zur Auslieferung.',
     'Ob mehrsprachige Produktbroschüre oder Buch mit Autorenteam und festem Termin — wir koordinieren Lektorat, Korrekturen und Druckerei und liefern pünktlich.'],
];

$fragen = [
    ['Wie lange dauert ein Corporate Design?',
     'Je nach Umfang zwischen einem und sechs Monaten. Für ein Magazin gilt dieselbe Spanne.'],
    ['Wie viel Zeit kostet das mich?',
     'Wir halten die Termine kurz: ein Briefing-Gespräch, ein Angebotsgespräch, die Erstpräsentation. Korrekturen laufen persönlich oder per Mail, je nachdem was schneller geht.'],
    ['Was kostet das?',
     'Kreativleistungen wie ein Corporate Design rechnen wir pauschal ab, einzelne Drucksorten und laufende Betreuung nach Aufwand. Das Erstgespräch und das Angebot sind kostenlos.'],
    ['Wir haben schon ein Corporate Design. Geht das trotzdem?',
     'Ja. Wir setzen Projekte nach Ihren bestehenden Guidelines um, und wenn es nötig ist, erweitern oder adaptieren wir das Manual.'],
    ['Was bekomme ich am Ende?',
     'Ein CD-Manual light ist bei jedem Corporate Design dabei: Schriften, Farbwelt, Gestaltungselemente und das Logo in allen gängigen Formaten. Druckdaten liefern wir druckfertig als PDF. InDesign-Vorlagen zum Selbstbearbeiten gibt es nach Vereinbarung.'],
    ['Kümmern Sie sich auch um den Druck?',
     'Meistens ja. Dann müssen Sie sich um nichts kümmern und bekommen die fertigen Drucksorten geliefert.'],
    ['Brauchen wir Texte und Fotos selbst?',
     'Wenn Sie wollen, übernehmen wir das. Beides läuft über Partner aus unserem Netzwerk, die Koordination bleibt bei uns.'],
    ['Sind die Websites barrierefrei?',
     'Auf Wunsch, in der Stufe, die Sie brauchen. Für Gemeinden und öffentliche Stellen ist das gesetzlich vorgeschrieben, und wir planen es von Anfang an mit.'],
    ['Wir arbeiten schon mit einer anderen Agentur. Ist das ein Problem?',
     'Nein. Wir liefern zu und stimmen uns ab. Es ist genug für alle da.'],
    ['Wir sitzen nicht in der Nähe. Geht das?',
     'Ja. Wir sind regelmäßig zwischen Wien, Salzburg und Graz unterwegs, und Termine gehen persönlich wie virtuell. Anfahrtskosten sind in der Pauschale berücksichtigt oder wir vereinbaren etwas.'],
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
    fn($p) => ($p['saeule'] ?? '') === 'gestaltung')), 0, 6);

$ctaTitel = 'Was dürfen wir für Sie gestalten?';
$ctaText  = 'Erzählen Sie uns von Ihrem Projekt.';
$ctaKnopf = 'Reden wir darüber';

require __DIR__ . '/../teile/kopf.php';
?>

<?php // Hero im Leistungs-Muster: Film läuft einmal, dimmt ab, die zwei
      // Absätze wechseln beim Scrollen (Maschine: assets/hero-film.js). ?>
<section class="leistung-hero" id="l-hero">
  <div class="seiten-hero leistung-hero-leinwand">
    <video class="leistung-hero-video" src="/assets/videos/leerzeichen-vernetzte-gestaltung.mp4"
      autoplay muted playsinline aria-hidden="true"></video>
    <div class="leistung-hero-inhalt">
      <span class="chip">Gestaltung für Unternehmen</span>
      <h1 class="titel-gross">Identität<br>sichtbar<br>machen.</h1>
      <div class="kopf-gross-zeile">
        <div class="kopf-gross-rechts">
      <p>Wir gestalten Corporate Designs, Publikationen und digitale Auftritte —
        vom Logo bis zur Gemeindechronik, vom Plakat bis zur Website.</p>
      <p>Ob innovatives Unternehmen oder geschichtsträchtige Stadtgemeinde:
        Jede Organisation hat Geschichten und Werte, die sichtbar sein wollen.
        Wir finden die passende gestalterische Form — eigenständig,
        wiedererkennbar und medienübergreifend wirksam.</p>
    </div>
      </div>
    </div>
    <span class="pj-runter leistung-runter" aria-hidden="true"><?= lz_pfeil() ?></span>
  </div>
</section>

<section class="lz-sec viel-luft">
  <h2>Was wir gestalten.</h2>
  <?php // Listen-Layout nach pixelart-Vorbild: Bild · Titel+Text · Pfeil,
        // der ganze Eintrag verlinkt reihum auf eines der Säulen-Projekte. ?>
  <div class="feld-fluss">
    <?php foreach ($felder as $i => [$feldTitel, $feldText]): ?>
    <?php $feldProjekt = $referenzen ? $referenzen[$i % count($referenzen)] : null; ?>
    <?php if ($feldProjekt): ?>
    <a class="feld-eintrag" href="/referenzen/<?= e($feldProjekt['slug'] ?? '') ?>/"
       aria-label="<?= e($feldTitel) ?> — zum Projekt <?= e((string) ($feldProjekt['titel'] ?? '')) ?>">
    <?php else: ?>
    <div class="feld-eintrag">
    <?php endif; ?>
      <div class="feld-bild">
        <?= $feldProjekt ? pj_bild($feldProjekt['teaser_quer'] ?? null, '', '(max-width: 900px) 100vw, 26vw') : '' ?>
      </div>
      <div class="feld-text">
        <h3><?= e($feldTitel) ?></h3>
        <p><?= e($feldText) ?></p>
      </div>
      <?php if ($feldProjekt): ?>
      <span class="feld-pfeil" aria-hidden="true"><?= lz_pfeil() ?></span>
      <?php endif; ?>
    <?= $feldProjekt ? '</a>' : '</div>' ?>
    <?php endforeach; ?>
  </div>
</section>

<section class="lz-sec viel-luft">
  <h2 class="titel-gross">Unser Ansatz.</h2>
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
<section class="lz-sec viel-luft">
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
    <a class="knopf knopf-hell" href="/referenzen/?filter=gestaltung">Alle Gestaltungs-Projekte <?= lz_pfeil() ?></a>
  </p>
</section>
<?php endif; ?>

<?php // „Zusammenarbeit.": zwei Absätze nebeneinander im Teaser-Format —
      // das Stärke-Muster (Umbruch im Text von uns gesetzt). ?>
<section class="lz-sec staerke viel-luft">
  <h2>Zusammenarbeit.</h2>
  <div class="staerke-spalten">
    <p>Für die Produktion arbeiten wir mit Druckereien, Lektorinnen,
      Fotografen, Illustratoren und Übersetzern zusammen, die wir seit
      Jahren kennen.</p>
    <p>Wir kennen die Drucktechnik, von Farbprofilen bis zur Veredelung,
      und wissen, welches Papier welche Wirkung erzielt. Am Ende bekommen
      Sie die fertigen Drucksorten geliefert.</p>
  </div>
</section>

<section class="lz-sec viel-luft">
  <h2>Häufige Fragen.</h2>
  <div class="faq">
    <?php foreach ($fragen as [$frage, $antwort]): ?>
    <details>
      <summary><?= e($frage) ?></summary>
      <p><?= e($antwort) ?></p>
    </details>
    <?php endforeach; ?>
  </div>
</section>


<script src="<?= e(lz_asset('/assets/hero-film.js')) ?>" defer></script>

<?php // CTA oberhalb des Newsletters (Beschluss Roman, 8.10.2026). ?>
<?php require __DIR__ . '/../teile/cta.php'; ?>
<?php require __DIR__ . '/../teile/newsletter.php'; ?>

<?php require __DIR__ . '/../teile/fuss.php'; ?>
