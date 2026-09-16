<?php
// Erzeugt die sitemap.xml (die .htaccess leitet /sitemap.xml hierher).
// Quellen: die feste Seitenliste unten + die Projekte aus daten/projekte/index.json.
// Newsletter-Bestätigungsseiten und 404 gehören NICHT in die Sitemap.

require_once __DIR__ . '/teile/firma.php';

$seiten = [
    '/',
    '/erlebnisgestaltung/',
    '/grafikdesign/',
    '/referenzen/',
    '/agentur/',
    '/kontakt/',
    '/kontakt/impressum/',
    '/kontakt/datenschutzerklaerung/',
    '/kontakt/agb/',
];

// Projekte ergänzen, sobald Space welche abgelegt hat.
$index = @file_get_contents(__DIR__ . '/daten/projekte/index.json');
if ($index !== false) {
    foreach ((json_decode($index, true)['projekte'] ?? []) as $projekt) {
        if (!empty($projekt['slug'])) {
            $seiten[] = '/referenzen/' . $projekt['slug'] . '/';
        }
    }
}

header('Content-Type: application/xml; charset=utf-8');
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
echo "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";
foreach ($seiten as $pfad) {
    echo '  <url><loc>' . htmlspecialchars(FIRMA_URL . $pfad, ENT_QUOTES) . "</loc></url>\n";
}
echo "</urlset>\n";
