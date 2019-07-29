Установка и настройка
------------

```
composer require sergios/yii2-worksection
```

#### Для установки домена, api ключа, директории для загрузки файлов в common/config/params необходимо положить следующие настройки:

```php
'worksection-api' => [
    'domain' => 'https://api домен', // api домен worksection вашей компании (Пример - https://doris.worksection.com) 
    'apiKey' => 'api ключ', // api hash key - (генерировать может только админ приложения)
    'uploadPath' => '/uploads/tests' // временный путь для сохранения файлов относительно webroot (после передачи файла api он будет автоматически удален)
]
```

Использование
-----
#### Работа с комментариями

##### Поиск комментариев
```php
use sergios\worksectionApi\src\mappers\CommentMapper;

$commentMapper = new CommentMapper('ссылка на задачу');// Пример /project/51000/7784366/ 

//В findByAttributes передача параметров происходит по атрибутах 2 моделей (Comments,User). 
//Имя полей моделей которое можно передавать в метод findByAttribures:
// - модель User [
                    'user' => [
                        'id' => Integer | String,
                        'lastName' => String,
                        'email' => String,
                        'name' => String,
                        'post' => String,
                        'avatar' => String,
                        'company' => String,
                        'department' => String
                    ]
                ];
// - модель Comment ['dateAdded' => String,'text' => String];

$commentCollection = $commentMapper->findByAttributes([
   'dateAdded' => '2019-07-24 11:01', // Формат YYYY-MM-DD hh:mm
   'text' => 'Test', //Текст комментария
   'user' => [
        'id' => user ID, // integer or string
        'lastName' => 'Фамилия',
        'firstName' => 'Василий',
        'email' => 'test@gmail.com',
        'name' => 'Василий Петрович',
        'post' => 'Backend developer', // должность
        'avatar' => 'https://ссылки-на-аватар',
        'company' => 'Название компании',
        'department' => 'Отдел',
    ]
]);//возвращает коллекцию комментариев по критериях поиска
$commentCollection = $commentMapper->findAll();//возвращает коллекцию всех комментариев
```
##### Создание кометария
```php
use sergios\worksectionApi\src\models\Comment;
use sergios\worksectionApi\src\mappers\CommentMapper;
use sergios\worksectionApi\src\models\User;

$commentMapper = new CommentMapper('ссылка на задачу');// Пример /project/51000/7784366/ 

//создание кометария
$comment = new Comment();
$comment->setAttributes(['text' => 'Test']);// Текст комментария
$comment->setTodo(1,'check box text 1'); // Создание checkbox с текстом - check box text 1 
$comment->setTodo(2,'check box text 2'); // Создание checkbox с текстом - check box text 2
...
$comment->saveImage($image); //отправка файла к комментарию ($image - объект UploadedFile)

//создание пользователя
$user = new User();
$user->setAttributes(['email' => 'sergeydovzhanutsia@gmail.com']);//заполнения атрибутов пользователя
$comment->setUser($user);//привязка пользователя к комментарию

$commentMapper = $commentMapper->create($comment);//Создание кометария (возвращает объект созданного комментария) 
```

#### Работа с пользователями
```php
use sergios\worksectionApi\src\mappers\UserMapper;

$userMapper = new UserMapper();
$userCollection = $userMapper->findAll(); //возвращает коллекцию всех пользователей

//поиск пользователей по критериям
//В findByAttribures нужно передавать имя полей которое есть в модели User.
$userCollection = $userMapper->findByAttributes([
    'id' => 51659, // id пользователя
    'email' => 'email',
    'lastName' => 'фамилия',
    'firstName' => 'имя',
    'name' => 'имя фамилия',
    'post' => 'должность',
    'avatar' => 'https://ссылка-на-аватар',
    'company' => 'Название компании',
    'department' => 'Отдел',
]); //возвращает коллекцию всех найденных пользователей
```