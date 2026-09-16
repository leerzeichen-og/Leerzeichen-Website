#!/bin/bash
# Rauchtest vor dem Push: (1) Syntax aller PHP-Dateien, (2) jede Seite einmal
# über den eingebauten PHP-Server aufrufen — findet auch Laufzeitfehler.
# Aufruf aus dem Repo-Ordner:  bash tools/rauchtest.sh
set -u
cd "$(dirname "$0")/.."
fehler=0

echo "— Syntax —"
while read -r f; do
  if ! php -l "$f" > /dev/null 2>&1; then
    php -l "$f" 2>&1 | head -2
    fehler=1
  fi
done < <(find . -name '*.php' -not -path './.git/*')
[ $fehler -eq 0 ] && echo "alle PHP-Dateien in Ordnung"

echo "— Seiten aufrufen —"
php -S 127.0.0.1:8931 > /tmp/lz-rauchtest.log 2>&1 &
server=$!
trap 'kill $server 2>/dev/null' EXIT
sleep 1

# Jede index.php im Repo entspricht einer Seite; dazu Sonderfälle.
seiten="/ /404.php /sitemap.php"
while read -r f; do
  pfad="${f#.}"; pfad="${pfad%index.php}"
  [ "$pfad" = "/" ] || seiten="$seiten $pfad"
done < <(find . -name 'index.php' -not -path './.git/*')

for seite in $seiten; do
  code=$(curl -s -o /tmp/lz-seite.html -w "%{http_code}" "http://127.0.0.1:8931$seite")
  erwartet=200; [ "$seite" = "/404.php" ] && erwartet=404
  if [ "$code" != "$erwartet" ] || grep -qE "Fatal error|Warning:|Deprecated:" /tmp/lz-seite.html; then
    echo "FEHLER $seite (HTTP $code)"
    grep -E "Fatal error|Warning:|Deprecated:" /tmp/lz-seite.html | head -3
    fehler=1
  else
    echo "ok     $seite"
  fi
done

[ $fehler -eq 0 ] && echo "Rauchtest bestanden." || echo "Rauchtest FEHLGESCHLAGEN."
exit $fehler
