#### Задача
Создать функционал, позволяющий загружать изображения.

Ширина загружаемого изображения должна быть больше 640, высота - больше 480.

Если изображение не удовлетворяет этим условиям - не загружать.

Загруженные изображения преобразовывать, сохраняя пропорции:
- ширина не более 640,
- высота не более 480

#### Решение
Решение включает в себя:
- базовый класс;
- его наследники для различных типов изображений;
- интерфейс для сохранения изображений
- отдельный класс для создания классов изображений для последующей обработки;
- некоторые тесты.

Проверка типа загружаемых изображений (исключения).

#### Установка
git clone https://github.com/Igorhlm/imagesOOP.git

composer update


#### Запуск тестов 
Из консоли каталога с проектом:

./vendor/phpunit/phpunit/phpunit --cache-result-file=.phpunit.result.cache --bootstrap src/autoload.php tests