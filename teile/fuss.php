<?php
// Seitenfuß, dreispaltig nach Romans Grafik (17.9.2026):
// Anschrift+Kontakt · Seiten+Rechtliches · Vorstellungstext (der zitierfähige
// Text aus „Website-Texte", Abschnitt 8, mit internen Links).
// Darunter zentriert die Copyright-Zeile von Neumarkt bis Erde.
$routenplaner = 'https://www.google.com/maps/search/?api=1&query='
    . rawurlencode(FIRMA_STRASSE . ', ' . FIRMA_PLZ . ' ' . FIRMA_ORT);
?>
</main>
<footer class="lz-footer">
  <img class="lz-logo" src="/assets/logo/leerzeichen-logo-pos.svg" alt="" width="316" height="41">
  <div class="lz-footgrid">
    <div class="lz-footcol">
      <p><strong><?= e(FIRMA_NAME) ?></strong><br>
        Agentur für Design, Abenteuer und Erfolg</p>
      <p><?= e(FIRMA_STRASSE) ?><br>
        <?= e(FIRMA_PLZ) ?> <?= e(FIRMA_ORT) ?><br>
        <a href="<?= e($routenplaner) ?>" rel="noopener noreferrer" target="_blank">Routenplaner</a></p>
      <p><a href="mailto:<?= e(FIRMA_MAIL) ?>"><?= e(FIRMA_MAIL) ?></a><br>
        <a href="tel:<?= e(str_replace(' ', '', FIRMA_TELEFON)) ?>"><?= e(FIRMA_TELEFON) ?></a></p>
    </div>
    <div class="lz-footcol">
      <p><a href="/">Startseite</a><br>
        <a href="/referenzen/">Referenzen</a><br>
        <a href="/agentur/">Agentur</a><br>
        <a href="/kontakt/">Kontakt</a></p>
      <p><a href="/kontakt/datenschutzerklaerung/">Datenschutzerklärung</a><br>
        <a href="/kontakt/impressum/">Impressum</a><br>
        <a href="/kontakt/agb/">AGB</a></p>
    </div>
    <div class="lz-footcol">
      <p>Seit <?= e(FIRMA_GEGRUENDET) ?> gestaltet <strong>leerzeichen</strong> als
        <a href="/agentur/">Agentur</a> in <?= e(FIRMA_ORT) ?> Erlebnisse für Tourismus,
        Kultur und Gemeinden: <a href="/referenzen/">Ausstellungen</a>, Escape-Rooms,
        Treasure Trails, Rundwege mit interaktiven Stationen, Outdoor-Abenteuer,
        Spielplätze und Kinderebenen. Für Unternehmen entwickeln wir
        <a href="/referenzen/">Corporate Design</a>, Logos, Leitsysteme,
        Mitarbeitermagazine, Bücher, Kataloge, Microsites und Landingpages.
        <a href="/kontakt/">Lassen Sie uns reden!</a></p>
    </div>
  </div>
  <div class="lz-footbase">
    <span>© <?= date('Y') ?> in Neumarkt an der Ybbs – Mostviertel – Niederösterreich – Österreich – Europa – Erde</span>
  </div>
</footer>
<script src="<?= e(lz_asset('/assets/einblenden.js')) ?>" defer></script>
</body>
</html>
