<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Test task - simple rest api converter</h1>
    <br>
</p>

# 1.First task - SQL code
![Image alt](https://github.com/goganasan/rest_api_yii2/raw/master/images/image.png)

<pre><i>SELECT u.id, u.firstName || ',' || u.lastName, bk.author, group_concat(bk.name)<br>
FROM Users u <br>
 &nbsp; INNER JOIN User_Books b <br>
 &nbsp;&nbsp;   ON u.id = b.user_id <br>
 &nbsp; INNER JOIN Books bk <br>
 &nbsp;&nbsp;   ON b.book_id = bk.id <br>
WHERE u.age BETWEEN 7 AND 17 <br>
 &nbsp;AND u.id IN <br>
 &nbsp;&nbsp;   (SELECT user_id FROM User_Books GROUP BY user_id HAVING COUNT(*) = 2) <br>
GROUP BY u.id HAVING COUNT(DISTINCT bk.author) = 1 <br></i></pre>


# 2.Second task - Restful api currency converter

![Image alt](https://github.com/goganasan/rest_api_yii2/raw/master/images/firstPHP.PNG)<br>
![Image alt](https://github.com/goganasan/rest_api_yii2/raw/master/images/secondPHP.PNG)<br>
DIRECTORY STRUCTURE
-------------------

      api/                contains api structure
      assets/             contains assets definition
      commands/           contains console commands (controllers)
      config/             contains application configurations
      controllers/        contains Web controller classes
      mail/               contains view files for e-mails
      migrations/         contains migrations to create user table in database
      models/             contains model classes
      runtime/            contains files generated during runtime
      tests/              contains various tests for the basic application
      vendor/             contains dependent 3rd-party packages
      views/              contains view files for the Web application
      web/                contains the entry script and Web resources




