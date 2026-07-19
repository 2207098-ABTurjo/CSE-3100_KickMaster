# ⚽ KickMaster — Football Management System

A university **Web Programming Laboratory** project built with **Laravel 12**, Blade, Bootstrap 5, and MySQL.
KickMaster lets an **Admin** manage teams, players, fixtures and matches, while a normal **User** can browse
fixtures, live scores, and player/team statistics.

---

## 1. Tech Stack

| Layer          | Technology                     |
|-----------------|--------------------------------|
| Backend         | Laravel 12 (PHP 8.2+)          |
| Frontend        | Blade Templates, Bootstrap 5   |
| Styling         | Bootstrap 5 + custom CSS       |
| Interactivity   | Vanilla JavaScript + `fetch()` AJAX |
| Database        | MySQL                          |
| Auth            | Laravel's built-in session auth (hand-written controllers, no Breeze/Jetstream) |

No REST API, Repository/Service pattern, Livewire, Vue/React, Docker, Redis, or other advanced packages were used — everything follows plain Laravel MVC, as expected for a lab project.

---

## 2. Installation Guide

> This project was generated as source code only. Because `composer install` and `npm install`
> need to reach **packagist.org** / the npm registry, run these commands on your own machine
> (this sandbox only had access to GitHub/npm mirrors, not Packagist).

```bash
# 1. Unzip the project and move into it
cd KickMaster

# 2. Install PHP dependencies
composer install

# 3. Install JS dependencies
npm install

# 4. Copy the environment file and generate the app key
cp .env.example .env
php artisan key:generate

# 5. Configure your MySQL credentials in .env
#    DB_DATABASE=kickmaster
#    DB_USERNAME=root
#    DB_PASSWORD=

# 6. Create the database (in MySQL shell or phpMyAdmin)
CREATE DATABASE kickmaster;

# 7. Run migrations + seeders (creates 12 teams, 120 players, 10 fixtures, 20 matches)
php artisan migrate --seed

# 8. Build front-end assets
npm run build

# 9. Serve the app
php artisan serve
```

Visit **http://localhost:8000**

### Demo Logins
| Role  | Email                  | Password |
|-------|-------------------------|----------|
| Admin | admin@kickmaster.com    | password |
| User  | user@kickmaster.com     | password |

### Optional: Weather API
`resources/views/fixtures/show.blade.php` calls the free **OpenWeather API** to show match-day weather.
Get a free key at https://openweathermap.org/api and paste it into the `apiKey` variable in that file's
`<script>` block (or wire it through `.env` → a Blade `@env` variable, if you want it configurable).

---

## 3. Database Schema