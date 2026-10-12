<?php
// Projektdaten lesen und rendern. Die Daten legt Space unter daten/projekte/
// ab (Format: docs/datenformat.md) — diese Datei ist die einzige Stelle,
// die das Format kennt.

// Die zwei Säulen der Positionierung: Schlüssel → [Anzeigename, Landingpage].
const PJ_SAEULEN = [
    'erlebnisse' => ['Erlebnisse', '/erlebnisgestaltung/'],
    'gestaltung' => ['Gestaltung', '/grafikdesign/'],
];

/** Liste aller Projekte aus index.json — leeres Array, wenn (noch) keine da sind. */
function pj_index(): array
{
    $roh = @file_get_contents(__DIR__ . '/../daten/projekte/index.json');
    if ($roh === false) {
        return [];
    }
    return json_decode($roh, true)['projekte'] ?? [];
}

/** Ein Projekt anhand des Slugs — null, wenn es das nicht gibt. */
function pj_projekt(string $slug): ?array
{
    // Nur Kleinbuchstaben, Ziffern, Bindestrich — alles andere ist kein Slug
    // (und darf nie in einen Dateipfad gelangen).
    if (!preg_match('/^[a-z0-9-]{1,120}$/', $slug)) {
        return null;
    }
    $roh = @file_get_contents(__DIR__ . '/../daten/projekte/' . $slug . '.json');
    if ($roh === false) {
        return null;
    }
    $p = json_decode($roh, true);
    return is_array($p) ? $p : null;
}

/** Klartext mit Leerzeilen → <p>-Absätze, vollständig escapet. */
function pj_absaetze(string $text): string
{
    $out = '';
    foreach (preg_split('/\n\s*\n/', trim($text)) as $absatz) {
        if (trim($absatz) !== '') {
            $out .= '<p>' . nl2br(e(trim($absatz))) . '</p>';
        }
    }
    return $out;
}

/** Einen Textblock ausgeben, wenn er gefüllt ist (Muster der alten Shortcode-Fassung). */
function pj_text(array $projekt, string $feld, string $klasse = ''): string
{
    $text = trim((string) ($projekt['texte'][$feld] ?? ''));
    if ($text === '') {
        return '';
    }
    return '<div class="pj-text' . ($klasse ? ' ' . $klasse : '') . '">' . pj_absaetze($text) . '</div>';
}

/**
 * Ein Bild als <img> mit srcset/sizes aus den Quellen im Bild-Objekt.
 * $zuerst = true nur für den Header: der bestimmt die wahrgenommene Ladezeit
 * (fetchpriority high, eager statt lazy).
 */
function pj_bild(?array $bild, string $klasse, string $sizes, bool $zuerst = false): string
{
    $quellen = $bild['quellen'] ?? [];
    if (!$quellen) {
        return '';
    }
    // Größte Fassung als src (Rückfall für Browser ohne srcset).
    usort($quellen, fn($a, $b) => ($a['breite'] ?? 0) <=> ($b['breite'] ?? 0));
    $groesste = end($quellen);
    $srcset = implode(', ', array_map(
        fn($q) => e($q['datei']) . ' ' . (int) $q['breite'] . 'w',
        $quellen
    ));
    // Zugeschnitten wird seit dem Modul-Format auf der Website (object-fit) —
    // der Fokuspunkt aus Space sagt, welcher Bildteil dabei stehen bleibt.
    $stil = '';
    if (isset($bild['fokus'][0], $bild['fokus'][1])) {
        $stil = ' style="object-position:' . round((float) $bild['fokus'][0] * 100, 1)
              . '% ' . round((float) $bild['fokus'][1] * 100, 1) . '%"';
    }
    return '<img class="' . e($klasse) . '"'
        . ' src="' . e($groesste['datei']) . '"'
        . ' srcset="' . $srcset . '"'
        . ' sizes="' . e($sizes) . '"'
        . (!empty($bild['breite']) ? ' width="' . (int) $bild['breite'] . '" height="' . (int) $bild['hoehe'] . '"' : '')
        . ' alt="' . e((string) ($bild['alt'] ?? '')) . '"'
        . $stil
        . ' decoding="async"'
        . ($zuerst ? ' loading="eager" fetchpriority="high"' : ' loading="lazy"')
        . '>';
}

/**
 * Ein Video aus dem Modul-Format: die Originaldatei, stumm im Loop (rein
 * illustrativ wie die Fotos daneben); bei reduzierter Bewegung hält es das
 * Seitenskript an. Space liefert keine Breitenstufen — Videos kann der
 * Server nicht rechnen.
 */
function pj_video(?array $bild, string $klasse): string
{
    $q = $bild['quellen'][0] ?? null;
    if (!$q) {
        return '';
    }
    $alt = trim((string) ($bild['alt'] ?? ''));
    return '<video class="' . e($klasse) . '"'
        . ' autoplay muted loop playsinline preload="metadata"'
        . ($alt !== '' ? ' aria-label="' . e($alt) . '"' : ' aria-hidden="true"')
        . '><source src="' . e($q['datei']) . '"'
        . (!empty($bild['mime']) ? ' type="' . e((string) $bild['mime']) . '"' : '')
        . '></video>';
}

/** Bild oder Video — Space markiert Videos mit "video": true. */
function pj_medium(?array $m, string $klasse, string $sizes, bool $zuerst = false): string
{
    if (!$m) {
        return '';
    }
    return !empty($m['video']) ? pj_video($m, $klasse) : pj_bild($m, $klasse, $sizes, $zuerst);
}

