<?php
// Landingpage Säule „Gestaltung für Unternehmen" — Gestaltungsbasis der
// Startseite (dunkler Hero mit Ink-Motiv und Chip, Leistungs-Laufband,
// Prinzipien mit Oberlinie, Referenzkarten, Newsletter, CTA).
// Texte: „Website-Texte", Abschnitt „LP Säule Grafikdesign"; Meta laut
// Briefing 5.3. FAQ folgt aus der Wissensbasis (Stufe 2).
require_once __DIR__ . '/../teile/firma.php';
require_once __DIR__ . '/../teile/projekte.php';

$titel        = 'Corporate Design, Magazine & Publikationen | leerzeichen';
$beschreibung = 'Corporate Design, Mitarbeitermagazine, Bücher, Kataloge und digitale '
              . 'Auftritte für regionale Unternehmen. Seit 2008.';
$brotkrumen   = [['Gestaltung', '/grafikdesign/']];
$styles       = ['/assets/projekt.css'];
$voll_breit   = true;

$leistungen = ['Corporate Design und Redesign', 'Logoentwicklung', 'Mitarbeitermagazine',
               'Kundenmagazine', 'Bücher und Publikationen', 'Kataloge und Prospekte',
               'Geschäftsausstattung', 'Microsites und Landingpages', 'Screendesign'];

$ansatz = [
    ['Zuerst zuhören.',
     'Bevor wir gestalten, verstehen wir, was Sie tun und für wen. Eine Gestaltung, die die Sache nicht trifft, ist auch dann falsch, wenn sie gut aussieht.'],
    ['Dann gestalten.',
     'Logo, Farben, Schrift und Bildwelt sind das Fundament. Darauf lässt sich Jahre später noch aufbauen, ohne von vorne anzufangen. Sie haben bereits ein tolles Corporate Design? Dann arbeiten wir gerne damit.'],
    ['Geschichten visuell erzählen.',
     'Damit Ihre Botschaft wirkt, ist Gestaltung essentiell. Wir bauen den Inhalt so auf, dass man ihn liest: Rhythmus über hunderte Seiten, die Bilder an der richtigen Stelle. Was Sie uns geben, bringen wir in Form. Wo der Inhalt erst entstehen darf, bringen wir uns gerne ein und organisieren alles, was es dazu braucht.'],
    ['Zeitlos ist unser Anspruch.',
     'Ein Erscheinungsbild soll zehn Jahre halten. Wir gestalten so, dass es in fünf Jahren noch richtig aussieht.'],
];

$referenzen = array_slice(array_values(array_filter(pj_index(),
    fn($p) => ($p['saeule'] ?? '') === 'gestaltung')), 0, 3);

$ctaTitel = 'Ihr Projekt fehlt hier noch?';
$ctaKnopf = 'Starten wir mit einem Gespräch';


require __DIR__ . '/../teile/kopf.php';
?>

<section class="seiten-hero" style="background-image:linear-gradient(180deg, rgba(0,0,0,0) 30%, rgba(0,0,0,.9) 72%), url(/assets/bilder/ink-splash.webp)">
  <span class="chip">Gestaltung für Unternehmen</span>
  <h1 class="titel-seite">Wir machen sichtbar, was Ihr Unternehmen ausmacht —
    und geben Ihrer Geschichte eine Form.</h1>
  <p class="lz-lead" style="margin-top:var(--space-6);max-width:52ch">Viele Betriebe
    können mehr, als man ihnen ansieht. Wir entwickeln das Bild, das dazu passt:
    ein Erscheinungsbild (Corporate Design), das auf dem Briefpapier genauso
    funktioniert wie auf dem Screen, der Messe, und in Publikationen, die jemand
    freiwillig in die Hand nimmt.</p>
  <p class="lz-lead" style="margin-top:var(--space-4);max-width:52ch">Unsere Kunden
    sind meist regional, aber ihre Geschichten wirken (Europa)weit.</p>
</section>

<section class="lz-sec" style="padding-top:var(--space-7);padding-bottom:var(--space-7)">
  <?= lz_laufband($leistungen, 'kipp-a') ?>
</section>

<section class="lz-sec">
  <h2 class="lz-h2" style="max-width:20ch">Unser Ansatz</h2>
  <div class="prinzipien">
    <?php foreach ($ansatz as [$kopf, $text]): ?>
    <div class="prinzip">
      <h3><?= e($kopf) ?></h3>
      <p><?= e($text) ?></p>
    </div>
    <?php endforeach; ?>
  </div>
</section>

<?php if ($referenzen): ?>
<section class="lz-sec">
  <h2 class="lz-h2">Referenzen</h2>
  <div class="pj-liste" style="margin-top:var(--space-7)">
    <?php foreach ($referenzen as $p) { echo pj_karte($p); } ?>
  </div>
</section>
<?php endif; ?>

<?php // FAQ-Block folgt aus der Wissensbasis (daten/faq/gestaltung.json, Stufe 2). ?>

<?php require __DIR__ . '/../teile/newsletter.php'; ?>
<?php require __DIR__ . '/../teile/cta.php'; ?>

<?php require __DIR__ . '/../teile/fuss.php'; ?>
