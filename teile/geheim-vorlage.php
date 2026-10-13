<?php
// VORLAGE für teile/geheim.php — die echte Datei liegt NIE im Repo
// (.gitignore): Am Server erzeugt sie die Deploy-Action aus dem
// GitHub-Secret BREVO_KEY; lokal kopiert man diese Vorlage zu
// teile/geheim.php und trägt den Schlüssel ein (Testkopien schicken
// aber ohnehin keine externen Anfragen — siehe Newsletter-Handler).
define('BREVO_KEY', '');            // API-Schlüssel (xkeysib-…)
define('BREVO_LISTE', 10);          // Brevo-Listen-ID „Empty Space"
define('BREVO_DOI_VORLAGE', 2);     // ID der Double-Opt-in-Vorlage (angelegt 13.10.2026)
