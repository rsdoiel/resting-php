
Here is the basic process. Need to make sure we have a test user and a test database
but that the test user only has permissions in the test database. Not you'll want to modify
this to use an appropriate password and not 'SOME_PASSWORD_GOES_HERE'.

```SQL
    USE mysql;
    INSERT INTO user (User, Password, Host) VALUES ("test", PASSWORD('SOME_PASSWORD_GOES_HERE'), 'localhost');
    INSERT INTO db (User, Host, Db, Select_priv, Insert_priv, Update_priv, Delete_priv) VALUES ('test', 'localhost', 'test', 'Y', 'Y','Y','Y');
    FLUSH PRIVILEGES;
    CREATE DATABASE IF NOT EXISTS test;
    USE test;
    CREATE TABLE IF NOT EXISTS  test_persistence (id INTEGER AUTO_INCREMENT PRIMARY KEY, name VARCHAR(255), level INTEGER, success FLOAT);
```

