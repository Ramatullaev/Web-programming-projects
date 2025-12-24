# Инструкция: Как добавить изображения в портфолио

## Проблема: "No items found"

Если вы видите сообщение "No items found", это означает, что:
1. База данных еще не создана или пуста
2. Изображения не загружаются правильно

## Решение: Пошаговая инструкция

### Шаг 1: Создание базы данных

1. Откройте **phpMyAdmin**: `http://localhost/phpmyadmin`
2. Нажмите на вкладку **"SQL"**
3. Скопируйте и выполните содержимое файла `data/schema.sql`
4. Или импортируйте файл через вкладку **"Import"**

### Шаг 2: Добавление изображений

У вас есть **3 способа** добавить изображения:

#### Способ 1: Использовать готовый скрипт (РЕКОМЕНДУЕТСЯ)

1. Откройте в браузере: `http://localhost/add_portfolio_item.php`
2. Заполните форму:
   - **Название**: например, "Торт на день рождения"
   - **Категория**: выберите из списка (Cakes, Desserts, Bread)
   - **Описание**: описание работы
   - **URL изображения**: см. варианты ниже
   - **Featured**: отметьте, если хотите показать на главной странице
3. Нажмите "Добавить элемент"

#### Способ 2: Добавить локальные изображения

1. **Поместите изображения** в папку `assets/images/`
   - Например: `assets/images/cake1.jpg`
   - Поддерживаемые форматы: JPG, PNG, GIF, WebP

2. **Добавьте в базу данных** через phpMyAdmin:
   ```sql
   INSERT INTO portfolio_items (title, category, description, image_url, featured) 
   VALUES ('Мой торт', 'Cakes', 'Описание торта', 'assets/images/cake1.jpg', 1);
   ```

3. Или используйте скрипт `add_portfolio_item.php` и укажите путь: `assets/images/cake1.jpg`

#### Способ 3: Использовать изображения из интернета

1. Найдите изображение в интернете (например, на Unsplash.com)
2. Скопируйте URL изображения
3. Добавьте через `add_portfolio_item.php` или напрямую в БД:
   ```sql
   INSERT INTO portfolio_items (title, category, description, image_url, featured) 
   VALUES ('Торт', 'Cakes', 'Описание', 'https://images.unsplash.com/photo-1565958011703-44f9829ba187?w=800', 1);
   ```

### Шаг 3: Проверка

1. Откройте: `http://localhost/portfolio.php`
2. Вы должны увидеть добавленные элементы
3. Проверьте фильтрацию по категориям
4. Проверьте сортировку

## Примеры готовых URL изображений (для тестирования)

Вы можете использовать эти URL для быстрого тестирования:

```
https://images.unsplash.com/photo-1565958011703-44f9829ba187?w=800
https://images.unsplash.com/photo-1606313564200-e75d5e30476c?w=800
https://images.unsplash.com/photo-1558961363-fa8fdf82db35?w=800
https://images.unsplash.com/photo-1578985545062-69928b1d9587?w=800
https://images.unsplash.com/photo-1509440159596-0249088772ff?w=800
https://images.unsplash.com/photo-1555507036-ab1f4038808a?w=800
```

## Быстрое добавление через SQL

Если хотите быстро добавить несколько элементов, выполните в phpMyAdmin:

```sql
INSERT INTO portfolio_items (title, category, description, image_url, featured) VALUES
('Свадебный торт', 'Cakes', 'Элегантный трехъярусный свадебный торт', 'https://images.unsplash.com/photo-1565958011703-44f9829ba187?w=800', 1),
('Шоколадные трюфели', 'Desserts', 'Ручные трюфели из темного шоколада', 'https://images.unsplash.com/photo-1606313564200-e75d5e30476c?w=800', 1),
('Коллекция макарон', 'Desserts', 'Цветные французские макароны', 'https://images.unsplash.com/photo-1558961363-fa8fdf82db35?w=800', 0);
```

## Устранение проблем

### Проблема: Изображения не отображаются

**Решение:**
1. Проверьте путь к изображению в базе данных
2. Для локальных файлов убедитесь, что файл существует в `assets/images/`
3. Проверьте права доступа к файлам
4. Откройте консоль браузера (F12) и проверьте ошибки

### Проблема: База данных не подключается

**Решение:**
1. Убедитесь, что MySQL запущен в XAMPP
2. Проверьте настройки в `includes/config.php`:
   ```php
   define('DB_USER', 'root');  // Ваш пользователь MySQL
   define('DB_PASS', '');      // Ваш пароль (пусто для XAMPP по умолчанию)
   ```

### Проблема: API не возвращает данные

**Решение:**
1. Откройте напрямую: `http://localhost/api/portfolio.php`
2. Должен вернуться JSON с данными
3. Если ошибка - проверьте подключение к БД

## Структура папок для изображений

```
htdocs/
├── assets/
│   ├── images/          ← Помещайте изображения сюда
│   │   ├── cake1.jpg
│   │   ├── cake2.jpg
│   │   └── dessert1.jpg
│   ├── css/
│   └── js/
```

## Полезные ссылки

- **Добавить элемент**: `http://localhost/add_portfolio_item.php`
- **Портфолио**: `http://localhost/portfolio.php`
- **API портфолио**: `http://localhost/api/portfolio.php`
- **phpMyAdmin**: `http://localhost/phpmyadmin`

