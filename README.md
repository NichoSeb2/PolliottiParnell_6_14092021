# PolliottiParnell_6_14092021

# Code quality
[![Maintainability](https://api.codeclimate.com/v1/badges/ce9ee9a821219f870f93/maintainability)](https://codeclimate.com/github/NichoSeb2/PolliottiParnell_6_14092021/maintainability)

# Prerequisite
* A Web Server (Apache, Nginx...)
* PHP 8.0
* Composer
* NodeJs
* A Database engine (Mysql, PostgreSQL...)
* SMTP server accessible from the machine hosting the site

## Site installation
* Clone or download the project
* Go to project folder in a terminal
* Type `composer install`
* Type `npm install`
* Type `npm run build` for production build or `npm run dev` for development build
* Copy `.env` to `.env.local` and edit sql, mail and app secret parameters
* Configure a new Virtual host in your web server configuration with `public/` folder as DocumentRoot

## Database setup
Type the following to setup the database :
 * `php bin/console doctrine:database:create`
 * `php bin/console make:migration`
 * `php bin/console doctrine:migrations:migrate`

To load provided data :
 * To start with only users data : `php bin/console doctrine:fixtures:load --purger=purger --group=users`
 * To start with samples data : `php bin/console doctrine:fixtures:load --purger=purger --group=samples_data`

## Secure your site
### Admin access 
By default, you can log as admin with : `Administrator / Password`

### Other users
Samples data come with 2 additional users, both use `Password` as password :
* `John Doe`, a verified user, author of the 10 tricks
* `Jane Doe`, a new unverified user  
