<h1 align="center">Project Fishsee <small>Laravel</small></h1>

###

<p align="center">Project innovatie periode 4 - INF1-B</p>



# Installatie en Configuratie Handleiding

## Introductie
Welkom bij de installatiegids van uw nieuwe systeem. Volg deze instructies zorgvuldig om het systeem correct te configureren en te installeren.

## Vereisten
- PHP >= 7.3
- Composer
- Laravel >= 8.x
- Node.js & npm

### Stappen
Clone de repository:
   ```sh
   git clone https://github.com/Fishsee/Laravel.git
   cd your-repo
``
## Installeer de vereisten:
:

composer install
npm install
```
Kopieer het voorbeeld van het environment bestand:


```
cp .env.example .env

```
Genereer de applicatiesleutel:

```
php artisan key:generate

```
Voer de migraties uit, en gebruik de seeders als je de database wilt vullen met willekeurige testdata:




```
php artisan migrate --seed

```
Start de server:


```
php artisan serve

```

## Bekende problemen
Er is veel van de codeconventie afgeweken, en er zijn controllers die niet goed zijn ingedeeld. Verder kan het lastig zijn om het Python-script aan het werk te krijgen; hiervoor moet je naar de storage-folder kijken in de Laravel-installatie.


## Code conventie
De code convetie word gevolgt met; https://github.com/alexeymezenin/laravel-best-practices
