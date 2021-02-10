<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Test task - simple rest api converter</h1>
    <br>
</p>

# 1.First task - SQL code
![Image alt](https://github.com/{username}/{repository}/raw/{branch}/{path}/image.png)

SELECT u.id, u.firstName, u.lastName, bk.author, group_concat(bk.name)
FROM Users u
  INNER JOIN User_Books b 
    ON u.id = b.user_id
  INNER JOIN Books bk 
    ON b.book_id = bk.id
WHERE u.age BETWEEN 7 AND 17
  AND u.id IN 
    (SELECT user_id FROM User_Books GROUP BY user_id HAVING COUNT(*) = 2)
GROUP BY u.id HAVING COUNT(DISTINCT bk.author) = 1


# 2.Second task - Restful api currency converter


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




