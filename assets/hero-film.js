// Gemeinsame Maschine der dunklen Film-Seiten (Leistungen und die beiden
// Säulen-Seiten) — vorher Inline-Skript der Leistungsseite, ausgelagert am
// 8.10.2026, als die Säulen denselben Hero bekamen.
//
// 1) Hero-Film: läuft einmal, dimmt danach ab (CSS film-fertig); solange er
//    läuft, ist die Seite nicht scrollbar. Die Absätze des Heros wechseln
//    beim Scrollen einzeln (Sektion bekommt eine Scrollstrecke, die Leinwand
//    bleibt sticky stehen); der erste erscheint von selbst nach dem Abspann,
//    gemeinsam mit dem Scrollhinweis-Pfeil. Zwei oder drei Absätze werden
//    unterstützt (kürzere bzw. längere Strecke).
// 2) Erscroll-Choreografie: Elemente treten erst auf (.wartet → .da), wenn
//    man sie in die obere Bildschirmhälfte erscrollt — Zeitstrahl-Schritte,
//    zweiter Stärken-Absatz, Ansatz-Merkmale.
//
// Ohne JavaScript oder bei reduzierter Bewegung bleibt alles statisch
// sichtbar und der Film steht auf dem ersten Bild.
(function () {
    var ruhig = matchMedia('(prefers-reduced-motion: reduce)').matches;
    var video = document.querySelector('.leistung-hero-video');
    if (ruhig && video) {
        video.pause();
        video.removeAttribute('autoplay');
    }

    var hero = document.getElementById('l-hero');
    var abs = hero ? hero.querySelectorAll('.kopf-gross-rechts p') : [];
    if (!ruhig && hero && abs.length >= 2) {
        // Lange Lesefenster mit echten Pausen dazwischen; bei zwei Absätzen
        // ist die Strecke kürzer (CSS rollt-kurz).
        var FENSTER = abs.length === 2
            ? [[0.05, 0.45], [0.55, 1.10]]
            : [[0.04, 0.30], [0.38, 0.70], [0.78, 1.10]];
        var BLENDE = 0.08;
        hero.classList.add('rollt');
        if (abs.length === 2) { hero.classList.add('rollt-kurz'); }

        // Solange der Film läuft, ist die Seite nicht scrollbar — drei
        // Sicherheitsnetze geben wieder frei: ended, blockiertes Autoplay
        // (1,5 s ohne Wiedergabe) und eine harte Obergrenze von 9 s. Wer
        // mitten auf der Seite einsteigt, wird gar nicht erst gesperrt.
        var gesperrt = false;
        if (video && !video.ended && scrollY < 50) {
            gesperrt = true;
            document.documentElement.style.overflow = 'hidden';
        }
        var freigeben = function () {
            if (!gesperrt) { return; }
            gesperrt = false;
            document.documentElement.style.overflow = '';
        };
        var zeichnen = function () {
            var r = hero.getBoundingClientRect();
            var strecke = r.height - innerHeight;
            var p = strecke > 0 ? Math.min(1, Math.max(0, -r.top / strecke)) : 1;
            abs.forEach(function (el, i) {
                var f = FENSTER[Math.min(i, FENSTER.length - 1)];
                var o = Math.min((p - f[0]) / BLENDE, (f[1] - p) / BLENDE);
                el.style.opacity = String(Math.max(0, Math.min(1, o)));
            });
        };
        var ersterAbsatzFrei = function () {
            freigeben();
            if (FENSTER[0][0] < 0) { return; }
            FENSTER[0][0] = -1;
            // Der stehende Schlussframe dimmt zusätzlich ab (CSS film-fertig),
            // und der Scrollhinweis-Pfeil erscheint mit dem Text.
            hero.querySelector('.leistung-hero-leinwand').classList.add('film-fertig');
            abs[0].style.transition = 'opacity 1.2s ease';
            zeichnen();
            setTimeout(function () { abs[0].style.transition = ''; }, 1300);
        };
        if (video) {
            if (video.ended) { ersterAbsatzFrei(); }
            video.addEventListener('ended', ersterAbsatzFrei);
            setTimeout(function () {
                if (video.currentTime === 0) { ersterAbsatzFrei(); }
            }, 1500);
            setTimeout(ersterAbsatzFrei, 9000);
        }
        addEventListener('scroll', zeichnen, { passive: true });
        addEventListener('resize', zeichnen);
        zeichnen();
    }

    // Schwebende Projektbilder neben der Leistungs-Liste: ein sanftes
    // Scroll-Parallax (gegenläufig, geglättet) auf dem äußeren <a>; die
    // CSS-Schwebe liegt auf dem inneren <span>, darum kein Konflikt.
    // Unter 1100 px stehen die Bilder im Fluss (CSS setzt transform ab).
    var flieger = document.querySelectorAll('.feld-flieger');
    if (!ruhig && flieger.length) {
        var zustand = [];
        flieger.forEach(function (el, i) {
            zustand.push({ el: el, y: 0, faktor: i % 2 ? -0.16 : -0.1 });
        });
        var flug = function () {
            if (innerWidth > 1100) {
                zustand.forEach(function (s) {
                    var r = s.el.parentElement.getBoundingClientRect();
                    var ziel = (r.top + r.height / 2 - innerHeight / 2) * s.faktor;
                    s.y += (ziel - s.y) * 0.08;
                    s.el.style.transform = 'translateY(calc(-50% + ' + s.y.toFixed(1) + 'px))';
                });
            }
            requestAnimationFrame(flug);
        };
        requestAnimationFrame(flug);
    }

    // Erscroll-Choreografie: einmal da, bleibt da; der riesige obere
    // Beobachtungsrand zählt alles OBERHALB des Fensters als erreicht —
    // schnelles Scrollen lässt sonst Elemente dauerhaft unsichtbar zurück.
    if (!ruhig && 'IntersectionObserver' in window) {
        var elemente = document.querySelectorAll('.ablauf-schritt, .staerke-zwei, .merkmal');
        if (elemente.length) {
            elemente.forEach(function (el) { el.classList.add('wartet'); });
            var io = new IntersectionObserver(function (eintraege) {
                eintraege.forEach(function (e) {
                    if (e.isIntersecting) {
                        e.target.classList.add('da');
                        io.unobserve(e.target);
                    }
                });
            }, { rootMargin: '10000px 0px -45% 0px' });
            elemente.forEach(function (el) { io.observe(el); });
        }
    }
})();
