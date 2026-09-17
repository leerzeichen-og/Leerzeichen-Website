<?php
// Landingpage Säule „Erlebnisse". Meta laut Briefing 5.3. Der ausgearbeitete
// LP-Text liegt noch nicht vor („Website-Texte" enthält nur die LP Grafikdesign)
// — bis dahin trägt der Startseiten-Säulentext die Seite; Ansatz-Blöcke und
// FAQ folgen mit dem Text bzw. der Wissensbasis (Stufe 2).
require_once __DIR__ . '/../teile/firma.php';
require_once __DIR__ . '/../teile/projekte.php';

$titel        = 'Ausstellungen, Erlebniswege & Escape-Rooms | leerzeichen';
$beschreibung = 'Wir gestalten Ausstellungen, Rundwege, Escape-Rooms, Spielplatzkonzepte '
              . 'und Kinderbegleitebenen — vom Konzept bis zur Eröffnung.';
$brotkrumen   = [['Erlebnisse', '/erlebnisgestaltung/']];
$styles       = ['/assets/projekt.css'];

$leistungen = ['Ausstellungen und Ausstellungsgestaltung', 'Kinderbegleitebenen', 'Escape-Rooms',
               'Treasure Trails', 'Rundwege mit interaktiven Stationen', 'Outdoor-Abenteuer',
               'Spielplatzkonzepte', 'Leitsysteme und Beschilderung', 'Interaktive Stationen'];

$referenzen = array_slice(array_values(array_filter(pj_index(),
    fn($p) => ($p['saeule'] ?? '') === 'erlebnisse')), 0, 3);

require __DIR__ . '/../teile/kopf.php';
?>

<section class="abschnitt">
  <h1 class="lz-h2" style="max-width:24ch">Wir schaffen Erlebnisse — und bringen
    Neues in die Welt.</h1>
  <p class="lz-lead" style="margin-top:var(--space-5);max-width:52ch">Erlebnisse haben
    viele Formen: Ausstellungen, Escape-Rooms und Treasure Trails, Rundwege mit
    interaktiven Stationen, Outdoor-Abenteuer, Spielplätze mit ihrer eigenen
    Geschichte, Kinderebenen, die eine Ausstellung für Familien öffnen. Am Ende
    steht immer dieselbe Frage: Was bringt Besucher zum Staunen?</p>
  <p class="lz-lead" style="margin-top:var(--space-4);max-width:52ch">Wir arbeiten für
    Museen, Gemeinden, Ausflugsziele und Tourismusregionen. Oft an Kinder und ihre
    Familien gerichtet. Analog und begreifbar. Digital dort, wo es Sinn stiftet.</p>
</section>

<section class="abschnitt">
  <h2>Leistungen</h2>
  <ul class="lz-svc" style="max-width:36rem">
    <?php foreach ($leistungen as $l): ?>
    <li><?= e($l) ?></li>
    <?php endforeach; ?>
  </ul>
</section>

<?php // Ansatz-Blöcke folgen mit dem ausgearbeiteten LP-Text (Website-Texte). ?>

<?php if ($referenzen): ?>
<section class="abschnitt">
  <h2>Referenzen</h2>
  <div class="pj-liste">
    <?php foreach ($referenzen as $p) { echo pj_karte($p); } ?>
  </div>
</section>
<?php endif; ?>

<?php // FAQ-Block folgt aus der Wissensbasis (daten/faq/erlebnisse.json, Stufe 2). ?>

<section class="abschnitt">
  <h2 class="lz-h2">Gemeinsam bringen wir Neues in Ihre Welt.</h2>
  <div style="margin-top:var(--space-6)">
    <a class="knopf" href="/kontakt/">Reden wir darüber</a>
  </div>
</section>

<?php require __DIR__ . '/../teile/fuss.php'; ?>
