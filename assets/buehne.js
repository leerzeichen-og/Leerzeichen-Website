// Scroll-Bühne der Startseite — schlichtes JavaScript, kein Framework.
// Portiert aus dem Claude-Design-Entwurf (scroll-buehne.jsx, 16.9.2026):
// Projekt-Objekte fliegen über den ersten Bildschirm, drei Fragen erscheinen
// wortweise am Scroll-Fortschritt, danach blendet die dunkle Fläche mit dem
// Astronauten und der Antwort ein. Klick auf ein Objekt öffnet eine Karte.
//
// Fortschrittlich verbessert: Ohne dieses Skript (oder bei reduzierter
// Bewegung) bleibt die statische Fassung (#buehne-statisch) stehen; die
// Bühne selbst trägt `hidden`, bis hier alles verdrahtet ist.

(function () {
    'use strict';

    var buehne   = document.getElementById('buehne');
    var statisch = document.getElementById('buehne-statisch');
    if (!buehne || !statisch) return;
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

    // Umschalten mit `hidden` — nie mit display (bekannte Falle).
    buehne.hidden = false;
    statisch.hidden = true;

    var blick    = buehne.querySelector('.buehne-blick');
    var huelle   = buehne.querySelector('.buehne-objekte');
    var objekte  = Array.prototype.slice.call(buehne.querySelectorAll('.buehne-obj'));
    var fragen   = Array.prototype.slice.call(buehne.querySelectorAll('.buehne-frage'));
    var finale    = buehne.querySelector('.buehne-finale');
    var splash    = buehne.querySelector('.buehne-splash');
    var antwort   = buehne.querySelector('.buehne-antwort');
    var uebergang = buehne.querySelector('.buehne-uebergang');
    var fotoHalter = buehne.querySelector('.buehne-team-halter');

    // Wo läge das Foto, wenn der Splash steht? (Layout-Abstand Halter→Splash;
    // unabhängig von der Splash-Verschiebung, weil der Halter mitfährt.)
    var fotoLage = 0;
    function fotoVermessen() {
        if (!fotoHalter) return;
        // Eigene Verschiebung herausrechnen — beim Nachvermessen (load/resize)
        // ist der Halter meist schon transformiert.
        var m = new DOMMatrixReadOnly(getComputedStyle(fotoHalter).transform);
        fotoLage = fotoHalter.getBoundingClientRect().top - m.f - splash.getBoundingClientRect().top;
    }
    fotoVermessen();
    window.addEventListener('load', function () { fotoVermessen(); angefordert(); });
    window.addEventListener('resize', fotoVermessen);

    var klemm = function (v) { return Math.min(1, Math.max(0, v)); };

    // Höhe der Umlaufbahn in vh: Das Anzeigefenster reicht von −50 (weit
    // über dem Bild, Platz fürs größte Objekt) bis 150 (weit darunter).
    var SPANNE = 200;

    // --- Wörter der Fragen in Masken zerlegen — je Zeile (span.buehne-zeile),
    //     damit die im Markup festgelegten Umbrüche erhalten bleiben.
    fragen.forEach(function (f) {
        var zeilen = Array.prototype.slice.call(f.querySelectorAll('.buehne-zeile'));
        f.setAttribute('aria-label', zeilen.map(function (z) { return z.textContent.trim(); }).join(' '));
        zeilen.forEach(function (z) {
            var text = z.textContent.trim();
            z.textContent = '';
            text.split(/\s+/).forEach(function (wort) {
                var maske = document.createElement('span');
                maske.className = 'buehne-wort-maske';
                maske.setAttribute('aria-hidden', 'true');
                var w = document.createElement('span');
                w.textContent = wort;
                maske.appendChild(w);
                z.appendChild(maske);
            });
        });
    });

    // --- Zustand je Objekt: schwebt fast am Stand (kleines seitliches
    //     Treiben), die Höhe hängt am Scroll-Fortschritt (y0 − p·tiefe).
    var zustand = objekte.map(function (el) {
        return {
            el: el,
            x: parseFloat(el.dataset.x), y0: parseFloat(el.dataset.y0),
            tiefe: parseFloat(el.dataset.tiefe), vx: parseFloat(el.dataset.vx),
            w: parseFloat(el.dataset.w), h: parseFloat(el.dataset.h),
            y: parseFloat(el.dataset.y0)   // angezeigte Höhe (geglättet, s. fliegen)
        };
    });

    var auswahl = null;      // Index des geöffneten Objekts (pausiert den Flug)
    var karte   = null;      // DOM-Knoten der offenen Karte
    var pBeimOeffnen = 0;    // Scroll-Stand beim Öffnen (Weiterscrollen schließt)

    // --- Scroll-Fortschritt 0–1 über die ganze Sektion ------------------------
    var p = 0, leseTicket = 0;
    function lesen() {
        leseTicket = 0;
        var gesamt = Math.max(1, buehne.offsetHeight - window.innerHeight);
        p = klemm(-buehne.getBoundingClientRect().top / gesamt);
        // Scrollt jemand mit offener Karte weiter, zöge das Objekt unter dem
        // Zeiger weg — dann lieber sauber schließen.
        if (karte && Math.abs(p - pBeimOeffnen) > 0.008) {
            schliessen();
        }
        malenFortschritt();
    }
    function angefordert() { if (!leseTicket) leseTicket = requestAnimationFrame(lesen); }
    window.addEventListener('scroll', angefordert, { passive: true });
    window.addEventListener('resize', angefordert);

    // --- Was am Fortschritt hängt: Fragen, Finale, Objekt-Ausblenden ----------
    // Zeitplan (Anteile der Scrollstrecke, Stand 17.9.2026): drei Fragen →
    // das Übergangsbild (weiß→schwarz) scrollt herein und deckt die Bühne zu,
    // dahinter wird hart auf den schwarzen Akt umgeschaltet (unsichtbar, weil
    // gerade alles zugedeckt ist) → Antwort mit Knöpfen → der Splash scrollt
    // herein, darauf schwebt das Team-Foto.
    var FRAGEN_FENSTER = [[0.10, 0.26], [0.28, 0.44], [0.46, 0.62]];

    function malenFortschritt() {
        fragen.forEach(function (f, i) {
            var fenster = FRAGEN_FENSTER[i] || [0, 1];
            var t = (p - fenster[0]) / (fenster[1] - fenster[0]);
            if (t <= -0.05 || t >= 1.05) { f.style.visibility = 'hidden'; return; }
            f.style.visibility = '';
            var woerter = f.querySelectorAll('.buehne-wort-maske');
            for (var j = 0; j < woerter.length; j++) {
                var rein = klemm((t - j * 0.012) / 0.24);
                var raus = klemm((t - 0.82 - j * 0.005) / 0.16);
                var e = rein * rein * (3 - 2 * rein);
                var w = woerter[j].firstChild;
                w.style.opacity = e * (1 - raus);
                w.style.transform = 'translateY(' + ((1 - e) * 105 - raus * 55) + '%) rotate(' + ((1 - e) * 2.5) + 'deg)';
            }
        });

        var objWeg    = 1 - klemm((p - 0.52) / 0.06);  // Objekte gehen
        // Übergangsbild: 100vh (unter dem Bild) → -100vh (oben hinaus);
        // bei 0 deckt es den Bildschirm vollständig — dort wird dahinter
        // unsichtbar auf den schwarzen Akt geschaltet.
        var uIn       = klemm((p - 0.56) / 0.20);
        var schwarz   = uIn >= 0.5 ? 1 : 0;
        var textIn    = klemm((p - 0.72) / 0.04);      // Antwort erscheint, sobald das Bild die Mitte freigibt
        var textWeg   = klemm((p - 0.87) / 0.03);      // … hält, geht
        var splashIn  = klemm((p - 0.88) / 0.11);      // Splash scrollt herein

        huelle.style.opacity = objWeg;
        huelle.style.pointerEvents = objWeg < 0.5 ? 'none' : '';
        if (uebergang) {
            uebergang.style.transform = 'translateY(' + (100 - uIn * 200) + 'vh)';
        }
        finale.style.opacity = schwarz;
        finale.style.pointerEvents = schwarz ? 'auto' : 'none';
        var splashPx = (1 - splashIn) * innerHeight;
        splash.style.transform = 'translateY(' + splashPx + 'px)';
        if (fotoHalter) {
            // Das Foto ragt schon im Antwort-Akt von unten herein: gewünschte
            // Oberkante am Bildschirm — erst Vorschau (105→70 % der Höhe),
            // dann mit dem Splash an den Layout-Platz (Versatz wird 0).
            var blickIn = klemm((p - 0.76) / 0.10);
            var ziel = innerHeight * (1.05 - 0.35 * blickIn);
            if (splashIn > 0) {
                ziel = ziel + (fotoLage - ziel) * splashIn;
            }
            fotoHalter.style.transform = 'translateY(' + (ziel - fotoLage - splashPx) + 'px)';
        }
        antwort.style.opacity = textIn * (1 - textWeg);
        // Unsichtbare Knöpfe dürfen keine Klicks abfangen (Splash liegt darüber).
        antwort.style.pointerEvents = (textIn * (1 - textWeg)) > 0.5 ? 'auto' : 'none';
        antwort.style.transform = 'translateY(calc(-50% + ' + ((1 - textIn) * 28) + 'px))';
    }

    // --- Sanftes Treiben am Stand; die Höhe kommt vom Scrollen ------------------
    var zuletzt = performance.now();
    function fliegen(jetzt) {
        var dt = Math.min(64, jetzt - zuletzt) / 1000;
        zuletzt = jetzt;
        if (auswahl === null) {
            zustand.forEach(function (s) {
                s.x += s.vx * dt * 1.6;
                if (s.x > 100) s.x = -s.w;
                if (s.x < -s.w - 2) s.x = 100;
            });
        }
        zustand.forEach(function (s) {
            // Die Höhe folgt dem Scroll-Ziel GEGLÄTTET (Exponentialfilter):
            // Am Telefon kommen Scroll-Ereignisse ruckhaft hinter dem nativen
            // Scrollen her — ungefiltert sprangen die Objekte sichtbar
            // (Roman, 24.9.2026). So wird aus jedem Sprung eine weiche Fahrt.
            var ziel = s.y0 - p * s.tiefe;
            s.y += (ziel - s.y) * Math.min(1, dt * 8);
            if (Math.abs(ziel - s.y) < 0.01) s.y = ziel;
            // Umlaufbahn: erst zur Anzeige wird die Höhe in die Spanne
            // −50…150 vh gefaltet — wer oben hinausfliegt, kommt unten
            // wieder herein (geglättet wird die UNgefaltete Höhe, sonst
            // würde jeder Umlauf als schnelle Durchfahrt animiert).
            var zeig = ((s.y + 50) % SPANNE + SPANNE) % SPANNE - 50;
            s.el.style.transform = 'translate3d(' + s.x + 'vw,' + zeig + 'vh,0)';
        });
        requestAnimationFrame(fliegen);
    }

    // --- Karte: wächst aus dem angeklickten Objekt heraus -----------------------
    function schliessen() {
        auswahl = null;
        buehne.classList.remove('hat-karte');
        if (karte) { karte.remove(); karte = null; }
        huelle.classList.remove('hat-auswahl');
        objekte.forEach(function (el) { el.classList.remove('ist-auswahl'); });
    }

    function oeffnen(i) {
        schliessen();
        var el = objekte[i];
        var r  = el.getBoundingClientRect();
        var vw = window.innerWidth, vh = window.innerHeight;
        var W  = Math.min(400, vw * 0.86), rand = 16, luft = 22;
        var zwischen = function (v, min, max) { return Math.min(max, Math.max(min, v)); };

        karte = document.createElement('div');
        karte.className = 'buehne-karte';
        karte.style.width = W + 'px';
        karte.innerHTML =
            '<span class="chip"></span>' +
            '<h3 class="lz-h3"></h3>' +
            '<p class="lz-lead"></p>' +
            '<div style="display:flex;gap:12px;align-items:center;flex-wrap:wrap">' +
            '<a class="knopf"></a>' +
            '<button type="button" class="buehne-schliessen">schließen</button></div>';
        karte.querySelector('.chip').textContent = el.dataset.kat;
        karte.querySelector('h3').textContent = el.dataset.titel;
        karte.querySelector('p').textContent = el.dataset.punchline;
        var link = karte.querySelector('a');
        link.textContent = 'Projekt ansehen';
        link.href = el.dataset.url;
        karte.querySelector('.buehne-schliessen').addEventListener('click', schliessen);

        // Erst unsichtbar anhängen und die ECHTE Höhe messen — vorher wurde
        // sie geschätzt, und die Karte stand oft schief zum Objekt.
        karte.style.visibility = 'hidden';
        blick.appendChild(karte);
        var H = karte.offsetHeight;

        // Wunschplätze der Reihe nach: ÜBER dem Objekt (mittig), sonst
        // daneben, sonst darunter (Telefon). 84 px halten die Kopfzeile frei.
        var ox = r.left + r.width / 2, oy = r.top + r.height / 2;
        var left, top, lage;
        if (r.top - H - luft >= 84) {
            lage = 'oben';
            top  = r.top - H - luft;
            left = zwischen(ox - W / 2, rand, vw - W - rand);
        } else if (r.right + luft + W <= vw - rand || r.left - luft - W >= rand) {
            var rechts = r.right + luft + W <= vw - rand;
            lage = rechts ? 'rechts' : 'links';
            left = rechts ? r.right + luft : r.left - W - luft;
            top  = zwischen(oy - H / 2, rand, vh - H - rand);
        } else {
            lage = 'unten';
            top  = zwischen(r.bottom + luft, rand, vh - H - rand);
            left = zwischen(ox - W / 2, rand, vw - W - rand);
        }
        karte.classList.add('lage-' + lage);
        karte.style.left = left + 'px';
        karte.style.top  = top + 'px';
        // Zeiger und Wachstums-Ursprung sitzen auf der Objektmitte — die
        // Karte kommt sichtbar AUS dem Objekt.
        karte.style.setProperty('--zeiger-x', zwischen(ox - left, 20, W - 20) + 'px');
        karte.style.setProperty('--zeiger-y', zwischen(oy - top, 20, H - 20) + 'px');
        karte.style.transformOrigin = (ox - left) + 'px ' + (oy - top) + 'px';
        karte.style.visibility = '';
        requestAnimationFrame(function () { karte && karte.classList.add('karte-da'); });

        auswahl = i;
        pBeimOeffnen = p;
        buehne.classList.add('hat-karte');
        huelle.classList.add('hat-auswahl');
        el.classList.add('ist-auswahl');
    }

    objekte.forEach(function (el, i) {
        el.querySelector('button').addEventListener('click', function () {
            if (auswahl === i) { schliessen(); } else { oeffnen(i); }
        });
    });
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape') schliessen(); });
    blick.addEventListener('click', function (e) {
        if (karte && !karte.contains(e.target) && !e.target.closest('.buehne-obj')) schliessen();
    });

    lesen();
    requestAnimationFrame(fliegen);
})();
