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
