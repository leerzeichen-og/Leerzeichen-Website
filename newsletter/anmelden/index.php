<?php
// Newsletter-Anmeldung „Empty Space" — nimmt das Formular aus
// teile/newsletter.php entgegen und stößt bei Brevo das Double-Opt-in
// an (Beschluss Roman, 13.10.2026): Brevo schickt die Bestätigungsmail
// (Vorlage BREVO_DOI_VORLAGE), erst der Klick darin trägt die Adresse
// in die Liste ein. Danach leitet Brevo auf /newsletter/bestaetigt/.
// Zugangsdaten: teile/geheim.php (nur am Server, siehe Vorlage).
// Spam-Schutz wie bei der Projektanfrage: Honigtopf + Zeitfalle —
// Bots bekommen kommentarlos die Danke-Seite, aber keine Mail.
require_once __DIR__ . '/../../teile/firma.php';
@include_once __DIR__ . '/../../teile/geheim.php';

$feld = fn(string $k): string => trim((string) ($_POST[$k] ?? ''));

// Ohne POST (direkter Aufruf) zur Startseite, ohne Zugangsdaten gleich
// zur Fehler-Ansicht unten — das Formular zeigt in dem Fall ohnehin
// die mailto-Fassung, hierher kommt dann niemand.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /', true, 302);
    exit;
}

$fehler = '';
$bereit = defined('BREVO_KEY') && BREVO_KEY !== ''
       && defined('BREVO_DOI_VORLAGE') && BREVO_DOI_VORLAGE > 0;

if ($feld('website') !== ''
    || (ctype_digit($feld('seit')) && time() - (int) $feld('seit') < 3)) {
    // Bot (Honigtopf gefüllt oder unter drei Sekunden): still so tun,
    // als wäre alles gut — keine Anfrage an Brevo.
    header('Location: /newsletter/danke/', true, 303);
    exit;
}

$email = $feld('email');
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $fehler = 'Bitte geben Sie eine gültige E-Mail-Adresse an.';
} elseif ($feld('zustimmung') === '') {
    $fehler = 'Bitte bestätigen Sie, dass wir Ihnen den Newsletter senden dürfen.';
} elseif (!$bereit) {
    $fehler = 'Die Anmeldung ist gerade nicht möglich — schreiben Sie uns an '
            . FIRMA_MAIL . ', wir tragen Sie gerne ein.';
} else {
    // Bestätigungs-Rücksprung auf dem Host, auf dem das Formular lief
    // (Staging wie Live) — unbekannte Hosts fallen auf die Live-Domain.
    $host = in_array($_SERVER['SERVER_NAME'] ?? '',
        ['www.leerzeichen.at', 'leerzeichen.at', 'neu.leerzeichen.at'], true)
        ? $_SERVER['SERVER_NAME'] : 'www.leerzeichen.at';

    $senden = function (array $daten): array {
        $c = curl_init('https://api.brevo.com/v3/contacts/doubleOptinConfirmation');
        curl_setopt_array($c, [
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => json_encode($daten),
            CURLOPT_HTTPHEADER     => ['api-key: ' . BREVO_KEY, 'Content-Type: application/json'],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 12,
        ]);
        $antwort = (string) curl_exec($c);
        $code    = (int) curl_getinfo($c, CURLINFO_RESPONSE_CODE);
        curl_close($c);
        return [$code, $antwort];
    };

    $daten = [
        'email'          => $email,
        'includeListIds' => [BREVO_LISTE],
        'templateId'     => BREVO_DOI_VORLAGE,
        'redirectionUrl' => 'https://' . $host . '/newsletter/bestaetigt/',
    ];
    if ($feld('vorname') !== '' || $feld('nachname') !== '') {
        $daten['attributes'] = array_filter([
            'FIRSTNAME' => $feld('vorname'),
            'LASTNAME'  => $feld('nachname'),
        ], fn($v) => $v !== '');
    }

    [$code, $antwort] = $senden($daten);
    // Heißen die Namens-Attribute im Konto anders, scheitert nur das
    // Beiwerk — dann noch einmal ohne Namen, die Anmeldung zählt.
    if ($code === 400 && isset($daten['attributes'])
        && stripos($antwort, 'attribute') !== false) {
        unset($daten['attributes']);
        [$code, $antwort] = $senden($daten);
    }

    if ($code >= 200 && $code < 300) {
        header('Location: /newsletter/danke/', true, 303);
        exit;
    }
    error_log('Brevo-Anmeldung fehlgeschlagen (' . $code . '): ' . substr($antwort, 0, 300));
    $fehler = 'Das hat leider nicht geklappt — bitte versuchen Sie es später '
            . 'noch einmal oder schreiben Sie uns an ' . FIRMA_MAIL . '.';
}

// --- Fehler-Ansicht im Seitenlayout ------------------------------------------
$titel        = 'Newsletter-Anmeldung | leerzeichen';
$beschreibung = 'Anmeldung zum Newsletter Empty Space.';
$voll_breit   = true;
require __DIR__ . '/../../teile/kopf.php';
?>

<section class="seiten-kopf">
  <h1 class="titel-seite">Das hat noch nicht geklappt.</h1>
</section>
<section class="text-spalte">
  <p><?= e($fehler) ?></p>
  <p><a class="text-link" href="javascript:history.back()">Zurück zum Formular <?= lz_pfeil() ?></a><br>
    <a class="text-link" href="/">Zur Startseite <?= lz_pfeil() ?></a></p>
</section>

<?php require __DIR__ . '/../../teile/fuss.php'; ?>
