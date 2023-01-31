## SVIATO ACADEMY

**Installation**

1. Clone the repository
```
git clone git@bitbucket.org:sviato/sviatoacademy.git
```
2. Switch to the repo folder
```
cd sviatoacademy
```
2. Install all the dependencies using composer
```
composer install --no-dev
```
3. Copy the example env file and make the required configuration changes in the .env file
```
cp .env.example .env
```
and update .env
```
APP_NAME="Sviato Academy"
APP_DEBUG=false
APP_URL=http://sviato.academy
ASSET_URL=http://sviato.academy/static
```
4. Generate a new application key
```
php artisan key:generate
```
5. Database is not required