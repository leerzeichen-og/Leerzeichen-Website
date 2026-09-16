<?php
// Seitenfuß nach dem Startseiten-Design: Logo, vier Spalten mit Oberlinie
// (Adresse · Kontakt · Seite · Rechtliches), darunter die Basiszeile.
// Wird am Ende jeder Seite eingebunden — nach teile/kopf.php versteht sich.
?>
</main>
<footer class="lz-footer">
  <img class="lz-logo" src="/assets/logo/leerzeichen-logo-pos.svg" alt="" width="316" height="41">
  <div class="lz-footgrid">
    <div class="lz-footcol">
      <div class="lz-foothead"><?= e(FIRMA_NAME) ?></div>
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
