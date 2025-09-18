# 🛒 Shop Project (Laravel + Laradock)

## 📌 Опис
Це інтернет-магазин, побудований на фреймворку **Laravel** з використанням **Laradock** для контейнеризації середовища.  
У проекті реалізовані:  
- API для клієнтів і адмінів  
- Функціонал кошика, замовлень та улюблених товарів  
- Документація API, що генерується автоматично  

---

## 🚀 Використані технології
- [Laravel](https://laravel.com/) – PHP фреймворк  
- [Laradock](https://laradock.io/) – Docker-середовище для Laravel  
- MySQL – база даних  
- Nginx – веб-сервер  

---

## ⚙️ Встановлення та запуск

### 1. Клонування репозиторію та запуск
```bash
git clone https://github.com/RomanZborovskiy/shop-project
cd shop-project
cp .env.example .env
docker compose up -d workspace php-fpm adminer nginx mysql redis redis-webui postgres pgadmin

### 2. Увійди у контейнер workspace:
docker compose exec --user=laradock workspace bash
### 2. Увійди в папку з проектом

composer install
php artisan key:generate
php artisan migrate 
php artisan db:seed 

### 3. Доступи

Сайт: http://localhost

API документація: http://localhost/docs

phpMyAdmin: http://localhost:8080