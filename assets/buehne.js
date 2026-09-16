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
    var finale   = buehne.querySelector('.buehne-finale');
    var astro    = buehne.querySelector('.buehne-astro');
    var antwort  = buehne.querySelector('.buehne-antwort');

    var klemm = function (v) { return Math.min(1, Math.max(0, v)); };

    // --- Wörter der Fragen in Masken zerlegen (Markup bleibt lesbarer Text) --
    fragen.forEach(function (f) {
        var text = f.textContent.trim();
        f.setAttribute('aria-label', text);
        f.textContent = '';
        text.split(/\s+/).forEach(function (wort) {
            var maske = document.createElement('span');
            maske.className = 'buehne-wort-maske';
            maske.setAttribute('aria-hidden', 'true');
            var w = document.createElement('span');
            w.textContent = wort;
            maske.appendChild(w);
            f.appendChild(maske);
        });
    });

    // --- Flugzustand je Objekt aus den data-Attributen -----------------------
    var zustand = objekte.map(function (el) {
        return {
            el: el,
            x: parseFloat(el.dataset.x), y: parseFloat(el.dataset.y),
            vx: parseFloat(el.dataset.vx), vy: parseFloat(el.dataset.vy),
            w: parseFloat(el.dataset.w), h: parseFloat(el.dataset.h)
        };
    });

    var auswahl = null;     // Index des geöffneten Objekts (pausiert den Flug)
    var karte   = null;     // DOM-Knoten der offenen Karte

    // --- Scroll-Fortschritt 0–1 über die ganze Sektion ------------------------
    var p = 0, leseTicket = 0;
    function lesen() {
        leseTicket = 0;
        var gesamt = Math.max(1, buehne.offsetHeight - window.innerHeight);
        p = klemm(-buehne.getBoundingClientRect().top / gesamt);
        malenFortschritt();
    }
    function angefordert() { if (!leseTicket) leseTicket = requestAnimationFrame(lesen); }
    window.addEventListener('scroll', angefordert, { passive: true });
    window.addEventListener('resize', angefordert);

    // --- Was am Fortschritt hängt: Fragen, Finale, Objekt-Ausblenden ----------
    var FRAGEN_FENSTER = [[0.15, 0.37], [0.38, 0.56], [0.58, 0.74]];

    function malenFortschritt() {
        fragen.forEach(function (f, i) {
            var fenster = FRAGEN_FENSTER[i] || [0, 1];
            var t = (p - fenster[0]) / (fenster[1] - fenster[0]);
            if (t <= -0.05 || t >= 1.05) { f.style.visibility = 'hidden'; return; }
            f.style.visibility = '';
            var woerter = f.children;
            for (var j = 0; j < woerter.length; j++) {
                var rein = klemm((t - j * 0.012) / 0.24);
                var raus = klemm((t - 0.82 - j * 0.005) / 0.16);
                var e = rein * rein * (3 - 2 * rein);
                var w = woerter[j].firstChild;
                w.style.opacity = e * (1 - raus);
                w.style.transform = 'translateY(' + ((1 - e) * 105 - raus * 55) + '%) rotate(' + ((1 - e) * 2.5) + 'deg)';
            }
        });

        var objWeg  = 1 - klemm((p - 0.78) / 0.05);
        var dunkel  = klemm((p - 0.72) / 0.08);
        var astroIn = klemm((p - 0.76) / 0.12);
        var astroE  = 1 - Math.pow(1 - astroIn, 3);
        var textIn  = klemm((p - 0.86) / 0.05);

        huelle.style.opacity = objWeg;
        huelle.style.pointerEvents = objWeg < 0.5 ? 'none' : '';
        buehne.querySelector('.buehne-fragen').style.opacity = 1 - dunkel;
        finale.style.opacity = dunkel;
        finale.style.pointerEvents = dunkel > 0.5 ? 'auto' : 'none';
        astro.style.opacity = astroIn;
        astro.style.transform = 'translateY(' + (26 - astroE * 26) + 'vh) scale(' + (0.9 + astroE * 0.1) + ')';
        antwort.style.opacity = textIn;
        antwort.style.transform = 'translateY(' + (28 - textIn * 28) + 'px)';
    }

    // --- Der Flug: gleichmäßiges Driften mit Umlauf ----------------------------
    var TEMPO = 1;
    var zuletzt = performance.now();
    function fliegen(jetzt) {
        var dt = Math.min(64, jetzt - zuletzt) / 1000;
        zuletzt = jetzt;
        if (auswahl === null) {
            zustand.forEach(function (s) {
                s.x += s.vx * TEMPO * dt * 1.6;
                s.y += s.vy * TEMPO * dt * 1.6;
                if (s.x > 100) s.x = -s.w;
                if (s.x < -s.w - 2) s.x = 100;
                if (s.y > 100) s.y = -s.h;
                if (s.y < -s.h - 2) s.y = 100;
            });
        }
        zustand.forEach(function (s) {
            s.el.style.transform = 'translate3d(' + s.x + 'vw,' + s.y + 'vh,0)';
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
        var W  = Math.min(420, vw * 0.86), H = 330, m = 16;
        var links = r.left + r.width / 2 > vw / 2;
        var left  = links ? r.left - W - 24 : r.right + 24;
        left = Math.min(vw - W - m, Math.max(m, left));
        var top = Math.min(vh - H - m, Math.max(m, r.top + r.height / 2 - H / 2));
        var ox = Math.min(W, Math.max(0, r.left + r.width / 2 - left));
        var oy = Math.min(H, Math.max(0, r.top + r.height / 2 - top));

        karte = document.createElement('div');
        karte.className = 'buehne-karte';
        karte.style.left = left + 'px';
        karte.style.top = top + 'px';
        karte.style.width = W + 'px';
        karte.style.transformOrigin = ox + 'px ' + oy + 'px';
        karte.innerHTML =
            '<div class="lz-eyebrow"></div>' +
            '<h3 class="lz-h3"></h3>' +
            '<p class="lz-lead"></p>' +
            '<div style="display:flex;gap:12px;align-items:center;flex-wrap:wrap">' +
            '<a class="knopf"></a>' +
            '<button type="button" class="buehne-schliessen">schließen</button></div>';
        karte.querySelector('.lz-eyebrow').textContent = el.dataset.kat;
        karte.querySelector('h3').textContent = el.dataset.titel;
        karte.querySelector('p').textContent = el.dataset.punchline;
        var link = karte.querySelector('a');
        link.textContent = 'Projekt ansehen';
        link.href = el.dataset.url;
        karte.querySelector('.buehne-schliessen').addEventListener('click', schliessen);

        blick.appendChild(karte);
        auswahl = i;
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
