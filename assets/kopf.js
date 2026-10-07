// Kopfzeile: Burger-Menü fürs Telefon (eingebunden in teile/kopf.php).
// Der Burger öffnet das Vollbild-Menü (#lz-menue, schwarz) und wird dabei
// zum X — beim Schließen umgekehrt (reines CSS über body.menue-offen).
//
// Fortschrittlich verbessert: Ohne dieses Skript bleibt der Burger `hidden`
// und die gewohnte Zeilen-Navigation steht wie bisher im Kopf.

(function () {
    'use strict';

    var burger = document.querySelector('button.lz-burger');
    var menue  = document.getElementById('lz-menue');
    if (!burger || !menue) {
        return;
    }

    // Erst jetzt schaltet CSS am Telefon auf den Burger um (html.hat-burger);
    // beide Burger-Fassungen (echte + Farblos-Schicht) werden sichtbar.
    document.documentElement.classList.add('hat-burger');
    document.querySelectorAll('.lz-burger').forEach(function (b) { b.hidden = false; });

    function setzen(offen) {
        document.body.classList.toggle('menue-offen', offen);
        burger.setAttribute('aria-expanded', offen ? 'true' : 'false');
        burger.setAttribute('aria-label', offen ? 'Menü schließen' : 'Menü öffnen');
    }

    burger.addEventListener('click', function () {
        setzen(!document.body.classList.contains('menue-offen'));
    });
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') setzen(false);
    });
    // Ein Klick auf einen Menüpunkt schließt (die Seite wechselt ohnehin,
    // aber bei Anker-Links bliebe das Menü sonst offen liegen).
    menue.querySelectorAll('a').forEach(function (a) {
        a.addEventListener('click', function () { setzen(false); });
    });
})();

// Magnet-Effekt der Knöpfe (7.10.2026): Das Leerzeichen-Rechteck zieht sich
// ein Stück zum Zeiger hin (CSS-Variablen --zieh-x/--zieh-y, ausgewertet in
// site.css). Rein dekorativ — ohne JavaScript bleibt das Rechteck ruhig.
(function () {
    'use strict';
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
    if (window.matchMedia('(hover: none)').matches) return;   // Touch: kein Zeiger

    document.addEventListener('mousemove', function (e) {
        var knopf = e.target.closest ? e.target.closest('.knopf') : null;
        if (!knopf) return;
        var r = knopf.getBoundingClientRect();
        // Lage des ruhenden Rechtecks: rechte Kante, senkrecht mittig.
        var zx = e.clientX - (r.right - 27);
        var zy = e.clientY - (r.top + r.height / 2);
        var deckel = 10;   // höchstens so viele Pixel Auslenkung
        knopf.style.setProperty('--zieh-x', Math.max(-deckel, Math.min(deckel, zx / 4)) + 'px');
        knopf.style.setProperty('--zieh-y', Math.max(-deckel, Math.min(deckel, zy / 4)) + 'px');
    }, { passive: true });

    document.addEventListener('mouseout', function (e) {
        var knopf = e.target.closest ? e.target.closest('.knopf') : null;
        if (!knopf || knopf.contains(e.relatedTarget)) return;
        knopf.style.setProperty('--zieh-x', '0px');
        knopf.style.setProperty('--zieh-y', '0px');
    }, { passive: true });
})();
