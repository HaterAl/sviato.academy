# Развертывание проекта на hretsko.com/sviato через Git

## Шаг 1: Подключитесь к VPS через SSH

```bash
ssh your_user@hretsko.com
```

## Шаг 2: Создайте директорию и клонируйте репозиторий

```bash
# Создайте родительскую директорию, если её нет
sudo mkdir -p /var/www/hretsko.com/html

# Перейдите в директорию
cd /var/www/hretsko.com/html

# Клонируйте репозиторий
sudo git clone https://github.com/HaterAl/sviato.academy.git sviato

# Перейдите в директорию проекта
cd sviato
```

## Шаг 3: Установите зависимости

```bash
# Установите PHP зависимости
composer install --no-dev --optimize-autoloader

# Если нужно собрать assets на сервере (или используйте уже собранные из git)
# npm install
# npm run build
```

## Шаг 4: Настройте .env файл

```bash
# Скопируйте пример production конфигурации
cp .env.production.example .env

# Отредактируйте .env файл (если нужно изменить настройки)
nano .env
```

Проверьте, что в .env указано:
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://hretsko.com/sviato
```

Сгенерируйте ключ приложения:
```bash
php artisan key:generate
```

## Шаг 5: Установите права доступа

```bash
# Установите владельца (замените www-data на пользователя nginx, если отличается)
sudo chown -R www-data:www-data /var/www/hretsko.com/html/sviato

# Установите права на директории
sudo chmod -R 755 /var/www/hretsko.com/html/sviato

# Установите права на storage и cache
sudo chmod -R 775 /var/www/hretsko.com/html/sviato/storage
sudo chmod -R 775 /var/www/hretsko.com/html/sviato/bootstrap/cache
```

## Шаг 6: Настройте Nginx

```bash
# Откройте конфигурацию nginx для домена hretsko.com
sudo nano /etc/nginx/sites-available/hretsko.com
```

Добавьте location блоки из файла `nginx-config.txt` в существующий server блок. Основной блок:

```nginx
# Внутри server { ... } добавьте:

location /sviato {
    alias /var/www/hretsko.com/html/sviato/public;
    try_files $uri $uri/ @sviato;

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;  # Проверьте версию PHP!
        fastcgi_param SCRIPT_FILENAME $request_filename;
        fastcgi_param SCRIPT_NAME /sviato/index.php;
    }
}

location @sviato {
    rewrite ^/sviato/(.*)$ /sviato/index.php?/$1 last;
}

# Для статических файлов (CSS, JS, изображения)
location ~ ^/sviato/(static|build|css|js|images|fonts)/ {
    alias /var/www/hretsko.com/html/sviato/public/$1/;
    expires 1y;
    access_log off;
    add_header Cache-Control "public, immutable";
}
```

После редактирования проверьте и перезагрузите nginx:
```bash
# Проверьте конфигурацию
sudo nginx -t

# Если все OK, перезагрузите nginx
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

Откройте в браузере: **https://hretsko.com/sviato**

---

## Обновление проекта в будущем

Когда нужно обновить проект:

```bash
# Подключитесь к серверу
ssh your_user@hretsko.com

# Перейдите в директорию проекта
cd /var/www/hretsko.com/html/sviato

# Получите последние изменения
sudo git pull origin main  # или master, в зависимости от названия ветки

# Обновите зависимости (если изменились)
composer install --no-dev --optimize-autoloader

# Очистите кэш
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Кэшируйте заново
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Если изменились права доступа
sudo chown -R www-data:www-data /var/www/hretsko.com/html/sviato
sudo chmod -R 775 /var/www/hretsko.com/html/sviato/storage
sudo chmod -R 775 /var/www/hretsko.com/html/sviato/bootstrap/cache
```

---

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
sudo chown -R www-data:www-data /var/www/hretsko.com/html/sviato
```

### Assets не загружаются
Убедитесь, что static/build/ директория существует и содержит файлы:
```bash
ls -la /var/www/hretsko.com/html/sviato/public/static/build/
```

### Проверка версии PHP
```bash
php -v  # Должна быть 8.1 или выше
```

### Проверка конфигурации nginx
```bash
sudo nginx -t
```

---

## Важные заметки

1. **Версия PHP**: Убедитесь, что используется PHP 8.1 или выше
2. **SSL сертификаты**: Убедитесь, что для hretsko.com настроены SSL сертификаты (Let's Encrypt)
3. **Путь к PHP-FPM сокету**: В конфигурации nginx указан `php8.1-fpm.sock` - проверьте вашу версию PHP и измените, если необходимо
4. **Git ветка**: По умолчанию используется ветка `main`. Если у вас `master`, замените в командах
5. **Файлы .env**: Не коммитьте .env файл в git! Используйте .env.production.example как шаблон
