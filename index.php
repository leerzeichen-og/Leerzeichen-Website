<?php
// Startseite. Dramaturgie der Bühne (Stand 17.9.2026, Beschluss Roman):
// Claim + fliegende Projekt-Objekte + drei Fragen → das Übergangsbild
// (weiß oben, schwarz unten) scrollt herein und trägt die Seite ins Schwarz
// (keine Einblendung) → Antwort zweizeilig mit zwei Pfeil-Knöpfen → der
// Splash scrollt herein, darauf schwebt das Team-Foto im Orbit, darunter
// zentriert Text und Knopf. Danach: die zwei Säulen (Fassung „frei") mit
// den Leistungs-Laufbändern darunter · Newsletter-Karte mit hineinragendem
// Kuvert · Abschluss-CTA.
// Ohne JavaScript oder bei reduzierter Bewegung steht die statische Fassung.

require_once __DIR__ . '/teile/firma.php';
require_once __DIR__ . '/teile/projekte.php';

$titel        = 'leerzeichen — Erlebnisse und Gestaltung | Neumarkt/Ybbs';
$beschreibung = 'Agentur für Erlebnisse & Gestaltung: Wir entwickeln Ausstellungen, '
              . 'Themenwege, Corporate Design & Websites für Gemeinden, Museen und Unternehmen.';
$styles       = ['/assets/startseite.css'];
$voll_breit   = true;



// Die zwei Fragen (Fassung Roman, 7.10.2026 — die dritte ist entfallen).
// Senkrechter Strich = fester Zeilenumbruch. Schreibtisch und Telefon
// brauchen UNTERSCHIEDLICHE Umbrüche (Roman) — beide Fassungen stehen im
// Markup, buehne.js behält beim Start nur die passende.
$fragen = [
    [
        'desktop' => 'Wie wird aus Ihrem Projekt|ein Erlebnis, das neue|Besucher anzieht?',
        'mobil'   => 'Wie wird aus Ihrem Projekt ein Erlebnis,|das neue Besucher|anzieht?',
    ],
    [
        'desktop' => 'Wie wird aus Ihrem Betrieb|eine Marke, die im|Kopf bleibt?',
        'mobil'   => 'Wie wird aus|Ihrem Betrieb|eine Marke, die|im Kopf bleibt?',
    ],
];

