#Тестовое задание для PHP Developer

##Что будет оцениваться
1. Работоспособность функционала.
  
2. Понятность, чистота кода.

3. Знание фреймворка.

##Описание. 

1. Установить последнюю стабильную версию Yii2 Basic.  

2. Закрыть доступ ко всем страницам для не аутентифицированных пользователей (кроме страницы входа). Страницу входа реализовать по своему усмотрению, можно использовать юзеров «из коробки». 
3. Создать таблицы для записей городов и улиц. Создать консольную команду для получения городов и улиц по API. 
Предположительно скрипт будет запускаться раз в день и добавлять новые записи в таблицу или обновлять название (города, улицы) если такая запись уже есть. Идентифицировать записи можно будет по уникальному идентификатору (ref).  Все запросы отправляются GET методом. 
В заголовки добавить ключ secret-token со значением 854E982F9BE2ADD7CCD1E79B86FD3 Ответ в JSON формате.  
    URL для получения списка городов: 
    ```https://digital.kt.ua/api/test/cities```  
    URL для получения списка улиц по определенному городу:
    ```https://digital.kt.ua/api/test/streets``` 
    Обязательный параметр city_ref.  
В данном примере только несколько населенных пунктов, соответственно только до 10к улиц. При получении и записи данных, учесть, что населенных пунктов может быть более тысячи, а улиц более 120к.  
4. Сделать страницу для вывода списка всех улиц (с фильтрами и пагинацией). Без возможности редактирования, удаления и создания новых. 
5. Выложить проект на удаленный репозиторий.

###Как предоставить результаты

URL на удаленный репозиторий с проектом

###Сколько необходимо времени на выполнение задания
Не более 1-го рабочего дня в зависимости от профессионального уровня

### Install with Docker

Update your vendor packages

```bash
    docker-compose run --rm php composer update --prefer-dist
```
    
Run the installation triggers

```bash
    docker-compose run --rm php composer install    
```
Apply migrations

```bash
     docker-compose run --rm php yii migrate/up --interactive=0
```

Use command for upload cities:

```bash
    docker-compose run --rm php yii catalog/update-cities
```

Use command for upload streets:

```bash
    docker-compose run --rm php yii catalog/update-streets
```
    
Start the container
```bash
    docker-compose up -d
```

You can then access the application through the following URL:

    http://127.0.0.1:8000

### Install with Vagrant 

Run Vagrant

    vagrant up
    
For test console command:

```bash
    vagrant ssh
    app
    php yii migrate/up
```

Use command for upload cities:

```bash
    php yii catalog/update-cities
```

Use command for upload streets:

```bash
    php yii catalog/update-streets
```

You can then access the application through the following URL for view list streets:

    http://yii2basic.test/