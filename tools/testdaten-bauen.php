<?php
// Erzeugt vier ERFUNDENE Testprojekte im Format von docs/datenformat.md —
// zum Prüfen des Layouts, solange Space noch keine echten Projekte liefert.
// Alle Slugs beginnen mit „test-“, Kunden und Orte sind frei erfunden.
//
// Aufruf:  php tools/testdaten-bauen.php [zielordner]
// Ohne Argument schreibt es direkt in daten/ und bilder/ des Repos (lokale
// Vorschau; beide Ordner sind gitignored). Die Action „Testdaten“ ruft es
// mit einem Zielordner auf und lädt dessen Inhalt per FTPS hoch.
// Wieder loswerden: Action „Testdaten“ mit Modus „entfernen“.

declare(strict_types=1);

$ziel = rtrim($argv[1] ?? __DIR__ . '/..', '/');

// ---- Bilderzeugung ----------------------------------------------------------
// Abstrakte Motive (Verlauf, Kreise, Band) — es geht um Formate und Ladeweite,
// nicht um Fotografie. Je Motiv und Breite eine eigene Datei, wie sie Space
// später liefert.

function td_bild(string $pfad, int $w, int $h, array $farben, string $label): void
{
    [$a, $b, $akzent] = $farben;
    $im = imagecreatetruecolor($w, $h);

    // Senkrechter Verlauf von Farbe A nach Farbe B.
    for ($y = 0; $y < $h; $y++) {
        $t = $y / max(1, $h - 1);
        $c = imagecolorallocate(
            $im,
            (int) round($a[0] + ($b[0] - $a[0]) * $t),
            (int) round($a[1] + ($b[1] - $a[1]) * $t),
            (int) round($a[2] + ($b[2] - $a[2]) * $t)
        );
        imageline($im, 0, $y, $w, $y, $c);
    }

    // Zwei große Kreise und ein Band in der Akzentfarbe (halbtransparent).
    $ak = imagecolorallocatealpha($im, $akzent[0], $akzent[1], $akzent[2], 90);
    imagefilledellipse($im, (int) ($w * 0.72), (int) ($h * 0.30), (int) ($w * 0.55), (int) ($w * 0.55), $ak);
    imagefilledellipse($im, (int) ($w * 0.18), (int) ($h * 0.85), (int) ($w * 0.32), (int) ($w * 0.32), $ak);
    imagesetthickness($im, max(2, (int) ($h * 0.02)));
    imageline($im, 0, (int) ($h * 0.62), $w, (int) ($h * 0.38), $ak);

    // Kennzeichnung als Testbild (klein, links oben).
    imagestring($im, 5, 16, 14, 'TEST  ' . $label . '  ' . $w . 'px', imagecolorallocate($im, 255, 255, 255));

    @mkdir(dirname($pfad), 0775, true);
    imagewebp($im, $pfad, 72);
}

/**
 * Ein Bild-Objekt laut Datenformat bauen und die Dateien dazu schreiben.
 * $ratio = Höhe/Breite des Motivs (Contentfotos dürfen jedes Format haben).
 */
function td_bildobjekt(string $ziel, string $slug, string $name, int $zielBreite, float $ratio,
                       array $farben, string $alt): array
{
    $breiten = array_values(array_filter([640, 1280, 1920], fn($x) => $x < $zielBreite));
    $breiten[] = $zielBreite;

    $quellen = [];
    foreach ($breiten as $w) {
        $h = max(1, (int) round($w * $ratio));
        $datei = "bilder/projekte/$slug/$name-$w.webp";
        td_bild("$ziel/$datei", $w, $h, $farben, $name);
        $quellen[] = ['datei' => '/' . $datei, 'breite' => $w];
    }
    return [
        'alt'          => $alt,
        'beschreibung' => '',
        'breite'       => $zielBreite,
        'hoehe'        => (int) round($zielBreite * $ratio),
        'quellen'      => $quellen,
    ];
}

// ---- Die vier Projekte --------------------------------------------------------
// Bewusst unterschiedlich vollständig: Projekt 2 hat kein Foto 4 und kein
// Detail 2, Projekt 4 kein Foto 5 und nur einen Credit plus sehr langen Titel —
// genau die Fälle, die ein Layout aushalten muss.

