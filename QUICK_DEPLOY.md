# Быстрая инструкция по развертыванию

## 1. Локально (уже выполнено)
```bash
npm run build
```
✅ Assets собраны в static/build/

## 2. Загрузите на сервер через SFTP

**Подключение:**
- Хост: hretsko.com
- Порт: 22
- Протокол: SFTP

**Загрузите весь проект в:**
```
/var/www/hretsko.com/html/sviato/
```

**НЕ загружайте:**
- node_modules/
- .git/

## 3. SSH команды на сервере

```bash
# Подключитесь к серверу
ssh your_user@hretsko.com

# Перейдите в директорию
cd /var/www/hretsko.com/html/sviato

# Установите зависимости (если не загружали vendor/)
composer install --no-dev --optimize-autoloader

# Создайте .env
cp .env.production.example .env
nano .env  # Отредактируйте настройки

# Сгенерируйте ключ
php artisan key:generate

# Установите права
sudo chown -R www-data:www-data /var/www/hretsko.com/html/sviato
sudo chmod -R 755 /var/www/hretsko.com/html/sviato
sudo chmod -R 775 /var/www/hretsko.com/html/sviato/storage
sudo chmod -R 775 /var/www/hretsko.com/html/sviato/bootstrap/cache

# Кэшируйте конфигурацию
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 4. Настройте Nginx

```bash
# Откройте конфигурацию
sudo nano /etc/nginx/sites-available/hretsko.com

# Добавьте содержимое из файла nginx-config.txt

# Проверьте и перезагрузите
sudo nginx -t
sudo systemctl reload nginx
```

## 5. Готово!

Откройте: **https://hretsko.com/sviato**

---

## Проверка версий на сервере

```bash
# PHP версия (нужна 8.1+)
php -v

# Composer
composer -V

# Nginx
nginx -v
```

## Если что-то не работает

1. Проверьте логи Laravel:
```bash
tail -f /var/www/hretsko.com/html/sviato/storage/logs/laravel.log
```

2. Проверьте логи Nginx:
```bash
tail -f /var/log/nginx/error.log
```

3. Проверьте права:
```bash
ls -la /var/www/hretsko.com/html/sviato/storage
ls -la /var/www/hretsko.com/html/sviato/bootstrap/cache
```

## API ключи

Не забудьте добавить в .env на сервере:
```env
MASTER_EVENT_KEY=ваш_ключ_из_конфига
```

Проверьте config/services.php чтобы узнать какие ключи нужны.
