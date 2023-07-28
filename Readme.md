### Тестовое задание Bitrix 
#### Бадамшин Т.И.

---

#### Разворачивание проекта
    
- ##### Запуск докера
    
    На машине должен быть установлен Docker и docker-compose). 
    - Настроить переменные окружения в .env (пример .env.example)
    - В корне проекта последовательно запустить: 
            
          $ make build
          $ make up
- ##### Разворачивание дампа базы данных
    - Скопировать дамп бд по ссылке (https://drive.google.com/file/d/1i8Vjv0yPHQlOF3fzQ9HECrDH-z7POq-b/view?usp=drive_link) и поместить его в папку dump
    - Запустить команду: 
            
          $ make initDump

-  ##### Разворачивание ядра битрикс
    - Скопировать архив ядра по ссылке (https://drive.google.com/file/d/1U5aK14mY1ZQpxMjpr8LgFfTtqrXhklFC/view?usp=drive_link) и поместить его в папку bitrixCore
    - Запустить команду: 
                
           $ make initBitrixCore
           
-  ##### Зависимости композера
    Выполните команду: 
    
        $ make composerInstall
     
     (Примечание зависимости composer подтягиваются в режиме --ignore-platform-reqs, так как зависимости композера я ядре битрикс symfony/console не поддерживают версию php 8.2)
     
-  ##### Миграции
    - Установите таблицу миграций
                    
          $ make migrateInstall
   
    - Запустите миграции
                        
          $ make migrateUp
    
    Среди миграции также есть инициализация начальных тестовых данных