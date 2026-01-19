# Развертывание на VPS (hretsko.com/sviato)

## Шаг 1: Загрузка файлов на сервер

1. Подключитесь к серверу через SFTP (например, FileZilla)
   - Хост: hretsko.com
   - Порт: 22
   - Протокол: SFTP

2. Создайте директорию на сервере:
   ```
   /var/www/hretsko.com/html/sviato
   ```

3. Загрузите **ВСЕ** файлы проекта в эту директорию, КРОМЕ:
   - node_modules/
   - .git/
   - .claude/

4. Файлы которые ОБЯЗАТЕЛЬНО нужно загрузить:
   - app/
   - bootstrap/
   - config/
   - database/
   - public/
   - resources/
   - routes/
   - storage/
   - static/build/ (собранные assets)
   - vendor/ (или установить через composer на сервере)
   - .env.example
   - artisan
   - composer.json
   - composer.lock
   - package.json
   - vite.config.js

## Шаг 2: Подключитесь к серверу через SSH

```bash
ssh your_user@hretsko.com
```

## Шаг 3: Установите недостающие компоненты (если нужно)

```bash
# Проверьте версию PHP
php -v

# Если PHP < 8.1, установите PHP 8.1+
sudo apt update
sudo apt install php8.1-fpm php8.1-cli php8.1-common php8.1-mysql php8.1-xml php8.1-mbstring php8.1-curl php8.1-zip php8.1-gd

# Проверьте Composer
composer -V

# Если нет Composer, установите:
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
```

## Шаг 4: Настройте проект на сервере

```bash
cd /var/www/hretsko.com/html/sviato

# Установите PHP зависимости (если не загружали vendor/)
composer install --no-dev --optimize-autoloader

# Создайте .env файл
cp .env.example .env
nano .env
```

В файле .env укажите:
```env
APP_NAME="Sviato Academy"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=https://hretsko.com/sviato

# Если есть база данных
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_user
DB_PASSWORD=your_password
```

Сгенерируйте ключ приложения:
```bash
php artisan key:generate
```

## Шаг 5: Настройте права доступа

```bash
# Установите владельца (замените www-data на вашего пользователя nginx)
sudo chown -R www-data:www-data /var/www/hretsko.com/html/sviato

# Установите права
sudo chmod -R 755 /var/www/hretsko.com/html/sviato
sudo chmod -R 775 /var/www/hretsko.com/html/sviato/storage
sudo chmod -R 775 /var/www/hretsko.com/html/sviato/bootstrap/cache
```

## Шаг 6: Настройте Nginx

Создайте или отредактируйте конфигурацию:
```bash
sudo nano /etc/nginx/sites-available/hretsko.com
```

Добавьте location для /sviato (см. файл nginx-config.txt)

После редактирования:
```bash
# Проверьте конфигурацию
sudo nginx -t

# Перезагрузите Nginx
sudo systemctl reload nginx
```

## Шаг 7: Оптимизация Laravel

```bash
cd /var/www/hretsko.com/html/sviato

# Очистите и кэшируйте конфигурацию
php artisan config:clear
php artisan config:cache

# Кэшируйте роуты
php artisan route:cache

# Кэшируйте views
php artisan view:cache
```

## Шаг 8: Проверка

Откройте в браузере: https://hretsko.com/sviato

## Устранение проблем

### Ошибка 500
Проверьте логи:
```bash
tail -f /var/www/hretsko.com/html/sviato/storage/logs/laravel.log
tail -f /var/log/nginx/error.log
```

### Ошибка прав доступа
```bash
sudo chmod -R 775 /var/www/hretsko.com/html/sviato/storage
sudo chmod -R 775 /var/www/hretsko.com/html/sviato/bootstrap/cache
```

### Assets не загружаются
Проверьте, что static/build/ директория загружена на сервер