// Bahnen der Projekt-Objekte — IMMER acht (Beschluss Roman 17.9.2026).
// Die Objekte schweben nahezu am Stand (nur sanftes seitliches Treiben, vx)
// und wandern ans Scrollen gekoppelt nach oben: y0 = Startlage in vh,
// tiefe = wie viele vh sie über die ganze Bühnenstrecke zurücklegen —
// dadurch verteilen sie sich über die Fragen-Reise statt auf einen Schirm.
// tiefe ≈ Bühnenhöhe (860vh): die Objekte ziehen etwa im Seitentempo vorbei
// (kein Schwindel), leichte Unterschiede geben dezente Tiefe. y0 staffelt
// sie über die Strecke — es sind immer nur zwei, drei zugleich im Bild.
// Die Objekte laufen auf einer UMLAUFBAHN (buehne.js, Spanne 200 vh): Wer
// oben hinausfliegt, kommt unten wieder herein — die Dichte bleibt dadurch
// über die ganze Scrollstrecke gleich, und ständig fliegt eines von unten
// ins Bild (Roman, 24.9.2026). y0 verteilt die zehn gleichmäßig über die
// Spanne, die leicht unterschiedlichen Tiefen lassen sie gegeneinander
// wandern, damit die Verteilung lebendig bleibt.
// Neun Bahnen (vorher zehn — mit zwei statt drei Fragen wirkte die Bühne
// zu dicht, Roman 12.10.2026), gleichmäßig über die 200-vh-Umlaufbahn.
// Startlagen x zur Mitte orientiert (Roman, 19.11.2026): Kein Objekt startet
// mehr angeschnitten an der Kante, und buehne.js stutzt die Wander-Amplituden
// auf den Spielraum zur Bildkante — nichts hängt mehr am Rand. y0 beginnt
// erst unterhalb der oberen Schutzzone (80 px + Fade, siehe buehne.js).
$bahnen = [
    ['w' => 31, 'h' => 22, 'x' => 12, 'y0' => 18,  'tiefe' => 790, 'vx' => 0.28],
    ['w' => 24, 'h' => 19, 'x' => 56, 'y0' => 38,  'tiefe' => 765, 'vx' => -0.22],
    ['w' => 20, 'h' => 26, 'x' => 36, 'y0' => 56,  'tiefe' => 815, 'vx' => 0.20],
    ['w' => 27, 'h' => 18, 'x' => 62, 'y0' => 76,  'tiefe' => 745, 'vx' => -0.26],
    ['w' => 22, 'h' => 24, 'x' => 16, 'y0' => 96,  'tiefe' => 840, 'vx' => 0.18],
    ['w' => 28, 'h' => 19, 'x' => 44, 'y0' => 118, 'tiefe' => 780, 'vx' => -0.20],
    ['w' => 25, 'h' => 16, 'x' => 60, 'y0' => 140, 'tiefe' => 805, 'vx' => 0.24],
    ['w' => 21, 'h' => 15, 'x' => 28, 'y0' => 162, 'tiefe' => 755, 'vx' => -0.18],
    ['w' => 26, 'h' => 17, 'x' => 52, 'y0' => 184, 'tiefe' => 825, 'vx' => 0.22],
];
// Immer neun Flieger: gibt es weniger Projekte mit Objekt, wiederholen sie sich.
// Bühnen-Steuerung aus Space (3.11.2026): „sofort" fliegt schon im ersten
// Bild, „spaeter" rückt erst beim Scrollen nach; steht die Bühne in Space
// auf „aus", fehlt objekt im Export komplett. Die vorderen Bahnen (y0 < 90,
// beim Seitenstart im Bild) bekommen deshalb nur sofort-Projekte. Ältere
// Exporte ohne buehne-Schlüssel fliegen wie bisher über alle Bahnen.
$objektProjekte = array_values(array_filter(pj_index(),
    fn($p) => !empty($p['objekt']['quellen'])));
$sofort  = array_values(array_filter($objektProjekte,
    fn($p) => ($p['buehne'] ?? '') === 'sofort'));
$spaeter = array_values(array_filter($objektProjekte,
    fn($p) => ($p['buehne'] ?? '') !== 'sofort'));
$neuesFormat = (bool) array_filter($objektProjekte,
    fn($p) => array_key_exists('buehne', $p));

$flieger = [];   // je Bahn ein Projekt — oder null, die Bahn bleibt dann leer
if ($objektProjekte) {
    $iSofort  = 0;
    $iSpaeter = 0;
    // sofort-Projekte, für die vorne kein Platz mehr ist, fliegen auf der
    // Scroll-Strecke mit — VOR den spaeter-Projekten. Vorher verschwanden
    // sie komplett, sobald die vorderen Bahnen voll waren (Befund 18.11.2026).
    $vorneBahnen = count(array_filter($bahnen, fn($b) => $b['y0'] < 90));
    $hinten = array_merge(array_slice($sofort, $vorneBahnen), $spaeter);
    if (!$hinten) {
        $hinten = $sofort;   // nur sofort-Projekte: die dürfen überall fliegen
    }
    foreach ($bahnen as $i => $b) {
        if (!$neuesFormat) {
            $flieger[] = $objektProjekte[$i % count($objektProjekte)];
        } elseif ($b['y0'] < 90) {
            // Erster Schirm: nur sofort-Projekte — gibt es keine, bleibt
            // die Bahn frei (genau das heißt „spaeter").
            $flieger[] = $sofort ? $sofort[$iSofort++ % count($sofort)] : null;
        } else {
            $flieger[] = $hinten ? $hinten[$iSpaeter++ % count($hinten)] : null;
        }
    }
}

