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
    return '<img class="' . e($klasse) . '"'
        . ' src="' . e($groesste['datei']) . '"'
        . ' srcset="' . $srcset . '"'
        . ' sizes="' . e($sizes) . '"'
        . (!empty($bild['breite']) ? ' width="' . (int) $bild['breite'] . '" height="' . (int) $bild['hoehe'] . '"' : '')
        . ' alt="' . e((string) ($bild['alt'] ?? '')) . '"'
        . ' decoding="async"'
        . ($zuerst ? ' loading="eager" fetchpriority="high"' : ' loading="lazy"')
        . '>';
}

/** Eine Projektkarte (Referenzen-Liste, „Weitere Projekte", später der Scroller). */
function pj_karte(array $eintrag): string
{
    $url = '/referenzen/' . e($eintrag['slug'] ?? '') . '/';
    $out = '<a class="pj-karte" href="' . $url . '">';
    $out .= '<span class="pj-karte-bildwrap">'
          . pj_bild($eintrag['teaser_quer'] ?? null, 'pj-karte-bild', '(max-width: 900px) 100vw, 33vw');
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
