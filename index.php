<?php
// Startseite. Aufbau laut Briefing Abschnitt 3:
// Claim · Projekt-Scroller · zwei Säulen · Über uns · Newsletter · CTA.
// Die Texte kommen aus dem Dokument „Website-Texte" — bis dahin Platzhalter.

$titel        = 'leerzeichen — Erlebnisse und Gestaltung | Neumarkt/Ybbs';
$beschreibung = 'Agentur für Ausstellungen, Erlebniswege und Corporate Design. '
              . 'Seit 2008 in Neumarkt an der Ybbs. Für Museen, Gemeinden und Unternehmen.';
require __DIR__ . '/teile/kopf.php';
?>

<section class="abschnitt">
  <h1>Gemeinsam Zeichen setzen</h1>
  <p class="platzhalter">Drei Fragen + Kanalzeile — Text aus „Website-Texte" einsetzen.</p>
</section>

<section class="abschnitt" aria-label="Ausgewählte Projekte">
  <h2>Ausgewählte Projekte</h2>
  <p class="platzhalter">Projekt-Scroller: vier Projekte aus <code>daten/projekte/index.json</code>,
  abwechselnd nach Säulen. Kommt mit dem Referenzen-Schritt.</p>
</section>

<section class="abschnitt">
  <h2>Gestaltung ist unser Handwerk</h2>
  <div class="platzhalter">
    <p><strong>Säule Erlebnisse</strong> — Teasertext, Link auf <a href="/erlebnisgestaltung/">/erlebnisgestaltung/</a></p>
    <p><strong>Säule Gestaltung</strong> — Teasertext, Link auf <a href="/grafikdesign/">/grafikdesign/</a></p>
  </div>
</section>

<section class="abschnitt">
  <h2>Wir sind Leerzeichen</h2>
  <p class="platzhalter">Über-uns-Teaser + Knopf zur <a href="/agentur/">Agenturseite</a>.</p>
</section>

<section class="abschnitt">
  <h2>Empty Space — der Newsletter</h2>
  <p class="platzhalter">Anmeldeformular folgt mit der Newsletter-Entscheidung (voraussichtlich Brevo).</p>
</section>

<section class="abschnitt">
  <h2>Gemeinsam bringen wir Neues in Ihre Welt</h2>
  <p class="platzhalter">Call to Action mit Kontakt-Knopf → <a href="/kontakt/">/kontakt/</a></p>
</section>

<?php require __DIR__ . '/teile/fuss.php'; ?>