// Die zwei Säulen (Texte: „Website-Texte"). Der erste Absatz ist der Lead.
$saeulen_boxen = [
    [
        'id' => 'erlebnis', 'url' => '/erlebnisgestaltung/', 'eyebrow' => 'Säule 1 · Erlebnisse',
        'titel' => 'Wir schaffen Erlebnisse, die in Erinnerung bleiben.',
        'text' => [
            'Inhalte erfahren und gleichzeitig etwas erleben: Ausstellungen, Escape-Rooms und Treasure-Trails, Rundwege mit interaktiven Stationen, Outdoor-Abenteuer, Themenspielplätze, Kinderebenen, die eine Ausstellung für Familien öffnen. Am Ende steht immer dieselbe Frage: Was bringt Besucher zum Staunen?',
            'Wir arbeiten für Museen, Gemeinden, Ausflugsziele und Tourismusregionen. Oft an Familien und Kinder gerichtet. Analog und begreifbar. Digital dort, wo es Sinn stiftet.',
        ],
        'liste' => ['Ausstellungen', 'Kinderbegleitebenen', 'Escape-Rooms',
                    'Treasure-Trails', 'Rundwege mit Begleitebenen', 'Outdoor-Abenteuer',
                    'Spielplatzkonzepte', 'Leitsysteme und Beschilderungen', 'Interaktive Stationen'],
    ],
    [
        'id' => 'marke', 'url' => '/grafikdesign/', 'eyebrow' => 'Säule 2 · Grafik & Design',
        'titel' => 'Wir machen sichtbar, was Ihr Unternehmen ausmacht.',
        'text' => [
            'Logo, Farben, Schrift, Bild und Layout ergeben einen einheitlichen Auftritt Ihrer Organisation und schaffen Wiedererkennungswert, auf Papier wie am Screen.',
            'Darauf aufbauend machen wir Ihre Botschaft greifbar: als Magazin, das gerne gelesen wird. Als Buch, das immer wieder aus dem Regal genommen wird. Als Microsite, die Ihre neue Produktlinie präsentiert.',
            'Unsere Kunden sind meist regional verankert, aber ihre Geschichten wirken (europa)weit.',
        ],
        'liste' => ['Corporate Design und Redesign', 'Logoentwicklung', 'Mitarbeitermagazine',
                    'Kundenmagazine', 'Bücher und Publikationen', 'Kataloge und Prospekte',
                    'Geschäftsausstattung', 'Microsites und Landingpages', 'Screendesign'],
    ],
];
// Säulen-Gestaltung: Variante „frei" (Beschluss Roman 17.9.2026) —
// offene, schmale Spalten mit kräftiger Oberlinie, viel Weißraum.

// Je Säule ein Motiv (Roman, 19.11.2026): der Quer-Teaser des neuesten
// Projekts der Säule, über der Oberlinie — automatisch aktuell, kein
// eigenes Bildmaterial nötig. Ohne Projekt der Säule entfällt das Bild.
// Verlinkt auf die Projektseite, am Zeigegerät mit dem Kreis-Hover der
// Bühne (buehne.js, 19.11.2026) — gespeichert wird deshalb das ganze
// Projekt (Slug und Titel), nicht nur das Bild.
$saeulen_motiv = ['erlebnis' => null, 'marke' => null];
$saeulen_quelle = ['erlebnis' => 'erlebnisse', 'marke' => 'gestaltung'];
foreach (pj_index() as $p) {
    foreach ($saeulen_quelle as $boxId => $saeule) {
        if ($saeulen_motiv[$boxId] === null && ($p['saeule'] ?? '') === $saeule
            && !empty($p['teaser_quer']['quellen'])) {
            $saeulen_motiv[$boxId] = $p;
        }
    }
}