$paletten = [
    'wasser'  => [[24, 58, 82],   [104, 160, 178], [14, 156, 147]],
    'burg'    => [[54, 44, 38],   [158, 134, 110], [192, 120, 47]],
    'molke'   => [[240, 234, 222],[168, 186, 160], [47, 143, 111]],
    'werk'    => [[38, 38, 44],   [120, 124, 138], [192, 69, 47]],
];

$projekte = [
    [
        'slug' => 'test-wasserwelt-erlebnisweg', 'palette' => 'wasser',
        'titel' => 'Verborgene Wasserwelt', 'kunde' => 'Gemeinde Nebelbach',
        'jahr' => 2026, 'saeule' => 'erlebnisse', 'startseite' => 'top',
        'schlagworte' => ['Erlebnisweg', 'Ausstellung', 'Leitsystem'],
        'punchline' => 'Ein Bachlauf wird zum Museum: acht Stationen machen sichtbar, was unter der Oberfläche passiert.',
        'texte' => [
            'kurzbeschreibung' => "Der Mühlbach von Nebelbach war immer da — gesehen hat ihn niemand. Der Erlebnisweg „Verborgene Wasserwelt“ holt auf 2,4 Kilometern ans Licht, was unter der Oberfläche lebt und arbeitet.\n\nAcht Stationen verbinden Spielorte, Beobachtungsplätze und eine begehbare Wasserkammer. Die Gestaltung folgt dem Bach: Alles fließt talwärts, nichts steht im Weg.",
            'aufgabenstellung' => "Die Gemeinde wollte den Ortskern mit dem Naherholungsgebiet verbinden und Familien einen Grund geben, länger zu bleiben. Der Weg sollte ohne Personal auskommen, das ganze Jahr funktionieren und die Aufsichtspflicht nicht überfordern.",
            'loesung' => "Wir haben den Bach selbst zur Ausstellung gemacht. Jede Station greift ein Phänomen auf, das genau dort zu sehen ist — vom Strudel bis zur Fischtreppe. Die Texte erzählen in zwei Ebenen: eine Zeile für Vorbeigehende, drei Absätze für Neugierige.",
            'detail_01' => "Das Leitsystem arbeitet mit Wasserstandsmarken statt Pfeilen: Wer der blauen Linie folgt, kann sich nicht verlaufen — auch nicht auf dem Rückweg.",
            'detail_02' => "Die Wasserkammer liegt zwei Meter unter dem Bachbett. Drei Panzerglasfenster zeigen den Querschnitt des Baches im Jahreslauf; die Beleuchtung kommt ohne Strom aus.",
            'zusammenfassung' => "Im ersten Sommer zählte die Gemeinde dreimal so viele Besucher:innen im Naherholungsgebiet wie im Jahr davor. Der Weg kommt ohne Wartungspersonal aus; die Stationen haben ihren ersten Winter ohne Schaden überstanden.",
            'call_to_action' => "Sie haben einen Ort, der mehr erzählen könnte, als man ihm ansieht?",
        ],
        'credits' => [
            ['bereich' => 'Konzept und Dramaturgie', 'person' => 'Roman Dachsberger'],
            ['bereich' => 'Grafik und Leitsystem',   'person' => 'Johanna Eder'],
            ['bereich' => 'Illustration',            'person' => 'Susanne Pichelmann'],
            ['bereich' => 'Stationenbau',            'person' => 'Tischlerei Almwind (erfunden)'],
            ['bereich' => 'Wasserbau',               'person' => 'IB Quellgrund (erfunden)'],
            ['bereich' => 'Fotografie',              'person' => 'Atelier Lichtfang (erfunden)'],
        ],
        'fotos' => ['foto_01' => 0.667, 'foto_02' => 0.75, 'foto_04' => 1.5, 'foto_05' => 0.667],
    ],
    [
        'slug' => 'test-zeitsprung-burgruine', 'palette' => 'burg',
        'titel' => 'Zeitsprung Burgruine', 'kunde' => 'Marktgemeinde Falkenstein am Berg',
        'jahr' => 2025, 'saeule' => 'erlebnisse', 'startseite' => 'erlebnisse',
        'schlagworte' => ['Ausstellung', 'Escape-Room'],
        'punchline' => 'Eine Ruine ohne Dach, ein Rätsel ohne Wärter: die Burg erzählt sich selbst.',
        'texte' => [
            'kurzbeschreibung' => "Die Burgruine Falkenstein hatte Mauern, Aussicht und keine Geschichte, die man mitnehmen konnte. „Zeitsprung“ ändert das mit einem Rätselrundgang, der ganz ohne Personal auskommt.",
            'aufgabenstellung' => "Die Ruine sollte ein Ausflugsziel werden — mit kleinem Budget, ohne Aufbauten, die das Denkmalamt ablehnt, und ohne laufende Betreuung.",
            'loesung' => "Sieben Bronzetafeln verstecken ein Rätsel im Mauerwerk. Wer alle löst, öffnet die Schatzkammer — einen Raum, der sonst verschlossen bleibt. Die Tafeln erzählen nebenbei die Baugeschichte; das Rätsel ist der Köder, die Geschichte der Fang.",
            'detail_01' => "Der Mechanismus der Schatzkammer ist rein mechanisch — kein Strom, kein Funk, nichts, was im Winter kaputtgeht.",
            'zusammenfassung' => "Die Gemeinde verkauft die Rätselkarten im Gemeindeamt und in zwei Gasthäusern. Die erste Auflage war nach einem Sommer vergriffen.",
            'call_to_action' => "Auch ein Ort mit Mauern voller Geschichten, aber ohne Erzähler?",
        ],
        'credits' => [
            ['bereich' => 'Konzept und Rätseldesign', 'person' => 'Roman Dachsberger'],
            ['bereich' => 'Grafik',                   'person' => 'Johanna Eder'],
            ['bereich' => 'Metallbau',                'person' => 'Schlosserei Grubhofer (erfunden)'],
        ],
        'fotos' => ['foto_01' => 0.75, 'foto_02' => 0.667, 'foto_05' => 0.75],   // kein Foto 4
    ],
    [
        'slug' => 'test-molkerei-sonnseit', 'palette' => 'molke',
        'titel' => 'Molkerei Sonnseit — Corporate Design', 'kunde' => 'Molkerei Sonnseit',
        'jahr' => 2026, 'saeule' => 'gestaltung', 'startseite' => 'gestaltung',
        'schlagworte' => ['Corporate Design', 'Verpackung'],
        'punchline' => 'Ein Familienbetrieb bekommt ein Gesicht, das im Kühlregal genauso trägt wie am Hoftor.',
        'texte' => [
            'kurzbeschreibung' => "Drei Generationen, vierzig Produkte, kein gemeinsamer Auftritt: Die Molkerei Sonnseit wuchs schneller als ihre Gestaltung. Das neue Corporate Design bringt Hof, Kühlregal und Lieferwagen wieder unter ein Dach.",
            'aufgabenstellung' => "Der Betrieb wollte im Handel als Marke erkennbar werden, ohne die Stammkundschaft ab Hof zu verlieren. Das Design musste auf Becher, Glas und Karton funktionieren — und von der hauseigenen Druckerei verarbeitbar sein.",
            'loesung' => "Die Marke erzählt vom Südhang, dem die Molkerei ihren Namen verdankt: eine aufgehende Sonne als Wortbild, eine warme Palette, eine Typografie mit Handschrift-Anmutung für die Sortennamen. Das System kommt mit zwei Farben je Produktlinie aus.",
            'detail_01' => "Die Etiketten sind als Baukasten angelegt: Neue Sorten entstehen im Betrieb selbst, ohne dass jedes Mal eine Agentur nötig ist.",
            'detail_02' => "Für die Hofmilch-Linie blieb das alte Glasflaschen-Design als Zitat erhalten — die Stammkundschaft findet ihre Flasche auf einen Blick.",
            'zusammenfassung' => "Der Betrieb hat das System auf alle vierzig Produkte ausgerollt — in der hauseigenen Druckerei, ohne externe Hilfe. Zwei Handelsketten haben die Linie neu gelistet.",
            'call_to_action' => "Ihr Unternehmen ist gewachsen, der Auftritt nicht mitgekommen?",
        ],
        'credits' => [
            ['bereich' => 'Corporate Design', 'person' => 'Johanna Eder'],
            ['bereich' => 'Konzept',          'person' => 'Roman Dachsberger'],
            ['bereich' => 'Reinzeichnung',    'person' => 'Susanne Pichelmann'],
        ],
        'fotos' => ['foto_01' => 0.667, 'foto_02' => 1.333, 'foto_04' => 0.667, 'foto_05' => 0.75],
    ],
    [
        'slug' => 'test-werksbericht-funkenflug', 'palette' => 'werk',
        'titel' => 'Schmiedwerk Brennmoser — Werksbericht und Mitarbeitermagazin „Funkenflug“',
        'kunde' => 'Schmiedwerk Brennmoser GmbH',
        'jahr' => 2024, 'saeule' => 'gestaltung', 'startseite' => null,
        'schlagworte' => ['Publikation', 'Magazin', 'Fotografie', 'Redaktion'],
        'punchline' => 'Ein Industriebetrieb erzählt seinen 300 Beschäftigten zweimal im Jahr, woran sie eigentlich gemeinsam arbeiten — auf Papier, das man behalten will.',
        'texte' => [
            'kurzbeschreibung' => "Interne Kommunikation per Aushang erreichte im Schmiedwerk Brennmoser niemanden mehr. „Funkenflug“ ist die Antwort: ein halbjährliches Magazin, das Werkshalle und Büro dieselben Geschichten lesen lässt.",
            'aufgabenstellung' => "Die Geschäftsführung wollte ein Medium, das alle 300 Beschäftigten erreicht — auch die ohne Firmen-Mailadresse — und das die Handschrift des Betriebs trägt statt der einer Agentur.",
            'loesung' => "Ein Heft im Werkzeugkasten-Format, gedruckt auf ungestrichenem Papier, fotografiert in der eigenen Halle. Die Rubriken bleiben, die Geschichten kommen aus der Belegschaft; wir liefern Gestaltung, Redaktion und den Mut zur Lücke.",
            'zusammenfassung' => "Nach vier Ausgaben liegt die Mitnahmequote bei den Ausgabestellen konstant über neunzig Prozent — gemessen an den nachgedruckten Exemplaren. Die fünfte Ausgabe entsteht gerade.",
            'call_to_action' => "Ihre Belegschaft erfährt Neuigkeiten aus der Zeitung statt vom eigenen Betrieb?",
        ],
        'credits' => [
            ['bereich' => 'Gestaltung und Redaktion', 'person' => 'leerzeichen multimedia og'],
        ],
        'fotos' => ['foto_01' => 0.667, 'foto_02' => 0.75, 'foto_04' => 0.667],   // kein Foto 5
    ],
];

