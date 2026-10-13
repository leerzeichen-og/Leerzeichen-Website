<?php
// Projektanfrage — eigene Seite mit Kontaktformular (Beschluss Roman,
// 12.10.2026), erreichbar über das schwebende
// Brief-Icon rechts unten (teile/fuss.php). Versand mit PHPs mail() an
// FIRMA_MAIL — kein Backend, keine Datenbank, nichts wird gespeichert.
// Spam-Schutz: ein unsichtbares Honigtopf-Feld („website"); füllt es ein
// Bot aus, wird still verworfen.
require_once __DIR__ . '/../../teile/firma.php';

$titel        = 'Projektanfrage | leerzeichen multimedia og';
$beschreibung = 'Erzählen Sie uns von Ihrem Projekt — wir melden uns und '
              . 'finden gemeinsam heraus, was es braucht.';
$brotkrumen   = [['Kontakt', '/kontakt/'], ['Projektanfrage', '/kontakt/anfrage/']];
$voll_breit   = true;

// --- Versand (POST auf dieselbe Seite) --------------------------------------
$gesendet = false;
$fehler   = [];
$alt      = [];   // Eingaben bleiben bei Fehlern stehen

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $feld = fn(string $k): string => trim((string) ($_POST[$k] ?? ''));
    $alt  = [
        'anrede'      => $feld('anrede'),
        'vorname'     => $feld('vorname'),
        'nachname'    => $feld('nachname'),
        'email'       => $feld('email'),
        'unternehmen' => $feld('unternehmen'),
        'telefon'     => $feld('telefon'),
        'nachricht'   => $feld('nachricht'),
    ];

    if ($feld('website') !== ''
        || (ctype_digit($feld('seit')) && time() - (int) $feld('seit') < 3)) {
        // Honigtopf gefüllt ODER unter drei Sekunden „ausgefüllt" (kein
        // Mensch schafft das Formular so schnell): ein Bot. Still so tun,
        // als wäre alles gut — keine Mail, keine Fehlermeldung.
        $gesendet = true;
    } else {
        if ($alt['vorname'] === '')  { $fehler[] = 'Bitte den Vornamen angeben.'; }
        if ($alt['nachname'] === '') { $fehler[] = 'Bitte den Nachnamen angeben.'; }
        if (!filter_var($alt['email'], FILTER_VALIDATE_EMAIL)) {
            $fehler[] = 'Bitte eine gültige E-Mail-Adresse angeben.';
        }

        if (!$fehler) {
            $zeilen = [];
            foreach ([
                'Anrede'                   => $alt['anrede'],
                'Vorname'                  => $alt['vorname'],
                'Nachname'                 => $alt['nachname'],
                'E-Mail'                   => $alt['email'],
                'Unternehmen/Organisation' => $alt['unternehmen'],
                'Telefon'                  => $alt['telefon'],
            ] as $name => $wert) {
                if ($wert !== '') {
                    $zeilen[] = $name . ': ' . $wert;
                }
            }
            $text = "Projektanfrage über leerzeichen.at\n\n"
                  . implode("\n", $zeilen)
                  . ($alt['nachricht'] !== '' ? "\n\nNachricht:\n" . $alt['nachricht'] : '')
                  . "\n";

            // Absender bleibt die eigene Domain (sonst sortieren Filter die
            // Mail aus); geantwortet wird der anfragenden Adresse. Die ist
            // oben validiert — keine Kopfzeilen-Einschleusung möglich.
            $kopf = 'From: Website <' . FIRMA_MAIL . ">\r\n"
                  . 'Reply-To: ' . $alt['email'] . "\r\n"
                  . "Content-Type: text/plain; charset=UTF-8\r\n";
            $gesendet = @mail(FIRMA_MAIL,
                '=?UTF-8?B?' . base64_encode('Projektanfrage von ' . $alt['vorname'] . ' ' . $alt['nachname']) . '?=',
                $text, $kopf);
            if (!$gesendet) {
                $fehler[] = 'Das Senden hat leider nicht geklappt — bitte schreiben Sie uns direkt an ' . FIRMA_MAIL . '.';
            }
        }
    }
}

require __DIR__ . '/../../teile/kopf.php';
?>

<?php // Kopf im Kontakt-Muster: große Light-Headline, Teaser rechts versetzt. ?>
<section class="kopf-gross">
  <h1 class="titel-gross">Erzählen Sie uns<br>von Ihrem Projekt.</h1>
  <div class="kopf-gross-zeile">
    <div class="kopf-gross-rechts">
      <p>Ein paar Zeilen genügen — wir melden uns und finden gemeinsam
        heraus, was Ihr Projekt braucht. Wir freuen uns darauf!</p>
    </div>
  </div>