// Wortwechsler statt der zwei Laufbänder (Beschluss Roman, 19.11.2026):
// EIN stehender Satz, in dem die Leistung durchwechselt — dieselbe
// Masken-Bewegung wie die Bühnen-Fragen, also kein Fremdkörper. KURZE
// Formen der Begriffe beider Säulen, alternierend gemischt — die langen
// Listeneinträge („Rundwege mit interaktiven Stationen") sprengten den
// Satz am Telefon. Ohne JavaScript (oder bei reduzierter Bewegung) steht
// der Satz mit den vollen Begriffen beider Listen ausgeschrieben.
$ww_kurz = [
    ['Ausstellungen', 'Escape-Rooms', 'Treasure-Trails', 'Erlebniswege',
     'Outdoor-Abenteuer', 'Spielplätze', 'Leitsysteme', 'Kinderebenen',
     'interaktive Stationen'],
    ['Corporate Designs', 'Logos', 'Mitarbeitermagazine', 'Kundenmagazine',
     'Bücher', 'Kataloge', 'Geschäftsausstattung', 'Microsites', 'Websites'],
];
$ww_woerter = [];
for ($i = 0, $n = max(count($ww_kurz[0]), count($ww_kurz[1])); $i < $n; $i++) {
    foreach ($ww_kurz as $liste) {
        if (isset($liste[$i])) {
            $ww_woerter[] = $liste[$i];
        }
    }
}
// Die statische Fassung nennt die vollen Begriffe beider Säulen.
$ww_statisch = array_merge($saeulen_boxen[0]['liste'], $saeulen_boxen[1]['liste']);

// Team-Text (Kurzfassung „Über uns") — steht jetzt im Splash-Akt der Bühne.
$teamText = 'Ohne Leerzeichen wäre dieser Satz kaum zu lesen. Der Abstand ist es, der '
          . 'den Blick lenkt und dem Wichtigen Raum gibt. Der kleinste Eingriff entscheidet '
          . 'darüber, ob und wie eine Botschaft ankommt. Diesem Leitgedanken folgend begleiten '
          . 'wir seit ' . FIRMA_GEGRUENDET . ' Projekte von der ersten Skizze bis zur Übergabe.';

// Motive: greifen automatisch, sobald die Datei unter assets/bilder/ liegt.
function startseite_bild(string $name): ?string
{
    foreach (['webp', 'jpg', 'png'] as $ext) {
        if (is_file(__DIR__ . '/assets/bilder/' . $name . '.' . $ext)) {
            return '/assets/bilder/' . $name . '.' . $ext;
        }
    }
    return null;
}
$inkSplash  = startseite_bild('ink-splash');
$uebergang  = startseite_bild('leerzeichen-design-abenteuer-erfolg-breiter_start_bg');
$teamFoto   = startseite_bild('team');

// Gruß an alle, die den Quellcode lesen (siehe teile/kopf.php).
$quellkunst = <<<'KUNST'
<!--
   _                                _     _
  | | ___  ___ _ __ _______(_) ___| |__   ___ _ __
  | |/ _ \/ _ \ '__|_  / _ \ |/ __| '_ \ / _ \ '_ \
  | |  __/  __/ |   / /  __/ | (__| | | |  __/ | | |
  |_|\___|\___|_|  /___\___|_|\___|_| |_|\___|_| |_|

              [                  ]
                     ^^^
       Achtung: Hier steht ein Leerzeichen.
            Gemeinsam Zeichen setzen.
-->
KUNST;

require __DIR__ . '/teile/kopf.php';
?>

