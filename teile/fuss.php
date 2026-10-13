<?php
// Seitenfuß, dreispaltig nach Romans Grafik (17.9.2026):
// Anschrift+Kontakt · Seiten+Rechtliches · Vorstellungstext (der zitierfähige
// Text aus „Website-Texte", Abschnitt 8, mit internen Links).
// Darunter zentriert die Copyright-Zeile von Neumarkt bis Erde.
$routenplaner = 'https://www.google.com/maps/search/?api=1&query='
    . rawurlencode(FIRMA_STRASSE . ', ' . FIRMA_PLZ . ' ' . FIRMA_ORT);
?>
</main>

<?php // Schwebendes Brief-Icon rechts unten (Roman, 12.10.2026) —
      // führt auf jeder Seite zur Projektanfrage. ?>
<a class="lz-anfrage" href="/kontakt/anfrage/" aria-label="Projekt anfragen">
  <svg viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke="currentColor"
    stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
    <rect x="2.6" y="5" width="18.8" height="14" rx="1.5"/>
    <path d="M3.4 6.2 12 12.6l8.6-6.4"/>
  </svg>
</a>

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
        <a href="/leistungen/">Leistungen</a><br>
        <a href="/referenzen/">Referenzen</a><br>
        <a href="/agentur/">Agentur</a><br>
        <a href="/kontakt/">Kontakt</a></p>
      <p><a href="/kontakt/datenschutzerklaerung/">Datenschutzerklärung</a><br>
        <a href="/kontakt/impressum/">Impressum</a><br>
        <a href="/kontakt/agb/">AGB</a></p>
    </div>
    <div class="lz-footcol">
      <p>Seit <?= e(FIRMA_GEGRUENDET) ?> gestaltet <strong>leerzeichen</strong> als
        <a href="/agentur/">Agentur</a> in <?= e(FIRMA_ORT) ?> Erlebnisse
        <strong>für Tourismus, Kultur und Gemeinden:</strong>
        <a href="/referenzen/">Ausstellungen</a>, Escape-Rooms,
        Treasure Trails, Rundwege mit interaktiven Stationen, Outdoor-Abenteuer,
        Spielplätze und Kinderebenen. <strong>Für Unternehmen</strong> entwickeln wir
        <a href="/referenzen/">Corporate Design</a>, Logos, Leitsysteme,
        Mitarbeitermagazine, Bücher, Kataloge, Microsites und Landingpages.
        <a href="/kontakt/">Lassen Sie uns reden!</a></p>
      <p><a class="lz-foot-badge" href="https://www.kreativwirtschaft.at/"
          rel="noopener noreferrer" target="_blank">
        <img src="/assets/bilder/Creative_Industry_CAT.svg" width="72" height="72"
          alt="Creative Industry Austria — Mitglied der Kreativwirtschaft Austria" loading="lazy">
      </a></p>
    </div>
  </div>
  <div class="lz-footbase">
    <span>© <?= date('Y') ?> in Neumarkt an der Ybbs – Mostviertel – Niederösterreich – Österreich – Europa – Erde</span>
  </div>
</footer>
<script src="<?= e(lz_asset('/assets/einblenden.js')) ?>" defer></script>
<script>
// Matomo-Ereignisse (13.10.2026): Klicks auf Telefonnummern, Mailadressen
// und das schwebende Anfrage-Icon — die sieht die Seitenmessung sonst
// nicht. Läuft nur, wenn das Matomo-Skript geladen ist (_paq); lokal und
// ohne Matomo passiert nichts. Ziele dazu: Matomo → Verwaltung → Ziele.
document.addEventListener('click', function (e) {
    if (!window._paq || !e.target.closest) { return; }
    var a = e.target.closest('a[href^="tel:"], a[href^="mailto:"], a.lz-anfrage');
    if (!a) { return; }
    var href = a.getAttribute('href') || '';
    var ereignis = a.classList.contains('lz-anfrage')
        ? ['Kontakt', 'Anfrage-Icon', location.pathname]
        : href.indexOf('tel:') === 0
            ? ['Kontakt', 'Anruf', href.slice(4)]
            : ['Kontakt', 'E-Mail', href.slice(7).split('?')[0]];
    _paq.push(['trackEvent', ereignis[0], ereignis[1], ereignis[2]]);
}, true);
</script>
</body>
</html>
