<?php
// Landingpage Säule „Erlebnisse" (Texte Roman, 8.10.2026) — Gestaltungsbasis
// ist die Leistungsseite: durchgehend schwarze Seite, Kontur-Boxen, große
// Light-Titel. Aufbau: Hero (mit Kreis-Video) · Was wir gestalten (fünf
// Liste mit Projekt-Fliegern + Knopf) · Wie wir gestalten (Merkmale) ·
// Häufige Fragen (<details> + FAQPage-JSON-LD) · CTA · Newsletter.
require_once __DIR__ . '/../teile/firma.php';
require_once __DIR__ . '/../teile/projekte.php';

$titel        = 'Ausstellungen, Erlebniswege & Escape-Rooms | leerzeichen';
$beschreibung = 'Wir gestalten Ausstellungen, Themenwege und Spielplätze mit eigener '
              . 'Geschichte — Orte, an denen Menschen stehen bleiben und staunen.';
$brotkrumen   = [['Leistungen', '/leistungen/'], ['Erlebnisse', '/erlebnisgestaltung/']];
$styles       = ['/assets/projekt.css'];
$voll_breit   = true;
$bodyKlasse   = 'seite-dunkel';

// Je Zeile: Titel, Text, Kategorien (Schlagworte in Space). Das Bild daneben
// zeigt das neueste Projekt mit einer dieser Kategorien, sonst einen
// Platzhalter (pj_feld_flieger()). Die erste Kategorie ist die, die der
// Platzhalter nennt.
$felder = [
    ['Ausstellungen',
     'Wir entwickeln Ausstellungen vom Konzept bis zur Eröffnung: Kuration, Raumkonzept, Grafik, Leitsystem und die Stationen im Raum. Manche Ausstellungen übernehmen wir komplett, bei anderen bringen wir einen Teil ein — etwa die Kinderebene oder die Gestaltung.',
     ['Ausstellung']],
    ['Escape-Rooms und Treasure-Trails',
     'Wir entwickeln Escape-Rooms und Treasure-Trails vom Rätselkonzept bis zur fertigen Station: Geschichte, Rätsellogik, Gestaltung und Bau. Ob drinnen oder draußen — wir schaffen einen Spannungsbogen, der die Aufmerksamkeit von der ersten bis zur letzten Aufgabe auf sich zieht.',
     ['Escape-Room', 'Treasure-Trail']],
    ['Spielplätze und Outdoor-Abenteuer',
     'Spielend lernen steht hier ganz oben auf der Tagesordnung. Wir gestalten Themenspielplätze und interaktive Outdoor-Stationen, die eine Geschichte erzählen und Inhalte spielerisch vermitteln. Wer sie betritt, findet eine Welt, die zum Forschen, Staunen und Entdecken einlädt. Das weckt die kindliche Neugier, nicht nur bei den Jüngsten.',
     ['Spielplatz']],
    ['Themenwege und Rundgänge',
     'Wir inszenieren Rundwege und Themenpfade entlang von Kultur- und Naturräumen. Der Weg wird hier tatsächlich zum Ziel: Jede Station ist wie ein Puzzlestück, das sich in die Geschichte einfügt.',
     ['Themenweg', 'Erlebnisweg']],
    ['Vermittlungsebenen für Familien',
     'Wir entwickeln Kinderbegleitebenen zu neuen und bestehenden Ausstellungen: Rätselhefte, Hörstationen und Mitmach-Elemente, die ein Thema für Kinder öffnen und gleichzeitig mit den Eltern erlebbar machen.',
     ['Kinderebene']],
];

$merkmale = [
    ['Analog und zum Anfassen.',
     'Wir bauen mit echtem Holz, mit Drehtrommeln, Klappen, Geruchs- und Taststationen. Was man angreifen kann, bleibt länger im Kopf — und hält im täglichen Einsatz länger durch als jeder Bildschirm.'],
    ['Digital mit Sinn.',
     'Audioguides, Screens und Medientechnik setzen wir ein, wenn sie etwas leisten, das analog nicht geht. Dann gehören sie dazu. Bis hin zu multimedial-immersiven Rauminstallationen.'],
    ['Für den Betrieb danach.',
     'Wir liefern Anleitungen für den laufenden Betrieb mit: Handbücher für die Technik, Handlungsanweisungen für das Team vor Ort und Inhaltssammlungen für die Kulturvermittlung. Damit funktioniert die Ausstellung auch dann, wenn wir nicht mehr dabei sind.'],
];

