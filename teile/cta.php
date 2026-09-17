<?php
// Abschluss-CTA (dunkel, zentriert) — überall gleich gebaut, Text je Seite
// über $ctaTitel / $ctaKnopf / $ctaZiel VOR dem Einbinden übersteuerbar.
$ctaTitel = $ctaTitel ?? 'Gemeinsam bringen wir Neues in Ihre Welt.';
$ctaKnopf = $ctaKnopf ?? 'Reden wir darüber';
$ctaZiel  = $ctaZiel  ?? '/kontakt/';
?>
<section id="kontakt-cta" class="lz-dark lz-sec kontakt-cta">
  <h2 class="lz-h2"><?= e($ctaTitel) ?></h2>
  <div class="knopf-wrap">
    <a class="knopf knopf-hell" href="<?= e($ctaZiel) ?>"><?= e($ctaKnopf) ?> <?= lz_pfeil() ?></a>
  </div>
</section>
<?php unset($ctaTitel, $ctaKnopf, $ctaZiel); ?>
