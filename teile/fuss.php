<?php
// Seitenfuß: Footer mit Firmendaten und rechtlichen Links, HTML-Ende.
// Wird am Ende jeder Seite eingebunden — nach teile/kopf.php versteht sich.
?>
</main>
<footer class="fuss">
  <div class="fuss-inhalt">
    <p><strong><?= e(FIRMA_NAME) ?></strong> aus <?= e(FIRMA_ORT) ?><br>
    <?= e(FIRMA_STRASSE) ?>, <?= e(FIRMA_PLZ) ?> <?= e(FIRMA_ORT) ?><br>
    Telefon <a href="tel:<?= e(str_replace(' ', '', FIRMA_TELEFON)) ?>"><?= e(FIRMA_TELEFON) ?></a></p>
    <ul class="fuss-links">
      <li><a href="/kontakt/impressum/">Impressum</a></li>
      <li><a href="/kontakt/datenschutzerklaerung/">Datenschutzerklärung</a></li>
      <li><a href="/kontakt/agb/">AGB</a></li>
    </ul>
  </div>
</footer>
</body>
</html>
