<?php
// Newsletter: Danke-Seite nach der Anmeldung (Double-Opt-in unterwegs).
// Text: „Website-Texte", Abschnitt Newsletter — Danke-Seite.
require_once __DIR__ . '/../../teile/firma.php';

$titel        = 'Fast geschafft — Empty Space | leerzeichen';
$beschreibung = 'Bitte bestätigen Sie Ihre Newsletter-Anmeldung über die Mail, die wir Ihnen geschickt haben.';
$brotkrumen   = [['Newsletter', '/newsletter/danke/']];

require __DIR__ . '/../../teile/kopf.php';
?>

<section class="abschnitt">
  <h1>Fast geschafft.</h1>
  <p class="lz-lead" style="max-width:52ch">Wir haben Ihnen eine Mail geschickt.
    Ein Klick auf den Link darin, und Sie sind dabei. Schauen Sie notfalls im
    Spam-Ordner nach — manchmal landen wir dort.</p>
</section>

<?php require __DIR__ . '/../../teile/fuss.php'; ?>
