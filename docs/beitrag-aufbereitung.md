# Portfolio-Beitrag aufbereiten — alle Darstellungsmöglichkeiten

Anleitung für die redaktionelle Aufbereitung eines Portfolio-Beitrags auf
www.leerzeichen.at. Gepflegt wird der Beitrag im Space-Portal (Modul
Portfolio); dieses Dokument beschreibt, welche Bausteine die Website
darstellen kann, was jeder Baustein braucht und welche Bild- und Textmaße
optimal sind. Technischer Vertrag dahinter: `docs/datenformat.md`
(Stand: 12.11.2026).

## 1 · Aufbau einer Projektseite

Die Seite besteht aus frei anordenbaren **Inhalts-Modulen**. Fixe Rahmung:

1. **Header-Modul** — immer das erste Modul, bildet den Seitenkopf
2. Beliebige Folge weiterer Module (Reihenfolge frei wählbar)
3. **Call to Action + Credits** — stehen immer ganz unten, sind kein Modul
4. **Häufige Fragen** (optional) — Aufklapp-Liste unter CTA/Credits
5. „Weitere Projekte" derselben Säule — automatisch, nicht steuerbar

## 2 · Die sechs Inhalts-Module

### header (Pflicht, genau 1×, an erster Stelle)
- **Darstellung:** Bild randlos über die volle Bildschirmhöhe, Projekttitel
  groß darauf; der Text des Moduls ist der **Lead** der Seite (erster
  Absatz unter dem Kopf).
- **Braucht:** 1 Bild (oder Video) + 1 Text.
- **Bild:** Querformat, möglichst 2560 px breit. Wird vollflächig
  beschnitten (cover) — der **Fokuspunkt** entscheidet, was sichtbar
  bleibt; wichtige Motive nicht an die Ränder legen. Der Titel liegt
  weiß auf dem Bild: Motive mit ruhiger, eher dunkler Fläche funktionieren
  am besten.
- **Text:** 2–4 Sätze Kurzbeschreibung — worum ging es, was wurde gebaut.

### foto_text
- **Darstellung:** Bild randlos in voller Breite (Original-Seitenverhältnis,
  unbeschnitten), darunter der Text in der Lesespalte; optional eine
  **Zwischenüberschrift** über dem Text.
- **Braucht:** 1 Bild/Video + 1 Text, optional `ueberschrift`.
- **Einsatz:** das Arbeitspferd — Aufgabenstellung, Lösung, einzelne Kapitel.

### foto_details
- **Darstellung:** Bild randlos, darunter **zwei Texte nebeneinander**
  (zweispaltig, am Telefon untereinander); optional Zwischenüberschrift.
- **Braucht:** 1 Bild/Video + 2 Texte.
- **Einsatz:** zwei gleichwertige Detail-Aspekte (z. B. Material + Technik).
  Die beiden Texte sollten ähnlich lang sein (je 1–3 Sätze).

### foto_zusammenfassung
- **Darstellung:** wie foto_text.
- **Einsatz:** typisch der letzte Baustein — Ergebnis, Wirkung, Bilanz.

### scroller
- **Darstellung:** 3–5 Medien in einer Reihe. Das Modul bleibt beim
  Erreichen im Fenster stehen, die Reihe fährt quer — 1 Pixel scrollen =
  1 Pixel Fahrt, erstes und letztes Bild stehen in Ruhe im Bild. Höhe am
  Desktop bis 680 px (62 % Fensterhöhe), am Telefon 42 %.
- **Braucht:** 3–5 Bilder/Videos, keine Texte.
- **Bilder:** werden über die **Höhe** vereinheitlicht, die Breite ergibt
  sich aus dem Seitenverhältnis — Hoch- und Querformate sind mischbar und
  machen die Reihe lebendig. Masterhöhe mindestens 1360 px.
- **Einsatz:** Bilderserien — Stationen eines Wegs, Seiten einer
  Publikation, Varianten eines Motivs.

### doppelbild
- **Darstellung:** zwei Medien randlos nebeneinander, beide gleich hoch
  im Format 4:3 beschnitten (cover um den Fokuspunkt); am Telefon
  untereinander.
- **Braucht:** genau 2 Bilder/Videos, keine Texte.
- **Einsatz:** Paare — vorher/nachher, Detail + Totale, zwei
  gleichberechtigte Motive. Fokuspunkt setzen, weil beschnitten wird.

## 3 · Medien

### Bilder
- **Upload in Space:** WebP, JPG oder PNG — kein TIFF, kein CMYK. Space
  rechnet alle Auslieferungsgrößen selbst (640/1280/1920 px + Ziel).
- **Mastergröße Modulbilder:** längste Kante **2560 px** (mehr bringt
  nichts, Space skaliert herunter); Original-Seitenverhältnis bleibt
  erhalten, außer bei header/doppelbild/Teasern (dort cover-Beschnitt
  um den Fokuspunkt).
- **Fokuspunkt** (Klick im Space-Editor): steuert bei allen beschnittenen
  Darstellungen, welcher Bildteil sichtbar bleibt. Bei Headern, Teasern
  und Doppelbildern immer bewusst setzen.
