<?php
// Landingpage Säule „Gestaltung für Unternehmen". Texte: „Website-Texte",
// Abschnitt „LP Säule Grafikdesign"; Meta laut Briefing 5.3. Aufbau laut
// Briefing 3: H1 · Teaser · Leistungen · Ansatz · Referenzen · FAQ · CTA ·
// Newsletter. FAQ folgt aus der Wissensbasis (Stufe 2), Referenzen aus Space.
require_once __DIR__ . '/../teile/firma.php';
require_once __DIR__ . '/../teile/projekte.php';

$titel        = 'Corporate Design, Magazine & Publikationen | leerzeichen';
$beschreibung = 'Corporate Design, Mitarbeitermagazine, Bücher, Kataloge und digitale '
              . 'Auftritte für regionale Unternehmen. Seit 2008.';
$brotkrumen   = [['Gestaltung', '/grafikdesign/']];
$styles       = ['/assets/projekt.css'];

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
    ['Zeitlose Gestaltung ist unser Anspruch.',
     'Ein Erscheinungsbild soll zehn Jahre halten. Wir gestalten so, dass es in fünf Jahren noch richtig aussieht.'],
];

// Drei Referenzen dieser Säule (aus Space; solange keine da sind, entfällt der Block).
$referenzen = array_slice(array_values(array_filter(pj_index(),
    fn($p) => ($p['saeule'] ?? '') === 'gestaltung')), 0, 3);

require __DIR__ . '/../teile/kopf.php';
?>

<section class="abschnitt">
  <h1 class="lz-h2" style="max-width:24ch">Wir machen sichtbar, was Ihr Unternehmen
    ausmacht — und geben Ihrer Geschichte eine Form.</h1>
  <p class="lz-lead" style="margin-top:var(--space-5);max-width:52ch">Viele Betriebe
    können mehr, als man ihnen ansieht. Wir entwickeln das Bild, das dazu passt:
    ein Erscheinungsbild (Corporate Design), das auf dem Briefpapier genauso
    funktioniert wie auf dem Screen, der Messe, und in Publikationen, die jemand
    freiwillig in die Hand nimmt.</p>
  <p class="lz-lead" style="margin-top:var(--space-4);max-width:52ch">Unsere Kunden
    sind meist regional, aber ihre Geschichten wirken (Europa)weit.</p>
</section>

<section class="abschnitt">
  <h2>Leistungen</h2>
  <ul class="lz-svc" style="max-width:36rem">
    <?php foreach ($leistungen as $l): ?>
    <li><?= e($l) ?></li>
    <?php endforeach; ?>
  </ul>
</section>

<section class="abschnitt">
  <h2>Unser Ansatz</h2>
  <?php foreach ($ansatz as [$kopf, $text]): ?>
  <h3 style="margin-top:var(--space-6)"><?= e($kopf) ?></h3>
  <p class="lz-lead" style="max-width:52ch"><?= e($text) ?></p>
  <?php endforeach; ?>
</section>

<?php if ($referenzen): ?>
<section class="abschnitt">
  <h2>Referenzen</h2>
  <div class="pj-liste">
    <?php foreach ($referenzen as $p) { echo pj_karte($p); } ?>
  </div>
</section>
<?php endif; ?>

<?php // FAQ-Block folgt aus der Wissensbasis (daten/faq/gestaltung.json, Stufe 2). ?>

<section class="abschnitt">
  <h2 class="lz-h2">Gemeinsam bringen wir Neues in Ihre Welt.</h2>
  <div style="margin-top:var(--space-6)">
    <a class="knopf" href="/kontakt/">Reden wir darüber</a>
  </div>
</section>

<?php require __DIR__ . '/../teile/fuss.php'; ?>
