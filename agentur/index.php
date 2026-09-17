<?php
// Agenturseite („Über uns", Langfassung). Texte: „Website-Texte", Abschnitt 5;
// Meta laut Briefing 5.3.
require_once __DIR__ . '/../teile/firma.php';

$titel        = 'Agentur — drei Gestalter in Neumarkt an der Ybbs';
$beschreibung = 'Wer wir sind, wie wir arbeiten, was wir machen. leerzeichen multimedia og, '
              . 'seit 2008 im Rathaus von Neumarkt an der Ybbs.';
$brotkrumen   = [['Agentur', '/agentur/']];

$team = [
    ['Roman Dachsberger', 'Gestalter'],
    ['Johanna Eder', 'Gestalterin'],
    ['Susanne Pichelmann', 'Gestalterin'],
];

require __DIR__ . '/../teile/kopf.php';
?>

<section class="abschnitt">
  <h1>Wir sind Leerzeichen.</h1>
  <p class="lz-lead" style="max-width:52ch">Ohne Leerzeichen wäre dieser Satz kaum zu
    lesen. Der kleinste Eingriff entscheidet darüber, ob etwas ankommt. Und der
    Abstand ist es, der den Blick lenkt und das Wichtige stehen lässt. Dem folgend
    begleiten wir seit <?= e(FIRMA_GEGRUENDET) ?> Projekte von der ersten Skizze
    bis zur Übergabe — <?= e(FIRMA_NAME) ?> aus <?= e(FIRMA_ORT) ?>.</p>
</section>

<section class="abschnitt">
  <h2>Ansatz</h2>
  <p class="lz-lead" style="max-width:52ch">Form follows Function, wörtlich genommen.
    Was wir gestalten, funktioniert: im Druck, am Screen, in einer Ausstellung, die
    jahrelang von Kindern benutzt wird. Zeitlose Gestaltung ist unser Anspruch.
    Unsere Konzepte und Gestaltungen sollen langlebig ihre Wirkung entfalten.</p>
</section>

<section class="abschnitt">
  <h2>Netzwerk</h2>
  <p class="lz-lead" style="max-width:52ch">Für die Produktion holen wir Leute dazu,
    mit denen wir seit Jahren arbeiten: Experten und Unternehmen, die außergewöhnliche
    Projekte mit uns umsetzen. Medientechniker, Motion Designer, Druckereien,
    Werbetechniker, Lektorinnen, Illustratoren, Architekten. Wir nutzen unser
    Netzwerk und bleiben verantwortlich, bis das Projekt steht.</p>
</section>

<section class="abschnitt">
  <h2>Technik</h2>
  <p class="lz-lead" style="max-width:52ch">Vom Screendesign fürs Handydisplay über
    Bücher mit mehreren hundert Seiten bis zum 30-Meter-Print haben wir alles schon
    produziert. Technologisch legen wir uns nicht fest, analog wie digital. KI setzen
    wir dort ein, wo sie Arbeit abnimmt und Ihren Nutzen vergrößert.</p>
</section>

<section class="abschnitt">
  <h2>Das Büro</h2>
  <p class="lz-lead" style="max-width:52ch">Wir arbeiten im altehrwürdigen Rathaus von
    <?= e(FIRMA_ORT) ?>, erbaut im 16. Jahrhundert. Es wurde schon als Mauthaus,
    Gefängnis, Volksschule, Post, Kindergarten und Musikschule genutzt. Wir sind also
    in guter Gesellschaft, was wechselnde Aufgaben angeht.</p>
</section>

<section class="abschnitt">
  <h2>Team</h2>
  <ul class="lz-svc" style="max-width:32rem">
    <?php foreach ($team as [$name, $rolle]): ?>
    <li><?= e($name) ?>, <?= e($rolle) ?></li>
    <?php endforeach; ?>
  </ul>
</section>

<section class="abschnitt">
  <a class="knopf" href="/kontakt/">Reden wir darüber</a>
</section>

<?php require __DIR__ . '/../teile/fuss.php'; ?>
