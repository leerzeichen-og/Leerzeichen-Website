<?php
// Landingpage Säule „Erlebnisse" — Gestaltungsbasis der Startseite (dunkler
// Hero mit Ink-Motiv und Chip, Leistungs-Laufband, Referenzkarten,
// Newsletter, CTA). Der ausgearbeitete LP-Text liegt noch nicht vor
// („Website-Texte" enthält nur die LP Grafikdesign) — bis dahin trägt der
// Säulentext die Seite; Ansatz-Blöcke und FAQ folgen.
require_once __DIR__ . '/../teile/firma.php';
require_once __DIR__ . '/../teile/projekte.php';

$titel        = 'Ausstellungen, Erlebniswege & Escape-Rooms | leerzeichen';
$beschreibung = 'Wir gestalten Ausstellungen, Rundwege, Escape-Rooms, Spielplatzkonzepte '
              . 'und Kinderbegleitebenen — vom Konzept bis zur Eröffnung.';
$brotkrumen   = [['Erlebnisse', '/erlebnisgestaltung/']];
$styles       = ['/assets/projekt.css'];
$voll_breit   = true;

$leistungen = ['Ausstellungen und Ausstellungsgestaltung', 'Kinderbegleitebenen', 'Escape-Rooms',
               'Treasure Trails', 'Rundwege mit interaktiven Stationen', 'Outdoor-Abenteuer',
               'Spielplatzkonzepte', 'Leitsysteme und Beschilderung', 'Interaktive Stationen'];

$referenzen = array_slice(array_values(array_filter(pj_index(),
    fn($p) => ($p['saeule'] ?? '') === 'erlebnisse')), 0, 3);

$ctaTitel = 'Ihr Projekt fehlt hier noch?';
$ctaKnopf = 'Starten wir mit einem Gespräch';

require __DIR__ . '/../teile/kopf.php';
?>

<section class="seiten-hero" style="background-image:linear-gradient(180deg, rgba(0,0,0,0) 30%, rgba(0,0,0,.9) 72%), url(/assets/bilder/ink-splash.webp)">
  <span class="chip">Erlebnisse</span>
  <h1 class="titel-seite">Wir schaffen Erlebnisse — und bringen Neues in die Welt.</h1>
  <p class="lz-lead" style="margin-top:var(--space-6);max-width:52ch">Erlebnisse haben
    viele Formen: Ausstellungen, Escape-Rooms und Treasure Trails, Rundwege mit
    interaktiven Stationen, Outdoor-Abenteuer, Spielplätze mit ihrer eigenen
    Geschichte, Kinderebenen, die eine Ausstellung für Familien öffnen. Am Ende
    steht immer dieselbe Frage: Was bringt Besucher zum Staunen?</p>
  <p class="lz-lead" style="margin-top:var(--space-4);max-width:52ch">Wir arbeiten für
    Museen, Gemeinden, Ausflugsziele und Tourismusregionen. Oft an Kinder und ihre
    Familien gerichtet. Analog und begreifbar. Digital dort, wo es Sinn stiftet.</p>
</section>

<section class="lz-sec" style="padding-top:var(--space-7);padding-bottom:var(--space-7)">
  <?= lz_laufband($leistungen, 'laufband-retour kipp-b') ?>
</section>

<?php // Ansatz-Blöcke folgen mit dem ausgearbeiteten LP-Text (Website-Texte). ?>

<?php if ($referenzen): ?>
<section class="lz-sec">
  <h2 class="lz-h2">Referenzen</h2>
  <div class="pj-liste" style="margin-top:var(--space-7)">
    <?php foreach ($referenzen as $p) { echo pj_karte($p); } ?>
  </div>
</section>
<?php endif; ?>

<?php // FAQ-Block folgt aus der Wissensbasis (daten/faq/erlebnisse.json, Stufe 2). ?>

<?php require __DIR__ . '/../teile/newsletter.php'; ?>
<?php require __DIR__ . '/../teile/cta.php'; ?>

<?php require __DIR__ . '/../teile/fuss.php'; ?>