- **Je Bild pflegbar:** `alt` (Pflicht, beschreibt das Motiv — dient
  Screenreadern und Suchmaschinen), `beschreibung` (optional),
  `credit` (optional — steht klein und gedreht rechts unten IM Bild,
  z. B. „Foto: Atelier Lichtfang"; leer = kein Vermerk).

### Videos
- Überall erlaubt, wo ein Modul-Bild stehen kann (nicht in den festen
  Slots Teaser/Objekt). Formate MP4 (H.264 empfohlen), MOV, WebM.
- Die Datei geht **unverändert** an die Website (keine Renditions!) —
  deshalb klein halten: Zielgröße wenige MB, 1920 px Breite genügt,
  10–20 Sekunden. Läuft stumm in Schleife; Ton wird nie abgespielt.
- Bei „reduzierter Bewegung" im System steht das Video still.

## 4 · Feste Bild-Slots (außerhalb der Module)

| Slot | Zielmaß | Verwendung |
| --- | --- | --- |
| `teaser_quer` | **2288 × 1520 px** (Crop um Fokus) | Karten der Referenzen-Übersicht, „Weitere Projekte", Share-Bild (og:image) |
| `teaser_hoch` | **1120 × 1520 px** (Crop um Fokus) | Hochformat-Karten der Collage; fehlt er, wird der Quer-Teaser beschnitten |
| `objekt` | contain, max. **960 px**, transparent (WebP/PNG) | freigestelltes Motiv für die Startseiten-Bühne |

- Master für die Teaser mindestens in Zielgröße anliefern — Space warnt,
  wenn hochgerechnet werden müsste.
- **Objekt + Bühne:** Das freigestellte Objekt fliegt auf der Startseite.
  Je Projekt wählbar: `sofort` (schon im ersten Bild sichtbar) ·
  `spaeter` (rückt erst beim Scrollen nach, Vorgabe) · `aus` (fliegt
  nicht). Nur wenige Projekte auf „sofort" stellen — der erste Schirm hat
  vier Plätze.

## 5 · Texttypen außerhalb der Module

| Feld | Länge/Form | Wo es erscheint |
| --- | --- | --- |
| Titel | kurz, prägnant | Seitenkopf (auf dem Headerbild), Karten, Browser-Tab |
| Kunde | Name | Browser-Tab/Suchergebnis („Kunde — Titel"), Karten |
| Jahr | Jahreszahl | Sortierung (neueste zuerst), strukturierte Daten |
| Säule | `erlebnisse` oder `gestaltung` | Badge am Seitenkopf, Filter, Säulen-Seiten, „Weitere Projekte" |
| Schlagworte | 1–3 Begriffe | Kategorien der Referenzen-Übersicht (jedes Schlagwort = eine Gruppe, der Beitrag erscheint in jeder) |
| Punchline | **max. 180 Zeichen, Ziel ~155** | Meta-Description (der Werbetext im Google-Ergebnis!) und Karten — der wichtigste Einzeltext fürs Gefundenwerden |
| Zitat + zitat_von | 1–3 Sätze Klartext, ohne Anführungszeichen; Quelle als „Name, Rolle" | schwarzer Zitat-Block in der Referenzen-Übersicht (Kundenstimme — nie erfinden, nur echte Aussagen) |
| CTA | 1 Satz/Frage, Klartext | plakativ ganz unten auf der Projektseite, mit Kontakt-Knopf |
| Credits | Paare „Bereich → Person/Firma" | Liste neben dem CTA |
| FAQ | je Eintrag Frage (< 120 Zeichen, mit Fragezeichen) + Antwort (2–4 Sätze) | Aufklapp-Liste unter CTA/Credits **plus FAQPage-JSON-LD** — zahlt direkt auf Auffindbarkeit in Suchmaschinen und KI-Antworten ein |

Alle Texte sind **Klartext** — kein HTML, keine Markdown-Auszeichnung.
Absätze innerhalb eines Modultexts durch Leerzeile trennen.

## 6 · Redaktionelle Faustregeln

- **Umfang:** Ein guter Beitrag hat über alle Module zusammen rund
  **2.000–2.200 Zeichen** Text — weniger wirkt dünn, mehr wiederholt sich.
- **Vollständig** heißt: Teaser quer + hoch · Header-Modul mit Bild und
  Text · mindestens 2 weitere Inhalts-Module · Säule · Schlagwort ·
  mindestens 1 Credit. (Punchline, Zitat, FAQ und Objekt sind optional,
  aber Punchline und FAQ zahlen am stärksten auf SEO ein.)
- **Bewährte Modulfolge:** header (Lead) → foto_text „Die Aufgabe" →
  scroller oder doppelbild (zeigen statt beschreiben) → foto_text
  „Die Lösung" → foto_details (zwei Detail-Aspekte) →
  foto_zusammenfassung (Ergebnis). Variieren erwünscht — nicht jeder
  Beitrag braucht alle Arten.
- **Bildrhythmus:** randlose Einzelbilder (foto_text) und dichte Serien
  (scroller/doppelbild) abwechseln; maximal ein Scroller je Seite wirkt
  am stärksten.
- **Zwischenüberschriften** sparsam — sie gliedern lange Seiten, aber
  nicht jedes Modul braucht eine.
