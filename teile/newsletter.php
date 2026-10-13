<?php
// Newsletter-Anmeldung „Empty Space" — zweispaltige Karte wie im Design-
// Briefing, aber nie auf voller Breite; die Kuvert-Grafik ragt über den
// Rahmen in die Box hinein (Beschluss Roman 17.9.2026).
// Texte: „Website-Texte", Abschnitt 6.
// Anmeldestrecke (13.10.2026): Mit hinterlegtem Brevo-Zugang
// (teile/geheim.php, nur am Server) sendet das Formular an
// /newsletter/anmelden/ — Double-Opt-in über Brevo. Ohne Zugang (lokal,
// oder bevor das Secret gesetzt ist) führt der Knopf wie bisher zur
// Mail, damit nichts ins Leere geht.
@include_once __DIR__ . '/geheim.php';
$nlBrevo = defined('BREVO_KEY') && BREVO_KEY !== ''
        && defined('BREVO_DOI_VORLAGE') && BREVO_DOI_VORLAGE > 0;
?>
<section id="newsletter" class="lz-sec nl-bereich">
  <div class="nl-karte">
    <img class="nl-kuvert" src="/assets/bilder/newsletter-baum.webp" alt=""
      width="1356" height="1164" loading="lazy">
    <div class="nl-spalten">
      <div>
        <h2>Empty Space</h2>
        <p class="nl-untertitel">Der leerzeichen Newsletter. Wir schreiben über
          Dinge, die uns bei der Arbeit beschäftigen. Vier Mal im Jahr.</p>
        <ul class="lz-nllist">
          <li><strong>Ein Fokus-Thema pro Ausgabe</strong><span>Spannende Themen
            aus der Welt der Gestaltung, der Erlebnisse und Abenteuer</span></li>
          <li><strong>Projekt-Schnipsel</strong><span>Erkenntnisse und Ergebnisse.</span></li>
          <li><strong>Farbe auf Papier</strong><span>Unser Quartals-Buchtipp
            zur analogen Erhellung</span></li>
        </ul>
      </div>
      <form class="nl-form"<?= $nlBrevo
          ? ' action="/newsletter/anmelden/" method="post"'
          : ' action="mailto:' . e(FIRMA_MAIL) . '?subject=Empty%20Space%20Anmeldung" method="get"' ?>>
        <?php if ($nlBrevo): ?>
        <?php // Honigtopf + Zeitfalle — gleiche Bot-Abwehr wie die Projektanfrage. ?>
        <p class="anfrage-falle" aria-hidden="true">
          <label>Website <input type="text" name="website" tabindex="-1" autocomplete="off"></label>
        </p>
        <input type="hidden" name="seit" value="<?= time() ?>">
        <?php endif; ?>
        <label class="lz-field"><span class="lz-label">E-Mail-Adresse</span><input class="lz-input" type="email" name="email"<?= $nlBrevo ? ' required' : '' ?>></label>
        <label class="lz-field"><span class="lz-label">Vorname</span><input class="lz-input" type="text" name="vorname"></label>
        <label class="lz-field"><span class="lz-label">Nachname</span><input class="lz-input" type="text" name="nachname"></label>
        <label class="nl-zustimmung">
          <input type="checkbox" required<?= $nlBrevo ? ' name="zustimmung" value="ja"' : '' ?>>
          <span>Ich bin damit einverstanden, dass leerzeichen mir den Newsletter
            zusendet. Eine Abmeldung ist jederzeit möglich.</span>
        </label>
        <div><button class="knopf" type="submit">Jetzt anmelden</button></div>
      </form>
    </div>
  </div>
</section>
