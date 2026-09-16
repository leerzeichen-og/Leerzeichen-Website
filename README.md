# leerzeichen.at — Website

Handgeschriebene Website von Leerzeichen Multimedia. Schlichtes PHP ohne
Framework, ohne Build-Schritt: **Was hier liegt, ist exakt das, was am Server
läuft.** Konzept und Inhalte: `SPEC-website.md` und `BRIEFING-website.md`
im Space-Repo unter `docs/`.

## Wie die Seite funktioniert

- **Ordner = URL.** `/agentur/index.php` ist die Seite `/agentur/`. Eine neue
  Seite = neuer Ordner mit `index.php` darin.
- Jede Seite setzt oben `$titel` und `$beschreibung` und bindet dann
  `teile/kopf.php` (HTML-Kopf, Navigation, Meta, JSON-LD) und am Ende
  `teile/fuss.php` (Footer) ein. Dazwischen steht normales HTML.
- Firmendaten (Adresse, Telefon, …) stehen **einmal** in `teile/firma.php`
  und werden überall von dort geholt — nie irgendwo abtippen, die
  Schreibweise muss überall zeichengleich sein (lokale Auffindbarkeit).
- Gestaltung: `assets/site.css`. Farben, Schriftgrößen und Abstände sind
  Variablen (`--…`) ganz oben in der Datei — dort ändern, nicht in den Regeln.
- Projektseiten (`/referenzen/…`) kommen aus Space: Space legt JSON-Dateien
  unter `daten/` und Bilder unter `bilder/` ab, die Templates hier rendern sie.
  `daten/` und `bilder/` liegen deshalb NICHT im Repo.

## Wie ändere ich einen Text?

Datei der Seite öffnen (z. B. `agentur/index.php`), Text im HTML ändern,
committen, pushen — fertig (siehe Deployment).

## Wie sehe ich die Seite lokal an?

    php -S localhost:8080

im Repo-Ordner starten, dann http://localhost:8080 im Browser öffnen.
(PHP einmalig installieren: `brew install php`.)

## Wie prüfe ich vor dem Push?

    bash tools/rauchtest.sh

Prüft die Syntax aller PHP-Dateien und ruft jede Seite einmal auf.
Die Deploy-Action macht dasselbe und lädt bei Fehlern nicht hoch.

## Deployment

Push auf `main` → GitHub Action lädt per FTPS auf den Webspace
(`.github/workflows/deploy.yml`). Der FTP-Benutzer ist direkt im
Zielverzeichnis der Website verankert (`server-dir: ./` im Workflow).
Secrets im GitHub-Repo: `LEERZEICHENAT_FTP_HOST`, `LEERZEICHENAT_FTP_USER`,
`LEERZEICHENAT_FTP_PWD`. Nicht hochgeladen werden `.md`-Dateien, `tools/`
und `docs/` — und `daten/`/`bilder/` werden am Server **nie angetastet**
(sie gehören Space).

## Server

All-Inkl, PHP 8.5 (in den Domain-Einstellungen festgelegt). Kein MySQL,
kein Backend, keine Anmeldung — die Website liest nur Dateien.
