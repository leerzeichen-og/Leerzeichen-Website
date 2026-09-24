<?php
// Datenschutzerklärung — zugeschnitten auf die tatsächliche Technik dieser
// Website (Beschluss Roman 24.9.2026): KEINE Cookies, Webanalyse nur über
// selbst gehostetes Matomo im cookielosen Betrieb mit IP-Kürzung.
// WICHTIG bei Änderungen: Kommt ein neues Werkzeug dazu (z. B. SalesViewer),
// braucht es hier einen eigenen Abschnitt — und die Aussage „keine Cookies"
// muss dann neu geprüft werden. Kein Rechtsrat; Roman lässt den Text prüfen.
require_once __DIR__ . '/../../teile/firma.php';

$titel        = 'Datenschutzerklärung | leerzeichen multimedia og';
$beschreibung = 'Wie diese Website mit Daten umgeht: keine Cookies, Webanalyse nur über eigenes Matomo mit gekürzten IP-Adressen.';
$brotkrumen   = [['Kontakt', '/kontakt/'], ['Datenschutzerklärung', '/kontakt/datenschutzerklaerung/']];
$voll_breit   = true;

require __DIR__ . '/../../teile/kopf.php';
?>

<section class="seiten-kopf">
  <span class="chip">Rechtliches</span>
  <h1 class="titel-seite">Datenschutzerklärung</h1>
</section>
<section class="rechtstext">
  <p>Der Schutz Ihrer Daten ist uns wichtig — und diese Website ist bewusst
    sparsam gebaut: <strong>Sie setzt keine Cookies</strong> und bindet keine
    Dienste von Werbenetzwerken ein. Was dennoch verarbeitet wird, steht hier.</p>

  <h2>Verantwortlicher</h2>
  <p><?= e(FIRMA_NAME) ?><br>
    <?= e(FIRMA_STRASSE) ?>, <?= e(FIRMA_PLZ) ?> <?= e(FIRMA_ORT) ?>, Österreich<br>
    Telefon: <a href="tel:<?= e(str_replace(' ', '', FIRMA_TELEFON)) ?>"><?= e(FIRMA_TELEFON) ?></a> ·
    E-Mail: <a href="mailto:<?= e(FIRMA_MAIL) ?>"><?= e(FIRMA_MAIL) ?></a></p>

  <h2>Hosting und Server-Logdateien</h2>
  <p>Beim Aufruf dieser Website verarbeitet unser Hosting-Anbieter automatisch
    technische Zugriffsdaten (sogenannte Server-Logs): IP-Adresse, Datum und
    Uhrzeit, aufgerufene Seite, übertragene Datenmenge, Browser und
    Betriebssystem. Diese Daten sind für den technischen Betrieb und die
    Sicherheit der Website erforderlich (Art&nbsp;6 Abs&nbsp;1 lit&nbsp;f
    DSGVO — berechtigtes Interesse an einem stabilen, sicheren Betrieb) und
    werden nach den üblichen Fristen des Hosting-Anbieters gelöscht. Eine
    Zusammenführung mit anderen Daten findet nicht statt.</p>

  <h2>Keine Cookies</h2>
  <p>Diese Website setzt keine Cookies — weder eigene noch solche von
    Drittanbietern. Deshalb gibt es hier auch keinen Cookie-Banner.</p>

  <h2>Webanalyse mit Matomo (selbst gehostet, ohne Cookies)</h2>
  <p>Um zu verstehen, welche Inhalte gelesen werden, verwenden wir die
    Open-Source-Software <strong>Matomo</strong> — auf unserem eigenen Server,
    ohne Cookies und mit gekürzten IP-Adressen. Die Daten verlassen unser Haus
    nicht, werden nicht an Dritte weitergegeben und lassen keine
    Identifizierung einzelner Personen zu. Rechtsgrundlage ist unser
    berechtigtes Interesse an der statistischen Auswertung der
    Website-Nutzung (Art&nbsp;6 Abs&nbsp;1 lit&nbsp;f DSGVO). Matomo
    respektiert außerdem die „Do not track“-Einstellung Ihres Browsers.</p>

  <h2>Kontaktaufnahme</h2>
  <p>Wenn Sie uns per E-Mail oder Telefon kontaktieren, verarbeiten wir die
    übermittelten Angaben (Name, Kontaktdaten, Inhalt der Nachricht) zur
    Bearbeitung Ihrer Anfrage und für allfällige Anschlussfragen
    (Art&nbsp;6 Abs&nbsp;1 lit&nbsp;b DSGVO). Wir speichern diese Daten so
    lange, wie es für die Bearbeitung nötig ist oder gesetzliche
    Aufbewahrungspflichten bestehen.</p>

  <h2>Newsletter „Empty Space“</h2>
  <p>Für den Newsletter verarbeiten wir Ihre E-Mail-Adresse sowie — freiwillig —
    Vor- und Nachname, ausschließlich für den Versand (Art&nbsp;6 Abs&nbsp;1
    lit&nbsp;a DSGVO, Einwilligung). Die Anmeldung wird erst nach Bestätigung
    per E-Mail wirksam (Double-Opt-in). Für den Versand nutzen wir den
    Dienstleister Brevo (Sendinblue GmbH, Berlin, Deutschland) als
    Auftragsverarbeiter. Sie können sich jederzeit abmelden — über den Link in
    jeder Ausgabe oder formlos per E-Mail; Ihre Daten werden dann aus dem
    Verteiler gelöscht.</p>

  <h2>Ihre Rechte</h2>
  <p>Ihnen stehen die Rechte auf Auskunft, Berichtigung, Löschung,
    Einschränkung der Verarbeitung, Datenübertragbarkeit und Widerspruch zu.
    Wenden Sie sich dafür formlos an
    <a href="mailto:<?= e(FIRMA_MAIL) ?>"><?= e(FIRMA_MAIL) ?></a>.
    Wenn Sie der Ansicht sind, dass die Verarbeitung Ihrer Daten gegen
    Datenschutzrecht verstößt, können Sie sich bei der österreichischen
    Datenschutzbehörde beschweren
    (<a href="https://www.dsb.gv.at/" rel="noopener noreferrer" target="_blank">dsb.gv.at</a>).</p>

  <p class="stand">Stand: September 2026</p>
</section>

<?php require __DIR__ . '/../../teile/fuss.php'; ?>
