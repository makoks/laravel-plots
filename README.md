# Plot Parser
Приложение для получения данных РосРеестра по земельным участкам.
## Установка
Склонируйте репозиторий и перейдите в папку проекта:
```
git clone git@github.com:makoks/laravel-plots.git plot-parser
cd plot-parser
```
Установите зависимости [Composer](https://getcomposer.org/) и [npm](https://www.npmjs.com/):
```
composer install
npm install
```
Скопируйте файл `.env.example` и переименуйте его в `.env`:
```
mv .env.example .env
```
Создайте базу данных и укажите ее конфигурацию в `.env` файле.

Сгенерируйте ключ приложения:
```
php artisan key:generate
```
Теперь вы можете запустить локальный сервер [Laravel](https://laravel.com/) с помощью команды `serve`:
```
php artisan serve
```
Перейдите на страницу приложения [http://127.0.0.1:8000/](http://127.0.0.1:8000/).
## Использование
### 1. Компонент для парсинга данных из РосРеестра
Компонент принимает в качестве аргументов массив кадастровых номеров:
```
use App\Domains\Plot\Support\PlotParser;

$plots = PlotParser::parsePlots(['69:27:0000022:1306','69:27:0000022:1307']);
```
и возвращает коллекцию моделей Plot:
```
Illuminate\Support\Collection {#4499
     all: [
       [
         "number" => "69:27:0000022:1306",
         "address" => "Тверская область, р-н Ржевский, с/пос "Успенское", северо-западнее д. Горшково из земель СПКколхоз "Мирный"",
         "price" => 37578.06,
         "area" => 10035,
       ],
       [
         "number" => "69:27:0000022:1307",
         "address" => "Тверская область, р-н Ржевский, с/пос "Успенское", северо-западнее д. Горшково из земель СПКколхоз "Мирный"",
         "price" => 38106.07,
         "area" => 10176,
       ],
     ],
   }
```
### 2. Web-контроллер
![Plot Parser web controller](https://raw.githubusercontent.com/makoks/laravel-plots/master/public/web.png)
### 3. Rest-контроллер
![Plot Parser REST controller](https://raw.githubusercontent.com/makoks/laravel-plots/master/public/rest.png)
### 4. Консольная команда
![Plot Parser console command](https://raw.githubusercontent.com/makoks/laravel-plots/master/public/console.png)