// ---- Schreiben -----------------------------------------------------------------

function td_json(array $daten): string
{
    return json_encode($daten, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "\n";
}

@mkdir($ziel . '/daten/projekte', 0775, true);

$index = [];
foreach ($projekte as $p) {
    $farben = $paletten[$p['palette']];
    $slug   = $p['slug'];

    $bilder = [
        'header'      => td_bildobjekt($ziel, $slug, 'header', 2560, 1440 / 2560, $farben,
            'Testmotiv: Header von ' . $p['titel']),
        'teaser_quer' => td_bildobjekt($ziel, $slug, 'teaser', 2288, 1520 / 2288, $farben,
            'Testmotiv: Teaser von ' . $p['titel']),
    ];
    foreach ($p['fotos'] as $name => $ratio) {
        $bilder[$name] = td_bildobjekt($ziel, $slug, str_replace('_', '-', $name), 2560, $ratio,
            $farben, 'Testmotiv ' . $name . ' von ' . $p['titel']);
    }

    file_put_contents(
        $ziel . '/daten/projekte/' . $slug . '.json',
        td_json([
            'slug' => $slug, 'titel' => $p['titel'], 'kunde' => $p['kunde'],
            'jahr' => $p['jahr'], 'saeule' => $p['saeule'],
            'schlagworte' => $p['schlagworte'], 'punchline' => $p['punchline'],
            'texte' => $p['texte'], 'credits' => $p['credits'],
            'bilder' => $bilder, 'stand' => date('c'),
        ])
    );

    $zeile = [
        'slug' => $slug, 'titel' => $p['titel'], 'kunde' => $p['kunde'],
        'jahr' => $p['jahr'], 'saeule' => $p['saeule'], 'punchline' => $p['punchline'],
        'teaser_quer' => $bilder['teaser_quer'],
    ];
    if (!empty($p['startseite'])) {
        $zeile['startseite'] = $p['startseite'];
    }
    $index[] = $zeile;
}

// Neueste zuerst, wie es Space später liefert.
usort($index, fn($a, $b) => $b['jahr'] <=> $a['jahr']);
@mkdir($ziel . '/daten/projekte', 0775, true);
file_put_contents($ziel . '/daten/projekte/index.json', td_json(['stand' => date('c'), 'projekte' => $index]));

echo count($projekte) . " Testprojekte geschrieben nach $ziel\n";