/**
 * Ein Inhalts-Modul des Beitrags-JSON rendern (Modul-Format seit 7.10.2026,
 * docs/datenformat.md). Eine unbekannte Art fällt auf das foto_text-Muster
 * zurück — so bricht ein neues Space-Modul die Seite nie, es wird nur
 * schlichter gezeigt.
 */
function pj_modul(array $m): string
{
    $art    = (string) ($m['art'] ?? '');
    $bilder = array_values((array) ($m['bilder'] ?? []));
    $texte  = array_values(array_filter(
        (array) ($m['texte'] ?? []),
        fn($t) => trim((string) $t) !== ''
    ));
    $kopf   = trim((string) ($m['ueberschrift'] ?? ''));

    switch ($art) {
        case 'doppelbild':
            $out = '<div class="pj-doppel">';
            foreach (array_slice($bilder, 0, 2) as $b) {
                $out .= pj_medium($b, 'pj-doppel-medium', '(max-width: 640px) 100vw, 50vw');
            }
            return $out . '</div>';

        case 'scroller':
            $out = '<div class="pj-scroller"><div class="pj-scroller-spur">';
            foreach ($bilder as $b) {
                $out .= pj_medium($b, 'pj-scroller-medium', '70vw');
            }
            return $out . '</div></div>';

        case 'foto_details':
            $out = pj_medium($bilder[0] ?? null, 'pj-foto', '100vw');
            if ($kopf !== '') {
                $out .= '<div class="pj-text"><h2 class="pj-zwischentitel">' . e($kopf) . '</h2></div>';
            }
            $spalten = '';
            foreach (array_slice($texte, 0, 2) as $t) {
                $spalten .= '<div class="pj-text">' . pj_absaetze((string) $t) . '</div>';
            }
            return $out . ($spalten !== '' ? '<div class="pj-details">' . $spalten . '</div>' : '');

        default:   // header (mitten im Lauf), foto_text, foto_zusammenfassung, Unbekanntes
            $out = pj_medium($bilder[0] ?? null, 'pj-foto', '100vw');
            if ($kopf !== '' || $texte) {
                $out .= '<div class="pj-text">'
                    . ($kopf !== '' ? '<h2 class="pj-zwischentitel">' . e($kopf) . '</h2>' : '')
                    . implode('', array_map(fn($t) => pj_absaetze((string) $t), $texte))
                    . '</div>';
            }
            return $out;
    }
}

/**
 * Eine Projektkarte (Referenzen-Liste, „Weitere Projekte", später der Scroller).
 * $variante steuert die Collage der Referenzen-Übersicht: 'hoch' (Hochformat,
 * nimmt teaser_hoch, wenn Space ihn geliefert hat — sonst wird der Quer-Teaser
 * per CSS beschnitten), 'quer', 'gross' (doppelt breit); der Zusatz '-tief'
 * rückt die Karte nach unten (Versatz im Raster). Ohne Variante: schlichte
 * Karte fürs gleichmäßige Raster (Landingpages, „Weitere Projekte").
 */
function pj_karte(array $eintrag, string $variante = ''): string
{
    $tief = str_ends_with($variante, '-tief');
    $form = $tief ? substr($variante, 0, -5) : $variante;

    $bild  = $eintrag['teaser_quer'] ?? null;
    $sizes = '(max-width: 900px) 100vw, 33vw';
    if ($form === 'hoch' && !empty($eintrag['teaser_hoch']['quellen'])) {
        $bild = $eintrag['teaser_hoch'];
    }
    if ($form === 'gross') {
        $sizes = '(max-width: 900px) 100vw, 66vw';
    }

    $klassen = 'pj-karte' . ($form !== '' ? ' pj-k-' . e($form) : '') . ($tief ? ' pj-k-tief' : '');
    $url = '/referenzen/' . e($eintrag['slug'] ?? '') . '/';
    $out = '<a class="' . $klassen . '" href="' . $url . '">';
    $out .= '<span class="pj-karte-bildwrap">'
          . pj_bild($bild, 'pj-karte-bild', $sizes);
    $saeule = PJ_SAEULEN[$eintrag['saeule'] ?? ''][0] ?? null;
    if ($saeule) {
        $out .= '<span class="chip pj-karte-chip">' . e($saeule) . '</span>';
    }
    $out .= '</span>';
    if (!empty($eintrag['kunde'])) {
        $out .= '<span class="pj-karte-kunde">' . e($eintrag['kunde']) . '</span>';
    }
    $out .= '<span class="pj-karte-titel">' . e((string) ($eintrag['titel'] ?? '')) . '</span>';
    if (!empty($eintrag['punchline'])) {
        $out .= '<span class="pj-karte-punchline">' . e($eintrag['punchline']) . '</span>';
    }
    return $out . '</a>';
}

/**
 * Kundenstimme als schwarzer, leicht gedrehter Block zwischen den Karten der
 * Referenzen-Übersicht. Kommt aus den Feldern zitat/zitat_von des Eintrags
 * (optional, gepflegt in Space) — ohne Zitat gibt es keinen Block.
 */
function pj_zitat(array $eintrag): string
{
    // Anführungszeichen setzt die Ausgabe selbst — doppelte vermeiden.
    $text = trim(trim((string) ($eintrag['zitat'] ?? '')), "„“\"");
    if ($text === '') {
        return '';
    }
    $out = '<figure class="pj-zitat"><blockquote><p>„' . e($text) . '“</p></blockquote>';
    if (!empty($eintrag['zitat_von'])) {
        $out .= '<figcaption>' . e((string) $eintrag['zitat_von']) . '</figcaption>';
    }
    return $out . '</figure>';
}
