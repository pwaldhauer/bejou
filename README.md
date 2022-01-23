# BetterJournal

Eine kleine Laravel-Webapp, mit der man ein Tagebuch führen kann, ohne viel bling bling.

## Requirements

- PHP 8 mit sqlite Extension
- 1 Webserver

## Setup

- Herunterladen und entpacken, `composer install`
- Webserver konfigurieren, oder einfach `php artisan serve`
- Config: `cp .env.example .env`
- Leere Datenbank: `touch pfad/zur/datenbank.sqlite`
- In der `.env` unter `DB_DATABASE` den vollständigen Pfad zur Datenbank angeben
- `php artisan migrate`
- `php artisan seed:user email@example.com` um einen neuen User anzulegen
- BetterJournal im Browser aufrufen und loslegen.
- Optional: `cp config/bejou.example.php config/bejou.php` -- dort können die Presets angelegt werden

## Warnung

Das hier ist alles schnell zusammengeklöppelt und keinesfalls production ready oder in irgendeinerweise auf Sicherheit geprüft. 
An sich benutzt es nur die normale Laravel Benutzerauthentifizierung, sollte also soweit sicher sein. Ich würde empfehlen 
es nur auf einem privaten / lokalen Server zu betreiben.

Außerdem kann sich jederzeit natürlich alles ändern, da es sich um ein Work in Progress handelt.


## Benutzung

Einloggen, losschreiben. 

Screenshots und mehr gibt es auf [knuspermagier.de](https://knuspermagier.de/wiki/projekte/betterjournal)
