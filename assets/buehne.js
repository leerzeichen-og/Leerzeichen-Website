// Scroll-Bühne der Startseite — schlichtes JavaScript, kein Framework.
// Portiert aus dem Design-Entwurf (scroll-buehne.jsx, 16.9.2026):
// Projekt-Objekte fliegen über den ersten Bildschirm, zwei Fragen erscheinen
// wortweise am Scroll-Fortschritt, danach blendet die dunkle Fläche mit dem
// Astronauten und der Antwort ein. Über einem Objekt erscheint ein schwarzes
// Rechteck-Badge (Logo-Form) unter dem Zeiger — Projekttitel + „Ansehen";
// ein Klick lässt es den Schirm füllen und führt zur Projektseite. Am
// Telefon zeigt der erste Tipp das Badge am Objekt, der zweite springt ab
// (Beschluss Roman, 12.10.2026).
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

    // --- Zustand je Objekt: wandert in zwei überlagerten Sinus-Schleifen je
    //     Achse (eine langsame große plus eine schnellere kleine), Perioden
    //     und Phasen je Besuch zufällig — unregelmäßige Wege statt Pendeln
    //     am Stand („zu berechnet", Befund 18.11.2026). Die Amplituden
    //     werden auf den SPIELRAUM zur Bildkante gestutzt (Roman, 19.11.2026:
    //     Objekte hingen an der Kante, weil die harte Klemme ständig griff) —
    //     die Wege orientieren sich dadurch am Zentrum, und die Klemme in
    //     fliegen() ist nur noch das Netz. Die waagrechten Phasen sind 0
    //     oder π: Beide Anteile starten bei 0 und schwingen symmetrisch um
    //     die Startlage, damit die gestaltete Verteilung (und claimFreihalten)
    //     gilt. Die Höhe hängt weiter am Scroll-Fortschritt (y0 − p·tiefe).
    var TAU = Math.PI * 2;
    var zustand = objekte.map(function (el) {
        var r = function (von, bis) { return von + Math.random() * (bis - von); };
        var w  = parseFloat(el.dataset.w);
        var x0 = parseFloat(el.dataset.x);
        var a1 = r(7, 12), a2 = r(2.5, 4.5);
        // Spielraum: 2 vw Abstand zur Kante bleiben immer.
        var raum = Math.max(3, Math.min(x0 - 2, 98 - w - x0));
        var f = raum / (a1 + a2);
        if (f < 1) { a1 *= f; a2 *= f; }
        return {
            el: el, w: w, x0: x0, x: x0,
            h: parseFloat(el.dataset.h),
            y0: parseFloat(el.dataset.y0),
            tiefe: parseFloat(el.dataset.tiefe),
            a1: a1, f1: TAU / r(46, 76), p1: Math.random() < 0.5 ? 0 : Math.PI,
            a2: a2, f2: TAU / r(13, 22), p2: Math.random() < 0.5 ? 0 : Math.PI,
            ay: r(2, 3.5), fy: TAU / r(16, 26), py: r(0, TAU),   // senkrechtes Treiben (vh)
            uhr: 0,                        // läuft nur, solange nichts armiert ist
            wy: 0,                         // aktuelles senkrechtes Treiben
            y: parseFloat(el.dataset.y0)   // angezeigte Höhe (geglättet, s. fliegen)
        };
    });

    // --- Startlagen am Telefon: kein Objekt unter dem Claim ---------------------
    // Zu Beginn (vor dem ersten Scrollen) darf kein Objekt im Band des
    // Schriftzugs „Gemeinsam Zeichen setzen." liegen (Roman, 12.10.2026).
    // Überlappende Bahnen weichen zur näheren Seite aus — ihre ganze
    // Umlaufbahn verschiebt sich dafür um ein paar vh, die Verteilung über
    // die Reise bleibt. Nach den Schriften noch einmal (load), die
    // Claim-Höhe steht erst dann fest.
    var claimTitel = buehne.querySelector('.buehne-claimblock h1');
    var runter     = buehne.querySelector('.buehne-runter');
    function claimFreihalten() {
        if (!claimTitel || window.innerWidth > 900 || (p || 0) > 0.02) { return; }
        var vh = window.innerHeight / 100;
        var r = claimTitel.getBoundingClientRect();
        var oben  = (r.top + window.scrollY) / vh - 4;
        var unten = (r.bottom + window.scrollY) / vh + 4;
        zustand.forEach(function (s) {
            var h = parseFloat(s.el.dataset.h);
            if (s.y0 + h > oben && s.y0 < unten) {
                s.y0 = (unten - s.y0 <= s.y0 + h - oben) ? unten : oben - h;
                s.y = s.y0;
                // Startlage auch im Markup nachziehen — macht die
                // Verschiebung im Inspektor ablesbar und wirkt sofort,
                // bevor der erste Animationsframe zeichnet.
                s.el.dataset.y0 = s.y0;
                s.el.style.transform = 'translate3d(' + s.x0 + 'vw,' + s.y0 + 'vh,0)';
            }
        });
    }
    claimFreihalten();
    window.addEventListener('load', claimFreihalten);

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
        // Der Scrollhinweis-Pfeil hat seinen Dienst getan, sobald gescrollt wird.
        if (runter) { runter.style.opacity = p > 0.012 ? '0' : ''; }
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

        // Übergangsbild: 100vh (unter dem Bild) → -100vh (oben hinaus);
        // bei 0 deckt es den Bildschirm vollständig — dort wird dahinter
        // unsichtbar auf den schwarzen Akt geschaltet.
        var uIn       = klemm((p - 0.56) / 0.20);
        var schwarz   = uIn >= 0.5 ? 1 : 0;
        var textIn    = klemm((p - 0.72) / 0.04);      // Antwort erscheint, sobald das Bild die Mitte freigibt
        var textWeg   = klemm((p - 0.87) / 0.03);      // … hält, geht
        var splashIn  = klemm((p - 0.88) / 0.11);      // Splash scrollt herein

        // Die Objekte werden nicht mehr ausgeblendet (Roman, 20.11.2026) —
        // sie verschwinden durchs Scrollen aus dem Blick, und das
        // hereinfahrende Übergangsbild deckt den Rest zu. Nur Klicks nehmen
        // sie ab dem Übergang keine mehr an: Das Bild selbst lässt Zeiger
        // durch (pointer-events: none), unsichtbar Anklickbares darunter
        // wäre eine Falle.
        huelle.style.pointerEvents = p > 0.55 ? 'none' : '';
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
    var ruhte = false;   // stand die Objekt-Schleife im letzten Frame still?
    function fliegen(jetzt) {
        var dt = Math.min(64, jetzt - zuletzt) / 1000;
        zuletzt = jetzt;
        // Hinter dem Übergang (alle Objekte unsichtbar, p > 0.8) ruht die
        // Objekt-Schleife: Im Antwort- und Team-Akt bewegen sich ohnehin
        // schon drei große Bildebenen je Frame — die neun Style-Writes
        // obendrauf kosteten am Telefon spürbar (Roman, 20.11.2026).
        // Ein letzter Durchlauf nach dem Eintritt schreibt noch opacity 0;
        // das Badge (unten) fährt IMMER weiter — es dient auch dem
        // Kreis-Hover der Säulen-Motive nach der Bühne.
        var ruhig = p > 0.8;
        if (!ruhig || !ruhte) {
        if (armiert === null) {
            zustand.forEach(function (s) {
                s.uhr += dt;
                // Phasen 0/π → sin(Phase) = 0, der Weg startet in der
                // Startlage; die Amplituden sind auf den Spielraum gestutzt,
                // die Klemme ist nur noch das Netz (2 vw Kantenabstand).
                var drift = s.a1 * Math.sin(s.f1 * s.uhr + s.p1)
                          + s.a2 * Math.sin(s.f2 * s.uhr + s.p2);
                s.x = Math.min(98 - s.w, Math.max(2, s.x0 + drift));
                s.wy = s.ay * (Math.sin(s.fy * s.uhr + s.py) - Math.sin(s.py));
            });
        }
        // Schutzzone (Roman, 19.11.2026): In den oberen 80 px fliegt nichts,
        // solange die Seite GANZ OBEN steht (Präzisierung Roman, 20.11.) —
        // dort hingen angeschnittene, nicht anklickbare Stückchen unter dem
        // Seitenkopf. Wer oben hinauswandert, löst sich auf, bevor die
        // Oberkante die Zone berührt (Fade über 6 vh darunter), und
        // Unsichtbare nehmen keine Klicks an. Beim Scrollen verliert die
        // Zone ihre Wirkung (deckel), die Objekte ziehen dann sichtbar bis
        // zur Kante hinaus. Die Startlagen in index.php beginnen unterhalb
        // von Zone + Fade.
        var zone   = 80 / (window.innerHeight / 100) + 1;   // in vh, mit Luft
        var deckel = 1 - klemm(p / 0.03);                   // nur am Seitenanfang scharf
        // Oberkante des Übergangsbilds: Das Bild ist auch in seinem weißen
        // Teil DECKEND (zweiter Befund Roman, 20.11.2026 — der erste Fix
        // setzte die Kante fälschlich auf die gemalte Tinte bei 60 % der
        // Bildhöhe, die Objekte wurden weiter schnurgerade abgeschnitten).
        // Jedes Objekt löst sich auf, bevor die hereinfahrende Bildkante
        // seine Unterkante erreicht; die Kante selbst ist Weiß auf Weiß
        // unsichtbar, das Auflösen wirkt wie sanftes Hinausscrollen. Nach
        // dem Übergang (Kante weit oben) sind damit ALLE Objekte aus —
        // auch die, die sonst am Bühnenende über den nächsten Abschnitt
        // lugten. Nebenwirkung: Unten hereinkommende Objekte blenden über
        // die letzten 8 vh ein (Kante steht ohne Übergang bei 100).
        var kante = 100 - klemm((p - 0.56) / 0.20) * 200;
        zustand.forEach(function (s) {
            // Die Höhe folgt dem Scroll-Ziel GEGLÄTTET (Exponentialfilter):
            // Am Telefon kommen Scroll-Ereignisse ruckhaft hinter dem nativen
            // Scrollen her — ungefiltert sprangen die Objekte sichtbar
            // (Roman, 24.9.2026). So wird aus jedem Sprung eine weiche Fahrt.
            var ziel = s.y0 - p * s.tiefe + s.wy;
            s.y += (ziel - s.y) * Math.min(1, dt * 8);
            if (Math.abs(ziel - s.y) < 0.01) s.y = ziel;
            // Umlaufbahn: erst zur Anzeige wird die Höhe in die Spanne
            // −50…150 vh gefaltet — wer oben hinausfliegt, kommt unten
            // wieder herein (geglättet wird die UNgefaltete Höhe, sonst
            // würde jeder Umlauf als schnelle Durchfahrt animiert).
            var zeig = ((s.y + 50) % SPANNE + SPANNE) % SPANNE - 50;
            var frei = 1 - (1 - klemm((zeig - zone) / 6)) * deckel;
            frei = Math.min(frei, klemm((kante - zeig - s.h) / 8));
            s.el.style.opacity = frei;
            s.el.style.pointerEvents = frei < 0.5 ? 'none' : '';
            s.el.style.transform = 'translate3d(' + s.x + 'vw,' + zeig + 'vh,0)';
        });
        }
        ruhte = ruhig;
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
        if (zoomZiel !== null) { return; }   // mitten im Absprung nichts löschen
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
        badgeZeigen(i);
        absprungNach(objekte[i].dataset.url);
    }
    function absprungNach(url) {
        if (zoomZiel !== null) { return; }
        zoomZiel = url;
        var r = badge.getBoundingClientRect();
        var faktor = 2 * Math.max(
            window.innerWidth / Math.max(1, r.width),
            window.innerHeight / Math.max(1, r.height)
        );
        badge.classList.add('zoom');
        badge.style.transition = 'transform .55s cubic-bezier(.5, 0, .2, 1)';
        void badge.offsetWidth;   // Reflow: Safari braucht die Transition VOR dem Ziel
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
                // Der Kreis liegt direkt AUF dem Objekt (Roman, 20.11.2026),
                // nicht mehr darüber — geklemmt, damit er im Bild bleibt.
                var r = el.getBoundingClientRect();
                bzx = bx = r.left + r.width / 2;
                bzy = by = Math.max(70, r.top + r.height / 2);
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
        if (armiert !== null && !e.target.closest('.buehne-obj')
            && !e.target.closest('.buehne-zeigerbadge')) entwaffnen();
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

    // --- Kreis-Hover auch auf den Säulen-Motiven (19.11.2026): dasselbe
    //     Badge wie über den fliegenden Objekten — es ist fixed und die
    //     fliegen()-Schleife fährt es ohnehin dauerhaft der Maus nach.
    //     Am Telefon bleibt der Link ein gewöhnlicher Link.
    if (feinzeiger) {
        document.querySelectorAll('.lz-saeule-bildlink').forEach(function (a) {
            a.classList.add('hat-kreis');   // cursor: none nur mit Skript
            a.addEventListener('mouseenter', function () {
                badgeTitel.textContent = a.dataset.titel || '';
                badgeDa = true;
                badge.classList.add('da');
            });
            a.addEventListener('mouseleave', function () {
                if (zoomZiel === null) { badgeDa = false; badge.classList.remove('da'); }
            });
            a.addEventListener('mousemove', function (e) {
                bzx = e.clientX;
                bzy = e.clientY;
                if (!badgeDa) { bx = bzx; by = bzy; }
            });
            a.addEventListener('click', function (e) {
                e.preventDefault();
                absprungNach(a.href);
            });
        });
    }

    // --- Wortwechsler im Handwerk-Abschnitt (19.11.2026, ersetzt die zwei
    //     Laufbänder): Ein stehender Satz, in dem die Leistung durchwechselt —
    //     das Wort fährt hinter seiner Maske hinaus, das nächste herein
    //     (dieselbe Masken-Bewegung wie die Fragen), die Maskenbreite gleitet
    //     mit (Transition im CSS). Ohne dieses Skript oder bei reduzierter
    //     Bewegung (frühes return oben) bleibt der ausgeschriebene Satz stehen.
    var wwSatz     = document.querySelector('.ww-satz');
    var wwStatisch = document.querySelector('.ww-statisch');
    if (wwSatz && wwStatisch) {
        var wwWoerter = [];
        try { wwWoerter = JSON.parse(wwSatz.dataset.woerter || '[]'); } catch (e) { }
        if (wwWoerter.length > 1) {
            wwStatisch.hidden = true;
            wwSatz.hidden = false;
            var wwMaske = wwSatz.querySelector('.ww-maske');
            var wwWort  = wwSatz.querySelector('.ww-wort');
            var wwAn = 0;
            wwMaske.style.width = wwWort.offsetWidth + 'px';
            setInterval(function () {
                // Nur wechseln, solange der Satz im Bild ist.
                var r = wwSatz.getBoundingClientRect();
                if (r.bottom < 0 || r.top > window.innerHeight) { return; }
                wwAn = (wwAn + 1) % wwWoerter.length;
                wwWort.style.transform = 'translateY(-115%)';    // hinaus nach oben
                setTimeout(function () {
                    wwWort.style.transition = 'none';
                    wwWort.textContent = wwWoerter[wwAn];
                    wwWort.style.transform = 'translateY(115%)'; // unten bereitstellen
                    var alt = wwMaske.offsetWidth;               // Breite gleitet zur neuen
                    wwMaske.style.width = 'auto';
                    var neu = wwWort.offsetWidth;
                    wwMaske.style.width = alt + 'px';
                    void wwMaske.offsetWidth;                    // Reflow: Startwerte festschreiben
                    wwMaske.style.width = neu + 'px';
                    wwWort.style.transition = '';
                    wwWort.style.transform = 'translateY(0)';    // herein von unten
                }, 340);
            }, 2600);
        }
    }

    lesen();
    requestAnimationFrame(fliegen);
})();
