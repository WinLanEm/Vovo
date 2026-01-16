# API (VOVO)

## Технологии

- PHP 8.2, Laravel 12
- MySQL 8
- OpenAPI 3 + swagger-php (атрибуты)
- L5-Swagger для UI (`/api/documentation`) [web:26]

## Эндпоинты

### GET `/api/products`

Возвращает список продуктов с поддержкой:

- Полнотекстовый поиск по названию (`q`)
- Фильтр по категории, цене, наличию и рейтингу
- Сортировка по цене, рейтингу и дате создания
- Пагинация [web:33][web:43]

Запуск проекта

git clone <repo-url> vovo
cd vovo

# .env уже в репозитории, менять не обязательно
docker-compose up -d

# миграции и сиды (выполнить внутри контейнера app)
docker-compose exec app php artisan migrate
docker-compose exec app php artisan l5-swagger:generate
# при необходимости:
# docker-compose exec app php artisan db:seed
# добавляет 10.000 продуктов

После запуска:

Swagger UI: http://localhost/api/documentation

