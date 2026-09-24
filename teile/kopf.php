<?php
// Seitenkopf: HTML-Anfang, Meta-Angaben, JSON-LD und Navigation.
// Jede Seite setzt VOR dem Einbinden: $titel (Browser-Tab/Suchergebnis)
// und $beschreibung (Meta-Description, ~155 Zeichen).
// Optional: $brotkrumen = [['Name', '/pfad/'], …] für die BreadcrumbList,
//           $jsonld_extra = fertiges Schema-Array (z. B. CreativeWork),
//           $styles = ['/assets/….css'] für zusätzliche Stylesheets,
//           $voll_breit = true lässt <main> ohne Lesespalten-Begrenzung
//           (Startseite: die Sektionen bringen ihre Ränder selbst mit).

require_once __DIR__ . '/firma.php';

// e() macht Text sicher für HTML-Ausgabe — für ALLES verwenden, was nicht
// wörtlich hier im Quelltext steht (Projektdaten, URL-Teile usw.).
if (!function_exists('e')) {
    function e(string $s): string { return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }
}

// lz_asset(): hängt die Änderungszeit der Datei als ?v= an CSS/JS-Adressen.
// Ändert sich die Datei, ändert sich ihre Adresse — Browser können nie mehr
// ein veraltetes Stylesheet aus dem Cache zeigen (passiert am 17.9.2026).
// lz_pfeil(): der lange Leerzeichen-Pfeil (assets/long-long-pfeil.svg) als
// Inline-SVG — erbt die Schriftfarbe des umgebenden Elements.
if (!function_exists('lz_pfeil')) {
    function lz_pfeil(): string
    {
        return '<svg viewBox="0 0 63.611 14.4" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">'
             . '<path fill="currentColor" d="M54.906,12.9l4.622-4.622H0V6.125H59.528L54.906,1.5,56.412,0l7.2,7.2-7.2,7.2Z"/></svg>';
    }
}

// lz_laufband(): das Leistungs-Laufband — eine geneigte, nahtlos laufende
// Bahn (Inhalt doppelt, aria-hidden); bei reduzierter Bewegung steht sie
// als umbrechende Liste. Klassen: kipp-a/kipp-b (Neigung), laufband-retour.
if (!function_exists('lz_laufband')) {
    function lz_laufband(array $liste, string $klassen): string
    {
        $teile = '';
        foreach ($liste as $l) {
            $teile .= '<span>' . e($l) . '</span><i aria-hidden="true"></i>';
        }
        return '<div class="laufbaender" aria-label="Unsere Leistungen">'
             . '<div class="laufband ' . e($klassen) . '"><div class="laufband-spur">'
             . '<span class="laufband-teil">' . $teile . '</span>'
             . '<span class="laufband-teil" aria-hidden="true">' . $teile . '</span>'
             . '</div></div></div>';
    }
}

if (!function_exists('lz_asset')) {
    function lz_asset(string $pfad): string
    {
        $datei = dirname(__DIR__) . $pfad;
        return $pfad . (is_file($datei) ? '?v=' . filemtime($datei) : '');
    }
}

$titel        = $titel        ?? FIRMA_KURZ;
$beschreibung = $beschreibung ?? '';

// Kanonische Adresse dieser Seite: Pfad ohne Parameter, an FIRMA_URL gehängt.
$kanonisch = FIRMA_URL . strtok($_SERVER['REQUEST_URI'] ?? '/', '?');

// --- JSON-LD: auf jeder Seite ProfessionalService + WebSite --------------
$jsonld = [
    [
        '@context' => 'https://schema.org',
        '@type'    => 'ProfessionalService',
        'name'     => FIRMA_NAME,
        'url'      => FIRMA_URL,
        'telephone' => FIRMA_TELEFON,
        'foundingDate' => FIRMA_GEGRUENDET,
        'address'  => [
            '@type' => 'PostalAddress',
            'streetAddress'   => FIRMA_STRASSE,
            'postalCode'      => FIRMA_PLZ,
            'addressLocality' => FIRMA_ORT,
            'addressCountry'  => FIRMA_LAND,
        ],
        'geo' => ['@type' => 'GeoCoordinates', 'latitude' => FIRMA_GEO_LAT, 'longitude' => FIRMA_GEO_LON],
        'areaServed' => 'Österreich',
    ] + (FIRMA_PROFILE ? ['sameAs' => FIRMA_PROFILE] : []),
    [
        '@context' => 'https://schema.org',
        '@type'    => 'WebSite',
        'name'     => FIRMA_KURZ,
        'url'      => FIRMA_URL,
        'publisher' => ['@type' => 'Organization', 'name' => FIRMA_NAME],
    ],
];
// Brotkrumen auf Unterseiten (die Startseite hat keine).
if (!empty($brotkrumen)) {
    $stufen = [['@type' => 'ListItem', 'position' => 1, 'name' => 'Startseite', 'item' => FIRMA_URL . '/']];
    foreach ($brotkrumen as $i => [$name, $pfad]) {
        $stufen[] = ['@type' => 'ListItem', 'position' => $i + 2, 'name' => $name, 'item' => FIRMA_URL . $pfad];
    }
    $jsonld[] = ['@context' => 'https://schema.org', '@type' => 'BreadcrumbList', 'itemListElement' => $stufen];
}
if (!empty($jsonld_extra)) {
    $jsonld[] = $jsonld_extra;
}

