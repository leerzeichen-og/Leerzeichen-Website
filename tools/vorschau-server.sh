#!/bin/bash
# Vorschau-Server fuer die Browser-Pane (Port kommt vom Werkzeug ueber $PORT).
exec php -S "localhost:${PORT:-8023}" -t "$(dirname "$0")/.."
