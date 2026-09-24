// Text-Einblendung beim Scrollen — auf allen Seiten (eingebunden in
// teile/fuss.php). Absätze, Überschriften und Karten stehen anfangs eine
// Spur tiefer und durchsichtig und gleiten beim Erscheinen im Fenster nach
// oben — dieselbe Bewegung wie die Texte der Startseiten-Bühne, nur ruhiger.
//
// Fortschrittlich verbessert: Die Startklasse .blende vergibt erst dieses
// Skript. Ohne JavaScript (und bei „reduzierter Bewegung" im System) bleibt
// jeder Text sofort sichtbar. Die Startseiten-Bühne ist ausgenommen — sie
// hat ihre eigene Choreografie in buehne.js.

(function () {
    'use strict';

    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        return;
    }
    if (!('IntersectionObserver' in window)) {
        return;   // sehr alte Browser: Text bleibt einfach stehen
    }

    // Was eingeblendet wird. Bewusst eine Liste konkreter Bausteine —
    // pauschal „alle Absätze" erwischte auch Fußzeile und Formulare.
    var AUSWAHL = [
        '.titel-seite', '.seiten-kopf .chip', '.seiten-hero .chip',
        '.text-spalte p', '.lz-lead', '.lz-h2',
        '.prinzip', '.lz-saeule',
        // Die Newsletter-Karte fliegt als GANZES ein (Postkarte) —
        // ihre Einzelteile bekommen deshalb keine eigene Blende.
        '.nl-karte',
        // .pj-text selbst trägt den Spaltenversatz — deshalb werden dort
        // die Absätze eingeblendet, nicht der Block; Fotos treten mit auf.
        '.pj-header-inhalt', '.pj-text p', '.pj-zitat', '.pj-karte',
        '.pj .pj-foto',
        '.buero-kachel', '.buero-text', '.portrait',
    ].join(',');

    var ziele = [];
    document.querySelectorAll(AUSWAHL).forEach(function (el) {
        if (el.closest('.buehne')) {
            return;   // Bühne macht das selbst
        }
        el.classList.add('blende');
        ziele.push(el);
    });
    if (!ziele.length) {
        return;
    }

    // Erscheint mehreres gleichzeitig (Seitenstart, schnelles Scrollen),
    // staffelt eine kleine Verzögerung je Fundstück den Auftritt.
    var beobachter = new IntersectionObserver(function (eintraege) {
        var i = 0;
        eintraege.forEach(function (e) {
            if (!e.isIntersecting) {
                return;
            }
            beobachter.unobserve(e.target);
            e.target.style.transitionDelay = (i++ * 90) + 'ms';
            e.target.classList.add('blende-da');
        });
    }, { rootMargin: '0px 0px -8% 0px', threshold: 0.05 });

    ziele.forEach(function (el) { beobachter.observe(el); });
})();
