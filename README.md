# Инструкция по установке и настройке
Важно: Я спешил сделать это за 1 день, поэтому не хватило времени сохранить цены в отдельной таблице. В будущем это позволило бы иметь несколько цен, а сейчас у нас только 1 цена и 1 валюта.

Также не хватило времени применить принципы SOLID. Сейчас бизнес-логика находится в контроллерах, а хотелось бы реализовать её с использованием паттерна репозитория и сервисов с внедрением зависимостей.

Кроме того, я добавил сиды в миграции для экономии времени.

**Требования:**
- PHP 8.2
- MySql 8.2

1. Выполните команду для получения последних изменений из репозитория:
    ```bash
    git pull
    ```

2. Установите зависимости с помощью Composer:
    ```bash
   composer install 
    ```

3. Настройте подключение к базе данных в файле `.env`:
    - Укажите параметры подключения к вашей базе данных.

4. Выполните миграции для создания таблиц в базе данных:
    ```bash
    php artisan migrate
    ```

