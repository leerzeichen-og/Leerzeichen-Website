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
      "schlagworte": ["Ausstellung", "Leitsystem"],
      "startseite": "top",
      "zitat": "Wir wollten einen Weg, der …",
      "zitat_von": "Herta Aubach, Bürgermeisterin",
      "teaser_quer": { …Bild-Objekt, siehe unten… },
      "teaser_hoch": { …Bild-Objekt… },
      "objekt": { …Bild-Objekt… }
    }
  ]
}
```

- `saeule`: `erlebnisse` oder `gestaltung` (die zwei Säulen der Positionierung).
- `startseite`: `top`, `erlebnisse`, `gestaltung` oder nicht gesetzt —
  bestimmt die vier Plätze im Startseiten-Scroller.
- `zitat`/`zitat_von` (seit 21.9.2026, optional): **Kundenstimme** — die
  Referenzen-Übersicht streut sie als schwarze Blöcke zwischen die Karten.
  Klartext ohne Anführungszeichen (setzt die Website), `zitat_von` als eine
  Zeile „Name, Rolle". Beide stehen auch im Beitrags-JSON.
- `teaser_hoch` (seit 21.9.2026, optional): Hochformat-Teaser (1120×1520) für
  die Hochformat-Karten der Collage; fehlt er, beschneidet die Website den
  Quer-Teaser per CSS.
- `objekt` (seit 16.9.2026): **freigestelltes Objekt** des Projekts —
  transparentes WebP/PNG, das stellvertretend fürs Projekt steht. Schwebt auf
  der Startseiten-Bühne (nur Projekte mit `objekt` fliegen dort mit, höchstens
  acht) und ist als Slot auch im Beitrags-JSON zulässig. Contain, keine feste
  Zielgröße; empfohlene Breitenstufen 320/640/960.

## daten/projekte/{slug}.json

Der vollständige Beitrag — **Modul-Format seit 7.10.2026** (Space:
`portfolio_module`, exportiert in `ws_push()`):

```json
{
  "slug": "…", "titel": "…", "kunde": "…", "jahr": 2026,
  "saeule": "erlebnisse",
  "schlagworte": ["Ausstellung", "Leitsystem"],
  "punchline": "…",
  "zitat": "…", "zitat_von": "…",
  "module": [
    { "art": "header",
      "texte": ["Kurzbeschreibung …"],
      "bilder": [ { …Bild-Objekt… } ] },
    { "art": "foto_text",
      "ueberschrift": "optional",
      "texte": ["…"],
      "bilder": [ { …Bild- oder Video-Objekt… } ] }
  ],
  "cta": "Sie haben einen Ort, der mehr erzählen könnte?",
  "credits": [ { "bereich": "Konzept", "person": "Roman Dachsberger" } ],
  "bilder": {
    "teaser_quer": { …Bild-Objekt… },
    "teaser_hoch": { },
    "objekt": { }
  },
  "stand": "2026-10-12T12:00:00+02:00"
}
```

- `module` steht in **Seitenreihenfolge**. Je Modul: `art` (Pflicht),
  `ueberschrift` (optional, nur wenn gesetzt), `texte` (nur wenn vorhanden,
  1–2 Klartexte je nach Art), `bilder` (immer, ggf. leer).
- Die Website rendert das **erste `header`-Modul als Seitenkopf** (Bild
  randlos, Titel darüber; sein Text ist der Lead). Alle weiteren Module
  laufen in Reihenfolge.
- `cta` (Klartext) und `credits` stehen **außerhalb** — die Website zeigt
  beide IMMER ganz unten, sie sind kein Modul.
- `bilder` enthält nur noch die festen Slots `teaser_quer`, `teaser_hoch`
  und `objekt` (Karten, Collage, Startseiten-Bühne).
- **Texte sind Klartext**, Absätze durch Leerzeile getrennt. Die Website
  macht daraus `<p>`-Absätze und escapet alles — kein HTML in den Daten.
- Eine der Website **unbekannte `art`** bricht nichts: Sie wird wie
  `foto_text` gerendert (erstes Bild + Texte).
- **Übergang:** Beiträge im alten Format (`texte{}` + feste Bildnamen
  `header`/`foto_01`…`foto_05`, `call_to_action` in `texte`) rendert die
  Website weiterhin, bis Space alle Einträge neu gepusht hat.

### Modularten

| `art` | Bilder | Texte | `ueberschrift` | Website |
| --- | --- | --- | --- | --- |
| `header` | 1 | 1 | nein | Seitenkopf: Bild randlos 100svh, Titel darauf; Text = Lead |
| `foto_text` | 1 | 1 | ja | Bild randlos, darunter Text in der Lesespalte |
| `foto_details` | 1 | 2 | ja | Bild, darunter zwei Texte zweispaltig |
| `foto_zusammenfassung` | 1 | 1 | ja | wie `foto_text` (typisch der letzte Baustein) |
| `scroller` | 3–5 | 0 | nein | Reihe nebeneinander, wandert quer mit dem Seiten-Scroll (ohne JS wischbar) |
| `doppelbild` | 2 | 0 | nein | zwei Medien randlos nebeneinander, gleich hoch (cover um den Fokus) |

Videos sind überall zulässig, wo ein Modul-Bild stehen kann (nicht in den
festen Slots); die Website spielt sie stumm im Loop und hält sie bei
reduzierter Bewegung an.

## Bild-Objekt

```json
{
  "alt": "Blick in den Ausstellungsraum …",
  "beschreibung": "",
  "credit": "Foto: Atelier Lichtfang",
  "breite": 2560, "hoehe": 1440,
  "fokus": [0.5, 0.4],
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
- `credit` (seit 12.10.2026): **Bildcredit**, leerer String wenn keiner
  eingetragen ist. Die Website zeigt ihn um −90° gedreht in der rechten
  unteren Ecke des Mediums (von unten nach oben zu lesen, Differenz-Modus
  gegen das Motiv); leer = nichts. Gilt für Bilder UND Videos.
- `fokus` (seit 7.10.2026): Fokuspunkt `[x, y]` als Anteile 0–1. Beschnitten
  wird seit dem Modul-Format auf der **Website** (object-fit); der Fokus
  sagt ihr, welcher Bildteil stehen bleibt (object-position). Nur die
  Teaser liefert Space weiterhin fertig zugeschnitten.
- Pfade beginnen mit `/bilder/…` (absolut zur Website-Wurzel).

## Video-Objekt

```json
{
  "alt": "…", "beschreibung": "",
  "credit": "",
  "video": true, "mime": "video/mp4",
  "quellen": [ { "datei": "/bilder/projekte/{slug}/video-12-abc123.mp4", "breite": null } ]
}
```

- Die **Originaldatei**, keine Breitenstufen (der Server rechnet kein Video);
  `breite`, `hoehe` und `fokus` entfallen. Genau eine Quelle, `breite: null`.

## Verantwortlichkeiten

- **Space schreibt, die Website liest** — nie umgekehrt.
- Depublizieren: Space löscht `{slug}.json` + Bilder und schreibt index.json neu.
- Die Deploy-Action der Website fasst `daten/` und `bilder/` nie an.