</section>

<section class="lz-sec anfrage">
  <?php if ($gesendet): ?>

  <div class="anfrage-danke">
    <h2>Danke für Ihre Anfrage.</h2>
    <p>Wir haben sie erhalten und melden uns so rasch wie möglich —
      meist noch am selben Werktag.</p>
    <p><a class="knopf" href="/">Zur Startseite <?= lz_pfeil() ?></a></p>
  </div>

  <?php else: ?>

  <?php if ($fehler): ?>
  <div class="anfrage-fehler" role="alert">
    <?php foreach ($fehler as $f): ?>
    <p><?= e($f) ?></p>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>

  <form class="anfrage-form" method="post" action="/kontakt/anfrage/">
    <?php // Honigtopf: für Menschen unsichtbar (CSS), Bots füllen ihn aus. ?>
    <p class="anfrage-falle" aria-hidden="true">
      <label>Website <input type="text" name="website" tabindex="-1" autocomplete="off"></label>
    </p>
    <?php // Zeitfalle: wann das Formular gerendert wurde — Antworten unter
          // drei Sekunden verwirft der Versand oben als Bot. ?>
    <input type="hidden" name="seit" value="<?= time() ?>">

    <div class="anfrage-raster">
      <label class="lz-field">
        <span class="lz-label">Anrede</span>
        <select class="lz-input" name="anrede">
          <option value=""<?= ($alt['anrede'] ?? '') === '' ? ' selected' : '' ?>>Bitte auswählen</option>
          <?php foreach (['Frau', 'Herr', 'Keine Angabe'] as $a): ?>
          <option<?= ($alt['anrede'] ?? '') === $a ? ' selected' : '' ?>><?= e($a) ?></option>
          <?php endforeach; ?>
        </select>
      </label>
      <label class="lz-field">
        <span class="lz-label">Vorname *</span>
        <input class="lz-input" type="text" name="vorname" required autocomplete="given-name"
          value="<?= e($alt['vorname'] ?? '') ?>">
      </label>
      <label class="lz-field">
        <span class="lz-label">Nachname *</span>
        <input class="lz-input" type="text" name="nachname" required autocomplete="family-name"
          value="<?= e($alt['nachname'] ?? '') ?>">
      </label>
      <label class="lz-field">
        <span class="lz-label">E-Mail *</span>
        <input class="lz-input" type="email" name="email" required autocomplete="email"
          value="<?= e($alt['email'] ?? '') ?>">
      </label>
      <label class="lz-field">
        <span class="lz-label">Unternehmen / Organisation</span>
        <input class="lz-input" type="text" name="unternehmen" autocomplete="organization"
          value="<?= e($alt['unternehmen'] ?? '') ?>">
      </label>
      <label class="lz-field">
        <span class="lz-label">Telefon</span>
        <input class="lz-input" type="tel" name="telefon" autocomplete="tel"
          value="<?= e($alt['telefon'] ?? '') ?>">
      </label>
      <label class="lz-field anfrage-breit">
        <span class="lz-label">Nachricht</span>
        <textarea class="lz-input" name="nachricht" rows="6"><?= e($alt['nachricht'] ?? '') ?></textarea>
      </label>
    </div>

    <p class="anfrage-hinweis">Ihre Angaben verwenden wir ausschließlich zur
      Bearbeitung Ihrer Anfrage (Art. 6 Abs. 1 lit. b DSGVO); gespeichert wird
      auf der Website nichts, eine Weitergabe erfolgt nicht. Mehr dazu in der
      <a href="/kontakt/datenschutzerklaerung/">Datenschutzerklärung</a>.</p>

    <p><button class="knopf" type="submit">Anfrage senden <?= lz_pfeil() ?></button></p>
  </form>

  <?php endif; ?>
</section>

<?php $ctaTitel = 'Lieber direkt reden?';
$ctaText  = 'Rufen Sie an: ' . FIRMA_TELEFON . ' — oder kommen Sie im Rathaus vorbei.';
$ctaKnopf = 'Zur Kontaktseite';
$ctaZiel  = '/kontakt/';
require __DIR__ . '/../../teile/cta.php'; ?>

<?php require __DIR__ . '/../../teile/fuss.php'; ?>