<?php // ---- Scroll-Bühne (Skript schaltet um; hidden = die bekannte Regel) ---- ?>
<section id="buehne" class="buehne" hidden>
  <div class="buehne-blick">
    <div class="buehne-objekte">
      <?php foreach ($flieger as $i => $p): if ($p === null) continue; $b = $bahnen[$i]; ?>
      <div class="buehne-obj"
           data-w="<?= $b['w'] ?>" data-h="<?= $b['h'] ?>"
           data-x="<?= $b['x'] ?>" data-y0="<?= $b['y0'] ?>"
           data-tiefe="<?= $b['tiefe'] ?>" data-vx="<?= $b['vx'] ?>"
           data-kat="<?= e(PJ_SAEULEN[$p['saeule'] ?? ''][0] ?? '') ?>"
           data-titel="<?= e((string) ($p['titel'] ?? '')) ?>"
           data-punchline="<?= e((string) ($p['punchline'] ?? '')) ?>"
           data-url="/referenzen/<?= e((string) ($p['slug'] ?? '')) ?>/"
           style="width:<?= $b['w'] ?>vw;height:<?= $b['h'] ?>vh;transform:translate3d(<?= $b['x'] ?>vw,<?= $b['y0'] ?>vh,0)">
        <button type="button" aria-label="<?= e((string) ($p['titel'] ?? '')) ?>">
          <?= pj_bild($p['objekt'], '', '22vw') ?>
        </button>
      </div>
      <?php endforeach; ?>
    </div>

    <div class="buehne-fragen">
      <?php foreach ($fragen as $f): foreach (['desktop', 'mobil'] as $fassung): ?>
      <p class="buehne-frage" data-fassung="<?= $fassung ?>"><?php foreach (explode('|', $f[$fassung]) as $zeile): ?><span class="buehne-zeile"><?= e($zeile) ?></span><?php endforeach; ?></p>
      <?php endforeach; endforeach; ?>
    </div>

    <?php // Schwarzer Akt: liegt unter dem Übergangsbild, wird von ihm
          // zugedeckt aufgedeckt — keine Einblendung nötig. ?>
    <div class="buehne-finale" style="opacity:0;pointer-events:none">
      <div class="buehne-antwort" style="opacity:0">
        <h2><span class="buehne-zeile">Darauf finden wir</span><span class="buehne-zeile">gemeinsam Antworten.</span></h2>
        <p>Seit <?= e(FIRMA_GEGRUENDET) ?>.<br>gedruckt • gebaut • digital</p>
        <div class="buehne-knoepfe">
          <a class="knopf knopf-hell" href="/referenzen/">Referenzen <?= lz_pfeil() ?></a>
          <a class="knopf knopf-umriss" href="/kontakt/">Kontakt <?= lz_pfeil() ?></a>
        </div>
      </div>
      <?php // Splash-Akt: scrollt herein; darauf schwebt das Team-Foto im
            // Orbit, darunter zentriert Text und Knopf. ?>
      <div class="buehne-splash" style="transform:translateY(100vh)<?= $inkSplash ? ';background-image:url(' . e($inkSplash) . ')' : '' ?>">
        <div class="buehne-team">
          <?php if ($teamFoto): ?>
          <div class="buehne-team-halter">
            <img class="buehne-team-foto" src="<?= e($teamFoto) ?>" width="2500" height="1667"
              alt="Das Team von leerzeichen bespricht Entwürfe an der Moodboard-Wand">
          </div>
          <?php endif; ?>
          <div class="buehne-team-text">
            <h2 class="lz-h3">Wir sind Leerzeichen.</h2>
            <p><?= e($teamText) ?></p>
            <a class="knopf" href="/agentur/">Lernen Sie unser Team kennen <?= lz_pfeil() ?></a>
          </div>
        </div>
      </div>
    </div>

    <?php // Übergangsbild (weiß oben, schwarz unten): scrollt über die weiße
          // Bühne herein und trägt sie ins Schwarz — liegt ÜBER dem Finale. ?>
    <?php if ($uebergang): ?>
    <div class="buehne-uebergang" style="transform:translateY(100vh);background-image:url(<?= e($uebergang) ?>)"></div>
    <?php endif; ?>
  </div>

  <div class="buehne-claimblock">
    <h1 class="lz-claim">Gemeinsam<br>Zeichen setzen.</h1>
    <?php // Scrollhinweis unter dem Claim (der kräftige Pfeil, seit
          // 20.11.2026 der gemeinsame Baustein aller Seiten); das Skript
          // blendet ihn mit dem ersten Scrollen aus. ?>
    <span class="buehne-runter" aria-hidden="true"><?= lz_pfeil_runter() ?></span>
  </div>
</section>

