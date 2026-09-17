<?php
// Newsletter-Anmeldung „Empty Space" — zweispaltige Karte wie im Design-
// Briefing, aber nie auf voller Breite; die Kuvert-Grafik ragt über den
// Rahmen in die Box hinein (Beschluss Roman 17.9.2026).
// Texte: „Website-Texte", Abschnitt 6. Anmeldestrecke folgt (Brevo) —
// bis dahin führt der Knopf zur Mail, damit nichts ins Leere geht.
?>
<section id="newsletter" class="lz-sec nl-bereich">
  <div class="nl-karte">
    <img class="nl-kuvert" src="/assets/bilder/newsletter-baum.webp" alt=""
      width="1356" height="1164" loading="lazy">
    <div class="nl-spalten">
      <div>
        <h2 class="lz-h3" style="font-weight:700">Empty Space</h2>
        <p class="nl-untertitel">Der leerzeichen Newsletter. Wir schreiben über
          Dinge, die uns bei der Arbeit beschäftigen. Vier Mal im Jahr.</p>
        <ul class="lz-nllist">
          <li><strong>Ein Fokus-Thema</strong><span>pro Ausgabe, etwa „Keine Angst
            vor Feedback“ oder „Der Wert des Gedruckten“</span></li>
          <li><strong>Projekt-Schnipsel</strong><span>Erkenntnisse und Ergebnisse.</span></li>
          <li><strong>Designbegriffe erklärt</strong><span>damit Sie wissen,
            wovon die Rede ist</span></li>
        </ul>
      </div>
      <form class="nl-form" action="mailto:<?= e(FIRMA_MAIL) ?>?subject=Empty%20Space%20Anmeldung" method="get">
        <label class="lz-field"><span class="lz-label">E-Mail-Adresse</span><input class="lz-input" type="email" name="email"></label>
        <label class="lz-field"><span class="lz-label">Vorname</span><input class="lz-input" type="text" name="vorname"></label>
        <label class="lz-field"><span class="lz-label">Nachname</span><input class="lz-input" type="text" name="nachname"></label>
        <label class="nl-zustimmung">
          <input type="checkbox" required>
          <span>Ich bin damit einverstanden, dass leerzeichen mir den Newsletter
            zusendet. Eine Abmeldung ist jederzeit möglich.</span>
        </label>
        <div><button class="knopf" type="submit">Jetzt anmelden</button></div>
      </form>
    </div>
  </div>
</section>
