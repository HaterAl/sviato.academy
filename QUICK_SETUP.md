# Быстрая установка на hretsko.com/sviato

## Команды для копирования в SSH

```bash
# 1. Подключитесь к серверу
ssh your_user@hretsko.com

# 2. Клонируйте репозиторий
sudo mkdir -p /var/www/hretsko.com/html
cd /var/www/hretsko.com/html
sudo git clone https://github.com/HaterAl/sviato.academy.git sviato
cd sviato

# 3. Установите зависимости
composer install --no-dev --optimize-autoloader

# 4. Настройте .env
cp .env.production.example .env
php artisan key:generate

# 5. Установите права
sudo chown -R www-data:www-data /var/www/hretsko.com/html/sviato
sudo chmod -R 755 /var/www/hretsko.com/html/sviato
sudo chmod -R 775 /var/www/hretsko.com/html/sviato/storage
sudo chmod -R 775 /var/www/hretsko.com/html/sviato/bootstrap/cache

# 6. Оптимизация
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 7. Настройте nginx
sudo nano /etc/nginx/sites-available/hretsko.com
# Добавьте содержимое из nginx-config.txt

# 8. Перезагрузите nginx
sudo nginx -t && sudo systemctl reload nginx
```

## Готово!
Откройте: **https://hretsko.com/sviato**

---

## Обновление (git pull)

```bash
ssh your_user@hretsko.com
cd /var/www/hretsko.com/html/sviato
sudo git pull origin main
composer install --no-dev --optimize-autoloader
php artisan config:clear && php artisan config:cache
php artisan route:cache
php artisan view:cache
sudo chown -R www-data:www-data /var/www/hretsko.com/html/sviato
sudo chmod -R 775 storage bootstrap/cache
```

---

## Проверка логов

```bash
# Laravel логи
tail -f /var/www/hretsko.com/html/sviato/storage/logs/laravel.log

# Nginx логи
tail -f /var/log/nginx/error.log
```