// Aktive Seite für die Navigation (erster Pfadteil der Adresse).
$nav_aktiv = explode('/', trim(strtok($_SERVER['REQUEST_URI'] ?? '/', '?'), '/'))[0];
$nav = [
    ['erlebnisgestaltung', 'Erlebnisse'],
    ['grafikdesign',       'Gestaltung'],
    ['referenzen',         'Referenzen'],
    ['agentur',            'Agentur'],
    ['kontakt',            'Kontakt'],
];

// HTML nie ungefragt aus dem Browser-Cache: Ohne diesen Header raten Browser
// die Gültigkeit und zeigen tagelang alte Seiten — samt alter ?v=-Adressen,
// womit auch lz_asset() ins Leere läuft (passiert am 21.9.2026, Referenzen).
// „no-cache" heißt: speichern erlaubt, aber vor jeder Anzeige nachfragen.
header('Cache-Control: no-cache');
?>
<!doctype html>
<html lang="de-AT">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($titel) ?></title>
<meta name="description" content="<?= e($beschreibung) ?>">
<link rel="canonical" href="<?= e($kanonisch) ?>">
<link rel="preload" href="/assets/fonts/ArticulatCF-Medium.woff2" as="font" type="font/woff2" crossorigin>
<link rel="stylesheet" href="<?= e(lz_asset('/assets/fonts.css')) ?>">
<link rel="stylesheet" href="<?= e(lz_asset('/assets/site.css')) ?>">
<?php foreach ($styles ?? [] as $css): ?>
<link rel="stylesheet" href="<?= e(lz_asset($css)) ?>">
<?php endforeach; ?>
<script src="<?= e(lz_asset('/assets/kopf.js')) ?>" defer></script>
<?php foreach ($jsonld as $block): ?>
<script type="application/ld+json"><?= json_encode($block, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>
<?php endforeach; ?>
</head>
<body>
<?php
// Die Kopfzeile wird ZWEIMAL gezeichnet (deckungsgleich): die echte im
// Mischmodus „difference" (färbt sich gegen den Hintergrund um) und eine
// nicht bedienbare Schicht im Mischmodus „color" direkt darüber — sie
// entsättigt das Differenz-Ergebnis, Logo und Navigation bleiben damit
// schwarz/weiß statt bunt (Roman, 24.9.2026). $bedienbar steuert, ob Links
// und Knopf echt sind (die Kopie darf weder Klicks noch Fokus bekommen).
function lz_kopf_inhalt(array $nav, string $aktiv, bool $bedienbar): void
{
    $a = $bedienbar ? 'a href="/"' : 'a';
?>
  <<?= $a ?> aria-label="Zur Startseite">
    <img class="lz-logo" src="/assets/logo/leerzeichen-logo-neg.svg" alt="<?= $bedienbar ? e(FIRMA_NAME) : '' ?>" width="316" height="41">
  </a>
  <nav class="lz-nav"<?= $bedienbar ? ' aria-label="Hauptnavigation"' : '' ?>>
    <?php foreach ($nav as [$pfad, $label]): ?>
    <a<?= $bedienbar ? ' href="/' . e($pfad) . '/"' : '' ?><?= $aktiv === $pfad ? ' aria-current="page"' : '' ?>><?= e($label) ?></a>
    <?php endforeach; ?>
  </nav>
  <?php // Burger fürs Telefon — bleibt versteckt, bis kopf.js ihn verdrahtet. ?>
  <?php if ($bedienbar): ?>
  <button type="button" class="lz-burger" aria-expanded="false" aria-controls="lz-menue"
    aria-label="Menü öffnen" hidden><i></i><i></i><i></i></button>
  <?php else: ?>
  <span class="lz-burger" hidden><i></i><i></i><i></i></span>
  <?php endif; ?>
<?php
}
?>
<header class="lz-header">
  <?php lz_kopf_inhalt($nav, $nav_aktiv, true) ?>
</header>
<div class="lz-header lz-header-farblos" aria-hidden="true">
  <?php lz_kopf_inhalt($nav, $nav_aktiv, false) ?>
</div>

<?php // Vollbild-Menü fürs Telefon: schwarz, weiße Links; auf und zu über
      // den Burger (kopf.js). Ohne JavaScript bleibt die Zeilen-Navigation. ?>
<div id="lz-menue" class="lz-menue">
  <nav aria-label="Hauptnavigation">
    <?php foreach ($nav as [$pfad, $label]): ?>
    <a href="/<?= e($pfad) ?>/"<?= $nav_aktiv === $pfad ? ' aria-current="page"' : '' ?>><?= e($label) ?></a>
    <?php endforeach; ?>
  </nav>
</div>
<main<?= empty($voll_breit) ? ' class="inhalt"' : '' ?>>
