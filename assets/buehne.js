// Scroll-Bühne der Startseite — schlichtes JavaScript, kein Framework.
// Portiert aus dem Claude-Design-Entwurf (scroll-buehne.jsx, 16.9.2026):
// Projekt-Objekte fliegen über den ersten Bildschirm, zwei Fragen erscheinen
// wortweise am Scroll-Fortschritt, danach blendet die dunkle Fläche mit dem
// Astronauten und der Antwort ein. Über einem Objekt erscheint ein schwarzes
// Rechteck-Badge (Logo-Form) unter dem Zeiger — Projekttitel + „Ansehen";
// ein Klick lässt es den Schirm füllen und führt zur Projektseite. Am
// Telefon zeigt der erste Tipp das Badge am Objekt, der zweite springt ab
// (Muster blossom.at, Beschluss Roman 12.10.2026).
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

    // Jede Frage liegt in zwei Fassungen mit eigenen Umbrüchen vor
    // (data-fassung desktop/mobil) — nur die passende bleibt im Spiel,
    // die andere fliegt aus dem DOM. Entschieden wird einmal beim Laden.
    var fassung = window.matchMedia('(max-width: 900px)').matches ? 'mobil' : 'desktop';
    buehne.querySelectorAll('.buehne-frage').forEach(function (f) {
        if (f.dataset.fassung && f.dataset.fassung !== fassung) f.remove();
    });
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

    // --- Zeiger-Badge (Rechteck in Logo-Form) über den Objekten ---------------
    var feinzeiger = window.matchMedia('(hover: hover) and (pointer: fine)').matches;
    var badge = document.createElement('div');
    badge.className = 'buehne-zeigerbadge';
    badge.innerHTML = '<strong></strong>'
        + '<svg viewBox="0 0 63.611 14.4" aria-hidden="true">'
        + '<path fill="currentColor" d="M54.906,12.9l4.622-4.622H0V6.125H59.528L54.906,1.5,56.412,0l7.2,7.2-7.2,7.2Z"/></svg>';
    blick.appendChild(badge);
    var badgeTitel = badge.querySelector('strong');

    var armiert = null;      // Telefon: Index des angetippten Objekts (pausiert den Flug)
    var zoomZiel = null;     // Adresse nach der Absprung-Animation
    var bx = 0, by = 0;      // Badge-Lage (geglättet)
    var bzx = 0, bzy = 0;    // … und ihr Ziel (Maus bzw. Objektmitte)
    var badgeDa = false;
    var pBeimArmieren = 0;   // Scroll-Stand beim Antippen (Weiterscrollen schließt)

    // --- Scroll-Fortschritt 0–1 über die ganze Sektion ------------------------
    var p = 0, leseTicket = 0;
    function lesen() {
        leseTicket = 0;
        var gesamt = Math.max(1, buehne.offsetHeight - window.innerHeight);
        p = klemm(-buehne.getBoundingClientRect().top / gesamt);
        // Scrollt jemand mit gezeigtem Badge weiter (Telefon), zöge das
        // Objekt darunter weg — dann lieber sauber schließen.
        if (armiert !== null && Math.abs(p - pBeimArmieren) > 0.008) {
            entwaffnen();
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
    // Zwei Fragen (seit 7.10.2026) — die Fenster teilen sich die Strecke
    // bis zum Übergangsbild (uIn ab 0.56).
    var FRAGEN_FENSTER = [[0.12, 0.32], [0.38, 0.56]];

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
        if (armiert === null) {
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
        // Das Badge fährt seinem Ziel weich hinterher (Maus bzw. Objekt) —
        // geklemmt, damit der Kreis nie aus dem Bild ragt.
        if (zoomZiel === null) {
            var halb = badge.offsetWidth / 2 + 8;
            var zx = Math.min(window.innerWidth - halb, Math.max(halb, bzx));
            var zy = Math.min(window.innerHeight - halb, Math.max(halb, bzy));
            bx += (zx - bx) * Math.min(1, dt * 12);
            by += (zy - by) * Math.min(1, dt * 12);
            badge.style.transform = 'translate(' + bx.toFixed(1) + 'px,' + by.toFixed(1) + 'px) translate(-50%, -50%)';
        }
        requestAnimationFrame(fliegen);
    }

    // --- Badge zeigen, Absprung zur Projektseite -------------------------------
    function entwaffnen() {
        armiert = null;
        badgeDa = false;
        badge.classList.remove('da');
        badge.style.pointerEvents = '';
        huelle.classList.remove('hat-auswahl');
        objekte.forEach(function (el) { el.classList.remove('ist-auswahl'); });
    }

    function badgeZeigen(i) {
        badgeTitel.textContent = objekte[i].dataset.titel;
        badgeDa = true;
        badge.classList.add('da');
    }

    // Klick: Das Rechteck füllt den Schirm (cover, mit Reserve), dann geht
    // es zur Projektseite — die beginnt ohnehin dunkel, der Übergang sitzt.
    function absprung(i) {
        if (zoomZiel !== null) { return; }
        zoomZiel = objekte[i].dataset.url;
        badgeZeigen(i);
        var r = badge.getBoundingClientRect();
        var faktor = 2 * Math.max(
            window.innerWidth / Math.max(1, r.width),
            window.innerHeight / Math.max(1, r.height)
        );
        badge.classList.add('zoom');
        badge.style.transition = 'transform .55s cubic-bezier(.5, 0, .2, 1)';
        badge.style.transform = 'translate(' + (window.innerWidth / 2) + 'px,'
            + (window.innerHeight / 2) + 'px) translate(-50%, -50%) scale(' + faktor + ')';
        setTimeout(function () { window.location.href = zoomZiel; }, 580);
    }

    objekte.forEach(function (el, i) {
        if (feinzeiger) {
            // Zeigegerät: Badge folgt der Maus über dem Objekt, Klick springt ab.
            el.addEventListener('mouseenter', function () { badgeZeigen(i); });
            el.addEventListener('mouseleave', function () {
                if (zoomZiel === null) { badgeDa = false; badge.classList.remove('da'); }
            });
            el.querySelector('button').addEventListener('click', function () { absprung(i); });
        } else {
            // Telefon: erster Tipp zeigt das Badge am Objekt, der zweite springt ab.
            el.querySelector('button').addEventListener('click', function () {
                if (armiert === i) { absprung(i); return; }
                entwaffnen();
                armiert = i;
                pBeimArmieren = p;
                var r = el.getBoundingClientRect();
                bzx = bx = r.left + r.width / 2;
                bzy = by = Math.max(70, r.top - 34);
                badgeZeigen(i);
                // Auch der Kreis selbst darf den zweiten Tipp entgegennehmen.
                badge.style.pointerEvents = 'auto';
                huelle.classList.add('hat-auswahl');
                el.classList.add('ist-auswahl');
            });
        }
    });
    badge.addEventListener('click', function () {
        if (armiert !== null) { absprung(armiert); }
    });
    if (feinzeiger) {
        blick.addEventListener('mousemove', function (e) {
            bzx = e.clientX;
            bzy = e.clientY;
            if (!badgeDa) { bx = bzx; by = bzy; }   // beim Erscheinen nicht anreisen
        });
    }
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape') entwaffnen(); });
    blick.addEventListener('click', function (e) {
        if (armiert !== null && !e.target.closest('.buehne-obj')) entwaffnen();
    });

    // Kommt jemand per Zurück-Knopf wieder, stellt der Browser die Seite
    // aus dem Cache so her, wie sie beim Absprung aussah — mit dem
    // bildschirmfüllenden Badge. Deshalb hier alles zurücksetzen.
    window.addEventListener('pageshow', function () {
        zoomZiel = null;
        badge.classList.remove('zoom', 'da');
        badge.style.transition = '';
        badge.style.transform = 'translate(' + bx.toFixed(1) + 'px,' + by.toFixed(1) + 'px) translate(-50%, -50%)';
        badgeDa = false;
        entwaffnen();
    });

    lesen();
    requestAnimationFrame(fliegen);
})();
