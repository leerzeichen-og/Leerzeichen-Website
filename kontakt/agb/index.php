<?php
// AGB — wortgetreu übernommen aus dem PDF im Downloads-Ordner (Stand
// Oktober 2026, von Roman geliefert am 13.10.2026; löst die Fassung
// Jänner 2024 ab). Änderungen am Wortlaut NUR über Roman — das ist ein
// rechtlich abgestimmter Text. Das PDF liegt zusätzlich als Download
// unter assets/downloads/leerzeichen-agb.pdf.
require_once __DIR__ . '/../../teile/firma.php';

$titel        = 'AGB | leerzeichen multimedia og';
$beschreibung = 'Allgemeine Geschäftsbedingungen der Leerzeichen Multimedia OG, Stand Oktober 2026.';
$brotkrumen   = [['Kontakt', '/kontakt/'], ['AGB', '/kontakt/agb/']];
$voll_breit   = true;

require __DIR__ . '/../../teile/kopf.php';
?>

<section class="seiten-kopf">
  <span class="chip">Rechtliches</span>
  <h1 class="titel-seite">Allgemeine Geschäftsbedingungen</h1>
</section>
<section class="rechtstext">
  <p><strong><?= e(FIRMA_NAME) ?></strong>, <?= e(FIRMA_STRASSE) ?>, <?= e(FIRMA_PLZ) ?> <?= e(FIRMA_ORT) ?> ·
    FN 411366a · UID ATU68723429<br>
    <a class="text-link" href="/assets/downloads/leerzeichen-agb.pdf">Als PDF herunterladen <?= lz_pfeil() ?></a></p>

  <h2>1. Geltung, Vertragsabschluss</h2>
  <p><strong>1.1</strong> Die Leerzeichen Multimedia OG (im Folgenden „Agentur“) erbringt ihre
    Leistungen ausschließlich auf der Grundlage der nachfolgenden Allgemeinen
    Geschäftsbedingungen (AGB). Diese gelten für alle Rechtsbeziehungen zwischen der Agentur
    und dem beauftragenden Unternehmen, selbst wenn nicht ausdrücklich auf sie Bezug genommen
    wird. Die AGB sind ausschließlich für Rechtsbeziehungen mit Unternehmen im Sinne des
    § 1 KSchG anwendbar (sohin B2B) sowie für Rechtsbeziehungen mit juristischen Personen des
    öffentlichen Rechts (insbesondere Gebietskörperschaften, Gemeinden, Gemeindeverbände und
    Tourismusverbände).</p>
  <p><strong>1.2</strong> Maßgeblich ist jeweils die zum Zeitpunkt des Vertragsschlusses gültige
    Fassung. Abweichungen von diesen sowie sonstige ergänzende Vereinbarungen mit dem
    beauftragenden Unternehmen sind nur wirksam, wenn sie von der Agentur schriftlich
    bestätigt werden.</p>
  <p><strong>1.3</strong> Allfällige Geschäftsbedingungen des beauftragenden Unternehmens werden,
    selbst bei Kenntnis, nicht akzeptiert, sofern nicht im Einzelfall ausdrücklich und
    schriftlich anderes vereinbart wird. AGB des beauftragenden Unternehmens widerspricht die
    Agentur ausdrücklich. Eines weiteren Widerspruchs gegen AGB des beauftragenden
    Unternehmens durch die Agentur bedarf es nicht.</p>
  <p><strong>1.4</strong> Änderungen der AGB werden dem beauftragenden Unternehmen bekannt gegeben
    und gelten als vereinbart, wenn das beauftragende Unternehmen den geänderten AGB nicht
    schriftlich binnen 14 Tagen widerspricht; auf die Bedeutung des Schweigens sowie auf die
    konkret geänderten Klauseln wird das beauftragende Unternehmen in der Verständigung
    ausdrücklich hingewiesen. Diese Zustimmungsfiktion gilt nicht für die Änderung
    wesentlicher Leistungsinhalte und Entgelte.</p>
  <p><strong>1.5</strong> Sollten einzelne Bestimmungen dieser Allgemeinen Geschäftsbedingungen
    unwirksam sein, so berührt dies die Verbindlichkeit der übrigen Bestimmungen und der unter
    ihrer Zugrundelegung geschlossenen Verträge nicht. Die unwirksame Bestimmung ist durch
    eine wirksame, die dem Sinn und Zweck am nächsten kommt, zu ersetzen.</p>
  <p><strong>1.6</strong> Die Angebote der Agentur sind freibleibend und unverbindlich.</p>

  <h2>2. Social-Media-Kanäle</h2>
  <p>Die Agentur weist das beauftragende Unternehmen vor Auftragserteilung ausdrücklich darauf
    hin, dass die Anbieter von „Social-Media-Kanälen“ (z.&nbsp;B. Facebook, Instagram, im
    Folgenden kurz: Anbieter) es sich in ihren Nutzungsbedingungen vorbehalten, Werbeanzeigen
    und -auftritte aus beliebigem Grund abzulehnen oder zu entfernen. Die Anbieter sind
    demnach nicht verpflichtet, Inhalte und Informationen an die Nutzer weiterzuleiten. Es
    besteht daher das von der Agentur nicht kalkulierbare Risiko, dass Werbeanzeigen und
    -auftritte grundlos entfernt werden. Im Fall einer Beschwerde eines anderen Nutzers wird
    zwar von den Anbietern die Möglichkeit einer Gegendarstellung eingeräumt, doch erfolgt
    auch in diesem Fall eine sofortige Entfernung der Inhalte. Die Wiedererlangung des
    ursprünglichen, rechtmäßigen Zustandes kann in diesem Fall einige Zeit in Anspruch nehmen.
    Die Agentur arbeitet auf der Grundlage dieser Nutzungsbedingungen der Anbieter, auf die
    sie keinen Einfluss hat, und legt diese auch dem Auftrag des beauftragenden Unternehmens
    zu Grunde. Ausdrücklich anerkennt das beauftragende Unternehmen mit der Auftragserteilung,
    dass diese Nutzungsbedingungen die Rechte und Pflichten eines allfälligen
    Vertragsverhältnisses (mit-)bestimmen. Die Agentur beabsichtigt, den Auftrag des
    beauftragenden Unternehmens nach bestem Wissen und Gewissen auszuführen und die
    Richtlinien von „Social-Media-Kanälen“ einzuhalten. Aufgrund der derzeit gültigen
    Nutzungsbedingungen und der einfachen Möglichkeit jedes Nutzers, Rechtsverletzungen zu
    behaupten und so eine Entfernung der Inhalte zu erreichen, kann die Agentur aber nicht
    dafür einstehen, dass die beauftragte Kampagne auch jederzeit abrufbar ist.</p>

  <h2>3. Konzept- und Ideenschutz</h2>
  <p>Hat ein Unternehmen die Agentur vorab bereits eingeladen, ein Konzept zu erstellen, und
    kommt die Agentur dieser Einladung noch vor Abschluss des Hauptvertrages nach, so gilt
    nachstehende Regelung:</p>
  <p><strong>3.1</strong> Bereits durch die Einladung und die Annahme der Einladung durch die
    Agentur entsteht ein Vertragsverhältnis („Pitching-Vertrag“). Auch diesem Vertrag liegen
    die AGB zu Grunde.</p>
  <p><strong>3.2</strong> Das einladende Unternehmen anerkennt, dass die Agentur bereits mit der
    Konzepterarbeitung kostenintensive Vorleistungen erbringt, obwohl noch keine
    Leistungspflichten übernommen worden sind.</p>
  <p><strong>3.3</strong> Das Konzept untersteht in seinen sprachlichen und grafischen Teilen,
    soweit diese Werkhöhe erreichen, dem Schutz des Urheberrechtsgesetzes. Eine Nutzung und
    Bearbeitung dieser Teile ohne Zustimmung der Agentur ist dem einladenden Unternehmen schon
    auf Grund des Urheberrechtsgesetzes nicht gestattet.</p>
  <p><strong>3.4</strong> Das Konzept enthält darüber hinaus werberelevante Ideen, die keine
    Werkhöhe erreichen und damit nicht den Schutz des Urheberrechtsgesetzes genießen. Diese
    Ideen stehen am Anfang jedes Schaffensprozesses und können als zündender Funke alles
    später Hervorgebrachten und somit als Ursprung von Vermarktungsstrategien definiert
    werden. Daher sind jene Elemente des Konzeptes geschützt, die eigenständig sind und der
    Vermarktungsstrategie ihre charakteristische Prägung geben. Als Idee im Sinne dieser
    Vereinbarung werden insbesondere Werbeschlagwörter, Werbetexte, Grafiken und
    Illustrationen, Werbemittel usw. angesehen, auch wenn sie keine Werkhöhe erreichen.</p>
  <p><strong>3.5</strong> Das einladende Unternehmen verpflichtet sich, es zu unterlassen, diese
    von der Agentur im Rahmen des Konzeptes präsentierten kreativen Werbeideen außerhalb des
    Korrektivs eines später abzuschließenden Hauptvertrages wirtschaftlich zu verwerten bzw.
    verwerten zu lassen oder zu nutzen bzw. nutzen zu lassen.</p>
  <p><strong>3.6</strong> Sofern das einladende Unternehmen der Meinung ist, dass ihm von der
    Agentur Ideen präsentiert wurden, auf die es bereits vor der Präsentation gekommen ist, so
    ist dies der Agentur binnen 14 Tagen nach dem Tag der Präsentation per E-Mail unter
    Anführung von Beweismitteln, die eine zeitliche Zuordnung erlauben, bekannt zu geben.</p>
  <p><strong>3.7</strong> Im gegenteiligen Fall gehen die Vertragsparteien davon aus, dass die
    Agentur dem einladenden Unternehmen eine für das Unternehmen neue Idee präsentiert hat.
    Wird die Idee vom einladenden Unternehmen verwendet, so ist davon auszugehen, dass die
    Agentur dabei verdienstlich wurde.</p>
  <p><strong>3.8</strong> Das einladende Unternehmen kann sich von seinen Verpflichtungen aus
    diesem Punkt durch Zahlung einer angemessenen Entschädigung, welche sich nach dem
    Einzelfall berechnet, befreien. Die Befreiung tritt erst nach vollständigem Eingang der
    Zahlung der Entschädigung bei der Agentur ein.</p>

  <h2>4. Leistungsumfang, Auftragsabwicklung und Mitwirkungspflichten des beauftragenden Unternehmens</h2>
  <p><strong>4.1</strong> Der Umfang der zu erbringenden Leistungen ergibt sich aus der
    Leistungsbeschreibung im Agenturvertrag oder einer allfälligen Auftragsbestätigung durch
    die Agentur, sowie dem allfälligen Briefingprotokoll („Angebotsunterlagen“). Nachträgliche
    Änderungen des Leistungsinhaltes bedürfen der schriftlichen Bestätigung durch die Agentur.
    Innerhalb des vom beauftragenden Unternehmen vorgegebenen Rahmens besteht bei der
    Erfüllung des Auftrages Gestaltungsfreiheit der Agentur.</p>
  <p><strong>4.2</strong> Alle Leistungen der Agentur (insbesondere alle Vorentwürfe, Skizzen,
    Reinzeichnungen, Bürstenabzüge, Blaupausen, Kopien, Farbabdrucke und elektronische
    Dateien) sind vom beauftragenden Unternehmen zu überprüfen und von ihm binnen angemessener
    Frist, längstens aber binnen 14 Werktagen ab Eingang beim beauftragenden Unternehmen
    freizugeben. Nach Verstreichen dieser Frist ohne Rückmeldung gelten sie als vom
    beauftragenden Unternehmen genehmigt.</p>
  <p><strong>4.3</strong> Das beauftragende Unternehmen wird der Agentur zeitgerecht und
    vollständig alle Informationen und Unterlagen zugänglich machen, die für die Erbringung
    der Leistung erforderlich sind. Es wird sie von allen Umständen informieren, die für die
    Durchführung des Auftrages von Bedeutung sind, auch wenn diese erst während der
    Durchführung des Auftrages bekannt werden. Das beauftragende Unternehmen trägt den
    Aufwand, der dadurch entsteht, dass Arbeiten infolge seiner unrichtigen, unvollständigen
    oder nachträglich geänderten Angaben von der Agentur wiederholt werden müssen oder
    verzögert werden.</p>
  <p><strong>4.4</strong> Das beauftragende Unternehmen ist weiters verpflichtet, die für die
    Durchführung des Auftrages zur Verfügung gestellten Unterlagen (Fotos, Logos etc.) auf
    allfällige Urheber-, Marken-, Kennzeichenrechte oder sonstige Rechte Dritter zu prüfen
    (Rechteclearing) und garantiert, dass die Unterlagen frei von Rechten Dritter sind und
    daher für den angestrebten Zweck eingesetzt werden können. Die Agentur haftet im Falle
    bloß leichter Fahrlässigkeit oder nach Erfüllung ihrer Warnpflicht – jedenfalls im
    Innenverhältnis zum beauftragenden Unternehmen – nicht wegen einer Verletzung derartiger
    Rechte Dritter durch zur Verfügung gestellte Unterlagen. Wird die Agentur wegen einer
    solchen Rechtsverletzung von einem Dritten in Anspruch genommen, so hält das beauftragende
    Unternehmen die Agentur schad- und klaglos; es hat ihr sämtliche Nachteile zu ersetzen,
    die ihr durch eine Inanspruchnahme Dritter entstehen, insbesondere die Kosten einer
    angemessenen rechtlichen Vertretung. Das beauftragende Unternehmen verpflichtet sich, die
    Agentur bei der Abwehr von allfälligen Ansprüchen Dritter zu unterstützen. Das
    beauftragende Unternehmen stellt der Agentur hierfür unaufgefordert sämtliche Unterlagen
    zur Verfügung.</p>

  <h2>5. Fremdleistungen / Beauftragung Dritter</h2>
  <p><strong>5.1</strong> Die Agentur ist nach freiem Ermessen berechtigt, die Leistung selbst
    auszuführen, sich bei der Erbringung von vertragsgegenständlichen Leistungen sachkundiger
    Dritter als Erfüllungsgehilfen zu bedienen und/oder derartige Leistungen zu substituieren
    („Fremdleistung“).</p>
  <p><strong>5.2</strong> Die Beauftragung von Dritten im Rahmen einer Fremdleistung erfolgt
    entweder im eigenen Namen oder im Namen des beauftragenden Unternehmens, letztere nach
    vorheriger Information an das beauftragende Unternehmen. Die Agentur wird diese Dritten
    sorgfältig auswählen und darauf achten, dass diese über die erforderliche fachliche
    Qualifikation verfügen.</p>
  <p><strong>5.3</strong> In Verpflichtungen gegenüber Dritten, die dem beauftragenden
    Unternehmen namhaft gemacht wurden und die über die Vertragslaufzeit hinausgehen, hat das
    beauftragende Unternehmen einzutreten. Das gilt ausdrücklich auch im Falle einer Kündigung
    des Agenturvertrages aus wichtigem Grund.</p>

  <h2>6. Termine</h2>
  <p><strong>6.1</strong> Angegebene Liefer- oder Leistungsfristen gelten, sofern nicht
    ausdrücklich als verbindlich vereinbart, nur als annähernd und unverbindlich. Verbindliche
    Terminabsprachen sind schriftlich festzuhalten bzw. von der Agentur schriftlich zu
    bestätigen.</p>
  <p><strong>6.2</strong> Verzögert sich die Lieferung/Leistung der Agentur aus Gründen, die sie
    nicht zu vertreten hat, wie z.&nbsp;B. Ereignisse höherer Gewalt und andere
    unvorhersehbare, mit zumutbaren Mitteln nicht abwendbare Ereignisse, ruhen die
    Leistungsverpflichtungen für die Dauer und im Umfang des Hindernisses und verlängern sich
    die Fristen entsprechend. Sofern solche Verzögerungen mehr als zwei Monate andauern, sind
    das beauftragende Unternehmen und die Agentur berechtigt, vom Vertrag zurückzutreten.</p>
  <p><strong>6.3</strong> Befindet sich die Agentur in Verzug, so kann das beauftragende
    Unternehmen vom Vertrag nur zurücktreten, nachdem es der Agentur schriftlich eine
    angemessene Nachfrist von zumindest 14 Tagen gesetzt hat und diese fruchtlos verstrichen
    ist. Schadenersatzansprüche des beauftragenden Unternehmens wegen Nichterfüllung oder
    Verzug sind ausgeschlossen, ausgenommen bei Nachweis von Vorsatz oder grober
    Fahrlässigkeit.</p>

  <h2>7. Vorzeitige Auflösung</h2>
  <p><strong>7.1</strong> Die Agentur ist berechtigt, den Vertrag aus wichtigen Gründen mit
    sofortiger Wirkung aufzulösen. Ein wichtiger Grund liegt insbesondere vor, wenn</p>
  <p>a) die Ausführung der Leistung aus Gründen, die das beauftragende Unternehmen zu vertreten
    hat, unmöglich wird oder trotz Setzung einer Nachfrist von 14 Tagen weiter verzögert
    wird;</p>
  <p>b) das beauftragende Unternehmen fortgesetzt, trotz schriftlicher Abmahnung mit einer
    Nachfristsetzung von 14 Tagen, gegen wesentliche Verpflichtungen aus diesem Vertrag, wie
    z.&nbsp;B. Zahlung eines fällig gestellten Betrages oder Mitwirkungspflichten,
    verstößt;</p>
  <p>c) berechtigte Bedenken hinsichtlich der Bonität des beauftragenden Unternehmens bestehen
    und dieses auf Begehren der Agentur weder Vorauszahlungen noch vor Leistung der Agentur
    taugliche Sicherheiten leistet.</p>
  <p><strong>7.2</strong> Das beauftragende Unternehmen ist berechtigt, den Vertrag aus
    wichtigen Gründen ohne Nachfristsetzung aufzulösen. Ein wichtiger Grund liegt insbesondere
    dann vor, wenn die Agentur fortgesetzt, trotz schriftlicher Abmahnung mit einer
    angemessenen Nachfrist von zumindest 14 Tagen zur Behebung des Verstoßes gegen wesentliche
    Bestimmungen aus diesem Vertrag verstößt.</p>

  <h2>8. Vergütung/Honorar</h2>
  <p><strong>8.1</strong> Wenn nichts anderes vereinbart ist, entsteht der Honoraranspruch der
    Agentur für jede einzelne Leistung, sobald diese erbracht wurde. Die Agentur ist
    berechtigt, zur Deckung ihres Aufwandes Vorschüsse zu verlangen. Ab einem Auftragsvolumen
    mit einem (jährlichen) Budget von €&nbsp;5.000, oder solchen, die sich über einen längeren
    Zeitraum erstrecken, ist die Agentur berechtigt, Zwischenabrechnungen bzw.
    Vorausrechnungen zu erstellen oder Akontozahlungen abzurufen.</p>
  <p><strong>8.2</strong> Das Honorar versteht sich als Netto-Honorar zuzüglich der Umsatzsteuer
    in gesetzlicher Höhe. Mangels Vereinbarung im Einzelfall hat die Agentur für die
    erbrachten Leistungen und die Überlassung der urheber- und kennzeichenrechtlichen
    Nutzungsrechte Anspruch auf Honorar in der marktüblichen Höhe.</p>
  <p><strong>8.3</strong> Alle Leistungen der Agentur, die nicht ausdrücklich durch das
    vereinbarte Honorar abgegolten sind, werden gesondert entlohnt. Alle der Agentur
    erwachsenden Barauslagen sind vom beauftragenden Unternehmen zu ersetzen.</p>
  <p><strong>8.4</strong> Kostenvoranschläge der Agentur sind unverbindlich. Wenn abzusehen ist,
    dass die tatsächlichen Kosten die von der Agentur schriftlich veranschlagten um mehr als
    15&nbsp;% übersteigen, wird die Agentur das beauftragende Unternehmen auf die höheren
    Kosten hinweisen. Die Kostenüberschreitung gilt als genehmigt, wenn das beauftragende
    Unternehmen nicht binnen drei Werktagen nach diesem Hinweis schriftlich widerspricht und
    gleichzeitig kostengünstigere Alternativen bekannt gibt. Handelt es sich um eine
    Kostenüberschreitung bis 15&nbsp;%, ist eine gesonderte Verständigung nicht erforderlich.
    Diese Kostenvoranschlagsüberschreitung gilt vom beauftragenden Unternehmen von vornherein
    als genehmigt.</p>
  <p><strong>8.5</strong> Wenn das beauftragende Unternehmen in Auftrag gegebene Arbeiten ohne
    Einbindung der Agentur – unbeschadet der laufenden sonstigen Betreuung durch diese –
    einseitig ändert oder abbricht, hat es der Agentur die bis dahin erbrachten Leistungen
    entsprechend der Honorarvereinbarung zu vergüten und alle angefallenen Kosten zu
    erstatten. Sofern der Abbruch nicht durch eine grob fahrlässige oder vorsätzliche
    Pflichtverletzung der Agentur begründet ist, hat das beauftragende Unternehmen der Agentur
    darüber hinaus das gesamte für diesen Auftrag vereinbarte Honorar (Provision) zu
    erstatten, wobei die Anrechnungsvergütung des §&nbsp;1168 ABGB ausgeschlossen wird.
    Weiters ist die Agentur bezüglich allfälliger Ansprüche Dritter schad- und klaglos zu
    stellen. Mit der Bezahlung des Entgelts erwirbt das beauftragende Unternehmen an bereits
    erbrachten Arbeiten keinerlei Nutzungsrechte; nicht ausgeführte Konzepte, Entwürfe und
    sonstige Unterlagen sind vielmehr unverzüglich der Agentur zurückzustellen.</p>

  <h2>9. Zahlung, Eigentumsvorbehalt</h2>
  <p><strong>9.1</strong> Das Honorar ist sofort mit Rechnungserhalt und ohne Abzug zur Zahlung
    fällig, sofern nicht im Einzelfall besondere Zahlungsbedingungen schriftlich vereinbart
    werden. Dies gilt auch für die Weiterverrechnung sämtlicher Barauslagen und sonstiger
    Aufwendungen. Die von der Agentur gelieferte Ware bleibt bis zur vollständigen Bezahlung
    des Entgelts einschließlich aller Nebenverbindlichkeiten im Eigentum der Agentur.</p>
  <p><strong>9.2</strong> Bei Zahlungsverzug des beauftragenden Unternehmens gelten die
    gesetzlichen Verzugszinsen in der für Unternehmergeschäfte geltenden Höhe. Weiters hat das
    beauftragende Unternehmen der Agentur den Pauschalbetrag gemäß §&nbsp;458 UGB in Höhe von
    €&nbsp;40,00 zu ersetzen. Darüber hinaus verpflichtet sich das beauftragende Unternehmen,
    der Agentur die entstehenden Mahn- und Inkassospesen zu ersetzen, soweit sie den
    Pauschalbetrag übersteigen und zur zweckentsprechenden Rechtsverfolgung notwendig sind,
    insbesondere die Kosten eines mit der Eintreibung beauftragten Rechtsanwalts. Die
    Geltendmachung weitergehender Rechte und Forderungen bleibt davon unberührt.</p>
  <p><strong>9.3</strong> Im Falle des Zahlungsverzuges des beauftragenden Unternehmens kann die
    Agentur sämtliche, im Rahmen anderer mit dem beauftragenden Unternehmen abgeschlossener
    Verträge, erbrachten Leistungen und Teilleistungen sofort fällig stellen.</p>
  <p><strong>9.4</strong> Weiters ist die Agentur nicht verpflichtet, weitere Leistungen bis zur
    Begleichung des aushaftenden Betrages zu erbringen (Zurückbehaltungsrecht). Die
    Verpflichtung zur Entgeltzahlung bleibt davon unberührt.</p>
  <p><strong>9.5</strong> Wurde die Bezahlung in Raten vereinbart, so behält sich die Agentur
    für den Fall der nicht fristgerechten Zahlung von Teilbeträgen oder Nebenforderungen das
    Recht vor, die sofortige Bezahlung der gesamten noch offenen Schuld zu fordern
    (Terminverlust).</p>
  <p><strong>9.6</strong> Das beauftragende Unternehmen ist nicht berechtigt, mit eigenen
    Forderungen gegen Forderungen der Agentur aufzurechnen, außer die Forderung des
    beauftragenden Unternehmens wurde von der Agentur schriftlich anerkannt oder gerichtlich
    festgestellt.</p>

  <h2>10. Eigentumsrecht und Urheberrecht</h2>
  <p><strong>10.1</strong> Alle Leistungen der Agentur, einschließlich jener aus Präsentationen
    (z.&nbsp;B. Anregungen, Ideen, Skizzen, Vorentwürfe, Skribbles, Reinzeichnungen, Konzepte,
    Negative, Dias), auch einzelne Teile daraus, bleiben ebenso wie die einzelnen Werkstücke
    und Entwurfsoriginale im Eigentum der Agentur und können von der Agentur jederzeit –
    insbesondere bei Beendigung des Vertragsverhältnisses – zurückverlangt werden. Dieser
    Punkt gilt gleichermaßen für Leistungen, die durch Einsatz von künstlicher Intelligenz
    erbracht werden. Das beauftragende Unternehmen erwirbt durch Zahlung des Honorars das
    Recht der Nutzung für den vereinbarten Verwendungszweck. Mangels anderslautender
    Vereinbarung darf das beauftragende Unternehmen die Leistungen der Agentur ausschließlich
    in Österreich nutzen; dies gilt nicht für Websites, Social-Media-Inhalte und sonstige
    Online-Medien, deren Abrufbarkeit aus dem Ausland in der Natur des Mediums liegt. Der
    Erwerb von Nutzungs- und Verwertungsrechten an Leistungen der Agentur setzt in jedem Fall
    die vollständige Bezahlung der von der Agentur dafür in Rechnung gestellten Honorare
    voraus. Nutzt das beauftragende Unternehmen bereits vor diesem Zeitpunkt die Leistungen
    der Agentur, so beruht diese Nutzung auf einem jederzeit widerrufbaren Leihverhältnis.</p>
  <p><strong>10.2</strong> Änderungen bzw. Bearbeitungen von Leistungen der Agentur, wie
    insbesondere deren Weiterentwicklung durch das beauftragende Unternehmen oder durch für
    dieses tätige Dritte, sind nur mit ausdrücklicher Zustimmung der Agentur zulässig. Die
    Herausgabe aller sogenannten „offenen Dateien“ wird damit ausdrücklich nicht
    Vertragsbestandteil. Die Agentur ist nicht zur Herausgabe verpflichtet. D.&nbsp;h. ohne
    vertragliche Abtretung der Nutzungsrechte auch für „elektronische Arbeiten“ hat das
    beauftragende Unternehmen keinen Rechtsanspruch darauf. Davon unberührt bleibt die
    laufende Pflege von Inhalten einer Website durch das beauftragende Unternehmen über den
    ihm dafür eingerichteten Redaktionszugang (siehe Punkt 15.6).</p>
  <p><strong>10.3</strong> Für die Nutzung von Leistungen der Agentur, die über den ursprünglich
    vereinbarten Zweck und Nutzungsumfang hinausgeht, ist – unabhängig davon, ob diese
    Leistung urheberrechtlich geschützt ist – die Zustimmung der Agentur erforderlich. Dieser
    Punkt gilt gleichermaßen für Leistungen, die durch Einsatz von künstlicher Intelligenz
    erbracht werden. Dafür steht der Agentur eine gesonderte angemessene Vergütung zu.</p>
  <p><strong>10.4</strong> Für die Nutzung von Leistungen der Agentur bzw. von Werbemitteln, für
    die die Agentur konzeptionelle oder gestalterische Vorlagen erarbeitet hat, ist nach
    Ablauf des Agenturvertrages unabhängig davon, ob diese Leistung urheberrechtlich geschützt
    ist oder nicht, ebenfalls die Zustimmung der Agentur notwendig.</p>
  <p><strong>10.5</strong> Für Nutzungen gemäß Punkt 10.4 steht der Agentur im 1. Jahr nach
    Vertragsende ein Anspruch auf die volle im abgelaufenen Vertrag vereinbarte
    Agenturvergütung zu, im 2. bzw. 3. Jahr nach Ablauf des Vertrages nur mehr die Hälfte bzw.
    ein Viertel der im Vertrag vereinbarten Vergütung. Ab dem 4. Jahr nach Vertragsende ist
    keine Agenturvergütung mehr zu zahlen. Die Bestimmungen der Punkte 10.4 und 10.5 gelten
    ausschließlich für zeitlich befristete Kampagnen oder laufende Betreuungsverträge
    (Dauerschuldverhältnisse), nicht hingegen für Einmalwerke (wie insbesondere Logos,
    Corporate-Design-Grundlagen, Bücher und sonstige Printpublikationen,
    Verpackungsgestaltungen oder Dauerausstellungen), an denen mit vollständiger Bezahlung des
    vereinbarten Honorars ein zeitlich unbeschränktes Nutzungsrecht für den vereinbarten
    Verwendungszweck gemäß Punkt 10.1 eingeräumt wird. Bei Logos und
    Corporate-Design-Grundlagen ist dieses Nutzungsrecht ausschließlich
    (Werknutzungsrecht).</p>
  <p><strong>10.6</strong> Das beauftragende Unternehmen haftet der Agentur für jede
    widerrechtliche Nutzung in doppelter Höhe des für diese Nutzung angemessenen Honorars.</p>

  <h2>11. Kennzeichnung</h2>
  <p><strong>11.1</strong> Die Agentur ist berechtigt, auf allen Werbemitteln und bei allen
    Werbemaßnahmen auf die Agentur und allenfalls auf den Urheber hinzuweisen, ohne dass dem
    beauftragenden Unternehmen dafür ein Entgeltanspruch zusteht.</p>
  <p><strong>11.2</strong> Die Agentur ist vorbehaltlich des jederzeit möglichen, schriftlichen
    Widerrufs des beauftragenden Unternehmens dazu berechtigt, auf eigenen Werbeträgern und
    insbesondere auf ihrer Website mit Namen und Firmenlogo auf die zum beauftragenden
    Unternehmen bestehende oder vormalige Geschäftsbeziehung hinzuweisen
    (Referenzhinweis).</p>

  <h2>12. Gewährleistung</h2>
  <p><strong>12.1</strong> Das beauftragende Unternehmen hat allfällige Mängel unverzüglich,
    jedenfalls innerhalb von acht Tagen nach Lieferung/Leistung durch die Agentur, verdeckte
    Mängel innerhalb von acht Tagen nach Erkennen derselben, schriftlich unter Beschreibung
    des Mangels anzuzeigen; andernfalls gilt eine allfällige Abweichung der Leistung als
    genehmigt. In diesem Fall ist die Geltendmachung von Gewährleistungs- und
    Schadenersatzansprüchen sowie das Recht auf Irrtumsanfechtung aufgrund von Mängeln
    ausgeschlossen.</p>
  <p><strong>12.2</strong> Im Fall berechtigter und rechtzeitiger Mängelrüge steht dem
    beauftragenden Unternehmen das Recht auf Verbesserung oder Austausch der Lieferung/Leistung
    durch die Agentur zu. Die Agentur wird die Mängel in angemessener Frist beheben, wobei das
    beauftragende Unternehmen der Agentur alle zur Untersuchung und Mängelbehebung
    erforderlichen Maßnahmen ermöglicht. Die Agentur ist berechtigt, die Verbesserung der
    Leistung zu verweigern, wenn diese unmöglich oder für die Agentur mit einem
    unverhältnismäßig hohen Aufwand verbunden ist. In diesem Fall stehen dem beauftragenden
    Unternehmen die gesetzlichen Wandlungs- oder Minderungsrechte zu. Im Fall der Verbesserung
    obliegt es dem beauftragenden Unternehmen, die Übermittlung der mangelhaften (körperlichen)
    Sache auf seine Kosten durchzuführen.</p>
  <p><strong>12.3</strong> Es obliegt auch dem beauftragenden Unternehmen, die Überprüfung der
    Leistung auf ihre rechtliche, insbesondere wettbewerbs-, marken-, urheber- und
    verwaltungsrechtliche Zulässigkeit durchzuführen. Die Agentur ist nur zu einer Grobprüfung
    der rechtlichen Zulässigkeit verpflichtet. Die Agentur haftet im Falle leichter
    Fahrlässigkeit oder nach Erfüllung einer allfälligen Warnpflicht gegenüber dem
    beauftragenden Unternehmen nicht für die rechtliche Zulässigkeit von Inhalten, wenn diese
    vom beauftragenden Unternehmen vorgegeben oder genehmigt wurden. Dieser Punkt gilt
    gleichermaßen für Leistungen, die durch Einsatz von künstlicher Intelligenz erbracht
    werden.</p>
  <p><strong>12.4</strong> Die Gewährleistungsfrist beträgt sechs Monate ab Lieferung/Leistung.
    Das beauftragende Unternehmen ist nicht berechtigt, Zahlungen wegen Bemängelungen
    zurückzuhalten. Die Vermutungsregelung des §&nbsp;924 ABGB wird ausgeschlossen.</p>

  <h2>13. Haftung und Produkthaftung</h2>
  <p><strong>13.1</strong> In Fällen leichter Fahrlässigkeit ist eine Haftung der Agentur und
    die ihrer Angestellten, Auftragnehmer oder sonstigen Erfüllungsgehilfen („Leute“) für
    Sach- oder Vermögensschäden des beauftragenden Unternehmens ausgeschlossen, gleichgültig,
    ob es sich um unmittelbare oder mittelbare Schäden, entgangenen Gewinn oder
    Mangelfolgeschäden, Schäden wegen Verzugs, Unmöglichkeit, positiver Forderungsverletzung,
    Verschuldens bei Vertragsabschluss, wegen mangelhafter oder unvollständiger Leistung
    handelt. Das Vorliegen von grober Fahrlässigkeit hat der Geschädigte zu beweisen. Soweit
    die Haftung der Agentur ausgeschlossen oder beschränkt ist, gilt dies auch für die
    persönliche Haftung ihrer „Leute“.</p>
  <p><strong>13.2</strong> Jegliche Haftung der Agentur für Ansprüche, die auf Grund der von der
    Agentur erbrachten Leistung (z.&nbsp;B. Werbemaßnahme) gegen das beauftragende Unternehmen
    erhoben werden, wird ausdrücklich ausgeschlossen, wenn die Agentur ihrer Hinweispflicht
    nachgekommen ist oder eine solche für sie nicht erkennbar war, wobei leichte Fahrlässigkeit
    nicht schadet. Insbesondere haftet die Agentur nicht für Prozesskosten, eigene
    Anwaltskosten des beauftragenden Unternehmens oder Kosten von Urteilsveröffentlichungen
    sowie für allfällige Schadenersatzforderungen oder sonstige Ansprüche Dritter; das
    beauftragende Unternehmen hat die Agentur diesbezüglich schad- und klaglos zu halten.
    Dieser Punkt gilt gleichermaßen für Leistungen, die durch Einsatz von künstlicher
    Intelligenz erbracht werden.</p>
  <p><strong>13.3</strong> Schadenersatzansprüche des beauftragenden Unternehmens verfallen in
    sechs Monaten ab Kenntnis des Schadens; jedenfalls aber nach drei Jahren ab der
    Verletzungshandlung der Agentur. Soweit gesetzlich zulässig, insbesondere im Falle
    schlichter grober Fahrlässigkeit, sind Schadenersatzansprüche der Höhe nach mit der
    Deckungssumme einer allfälligen Betriebshaftpflichtversicherung der Agentur, maximal
    jedoch mit dem Netto-Auftragswert des jeweiligen Auftrags begrenzt. Besteht keine
    Versicherungsdeckung, gilt als Höchstgrenze der Netto-Auftragswert des jeweiligen
    Auftrags.</p>

  <h2>14. Einsatz künstlicher Intelligenz</h2>
  <p><strong>14.1</strong> Die Agentur ist berechtigt, bei der Erbringung ihrer Leistungen
    Werkzeuge der künstlichen Intelligenz (KI) als unterstützendes Arbeitsmittel im Rahmen des
    menschlich gesteuerten Konzeptions- und Schaffensprozesses einzusetzen (z.&nbsp;B. zur
    Recherche, Strukturierung, Bildbearbeitung und -skalierung, Bild-, Video- und
    Audioerzeugung, Texterstellung oder Code-Entwicklung), sofern dies nicht im Einzelfall
    schriftlich ausgeschlossen wurde. Der Einsatz solcher Werkzeuge berührt den vereinbarten
    Honoraranspruch der Agentur nicht.</p>
  <p><strong>14.2</strong> Die Agentur verwendet für vertrauliche Unterlagen und
    personenbezogene Daten des beauftragenden Unternehmens nur KI-Dienste, deren
    Nutzungsbedingungen eine Verwendung dieser Daten zum Training der KI-Modelle ausschließen
    und die einen datenschutzkonformen Einsatz ermöglichen. Das beauftragende Unternehmen
    kennzeichnet Unterlagen, die besonders vertraulich zu behandeln sind.</p>
  <p><strong>14.3</strong> Das beauftragende Unternehmen nimmt zur Kenntnis, dass ausschließlich
    durch KI erzeugte Inhalte mangels menschlicher Schöpfung in der Regel keinen
    urheberrechtlichen Schutz genießen und dass KI-Werkzeuge vergleichbare Ergebnisse auch für
    Dritte erzeugen können. Die Agentur übernimmt daher keine Gewähr für die urheberrechtliche
    Schutzfähigkeit oder Einzigartigkeit solcher Inhalte. Die Regelungen der Punkte 3 und 10
    gelten unabhängig davon als vertragliche Vereinbarung.</p>
  <p><strong>14.4</strong> Bestehen für die Veröffentlichung von KI-erzeugten oder
    KI-veränderten Inhalten gesetzliche Kennzeichnungs- oder Transparenzpflichten
    (insbesondere nach der Verordnung (EU) 2024/1689 über künstliche Intelligenz), weist die
    Agentur auf ihr erkennbare Pflichten hin. Die Kennzeichnung bei der Veröffentlichung
    obliegt, sofern nicht anders vereinbart, dem beauftragenden Unternehmen.</p>

  <h2>15. Websites, Webanwendungen und Wartung</h2>
  <p><strong>15.1</strong> Die Agentur erbringt keine Hosting-Leistungen. Webspace, Server,
    Domains und E-Mail-Dienste werden vom beauftragenden Unternehmen direkt bei Drittanbietern
    bezogen oder von der Agentur im Namen des beauftragenden Unternehmens beauftragt
    (Punkt 5.2). Für Verfügbarkeit, Leistung, Datensicherheit und Datensicherung der
    Hosting-Infrastruktur ist der jeweilige Anbieter verantwortlich; die Agentur haftet nicht
    für Ausfälle, Datenverluste oder Sicherheitsvorfälle, die ihre Ursache in der Sphäre des
    Anbieters haben.</p>
  <p><strong>15.2</strong> Websites und Webanwendungen beruhen regelmäßig auf Software,
    Erweiterungen, Schriften und Diensten Dritter (z.&nbsp;B. Content-Management-Systeme,
    Plugins, Schnittstellen, Kartendienste), teils unter Open-Source-, teils unter
    kommerziellen Lizenzen. Für diese gelten die Lizenz- und Nutzungsbedingungen der
    jeweiligen Hersteller. Laufende Lizenz- und Abonnementkosten trägt das beauftragende
    Unternehmen. Für Fehler, Sicherheitslücken, Änderungen oder die Einstellung von Software
    und Diensten Dritter haftet die Agentur nicht.</p>
  <p><strong>15.3</strong> Die laufende Wartung (insbesondere Aktualisierung von Software und
    Erweiterungen, Sicherheitsmaßnahmen, Überprüfung von Datensicherungen) ist nur geschuldet,
    wenn sie gesondert vereinbart wurde („Wartungsvertrag“). Ohne Wartungsvertrag obliegt die
    Aktualisierung dem beauftragenden Unternehmen; die Folgen unterlassener Aktualisierungen
    trägt das beauftragende Unternehmen.</p>
  <p><strong>15.4</strong> Im Rahmen eines Wartungsvertrages führt die Agentur Aktualisierungen
    mit der gebotenen Sorgfalt durch. Funktionsstörungen, die durch Aktualisierungen von
    Software Dritter entstehen, stellen keinen Mangel der Leistung der Agentur dar; ihre
    Behebung wird, soweit nicht im Wartungsvertrag abgedeckt, nach Aufwand verrechnet.</p>
  <p><strong>15.5</strong> Wartungsverträge werden, sofern nicht anders vereinbart, auf
    unbestimmte Zeit abgeschlossen und können von beiden Vertragsparteien unter Einhaltung
    einer Frist von drei Monaten zum Ende eines Kalendermonats schriftlich gekündigt
    werden.</p>
  <p><strong>15.6</strong> Das beauftragende Unternehmen erhält zur Pflege der Inhalte einen
    Redaktionszugang zum Content-Management-System. Weitergehende Zugänge (z.&nbsp;B.
    Administrationszugang, Server- oder Datenbankzugang) sowie die Herausgabe von Quellcode
    werden gesondert vereinbart. Für Inhalte, die das beauftragende Unternehmen selbst
    einpflegt, sowie für Schäden aus Änderungen durch das beauftragende Unternehmen oder von
    ihm beauftragte Dritte ist die Agentur nicht verantwortlich. Zugangsdaten sind vertraulich
    zu behandeln.</p>
  <p><strong>15.7</strong> Rechtlich erforderliche Angaben und Einrichtungen der Website
    (insbesondere Impressum, Datenschutzerklärung, Einwilligungsverwaltung für Cookies und
    Drittdienste) verantwortet das beauftragende Unternehmen. Die Agentur kann bei der
    technischen Umsetzung unterstützen, erbringt jedoch keine Rechtsberatung.</p>

  <h2>16. Barrierefreiheit</h2>
  <p><strong>16.1</strong> Die barrierefreie Gestaltung von Websites, Webanwendungen, Dokumenten
    und sonstigen Leistungen ist nur geschuldet, wenn sie ausdrücklich vereinbart wurde. Der
    zu erfüllende Standard (z.&nbsp;B. WCAG 2.1 Konformitätsstufe AA bzw. EN 301 549) und der
    Umfang ergeben sich aus den Angebotsunterlagen.</p>
  <p><strong>16.2</strong> Wurde Barrierefreiheit vereinbart, bezieht sie sich auf die von der
    Agentur erstellten Vorlagen, Funktionen und Inhalte zum Zeitpunkt der Übergabe. Für
    Inhalte und Dokumente, die das beauftragende Unternehmen nachträglich einpflegt oder
    verändert, sowie für eingebundene Dienste Dritter ist das beauftragende Unternehmen
    verantwortlich.</p>
  <p><strong>16.3</strong> Ob das beauftragende Unternehmen gesetzlich zur Barrierefreiheit
    verpflichtet ist (z.&nbsp;B. nach dem Barrierefreiheitsgesetz oder dem
    Web-Zugänglichkeits-Gesetz), hat das beauftragende Unternehmen selbst zu beurteilen. Die
    Agentur weist auf ihr erkennbare Verpflichtungen hin.</p>

  <h2>17. Datenschutz</h2>
  <p><strong>17.1</strong> Die Vertragsparteien verpflichten sich zur Einhaltung der
    Datenschutz-Grundverordnung (DSGVO) und des Datenschutzgesetzes (DSG).</p>
  <p><strong>17.2</strong> Soweit die Agentur im Auftrag des beauftragenden Unternehmens
    personenbezogene Daten verarbeitet (z.&nbsp;B. im Rahmen der Wartung, bei Formularen,
    Newslettern oder Kampagnen), schließen die Vertragsparteien eine Vereinbarung zur
    Auftragsverarbeitung gemäß Art.&nbsp;28 DSGVO. Diese geht den Bestimmungen dieser AGB
    vor.</p>
  <p><strong>17.3</strong> Für die Zulässigkeit der Datenverarbeitung, die Informationspflichten
    gegenüber betroffenen Personen und die Einholung erforderlicher Einwilligungen ist das
    beauftragende Unternehmen als Verantwortlicher zuständig. Dies gilt insbesondere für Fotos
    und Videos, auf denen Personen erkennbar sind, sofern diese vom beauftragenden Unternehmen
    beigestellt oder in seinem Auftrag angefertigt werden.</p>

  <h2>18. Ausstellungen, Installationen und Spielanlagen</h2>
  <p><strong>18.1</strong> Bei Ausstellungen, Außeninstallationen sowie Spiel- und
    Erlebnisanlagen erbringt die Agentur, sofern nicht ausdrücklich anders vereinbart,
    Konzeption, inhaltliche Ausarbeitung und Gestaltung.</p>
  <p><strong>18.2</strong> Statik, Tragwerks- und Ausführungsplanung, die Auswahl von
    Materialien und Konstruktionen in sicherheitstechnischer Hinsicht, Herstellung, Montage,
    die Prüfung nach den einschlägigen Normen (insbesondere ÖNORM EN 1176 und EN 1177),
    sämtliche behördlichen Genehmigungen (einschließlich baurechtlicher,
    naturschutzrechtlicher, forstrechtlicher oder denkmalschutzrechtlicher Bewilligungen)
    sowie Inspektion und Wartung nach Inbetriebnahme obliegen den ausführenden
    Fachunternehmen bzw. dem beauftragenden Unternehmen als Betreiber.</p>
  <p><strong>18.3</strong> Gestalterische Vorgaben der Agentur sind von den ausführenden
    Fachunternehmen auf technische Umsetzbarkeit, Sicherheit und Normkonformität zu prüfen.
    Bedenken sind der Agentur und dem beauftragenden Unternehmen vor der Ausführung
    schriftlich mitzuteilen.</p>

  <h2>19. Anzuwendendes Recht</h2>
  <p>Der Vertrag und alle daraus abgeleiteten wechselseitigen Rechte und Pflichten sowie
    Ansprüche zwischen der Agentur und dem beauftragenden Unternehmen unterliegen dem
    österreichischen materiellen Recht unter Ausschluss seiner Verweisungsnormen und unter
    Ausschluss des UN-Kaufrechts.</p>

  <h2>20. Erfüllungsort und Gerichtsstand</h2>
  <p><strong>20.1</strong> Erfüllungsort ist der Sitz der Agentur. Bei Versand geht die Gefahr
    auf das beauftragende Unternehmen über, sobald die Agentur die Ware dem von ihr gewählten
    Beförderungsunternehmen übergeben hat.</p>
  <p><strong>20.2</strong> Als Gerichtsstand für alle sich zwischen der Agentur und dem
    beauftragenden Unternehmen ergebenden Rechtsstreitigkeiten im Zusammenhang mit diesem
    Vertragsverhältnis wird das für den Sitz der Agentur sachlich zuständige Gericht
    vereinbart. Ungeachtet dessen ist die Agentur berechtigt, das beauftragende Unternehmen an
    seinem allgemeinen Gerichtsstand zu klagen.</p>

  <p class="stand">Stand: Oktober 2026</p>
</section>

<?php require __DIR__ . '/../../teile/fuss.php'; ?>
