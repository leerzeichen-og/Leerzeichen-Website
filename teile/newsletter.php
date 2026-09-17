<?php
// Newsletter-Anmeldung „Empty Space" — kompakter Block in Postkarten-Anmutung
// (bewusst nie volle Breite; Beschluss Roman 17.9.2026). Wird von der
// Startseite und den Landingpages eingebunden. Texte: „Website-Texte", Abschnitt 6.
// Die Anmeldestrecke folgt mit der Newsletter-Entscheidung (voraussichtlich
// Brevo) — bis dahin führt der Knopf zur Mail, damit nichts ins Leere geht.
?>
<section id="newsletter" class="lz-sec nl-bereich">
  <div class="nl-baum">
    <img src="/assets/bilder/newsletter-baum.webp" alt="" width="1356" height="1164" loading="lazy">
  </div>
  <div class="nl-karte">
    <div class="nl-karte-inhalt">
      <h2 class="lz-h3" style="font-weight:700">Empty Space</h2>
      <p>Der leerzeichen Newsletter. Wir schreiben über Dinge, die uns bei der
        Arbeit beschäftigen. Vier Mal im Jahr.</p>
      <ul class="nl-punkte">
        <li>Ein Fokus-Thema pro Ausgabe, etwa „Keine Angst vor Feedback“ oder
          „Der Wert des Gedruckten“</li>
        <li>Projekt-Schnipsel: Erkenntnisse und Ergebnisse.</li>
        <li>Designbegriffe erklärt: damit Sie wissen, wovon die Rede ist</li>
      </ul>
    </div>
    <form class="nl-form" action="mailto:<?= e(FIRMA_MAIL) ?>?subject=Empty%20Space%20Anmeldung" method="get">
      <label class="lz-field"><span class="lz-label">E-Mail-Adresse</span><input class="lz-input" type="email" name="email"></label>
      <label class="nl-zustimmung">
        <input type="checkbox" required>
        <span>Ich bin damit einverstanden, dass leerzeichen mir den Newsletter zusendet.
          Eine Abmeldung ist jederzeit möglich.</span>
      </label>
      <div><button class="knopf" type="submit">Jetzt anmelden</button></div>
    </form>
  </div>
</section>
