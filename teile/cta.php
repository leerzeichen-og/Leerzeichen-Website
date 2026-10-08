<?php
// Abschluss-CTA (dunkel, zentriert) — überall gleich gebaut, Text je Seite
// über $ctaTitel / $ctaText (optionale Zeile unter dem Titel) / $ctaKnopf /
// $ctaZiel VOR dem Einbinden übersteuerbar.
$ctaTitel = $ctaTitel ?? 'Gemeinsam bringen wir Neues in Ihre Welt.';
$ctaKnopf = $ctaKnopf ?? 'Reden wir darüber';
$ctaZiel  = $ctaZiel  ?? '/kontakt/';
?>
<section id="kontakt-cta" class="lz-dark lz-sec kontakt-cta">
  <h2 class="lz-h2"><?= e($ctaTitel) ?></h2>
  <?php if (!empty($ctaText)): ?>
  <p class="kontakt-cta-text"><?= e($ctaText) ?></p>
  <?php endif; ?>
  <div class="knopf-wrap">
    <a class="knopf knopf-hell" href="<?= e($ctaZiel) ?>"><?= e($ctaKnopf) ?> <?= lz_pfeil() ?></a>
  </div>
</section>
<?php unset($ctaTitel, $ctaText, $ctaKnopf, $ctaZiel); ?>
