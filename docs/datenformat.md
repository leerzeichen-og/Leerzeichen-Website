# Datenformat: Space → Website

Space legt per FTPS Dateien unter `daten/` und `bilder/` ab; die Website
rendert sie. Dieses Dokument ist der Vertrag zwischen beiden Seiten —
Änderungen hier müssen beide Repos kennen (Space: `modules/portfolio/website.php`).

## daten/projekte/index.json

Liste aller veröffentlichten Projekte, neueste zuerst (Jahr, dann Anlage):

```json
{
  "stand": "2026-09-16T12:00:00+02:00",
  "projekte": [
    {
      "slug": "gefangen-im-ewigen-eis",
      "titel": "Gefangen im ewigen Eis",
      "kunde": "Museum XY",
      "jahr": 2026,
      "saeule": "erlebnisse",
      "punchline": "Eine Ausstellung, die …",
      "startseite": "top",
      "teaser_quer": { …Bild-Objekt, siehe unten… }
    }
  ]
}
```

- `saeule`: `erlebnisse` oder `gestaltung` (die zwei Säulen der Positionierung).
- `startseite`: `top`, `erlebnisse`, `gestaltung` oder nicht gesetzt —
  bestimmt die vier Plätze im Startseiten-Scroller.

## daten/projekte/{slug}.json

Der vollständige Beitrag:

```json
{
  "slug": "…", "titel": "…", "kunde": "…", "jahr": 2026,
  "saeule": "erlebnisse",
  "schlagworte": ["Ausstellung", "Leitsystem"],
  "punchline": "…",
  "texte": {
    "kurzbeschreibung": "…", "aufgabenstellung": "…", "loesung": "…",
    "detail_01": "…", "detail_02": "…", "zusammenfassung": "…",
    "call_to_action": "…"
  },
  "credits": [ { "bereich": "Konzept", "person": "Roman Dachsberger" } ],
  "bilder": {
    "header":  { …Bild-Objekt… },
    "foto_01": { }, "foto_02": { }, "foto_04": { }, "foto_05": { },
    "teaser_quer": { }
  },
  "stand": "2026-09-16T12:00:00+02:00"
}
```

- **Texte sind Klartext**, Absätze durch Leerzeile getrennt. Die Website
  macht daraus `<p>`-Absätze und escapet alles — es gibt kein HTML in den Daten.
- Fehlende Texte/Bilder: Schlüssel weglassen oder leer — die Website lässt
  den Block dann aus (wie bisher der Shortcode).

## Bild-Objekt

```json
{
  "alt": "Blick in den Ausstellungsraum …",
  "beschreibung": "",
  "breite": 2560, "hoehe": 1440,
  "quellen": [
    { "datei": "/bilder/projekte/{slug}/header-640.webp",  "breite": 640 },
    { "datei": "/bilder/projekte/{slug}/header-1280.webp", "breite": 1280 },
    { "datei": "/bilder/projekte/{slug}/header-2560.webp", "breite": 2560 }
  ]
}
```

- `quellen` sind dieselbe Datei in mehreren Breiten → daraus baut die Website
  `srcset` (das hat früher WordPress erledigt). Empfohlene Stufen: 640, 1280,
  1920 und die Zielgröße des Slots. `breite`/`hoehe` beziehen sich auf die
  größte Fassung und verhindern Layout-Springen beim Laden.
- Pfade beginnen mit `/bilder/…` (absolut zur Website-Wurzel).

## Verantwortlichkeiten

- **Space schreibt, die Website liest** — nie umgekehrt.
- Depublizieren: Space löscht `{slug}.json` + Bilder und schreibt index.json neu.
- Die Deploy-Action der Website fasst `daten/` und `bilder/` nie an.