<?php // ---- Statische Fassung: ohne JavaScript ist DAS die Startseite -------- ?>
<section id="buehne-statisch" class="buehne-statisch">
  <h1 class="lz-claim">Gemeinsam<br>Zeichen setzen.</h1>
  <?php foreach ($fragen as $f): ?>
  <p class="buehne-statisch-frage"><?= e(str_replace('|', ' ', $f['desktop'])) ?></p>
  <?php endforeach; ?>
  <p class="lz-lead buehne-statisch-antwort">Darauf finden wir gemeinsam Antworten.
    Seit <?= e(FIRMA_GEGRUENDET) ?> — gedruckt • gebaut • digital.</p>
  <div class="buehne-knoepfe">
    <a class="knopf" href="/referenzen/">Referenzen <?= lz_pfeil() ?></a>
    <a class="knopf knopf-umriss-dunkel" href="/kontakt/">Kontakt <?= lz_pfeil() ?></a>
  </div>
  <div class="lz-teamgrid" style="margin-top:var(--space-9)">
    <?php if ($teamFoto): ?>
    <img class="team-foto-bild" src="<?= e($teamFoto) ?>"
      alt="Das Team von leerzeichen bespricht Entwürfe an der Moodboard-Wand" loading="lazy">
    <?php endif; ?>
    <div>
      <h2 class="lz-h2">Wir sind Leerzeichen.</h2>
      <p class="lz-lead" style="margin-top:var(--space-5);max-width:min(44ch,100%)"><?= e($teamText) ?></p>
      <div style="margin-top:var(--space-6)">
        <a class="knopf" href="/agentur/">Lernen Sie unser Team kennen <?= lz_pfeil() ?></a>
      </div>
    </div>
  </div>
</section>

<?php // ---- Die zwei Säulen (Variante über ?saeulen=…, bis entschieden) -------- ?>


<section id="handwerk" class="lz-sec">
  <h2 class="handwerk-titel"><span class="buehne-zeile">Gestaltung ist</span><span class="buehne-zeile">unser Handwerk.</span></h2>
  <div class="lz-saeulen">
    <?php foreach ($saeulen_boxen as $nr => $box): $motiv = $saeulen_motiv[$box['id']] ?? null; ?>
    <?php if ($nr === 1): ?>
    <?php // Wortwechsler (ersetzt die zwei Laufbänder, 19.11.2026; seit dem
          // 19.11. abends ZWISCHEN den Säulen, zweizeilig, ohne Punkt —
          // Wunsch Roman): Die statische Fassung nennt alle vollen Begriffe;
          // buehne.js schaltet auf den Satz mit wechselndem Wort um
          // (hidden-Muster, nie display). ?>
    <div class="ww">
      <p class="ww-statisch">Wir gestalten
        <?= e(implode(', ', array_slice($ww_statisch, 0, -1))) ?> und <?= e(end($ww_statisch)) ?>.</p>
      <?php // Der Kreis ist ein Link auf die Leistungs-Seite (Roman, 20.11.2026). ?>
      <a class="ww-satz" hidden href="/leistungen/" aria-label="Zu unseren Leistungen"
         data-woerter="<?= e(json_encode($ww_woerter, JSON_UNESCAPED_UNICODE)) ?>"><span class="ww-vorspann">Wir gestalten</span> <span class="ww-maske"><span class="ww-wort"><?= e($ww_woerter[0]) ?></span></span></a>
    </div>
    <?php endif; ?>
    <article id="<?= e($box['id']) ?>" class="lz-saeule<?= $motiv ? ' hat-bild' : '' ?>">
      <?php if ($motiv): ?>
      <a class="lz-saeule-bildlink" href="/referenzen/<?= e((string) ($motiv['slug'] ?? '')) ?>/"
         data-titel="<?= e((string) ($motiv['titel'] ?? '')) ?>"
         aria-label="Zum Projekt <?= e((string) ($motiv['titel'] ?? '')) ?>">
        <?= pj_bild($motiv['teaser_quer'], 'lz-saeule-bild', '(max-width: 900px) 100vw, 420px') ?>
      </a>
      <?php endif; ?>
      <h3 class="lz-saeule-titel"><?= e($box['titel']) ?></h3>
      <?php foreach ($box['text'] as $t): ?>
      <p class="lz-saeule-text"><?= e($t) ?></p>
      <?php endforeach; ?>
      <div class="lz-saeule-fuss">
        <a class="knopf" href="<?= e($box['url']) ?>">Mehr dazu <?= lz_pfeil() ?></a>
      </div>
    </article>
    <?php endforeach; ?>
  </div>
</section>

<?php require __DIR__ . '/teile/newsletter.php'; ?>
<?php require __DIR__ . '/teile/cta.php'; ?>

<script src="<?= e(lz_asset('/assets/buehne.js')) ?>" defer></script>
<?php require __DIR__ . '/teile/fuss.php'; ?>
