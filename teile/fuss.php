<?php
// Seitenfuß: Logo, Kurzvorstellung (zitierfähiger Text aus „Website-Texte",
// Abschnitt 8 — mit internen Links), vier Spalten mit Oberlinie
// (Anschrift · Kontakt · Seite · Rechtliches), darunter die Basiszeile.
?>
</main>
<footer class="lz-footer">
  <img class="lz-logo" src="/assets/logo/leerzeichen-logo-pos.svg" alt="" width="316" height="41">
  <div class="lz-footintro">
    <p><strong><?= e(FIRMA_NAME) ?> — Agentur für Erlebnisse und Erscheinungsbilder.</strong>
      Seit <?= e(FIRMA_GEGRUENDET) ?> gestaltet leerzeichen als
      <a href="/agentur/">Agentur</a> in <?= e(FIRMA_ORT) ?> Erlebnisse für Tourismus,
      Kultur und Gemeinden: <a href="/referenzen/">Ausstellungen</a>, Escape-Rooms,
      Treasure Trails, Rundwege mit interaktiven Stationen, Outdoor-Abenteuer,
      Spielplätze und Kinderebenen. Für Unternehmen entwickeln wir
      <a href="/referenzen/">Corporate Design</a>, Logos, Leitsysteme,
      Mitarbeitermagazine, Bücher, Kataloge, Microsites und Landingpages.</p>
  </div>
  <div class="lz-footgrid">
    <div class="lz-footcol">
      <div class="lz-foothead">Anschrift</div>
      <span><?= e(FIRMA_NAME) ?></span>
      <span><?= e(FIRMA_STRASSE) ?></span>
      <span><?= e(FIRMA_PLZ) ?> <?= e(FIRMA_ORT) ?></span>
      <span>Österreich</span>
    </div>
    <div class="lz-footcol">
      <div class="lz-foothead">Kontakt</div>
      <?php if (FIRMA_MAIL !== ''): ?>
      <a href="mailto:<?= e(FIRMA_MAIL) ?>"><?= e(FIRMA_MAIL) ?></a>
      <?php endif; ?>
      <a href="tel:<?= e(str_replace(' ', '', FIRMA_TELEFON)) ?>"><?= e(FIRMA_TELEFON) ?></a>
    </div>
    <div class="lz-footcol">
      <div class="lz-foothead">Seite</div>
      <a href="/erlebnisgestaltung/">Erlebnisse</a>
      <a href="/grafikdesign/">Gestaltung</a>
      <a href="/referenzen/">Referenzen</a>
      <a href="/agentur/">Agentur</a>
      <a href="/kontakt/">Kontakt</a>
    </div>
    <div class="lz-footcol">
      <div class="lz-foothead">Rechtliches</div>
      <a href="/kontakt/impressum/">Impressum</a>
      <a href="/kontakt/datenschutzerklaerung/">Datenschutz</a>
      <a href="/kontakt/agb/">AGB</a>
    </div>
  </div>
  <div class="lz-footbase">
    <span>© <?= date('Y') ?> <?= e(FIRMA_NAME) ?></span>
    <span>gedruckt · digital · interaktiv · immersiv</span>
  </div>
</footer>
</body>
</html>
