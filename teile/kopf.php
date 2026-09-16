<?php
// Seitenkopf: HTML-Anfang, Meta-Angaben, JSON-LD und Navigation.
// Jede Seite setzt VOR dem Einbinden: $titel (Browser-Tab/Suchergebnis)
// und $beschreibung (Meta-Description, ~155 Zeichen).
// Optional: $brotkrumen = [['Name', '/pfad/'], …] für die BreadcrumbList,
//           $jsonld_extra = fertiges Schema-Array (z. B. CreativeWork),
//           $styles = ['/assets/….css'] für zusätzliche Stylesheets.

require_once __DIR__ . '/firma.php';

// e() macht Text sicher für HTML-Ausgabe — für ALLES verwenden, was nicht
// wörtlich hier im Quelltext steht (Projektdaten, URL-Teile usw.).
if (!function_exists('e')) {
    function e(string $s): string { return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }
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
?>
<!doctype html>
<html lang="de-AT">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($titel) ?></title>
<meta name="description" content="<?= e($beschreibung) ?>">
<link rel="canonical" href="<?= e($kanonisch) ?>">
<link rel="stylesheet" href="/assets/site.css">
<?php foreach ($styles ?? [] as $css): ?>
<link rel="stylesheet" href="<?= e($css) ?>">
<?php endforeach; ?>
<?php foreach ($jsonld as $block): ?>
<script type="application/ld+json"><?= json_encode($block, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>
<?php endforeach; ?>
</head>
<body>
<header class="kopf">
  <nav class="kopf-nav" aria-label="Hauptnavigation">
    <a class="kopf-marke" href="/"><?= e(FIRMA_KURZ) ?></a>
    <ul class="kopf-menue">
      <?php foreach ($nav as [$pfad, $label]): ?>
      <li><a href="/<?= e($pfad) ?>/"<?= $nav_aktiv === $pfad ? ' aria-current="page"' : '' ?>><?= e($label) ?></a></li>
      <?php endforeach; ?>
    </ul>
  </nav>
</header>
<main class="inhalt">
