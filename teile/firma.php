<?php
// Firmendaten — die EINZIGE Stelle, an der Adresse, Telefon usw. stehen.
// Wichtig für die lokale Auffindbarkeit: Diese Schreibweisen müssen mit dem
// Google-Unternehmensprofil und Branchenverzeichnissen zeichengleich sein.

const FIRMA_NAME      = 'leerzeichen multimedia og';
const FIRMA_KURZ      = 'leerzeichen';
const FIRMA_STRASSE   = 'Marktplatz 1';
const FIRMA_PLZ       = '3371';
const FIRMA_ORT       = 'Neumarkt an der Ybbs';
const FIRMA_LAND      = 'AT';
const FIRMA_TELEFON   = '+43 7412 53638';
const FIRMA_MAIL      = 'office@leerzeichen.at';
const FIRMA_GEGRUENDET = '2008';
const FIRMA_URL       = 'https://www.leerzeichen.at';

// Geokoordinaten des Standorts fürs JSON-LD.
// TODO Roman: prüfen (Google Maps → Rechtsklick auf das Rathaus → Koordinaten).
const FIRMA_GEO_LAT   = '48.1418';
const FIRMA_GEO_LON   = '15.0575';

// Social-Profile für JSON-LD "sameAs" — ergänzen, sobald entschieden ist,
// welche Profile öffentlich verlinkt werden sollen.
const FIRMA_PROFILE = [
    // 'https://www.instagram.com/…',
    // 'https://www.linkedin.com/company/…',
];