// Häufige Fragen — die Antwort zur Projektdauer fehlt noch (Roman).
$fragen = [
    ['Können Sie eine Ausstellung komplett übernehmen?',
     'Ja, vom Konzept bis zur Eröffnung, mit allen Rollen im Prozess. Was wir nicht selbst machen, übernehmen Partner aus unserem Netzwerk.'],
    ['Wir haben schon ein Team. Kommen Sie trotzdem dazu?',
     'Gerne. Oft holt man uns für einen bestimmten Teil, etwa die Kinderebene oder die Ausstellungsdidaktik. Dann arbeiten wir mit allen Beteiligten zusammen.'],
    ['Wie lange dauert das — vom Auftrag bis zur Eröffnung?',
     'Je nach Umfang: Ein Erlebnisweg oder Spielplatz ist in rund 8 Monaten umgesetzt, eine umfangreiche Ausstellung braucht bis zu 18 Monate.'],
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


$ctaTitel = 'Planen Sie eine Ausstellung oder ein Ausflugsziel?';
$ctaText  = 'Erzählen Sie uns von Ihrem Ort und Ihrer Geschichte.';
$ctaKnopf = 'Reden wir darüber';

// Gruß an alle, die den Quellcode lesen (siehe teile/kopf.php).
$quellkunst = <<<'KUNST'
<!--
                ___
              /' _ `\     [ BAUAUFSICHT PFAU ]
             |  / \  |    "Ich prüfe nur die Spaltmaße..."
             |  \_/  |
        .---'\_____/'---.
       /                 \
      |   (o)   (o)   (o) |
      |  (o)   (o)   (o)  |
       \                 /
        '--._________.-'
              /     \
             /       \

  Spielplätze, Ausstellungen, Pfau-Begutachtungen.
  Wir inszenieren Erlebnisse, die im Gedächtnis bleiben.
-->
KUNST;

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
      <h1 class="titel-gross">Inhalte<br>begreifbar<br>machen.</h1>
      <div class="kopf-gross-zeile">
        <div class="kopf-gross-rechts">
      <p>Wir gestalten Ausstellungen, Themenwege und Spielplätze mit eigener
        Geschichte — Orte, an denen Menschen stehen bleiben, staunen und etwas
        mitnehmen.</p>
      <p>Wissen wirkt am stärksten dort, wo man es spürt. Wir kuratieren,
        inszenieren und gestalten Erlebnisse, die komplexe Themen begreifbar
        machen — für Familien, für Schulklassen, für Neugierige jeden Alters. Zu
        unseren Auftraggebern gehören Museen, Gemeinden,
        Tourismusregionen und Ausflugsziele.</p>
    </div>
      </div>
    </div>
    <span class="pj-runter leistung-runter" aria-hidden="true"><?= lz_pfeil_runter() ?></span>
  </div>
</section>

<section class="lz-sec viel-luft">
  <h2 class="titel-gross">Was wir<br>gestalten.</h2>
  <?php // Zentrierte Liste; die Projektbilder schweben abwechselnd links
        // und rechts außerhalb und verlinken (nur sie) zum Portfolio-Eintrag. ?>
  <div class="feld-fluss">
    <?php foreach ($felder as [$feldTitel, $feldText, $feldKategorien]): ?>
    <div class="feld-eintrag">
      <div class="feld-text">
        <h3><?= e($feldTitel) ?></h3>
        <p><?= e($feldText) ?></p>
      </div>
      <?= pj_feld_flieger($feldKategorien) ?>
    </div>
    <?php endforeach; ?>
  </div>
  <p class="feld-knopf">
    <a class="knopf knopf-hell" href="/referenzen/?filter=erlebnis">Alle Erlebnis-Projekte <?= lz_pfeil() ?></a>
  </p>
</section>

<section class="lz-sec viel-luft">
  <h2 class="titel-gross">Wie wir<br>gestalten.</h2>
  <div class="merkmale">
    <?php foreach ($merkmale as [$mTitel, $mText]): ?>
    <div class="merkmal">
      <h3><?= e($mTitel) ?></h3>
      <p><?= e($mText) ?></p>
    </div>
    <?php endforeach; ?>
  </div>
</section>

<section class="lz-sec viel-luft">
  <h2 class="titel-gross">Häufige Fragen.</h2>
  <div class="faq">
    <?php foreach ($fragen as [$frage, $antwort]): ?>
    <details>
      <summary><?= e($frage) ?></summary>
      <p><?= e($antwort) ?></p>
    </details>
    <?php endforeach; ?>
  </div>
</section>

<?php // Querverweis zur anderen Säule (Roman, 12.10.2026) — steht auf
      // beiden Säulen-Seiten baugleich vor dem CTA. ?>
<section class="lz-sec saeule-wechsel">
  <p class="saeule-wechsel-satz">Sie suchen Corporate Design, Publikationen
    oder eine Website?</p>
  <a class="knopf knopf-hell" href="/grafikdesign/">Zum Grafikdesign <?= lz_pfeil() ?></a>
</section>

<script src="<?= e(lz_asset('/assets/hero-film.js')) ?>" defer></script>

<?php // CTA oberhalb des Newsletters (Beschluss Roman, 8.10.2026). ?>
<?php require __DIR__ . '/../teile/cta.php'; ?>
<?php require __DIR__ . '/../teile/newsletter.php'; ?>

<?php require __DIR__ . '/../teile/fuss.php'; ?>
